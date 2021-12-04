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
        'Services' => (object) [
            'SERV01' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'IncludeCore' => [false, 3], // @param 1 boolean | @param 2 Int Limit
                'config' => (object) [
                    'titleMenu' => 'Serviços',
                    'anchor' =>  false,
                    'linkMenu' => 'serv01.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Serviços',
                    'iconPanel' => 'mdi-room-service-outline'
                ],
                'IncludeSections' => (object) [],
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
                'model' => App\Models\Slides\SLID01Slides::class
            ],
        ],
        'Topics' => (object)[
            'TOPI01' => (object)[
                'controller' => App\Http\Controllers\Topics\TOPI01Controller::class,
                'model' => App\Models\Topics\TOPI01Topics::class
            ],
        ],
        'Services' => (object)[
            'SERV01' => (object)[
                'controller' => App\Http\Controllers\Services\SERV01Controller::class,
                'model' => App\Models\Services\SERV01Services::class
            ],
        ],
    ],

    // 'Relations' => (object) [
    //     'Services' => [
    //         'SERV01' => (object) [
    //             'before' => [
    //                 'Categories' => 'ART01',
    //             ],
    //             'after' => ['ProductGallery' => 'PRCA01','ProductPhoto' => 'PRSU01']
    //         ]
    //     ]
    // ],
];
