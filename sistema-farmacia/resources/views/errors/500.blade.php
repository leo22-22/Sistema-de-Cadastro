@include('errors.layout', [
    'codigo'   => '500',
    'icone'    => 'bi-exclamation-triangle-fill',
    'cor'      => '#ef4444',
    'titulo'   => 'Erro interno do servidor',
    'mensagem' => 'Algo deu errado no servidor. Nossa equipe foi notificada. Por favor, tente novamente em alguns instantes.',
])
