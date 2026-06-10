@include('errors.layout', [
    'codigo'   => '403',
    'icone'    => 'bi-shield-lock-fill',
    'cor'      => '#f59e0b',
    'titulo'   => 'Acesso não autorizado',
    'mensagem' => 'Você não tem permissão para acessar esta página. Se acredita que isso é um erro, entre em contato com o administrador.',
])
