<?php

return [

    /*
    Configura quais módulos do Headers e Footers serão impressos na sua página
    Obs.: Os nomes dos modulos deveram ser criados com a primeira letra em maiusculo e no plural

        'Headers' => (object)[
            'Code' => 'HD001',
            'IncludeCategory' => (object) [
                'Model' => 'CategoryProduct',
                'Code' => 'CP001',
                'Limit' => '3'
            ],
            'IncludeSubcategory' => (object) []
        ],
    */
    'InsertModelsCore' => (object) [
        'Headers' => (object)[
            'Code' => 'HEAD01',
            'IncludeCategory' => (object) [],
            'IncludeSubcategory' => (object) []
        ],
        'Footers' => (object)[
            'Code' => 'FOOT01',
            'IncludeCategory' => (object) [],
            'IncludeSubcategory' => (object) []
        ]
    ],

    /*
    Configurar quais módulos serão usados para o site/sistema no geral, exceto Header e Footer.
    A ordem dos módulos posto no array afetarar a ordem das seções no site e painel

    Ex.:
        'Topics' => (object)[
            'Code' => 'TOPI01',
            'ViewHome' => true,
            'config' => (object) [
                'TitleMenu' => 'Tópicos',
                'AnchorMenu' => 'javascript:void(0)',
                'iconMenu' => '',
                'TitlePanel' => 'Tópicos',
                'iconPanel' => ''
            ],
            'IncludeSections' => (object) []
        ],

    Para cadada indice do array algumas opções estão disponíveis sendo elas:

    OBS.: Módulos não poderão se repetir no array. No módulo já está incluso todas as dependencias para que funcione corretamente,
    aqui deverá apenas informar as configurações do mesmo.
    */

    'InsertModelsMain' => (object) [
        'Topics' => (object)[
            'Code' => 'TOPI01',
            'ViewHome' => true,
            'ViewListMenu' => true,
            'config' => (object) [
                'titleMenu' => 'Tópicos',
                'anchorMenu' => 'javascript:void(0)',
                'iconMenu' => '',
                'titlePanel' => 'Tópicos',
                'iconPanel' => 'mdi mdi-image-move'
            ],
            'IncludeSections' => (object) []
        ],
    ],

    /*
    ETRUTURA PADRÃO PARA MODELS

    -- MODELO COM CATEEGORIA

    'Product' => (object)[
        'PD001' => (object) [
            'Class' => 'Class Model Product',
            'Category' => 'Class Model Category',
            'Subcategory' => 'Class Model Subcategory'
        ]
    ],

    -- MODELO SEM CATEGORIA

    'Product' => (object)[
        'PD001' => (object) [
            'Class' => 'Class Model Product',
        ]
    ],

    Exemplo de Caminho do controlador: App\Http\Controllers\Topics\TOPI01Controller::class

    */

    'Models' => (object) [
        'Topics' => (object)[
            'TOPI01' => (object) [
                'Class' => App\Http\Controllers\Topics\TOPI01Controller::class,
            ]
        ],
    ]
];
