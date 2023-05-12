<?php

return [
    // Configure the model the header and footer, not change the module
    'InsertModelsCore' => (object)[
        'Headers' => (object)[
            'Code' => 'HEAD02',
            'themeMenu' => 'SIDE02'
        ],
        'Footers' => (object)[
            'Code' => 'FOOT02',
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
                // 'IncludeCore' => (object) [
                //     'include' => true,
                //     'sorting' => true,
                //     'limit' => 'all',
                //     'condition' => 'active=1{Ativos},featured_home=1{Detaques Home},featured_page=1{Detaques Página}',
                //     'titleList' => 'title',
                //     'relation' => (object)[
                //         'category' =>(object)[
                //             'name' => 'Categoria',
                //             'titleList' => 'title',
                //             'condition' => 'active=1{Ativos}',
                //         ]
                //     ],
                // ],
                'config' => (object) [
                    'titleMenu' => 'Portal',
                    'anchor' =>  false,
                    'linkMenu' => 'pota01.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Portais',
                    'iconPanel' => 'mdi-filter-plus'
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
