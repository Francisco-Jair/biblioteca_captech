<?php

return [
    'versaoGenesis' => '3.4',
    'template' => '', # 'monarch' ou ''
    'dataGenesis' => '17.02.2017',
    'cliente' => 'RLustosa',
    'upload' => [
        'paginas' => [
            'caminho' => 'imgs/paginas/',
            'caminhoOriginal' => 'imgs/paginas/original/',

            'tamanhoExibicaoDoCrop' => 570,
            'widthSite' => 570,
            'heightSite' => 380,
            'aspectRatio' => '1.5/1'
        ],
    ],
    'tempoCache' => [
        'paginasDoBanco' => 60 * 24 * 7,
        'configuracoesGerais' => 60 * 24 * 7,
        'configuracoesDeContato' => 60 * 24 * 7,
    ]
];
