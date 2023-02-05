<?php
$menusDeConfiguracoes = collect([
                ['url' => 'gestor.configuracoes.index', 'label' => 'Configurações Gerais'],
                ['url' => 'gestor.contato_configuracoes.index', 'label' => 'Configurações de Contato'],
                ['url' => 'gestor.assuntos.index', 'label' => 'Assuntos do Contato'],
                ['url' => 'gestor.gestores.index', 'label' => 'Gestores'],
                ['url' => 'gestor.log_atividades.index', 'label' => 'Log de Atividades'],
                ['url' => 'gestor.log_login.index', 'label' => 'Log de Login'],
                ['url' => 'gestor.log_login_errado.index', 'label' => 'Log de Falhas de Login'],
        ]
);
$menus[] = ['label' => 'Configurações', 'icone' => 'fa fa-wrench fa-fw', 'menus' => $menusDeConfiguracoes];



$menusDoSite = collect([
                ['url' => 'gestor.contatos.index', 'label' => 'Contatos'],

        ]
);
$menus[] = ['label' => 'Site', 'icone' => 'fa fa-puzzle-piece fa-fw', 'menus' => $menusDoSite];

function substituiUrlDaCollection($value)
{
    $url = str_replace('.', '/', $value['url']);
    return str_replace('/index', '', $url);
}


function converteParaUrl($value)
{
    $link = null;
    $explode = explode("/", $value);
    if (count($explode) >= 2) {
        $link = $explode[0] . "/" . $explode[1];
    }

    return $link;
}

?>

@foreach($menus as $menu)
    <li class="has-submenu
        @if(in_array(converteParaUrl(Route::getCurrentRoute()->getPath()), $menu['menus']->map(function($value) {
            return substituiUrlDaCollection($value);
        })->toArray()) )
            active
        @endif
            ">
        <a href="#"><i class="fa {{ $menu['icone'] }}"></i> <span
                    class="nav-label">{{ $menu['label'] }}</span></a>
        <ul class="list-unstyled">

            @foreach($menu['menus'] as $item)
                <li><a href="{{ URL::route($item['url']) }}"> &raquo; {{--<i class="glyphicon glyphicon-chevron-right">--}}</i> {{ $item['label'] }}</a></li>
            @endforeach
        </ul>
    </li>
@endforeach