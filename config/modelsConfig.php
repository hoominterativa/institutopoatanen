<?php

return [
    // Configure the model the header and footer, not change the module
    'InsertModelsCore' => (object)[
        'Headers' => (object)[
            'Code' => 'HEAD01',
            'themeMenu' => 'MENU01'
        ],
        'Footers' => (object)[]
    ],

    // Configure existing modules and templates site-wide/system
    'InsertModelsMain' => (object) [
        'Slides' => (object) [
            'SLID01' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => false,
                'ViewListPanel' => true,
                'config' => (object) [
                    'titleMenu' => '',
                    'anchor' =>  false,
                    'linkMenu' => '',
                    'iconMenu' => '',
                    'titlePanel' => 'Banners',
                    'iconPanel' => 'mdi-monitor-screenshot'
                ]
            ],
        ],
        'Contents' => (object) [
            'CONT01' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => false,
                'ViewListPanel' => true,
                'config' => (object) [
                    'titleMenu' => '',
                    'anchor' =>  false,
                    'linkMenu' => '',
                    'iconMenu' => '',
                    'titlePanel' => 'Seção de Conteúdo',
                    'iconPanel' => 'mdi-play-protected-content'
                ]
            ],
        ],
        'Portfolios' => (object) [
            'PORT01' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'IncludeCore' => (object) [
                    'include' => false,
                    'limit' => 4,
                    'condition' => 'active',
                    'relation' => 'category',
                ],
                'config' => (object) [
                    'titleMenu' => 'O que fazemos',
                    'anchor' =>  false,
                    'linkMenu' => 'port01.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Portifólios',
                    'iconPanel' => 'mdi-book-open-outline'
                ],
                'IncludeSections' => (object) [],
            ],
        ],
    ],

    'ModelsForm' => (object)[
        'FORM01' => 'Contacts_FORM01.jpg',
        'FORM02' => 'Contacts_FORM02.jpg',
        'FORM03' => 'Newsletter_FORM01.jpg',
        'FORM04' => 'Newsletter_FORM02.jpg',
    ],
];
