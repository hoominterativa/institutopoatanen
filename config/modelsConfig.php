<?php

return [

    /*
    Configura quais módulos do Headers e Footers serão impressos na sua página
    */
    'InsertModelsCore' => (object) [
        'Header' => (object)[
            'Code' => 'HD001',
            'IncludeCategory' => (object) [
                'Model' => 'Product',
                'Code' => 'PD001',
                'Limit' => '3'
            ],
            'IncludeSubcategory' => (object) [
                'Model' => 'Product',
                'Code' => 'PD001',
                'Limit' => '5'
            ]
        ],
        'Footer' => (object)[
            'Code' => 'FT001',
            'IncludeCategory' => (object) [
                'Model' => 'Product',
                'Code' => 'PD001',
                'Limit' => '3'
            ],
            'IncludeSubcategory' => (object) [
                'Model' => 'Product',
                'Code' => 'PD001',
                'Limit' => '5'
            ]
        ]
    ],

    /*
    Configurar quais módulos serão usados para o site/sistema no geral, exceto Header e Footer.

    Ex.:
        'Name Modulo' => (object)[
            'Code' => 'Código do Modulo',
            'ViewHome' => true,
            'Category' => true,
            'Subategory' => true,
            'ListMenu' => (object) [ Titulo do menu e ancora caso exista, caso não incluir o caractere "-"
                'Title' => 'Home',
                'Anchor' => '-',
            ],
            'IncludeSections' => (object) [array de Códigos do modulo]
        ],

    Para cadada indice do array algumas opções estão disponíveis sendo elas:
        Code => (String) Código do módulo, informado tbm no layout
        ViewHome => (Boolean) "True" para exibir uma seção na home e "False" para não
        ListMenu => (String) Título e ancora a ser exibido no menu do site e "-" para não listar no menu do site
        IncludeSections => (Array) Insere Sessões nas páginas internas do módulo, essa opção só valerá para módulos que possuem páginas internas.
                           Caso não exista seções impressas nas internas deixar o array vazio. Ex.: 'IncludeSections' => []
                           Obs.: Digitar Nome e código do modulo Ex.: ['Slide' => 'SD001', 'Topic' => 'TP002', 'News' => 'NE003']

    OBS.: Módulos não poderão se repetir no array. No módulo já está incluso todas as dependencias para que funcione corretamente,
    aqui deverá apenas informar as configurações do mesmo.
    */

    'InsertModelsMain' => (object) [
        'Slide' => (object)[
            'Code' => 'SD001',
            'ViewHome' => true,
            'Category' => false,
            'Subategory' => false,
            'ListMenu' => (object) [
                'Title' => 'Home',
                'Anchor' => ''
            ],
            'IncludeSections' => (object) []
        ],
        'Product' => (object)[
            'Code' => 'PD001',
            'ViewHome' => true,
            'Category' => true,
            'Subategory' => false,
            'ListMenu' => (object) [
                'Title' => 'Produto',
                'Anchor' => '#product'
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

    Exemplo de Caminho do controlador: Modules\Slides\Http\Controllers\SD001Controller::class

    */

    'Models' => (object) [
        'Product' => (object)[
            'PD001' => (object) [
                'Class' => 'Class Model Product',
                'Category' => 'Class Model Category',
                'Subcategory' => 'Class Model Subcategory'
            ]
        ],
    ]
];
