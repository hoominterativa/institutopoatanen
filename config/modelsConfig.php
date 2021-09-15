<?php

return [

    'InsertModelsCore' => (object)[
        'Headers' => (object)[
            // 'Code' => 'HEAD01'
        ],
        'Footers' => (object)[
            // 'Code' => 'FOOT01'
        ]
    ],

    'InsertModelsMain' => (object) [
        'Products' => (object) [
            'PROD01' => (object)[
                'ViewHome' => false,
                'ViewListMenu' => true,
                'IncludeCore' => [true, 3], // @param 1 boolean | @param 2 Int Limit
                'config' => (object) [
                    'titleMenu' => 'Produtos',
                    'anchor' =>  false,
                    'linkMenu' => 'prod01.page',
                    'iconMenu' => 'mdi-home',
                    'titlePanel' => 'Produtos',
                    'iconPanel' => 'mdi-box'
                ],
                'IncludeSections' => (object) []
            ],
            'PROD02' => (object)[
                'ViewHome' => false,
                'ViewListMenu' => true,
                'IncludeCore' => [true, 3], // @param 1 boolean | @param 2 Int Limit
                'config' => (object) [
                    'titleMenu' => 'Artigos',
                    'anchor' =>  false,
                    'linkMenu' => 'prod02.page',
                    'iconMenu' => 'mdi-home',
                    'titlePanel' => 'Artigos',
                    'iconPanel' => 'mdi-box'
                ],
                'IncludeSections' => (object) []
            ],
        ]
    ],

    'Relations' => (object) [
        // 'Product' => [
        //     'PROD01' => (object) [
        //         'before' => ['ProductCategory' => 'PRCA01','ProductSubategory' => 'PRSU01'],
        //         'after' => ['ProductGallery' => 'PRCA01','ProductPhoto' => 'PRSU01']
        //     ]
        // ]
    ],

    'Class' => (object) [
        'Products' => (object)[
            'PROD01' => (object)[
                'controller' => App\Http\Controllers\Products\PROD01Controller::class,
                'model' => App\Models\Products\PROD01Products::class,
            ],
        ],
    ],
];
