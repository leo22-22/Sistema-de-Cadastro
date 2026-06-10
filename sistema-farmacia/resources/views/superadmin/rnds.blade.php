<x-app-layout>

<div class="page-header">
    <div>
        <h4><i class="bi bi-cloud-upload-fill me-2"></i>Integração RNDS</h4>
        <small>Rede Nacional de Dados em Saúde — Ministério da Saúde</small>
    </div>
    @php
        $statusLabel = 'Não configurado';
        $statusClass = 'secondary';
        if (!empty($config['cnpj']) || !empty($config['cpf_habilitador'])) {
            if (!empty($config['ativo']) && ($config['ambiente'] ?? '') === 'producao') {
                $statusLabel = 'Ativo — Produção';
                $statusClass = 'success';
            } else {
                $statusLabel = 'Configurado — Homologação';
                $statusClass = 'warning text-dark';
            }
        }
    @endphp
    <span class="badge bg-{{ $statusClass }}" style="font-size:.8rem;padding:.4rem .8rem;border-radius:8px">
        {{ $statusLabel }}
    </span>
</div>

{{-- What is RNDS --}}
<div class="alert d-flex gap-3 mb-4" style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:12px">
    <i class="bi bi-info-circle-fill" style="color:#3b82f6;font-size:1.2rem;flex-shrink:0;margin-top:.1rem"></i>
    <div style="font-size:.855rem;color:#1e3a5f;line-height:1.65">
        <strong>O que é a RNDS?</strong><br>
        A Rede Nacional de Dados em Saúde (RNDS) é a plataforma nacional de interoperabilidade de dados em saúde do Ministério da Saúde.
        A integração permitirá o envio automático de registros de dispensação para o portal federal, conforme determinação da
        <strong>Portaria GM/MS nº 1.792/2023</strong>.
        <a href="https://www.gov.br/saude/pt-br/assuntos/rnds" target="_blank" class="ms-1" style="color:#3b82f6">
            Saiba mais <i class="bi bi-box-arrow-up-right" style="font-size:.75rem"></i>
        </a>
    </div>
</div>

<div class="row g-4">
    {{-- Settings form --}}
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <span style="font-size:.88rem;font-weight:700;color:#374151">
                    <i class="bi bi-gear-fill me-1" style="color:var(--indigo)"></i>Configurações de Credenciais
                </span>
            </div>
            <div class="card-body p-3">
                <form method="POST" action="{{ route('rnds.update') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">CNPJ da Farmácia</label>
                        <input type="text" name="cnpj" class="form-control @error('cnpj') is-invalid @enderror"
                               value="{{ old('cnpj', $config['cnpj'] ?? '') }}"
                               placeholder="00.000.000/0000-00" data-mask="cnpj">
                        @error('cnpj')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">CNPJ do estabelecimento junto ao CNES/RNDS.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">CPF do Habilitador</label>
                        <input type="text" name="cpf_habilitador" class="form-control @error('cpf_habilitador') is-invalid @enderror"
                               value="{{ old('cpf_habilitador', $config['cpf_habilitador'] ?? '') }}"
                               placeholder="000.000.000-00" data-mask="cpf">
                        @error('cpf_habilitador')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">CPF do profissional habilitado no portal e-SUS RNDS.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ambiente</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="ambiente" id="amb_homolog" value="homologacao"
                                    {{ (old('ambiente', $config['ambiente'] ?? 'homologacao') === 'homologacao') ? 'checked' : '' }}>
                                <label class="form-check-label" for="amb_homolog" style="font-size:.855rem">
                                    <i class="bi bi-flask me-1 text-warning"></i>Homologação
                                    <span class="text-muted d-block" style="font-size:.75rem">Ambiente de testes</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="ambiente" id="amb_prod" value="producao"
                                    {{ (old('ambiente', $config['ambiente'] ?? '') === 'producao') ? 'checked' : '' }}>
                                <label class="form-check-label" for="amb_prod" style="font-size:.855rem">
                                    <i class="bi bi-broadcast me-1 text-success"></i>Produção
                                    <span class="text-muted d-block" style="font-size:.75rem">Ambiente real</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="ativo" name="ativo" value="1"
                                {{ !empty($config['ativo']) ? 'checked' : '' }}>
                            <label class="form-check-label" for="ativo" style="font-size:.855rem;font-weight:600">
                                Integração ativa
                            </label>
                            <div class="form-text">Ativa o envio automático de dispensações para a RNDS.</div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-floppy2-fill me-1"></i>Salvar Configurações
                        </button>
                        <button type="button" class="btn btn-outline-secondary"
                                onclick="alert('Funcionalidade disponível em breve.\nA integração RNDS está prevista para Q3 2025.')">
                            <i class="bi bi-wifi me-1"></i>Testar Conexão
                        </button>
                    </div>

                    @if(!empty($config['updated_at']))
                    <div class="mt-3" style="font-size:.76rem;color:#94a3b8">
                        <i class="bi bi-clock me-1"></i>
                        Última atualização: {{ \Carbon\Carbon::parse($config['updated_at'])->format('d/m/Y H:i') }}
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>

    {{-- Roadmap --}}
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header">
                <span style="font-size:.88rem;font-weight:700;color:#374151">
                    <i class="bi bi-map-fill me-1" style="color:var(--indigo)"></i>Roadmap de Implementação
                </span>
            </div>
            <div class="card-body p-3">
                <div style="display:flex;flex-direction:column;gap:.75rem">

                    <div style="display:flex;gap:.85rem;align-items:flex-start">
                        <div style="width:32px;height:32px;border-radius:50%;background:#dcfce7;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:.95rem">
                            ✅
                        </div>
                        <div>
                            <div style="font-size:.855rem;font-weight:600;color:#374151">Fase 1: Preparação do sistema</div>
                            <div style="font-size:.78rem;color:#10b981;font-weight:500">Concluída</div>
                            <div style="font-size:.78rem;color:#64748b;margin-top:.15rem">Estrutura de dados compatível com RNDS, cadastro de farmácias e pacientes.</div>
                        </div>
                    </div>

                    <div style="display:flex;gap:.85rem;align-items:flex-start">
                        <div style="width:32px;height:32px;border-radius:50%;background:#fef3c7;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:.95rem">
                            🔄
                        </div>
                        <div>
                            <div style="font-size:.855rem;font-weight:600;color:#374151">Fase 2: Configuração de credenciais</div>
                            <div style="font-size:.78rem;color:#f59e0b;font-weight:500">Em andamento</div>
                            <div style="font-size:.78rem;color:#64748b;margin-top:.15rem">Registro no portal e-SUS, obtenção de certificados e configuração de acesso.</div>
                        </div>
                    </div>

                    <div style="display:flex;gap:.85rem;align-items:flex-start">
                        <div style="width:32px;height:32px;border-radius:50%;background:#f1f5f9;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:.95rem">
                            ⏳
                        </div>
                        <div>
                            <div style="font-size:.855rem;font-weight:600;color:#374151">Fase 3: Envio de dispensações</div>
                            <div style="font-size:.78rem;color:#94a3b8;font-weight:500">Previsto Q3 2025</div>
                            <div style="font-size:.78rem;color:#64748b;margin-top:.15rem">Envio automático dos registros de dispensação do CEAF para a RNDS.</div>
                        </div>
                    </div>

                    <div style="display:flex;gap:.85rem;align-items:flex-start">
                        <div style="width:32px;height:32px;border-radius:50%;background:#f1f5f9;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:.95rem">
                            ⏳
                        </div>
                        <div>
                            <div style="font-size:.855rem;font-weight:600;color:#374151">Fase 4: Validação e go-live</div>
                            <div style="font-size:.78rem;color:#94a3b8;font-weight:500">Previsto Q4 2025</div>
                            <div style="font-size:.78rem;color:#64748b;margin-top:.15rem">Testes em homologação, aprovação e ativação em ambiente de produção.</div>
                        </div>
                    </div>
                </div>

                <div class="mt-3 pt-3" style="border-top:1px solid #e2e8f0">
                    <a href="https://www.gov.br/saude/pt-br/assuntos/rnds" target="_blank"
                       class="btn btn-sm btn-outline-primary w-100">
                        <i class="bi bi-box-arrow-up-right me-1"></i>
                        Documentação RNDS — Ministério da Saúde
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

</x-app-layout>
