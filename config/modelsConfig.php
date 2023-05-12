<?php

return [
    // Configure the model the header and footer, not change the module
    'InsertModelsCore' => (object)[
        'Headers' => (object)[
            'Code' => 'HEAD02',
            'themeMenu' => 'SIDE03'
        ],
        'Footers' => (object)[
            'Code' => 'FOOT03',
        ]
    ],

    // Configure existing modules and templates site-wide/system
    'InsertModelsMain' => (object) [
        // 'Portals' => (object) [
        //     'POTA01' => (object)[
        //         'ViewHome' => true,
        //         'ViewListMenu' => true,
        //         'ViewListPanel' => true,
        //         'CustomPanelView' => [true, 'organge'], // [boolean, hexadecimal]
        //         'ViewListFooter' => true,
        //         'Viewer' => 'dropdown', // accepted values, list or dropdown
        //         // 'IncludeCore' => (object) [
        //         //     'include' => true,
        //         //     'sorting' => true,
        //         //     'limit' => 'all',
        //         //     'condition' => 'active=1{Ativos},featured_home=1{Detaques Home},featured_page=1{Detaques Página}',
        //         //     'titleList' => 'title',
        //         //     'relation' => (object)[
        //         //         'category' =>(object)[
        //         //             'name' => 'Categoria',
        //         //             'titleList' => 'title',
        //         //             'condition' => 'active=1{Ativos}',
        //         //         ]
        //         //     ],
        //         // ],
        //         'config' => (object) [
        //             'titleMenu' => 'Portal',
        //             'anchor' =>  true,
        //             'linkMenu' => 'pota01.page',
        //             'iconMenu' => '',
        //             'titlePanel' => 'Portais',
        //             'iconPanel' => ''
        //         ],
        //         'IncludeSections' => (object) []
        //     ],
        // ],

        'Products' => (object) [
            'PROD02' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'ViewListFooter' => true,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'IncludeCore' => (object) [
                    'include' => true,
                    'sorting' => true,
                    'limit' => 'all',
                    'condition' => 'active=1{Ativos},featured=1{Detaques}',
                    'titleList' => 'title',
                    'relation' => (object)[
                        'category' =>(object)[
                            'name' => 'Categoria',
                            'titleList' => 'title',
                            'condition' => 'active=1{Ativos}',
                        ]
                    ],
                ],
                'config' => (object) [
                    'titleMenu' => 'Produtos',
                    'anchor' =>  false,
                    'linkMenu' => 'prod02.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Produtos',
                    'iconPanel' => 'mdi-shopping-outline'
                ],
                'IncludeSections' => (object) [
                    'Feedbacks' => 'FEED01',
                ]
            ],
        ],

        'Services' => (object) [
            'SERV04' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'ViewListFooter' => true,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'IncludeCore' => (object) [
                    'include' => true,
                    'sorting' => true,
                    'limit' => 'all',
                    'condition' => 'active=1{Ativos},featured=1{Detaques}',
                    'titleList' => 'title',
                    'relation' => (object)[
                        'category' =>(object)[
                            'name' => 'Categoria',
                            'titleList' => 'title',
                            'condition' => 'active=1{Ativos}',
                        ]
                    ],
                ],
                'config' => (object) [
                    'titleMenu' => 'Serviços',
                    'anchor' =>  false,
                    'linkMenu' => 'serv04.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Serviços',
                    'iconPanel' => ''
                ],
                'IncludeSections' => (object) [
                    'Feedbacks' => 'FEED01',
                ]
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
