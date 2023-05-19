<?php

return [
    // Configure the model the header and footer, not change the module
    'InsertModelsCore' => (object)[
        'Headers' => (object)[
            'Code' => 'HEAD02',
            'themeMenu' => 'SIDE02'
        ],
        'Footers' => (object)[
            'Code' => 'FOOT02'
        ]
    ],

    // Configure existing modules and templates site-wide/system
    'InsertModelsMain' => (object) [
        'Portals' => (object) [
            'POTA01' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'CustomPanelView' => [true, '#ffa500'], // [boolean, hexadecimal]
                'ViewListFooter' => true,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'IncludeCore' => (object) [
                    'include' => true,
                    'sorting' => true,
                    'limit' => 'all',
                    'condition' => 'active=1{Ativos},featured_home=1{Detaques Home},featured_page=1{Detaques Página}',
                    'titleList' => 'title',
                    'relation' => (object)[
                        'category' =>(object)[
                            'name' => 'Categoria',
                            'titleList' => 'title',
                            'condition' => 'active=1{Ativos},featured_home=1{Detaques Home}',
                        ]
                    ],
                ],
                'pages' => (object) [
                    'podcast' =>(object)[
                        'name' => 'Podcast',
                        'route' => 'pota01.podcast',
                    ]
                ],
                'config' => (object) [
                    'titleMenu' => 'Notícias',
                    'anchor' =>  false,
                    'linkMenu' => 'pota01.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Notícias',
                    'iconPanel' => 'mdi-filter-plus'
                ],
                'IncludeSections' => (object) []
            ],
        ],
        'Abouts' => (object) [
            'ABOU02' => (object)[
                'ViewHome' => false,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'config' => (object) [
                    'titleMenu' => 'Sobre o Portal',
                    'anchor' =>  false,
                    'linkMenu' => 'abou02.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Sobre o Portal',
                    'iconPanel' => ''
                ],
                'IncludeSections' => (object) [
                ]
            ],
        ],
        'Brands' => (object) [
            'BRAN01' => (object)[
                'ViewHome' => false,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'config' => (object) [
                    'titleMenu' => 'Parceiros',
                    'anchor' =>  false,
                    'linkMenu' => 'bran01.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Parceiros',
                    'iconPanel' => ''
                ],
                'IncludeSections' => (object) []
            ],
        ],
        'Contacts' => (object) [
            'COTA02' => (object)[
                'ViewHome' => false,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'config' => (object) [
                    'titleMenu' => 'Anúncie',
                    'anchor' =>  false,
                    'linkMenu' => 'cota02.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Anúncie',
                    'iconPanel' => ''
                ],
                'IncludeSections' => (object) []
            ],
        ],
    ],

    'ModelsForm' => (object)[
        'FORM101' => 'Contacts_FORM101.jpg',
    ],

    'ModelsCompliances' => (object)[
        'Code' => 'COMP01'
    ],
];
