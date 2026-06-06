<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\Recibo;
use App\Models\Processo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RelatorioController extends Controller
{
    private function escopoFarmacia($query, string $via = 'farmacia_id')
    {
        $user = auth()->user();
        if (!$user->isSuperadmin() && $user->farmacia_id) {
            $query->where($via, $user->farmacia_id);
        }
        return $query;
    }

    public function index()
    {
        return view('relatorios.index');
    }

    /* ── Dispensações ────────────────────────────────────────── */

    public function dispensacoes(Request $request)
    {
        $request->validate([
            'data_de'  => 'nullable|date',
            'data_ate' => 'nullable|date|after_or_equal:data_de',
        ]);

        $query = $this->escopoFarmacia(
            Recibo::with(['processo.paciente', 'medicamento', 'geradoPor'])
        );

        if ($request->filled('data_de')) {
            $query->whereDate('created_at', '>=', $request->data_de);
        }
        if ($request->filled('data_ate')) {
            $query->whereDate('created_at', '<=', $request->data_ate);
        }
        if ($request->filled('medicamento_id')) {
            $query->where('medicamento_id', $request->medicamento_id);
        }

        $recibos   = $query->latest()->get();
        $total     = $recibos->sum('quantidade');
        $filtros   = $request->only('data_de', 'data_ate', 'medicamento_id');

        if ($request->formato === 'csv') {
            return $this->csvDispensacoes($recibos);
        }

        if ($request->formato === 'pdf') {
            return $this->pdfDispensacoes($recibos, $total, $filtros);
        }

        $medicamentos = \App\Models\Medicamento::ativo()->orderBy('nome')->get();
        return view('relatorios.dispensacoes', compact('recibos', 'total', 'filtros', 'medicamentos'));
    }

    /* ── Estoque ────────────────────────────────────────────── */

    public function estoque(Request $request)
    {
        $query = $this->escopoFarmacia(Lote::with('medicamento'));

        if ($request->filled('situacao')) {
            match ($request->situacao) {
                'vencidos'   => $query->where('validade', '<', now()),
                'sem_estoque'=> $query->where('quantidade_atual', '<=', 0),
                'baixo'      => $query->where('quantidade_atual', '>', 0)->where('quantidade_atual', '<=', 10)->where('validade', '>=', now()),
                'ok'         => $query->where('quantidade_atual', '>', 10)->where('validade', '>=', now()),
                default      => null,
            };
        }

        $lotes = $query->orderBy('validade')->get();

        if ($request->formato === 'csv') {
            return $this->csvEstoque($lotes);
        }

        if ($request->formato === 'pdf') {
            return $this->pdfEstoque($lotes);
        }

        return view('relatorios.estoque', compact('lotes'));
    }

    /* ── Processos ─────────────────────────────────────────── */

    public function processos(Request $request)
    {
        $query = $this->escopoFarmacia(
            Processo::with(['paciente', 'cid10', 'criadoPor'])
        );

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('data_de')) {
            $query->whereDate('created_at', '>=', $request->data_de);
        }
        if ($request->filled('data_ate')) {
            $query->whereDate('created_at', '<=', $request->data_ate);
        }

        $processos = $query->latest()->get();

        if ($request->formato === 'csv') {
            return $this->csvProcessos($processos);
        }

        if ($request->formato === 'pdf') {
            return $this->pdfProcessos($processos);
        }

        return view('relatorios.processos', compact('processos'));
    }

    /* ── Exportações CSV ───────────────────────────────────── */

    private function csvDispensacoes($recibos): Response
    {
        $linhas = [];
        $linhas[] = ['Número', 'Data', 'Paciente', 'Medicamento', 'Quantidade', 'Mês Ref.', 'Gerado por'];
        foreach ($recibos as $r) {
            $linhas[] = [
                $r->numero,
                $r->created_at->format('d/m/Y H:i'),
                $r->processo->paciente->nome ?? '',
                $r->medicamento->nome ?? '',
                $r->quantidade,
                $r->mes_referencia ? \Carbon\Carbon::parse($r->mes_referencia)->format('m/Y') : '',
                $r->geradoPor->name ?? '',
            ];
        }
        return $this->gerarCsv($linhas, 'dispensacoes_' . now()->format('Ymd'));
    }

    private function csvEstoque($lotes): Response
    {
        $linhas = [];
        $linhas[] = ['Medicamento', 'Lote', 'Qtd Inicial', 'Qtd Atual', 'Validade', 'Entrada', 'Situação'];
        foreach ($lotes as $l) {
            $situacao = $l->validade->isPast() ? 'Vencido' : ($l->quantidade_atual <= 0 ? 'Sem Estoque' : ($l->quantidade_atual <= 10 ? 'Baixo' : 'OK'));
            $linhas[] = [
                $l->medicamento->nome ?? '',
                $l->lote,
                $l->quantidade_inicial,
                $l->quantidade_atual,
                $l->validade->format('d/m/Y'),
                $l->data_entrada->format('d/m/Y'),
                $situacao,
            ];
        }
        return $this->gerarCsv($linhas, 'estoque_' . now()->format('Ymd'));
    }

    private function csvProcessos($processos): Response
    {
        $linhas = [];
        $linhas[] = ['Número', 'Paciente', 'CID', 'Tipo', 'Status', 'Abertura', 'APAC'];
        foreach ($processos as $p) {
            $linhas[] = [
                $p->numero,
                $p->paciente->nome ?? '',
                $p->cid10->codigo ?? '',
                Processo::$tiposProcesso[$p->tipo_processo] ?? $p->tipo_processo,
                $p->statusLabel(),
                $p->created_at->format('d/m/Y'),
                $p->validade_apac?->format('d/m/Y') ?? '',
            ];
        }
        return $this->gerarCsv($linhas, 'processos_' . now()->format('Ymd'));
    }

    private function gerarCsv(array $linhas, string $nome): Response
    {
        $bom = "\xEF\xBB\xBF";
        ob_start();
        $fp = fopen('php://output', 'w');
        foreach ($linhas as $linha) {
            fputcsv($fp, $linha, ';');
        }
        fclose($fp);
        $csv = ob_get_clean();

        return response($bom . $csv, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$nome}.csv\"",
        ]);
    }

    /* ── Exportações PDF (via dompdf) ──────────────────────── */

    private function pdfDispensacoes($recibos, int $total, array $filtros)
    {
        $html = view('relatorios.pdf.dispensacoes', compact('recibos', 'total', 'filtros'))->render();
        return $this->gerarPdf($html, 'dispensacoes_' . now()->format('Ymd'));
    }

    private function pdfEstoque($lotes)
    {
        $html = view('relatorios.pdf.estoque', compact('lotes'))->render();
        return $this->gerarPdf($html, 'estoque_' . now()->format('Ymd'));
    }

    private function pdfProcessos($processos)
    {
        $html = view('relatorios.pdf.processos', compact('processos'))->render();
        return $this->gerarPdf($html, 'processos_' . now()->format('Ymd'));
    }

    private function gerarPdf(string $html, string $nome): Response
    {
        $dompdf = new \Dompdf\Dompdf(['defaultPaperSize' => 'A4', 'defaultPaperOrientation' => 'landscape']);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->render();
        $pdf = $dompdf->output();

        return response($pdf, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => "attachment; filename=\"{$nome}.pdf\"",
        ]);
    }
}
