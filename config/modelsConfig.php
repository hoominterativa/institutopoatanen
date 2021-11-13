<?php

return [

    'InsertModelsCore' => (object)[
        'Headers' => (object)[
            'Code' => 'HEAD01'
        ],
        'Footers' => (object)[
            'Code' => 'FOOT01'
        ]
    ],

    'InsertModelsMain' => (object) [
        'Slides' => (object) [
            'SLID01' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => false,
                'ViewListPanel' => true,
                'IncludeCore' => [false, 3], // @param 1 boolean | @param 2 Int Limit
                'config' => (object) [
                    'titleMenu' => '',
                    'anchor' =>  false,
                    'linkMenu' => '',
                    'iconMenu' => '',
                    'titlePanel' => 'Banner',
                    'iconPanel' => 'mdi-aspect-ratio'
                ],
                'IncludeSections' => (object) []
            ],
        ],
        'Topics' => (object) [
            'TOPI01' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => false,
                'ViewListPanel' => true,
                'IncludeCore' => [false, 3], // @param 1 boolean | @param 2 Int Limit
                'config' => (object) [
                    'titleMenu' => '',
                    'anchor' =>  false,
                    'linkMenu' => '',
                    'iconMenu' => '',
                    'titlePanel' => 'Tópicos',
                    'iconPanel' => 'mdi-bookmark-multiple'
                ],
                'IncludeSections' => (object) []
            ],
        ],
        'Contacts' => (object) [
            'CONT01' => (object)[
                'ViewHome' => false,
                'ViewListMenu' => true,
                'ViewListPanel' => false,
                'IncludeCore' => [false, 3], // @param 1 boolean | @param 2 Int Limit
                'config' => (object) [
                    'titleMenu' => 'Contato',
                    'anchor' =>  false,
                    'linkMenu' => 'cont01.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Contato',
                    'iconPanel' => 'mdi-box'
                ],
                'IncludeSections' => (object) []
            ],
        ]
    ],

    'Class' => (object) [
        'Contacts' => (object)[
            'CONT01' => (object)[
                'controller' => App\Http\Controllers\Contacts\CONT01Controller::class,
            ],
        ],
        'Slides' => (object)[
            'SLID01' => (object)[
                'controller' => App\Http\Controllers\Slides\SLID01Controller::class,
                'modelo' => App\Models\Slides\SLID01Slides::class
            ],
        ],
        'Topics' => (object)[
            'TOPI01' => (object)[
                'controller' => App\Http\Controllers\Topics\TOPI01Controller::class,
                'modelo' => App\Models\Topics\TOPI01Topics::class
            ],
        ],
    ],

    'Relations' => (object) [
        // 'Product' => [
        //     'PROD01' => (object) [
        //         'before' => ['ProductCategory' => 'PRCA01','ProductSubategory' => 'PRSU01'],
        //         'after' => ['ProductGallery' => 'PRCA01','ProductPhoto' => 'PRSU01']
        //     ]
        // ]
    ],
];
