<x-app-layout>
<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
        <h4 class="mb-1"><i class="bi bi-bell me-2"></i>Notificações</h4>
        <p class="text-muted small mb-0">Histórico de alertas do sistema</p>
    </div>
    @if(auth()->user()->unreadNotifications->count() > 0)
    <form action="{{ route('notificacoes.todas-lidas') }}" method="POST">
        @csrf
        <button class="btn btn-sm btn-outline-primary">
            <i class="bi bi-check2-all me-1"></i>Marcar todas como lidas
        </button>
    </form>
    @endif
</div>

<div class="card">
    @forelse($notificacoes as $notif)
    @php $d = $notif->data; @endphp
    <div class="d-flex align-items-start gap-3 px-4 py-3 {{ $loop->last ? '' : 'border-bottom' }} {{ $notif->read_at ? '' : 'bg-indigo-light' }}"
         style="{{ $notif->read_at ? '' : 'background:rgba(99,102,241,.04)' }}">
        <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0"
             style="width:38px;height:38px;background:rgba(99,102,241,.1)">
            <i class="bi {{ $d['icone'] ?? 'bi-bell' }} text-{{ $d['cor'] ?? 'secondary' }}"></i>
        </div>
        <div style="flex:1;min-width:0">
            <div class="fw-semibold small {{ $notif->read_at ? 'text-muted' : '' }}">{{ $d['titulo'] ?? '' }}</div>
            <div class="text-muted" style="font-size:.8rem">{{ $d['corpo'] ?? '' }}</div>
            <div style="font-size:.7rem;color:#94a3b8;margin-top:.2rem">{{ $notif->created_at->format('d/m/Y H:i') }} — {{ $notif->created_at->diffForHumans() }}</div>
        </div>
        <div class="d-flex gap-2 align-items-center flex-shrink-0">
            @if(isset($d['link']))
            <a href="{{ $d['link'] }}" class="btn btn-sm btn-outline-secondary py-1 px-2" style="font-size:.72rem">Ver</a>
            @endif
            @if(!$notif->read_at)
            <form action="{{ route('notificacoes.lida', $notif->id) }}" method="POST">@csrf
                <button class="btn btn-sm btn-outline-primary py-1 px-2" style="font-size:.72rem">Lida</button>
            </form>
            @else
            <span class="badge bg-light text-muted border" style="font-size:.65rem">Lida</span>
            @endif
        </div>
    </div>
    @empty
    <div class="text-center py-5 text-muted">
        <i class="bi bi-bell-slash fs-3 d-block mb-2"></i>
        Nenhuma notificação.
    </div>
    @endforelse
</div>

@if($notificacoes->hasPages())
<div class="mt-3">{{ $notificacoes->links() }}</div>
@endif
</x-app-layout>
