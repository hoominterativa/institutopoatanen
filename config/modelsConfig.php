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
        'Name Modulo' => (object)[
            'Code' => 'Código do Modulo',
            'ViewHome' => true,
            'ListMenu' => (object) [ Titulo do menu e ancora caso exista, caso não incluir o caractere "-"
                'Title' => 'Home',
                'Anchor' => '-',
            ],
            'IncludeSections' => (object) [ array de Códigos do modulo
                'Slides' => 'SD001',
                'Topics' => 'TP002',
                'News' => 'NE003'
            ]
        ],

    Para cadada indice do array algumas opções estão disponíveis sendo elas:
        Code => (String) Código do módulo, informado tbm no layout
        ViewHome => (Boolean) "True" para exibir uma seção na home e "False" para não
        ListMenu => (Array) Título e ancora a ser exibido no menu do site e vazio para não listar no menu do site
        Title=> (String) Título que será impresso nos menus, nas sessões, nos boxes do painel e links do site
        Anchor => (string) Caso o link seja uma ancora Ex.: #topi01 caso contrário deixar vazio
        IncludeSections => (Array) Insere Sessões nas páginas internas do módulo, essa opção só valerá para módulos que possuem páginas internas.
                           Caso não exista seções impressas nas internas deixar o array vazio. Ex.: 'IncludeSections' => []
                           Obs.: Digitar Nome e código do modulo Ex.: ['Slide' => 'SD001', 'Topic' => 'TP002', 'News' => 'NE003']

    OBS.: Módulos não poderão se repetir no array. No módulo já está incluso todas as dependencias para que funcione corretamente,
    aqui deverá apenas informar as configurações do mesmo.
    */

    'InsertModelsMain' => (object) [
        'Topics' => (object)[
            'Code' => 'TOPI01',
            'ViewHome' => true,
            'ListMenu' => (object) [
                'Title' => 'Tópicos',
                'Anchor' => 'javascript:void(0)'
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
