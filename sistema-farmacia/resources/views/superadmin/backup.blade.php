<x-app-layout>

<div class="page-header">
    <div>
        <h4><i class="bi bi-database-fill-down me-2"></i>Backup do Banco de Dados</h4>
        <small>Gerencie os backups do banco de dados do sistema</small>
    </div>
    @if($isSuperadmin)
    <form method="POST" action="{{ route('backup.store') }}">
        @csrf
        <button type="submit" class="btn btn-primary" onclick="return confirm('Iniciar backup agora? Isso pode levar alguns segundos.')">
            <i class="bi bi-play-circle-fill me-1"></i>Fazer Backup Agora
        </button>
    </form>
    @endif
</div>

{{-- Info about automatic backups --}}
<div class="alert alert-info d-flex align-items-center gap-2 mb-4" style="border-radius:10px;font-size:.855rem">
    <i class="bi bi-info-circle-fill" style="font-size:1rem;flex-shrink:0"></i>
    <span>Backups automáticos são realizados diariamente às <strong>3h</strong>. Os últimos <strong>30 backups</strong> são mantidos automaticamente.</span>
</div>

@if($isSuperadmin)
{{-- Superadmin: full backup management --}}

@if(empty($backups))
<div class="card">
    <div class="card-body text-center py-5">
        <i class="bi bi-cloud-slash" style="font-size:2.5rem;color:#94a3b8"></i>
        <div style="font-size:.95rem;font-weight:600;color:#374151;margin-top:.75rem">Nenhum backup realizado ainda</div>
        <div style="font-size:.82rem;color:#94a3b8;margin-top:.25rem">Clique em <strong>Fazer Backup</strong> para criar o primeiro.</div>
    </div>
</div>
@else
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span style="font-size:.82rem;font-weight:700;color:#374151">
            <i class="bi bi-archive-fill me-1" style="color:var(--indigo)"></i>
            {{ count($backups) }} backup{{ count($backups) !== 1 ? 's' : '' }} disponível{{ count($backups) !== 1 ? 'is' : '' }}
        </span>
        <span style="font-size:.78rem;color:#94a3b8">Mais recentes primeiro</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Arquivo</th>
                    <th>Tamanho</th>
                    <th>Data/Hora</th>
                    <th class="text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($backups as $backup)
                <tr>
                    <td>
                        <i class="bi bi-file-earmark-zip me-1" style="color:#94a3b8"></i>
                        <span style="font-size:.83rem;font-family:monospace">{{ $backup['filename'] }}</span>
                    </td>
                    <td>
                        @php
                            $kb = round($backup['size'] / 1024, 1);
                            $mb = round($backup['size'] / 1024 / 1024, 2);
                            $sizeStr = $kb >= 1024 ? "{$mb} MB" : "{$kb} KB";
                        @endphp
                        <span style="font-size:.83rem;color:#64748b">{{ $sizeStr }}</span>
                    </td>
                    <td>
                        <span style="font-size:.83rem">{{ $backup['created_at']->format('d/m/Y H:i:s') }}</span>
                        <br><small style="color:#94a3b8;font-size:.73rem">{{ $backup['created_at']->diffForHumans() }}</small>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('backup.download', $backup['filename']) }}"
                           class="btn btn-sm btn-outline-primary me-1" title="Baixar">
                            <i class="bi bi-download"></i>
                        </a>
                        <form method="POST" action="{{ route('backup.destroy', $backup['filename']) }}"
                              style="display:inline"
                              onsubmit="return confirm('Excluir este backup permanentemente?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@else
{{-- Admin farmácia: read-only view --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6">
        <div class="stat-card">
            <div class="stat-icon-wrap" style="background:#eff6ff">
                <i class="bi bi-archive-fill" style="color:#4f46e5"></i>
            </div>
            <div>
                <div class="stat-value" data-count="{{ count($backups) }}">{{ count($backups) }}</div>
                <div class="stat-label">Backups disponíveis</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="stat-card">
            <div class="stat-icon-wrap" style="background:#f0fdf4">
                <i class="bi bi-clock-history" style="color:#10b981"></i>
            </div>
            <div>
                @if(!empty($backups))
                <div class="stat-value" style="font-size:1rem;font-weight:700">
                    {{ $backups[0]['created_at']->format('d/m/Y H:i') }}
                </div>
                <div class="stat-label">Último backup ({{ $backups[0]['created_at']->diffForHumans() }})</div>
                @else
                <div class="stat-value" style="font-size:1rem">—</div>
                <div class="stat-label">Nenhum backup realizado</div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="alert d-flex align-items-center gap-2 mb-0" style="background:#f0f9ff;border:1px solid #bae6fd;border-radius:10px;font-size:.855rem">
    <i class="bi bi-lock-fill" style="color:#0284c7;font-size:1rem;flex-shrink:0"></i>
    <span style="color:#0c4a6e">Backups são gerenciados automaticamente pelo administrador do sistema. Entre em contato com o suporte para solicitar uma cópia ou restauração.</span>
</div>
@endif

</x-app-layout>
