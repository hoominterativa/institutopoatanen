<?php

return [

    'InsertModelsCore' => (object)[
        // 'Headers' => (object)[
        //     'Code' => 'HEAD01',
        //     'IncludeCategory' => (object) [
        //         'Model' => 'CategoryProduct',
        //         'Code' => 'CP001',
        //         'Limit' => '3'
        //     ],
        //     'IncludeSubcategory' => (object)[]
        // ],
        // 'Footers' => (object)[
        //     'Code' => 'FOOT01',
        //     'IncludeCategory' => (object)[],
        //     'IncludeSubcategory' => (object)[]
        // ]
    ],

    'InsertModelsMain' => (object) [
        // 'Product' => (object)[
        //     'PROD01' => (object)[
        //         'ViewHome' => true,
        //         'ViewListMenu' => true,
        //         'config' => (object) [
        //             'titleMenu' => 'Produtos',
        //             'achor' =>  false,
        //             'linkMenu' => 'home',
        //             'iconMenu' => 'mdi-home',
        //             'titlePanel' => 'Produtos',
        //             'iconPanel' => 'mdi-box'
        //         ],
        //         'IncludeSections' => (object) []
        //     ],
        //     'PROD02' => (object)[
        //         'ViewHome' => true,
        //         'ViewListMenu' => true,
        //         'config' => (object) [
        //             'titleMenu' => 'Artigos',
        //             'achor' =>  false,
        //             'linkMenu' => 'home',
        //             'iconMenu' => 'mdi-home',
        //             'titlePanel' => 'Artigos',
        //             'iconPanel' => 'mdi-box'
        //         ],
        //         'IncludeSections' => (object) []
        //     ],
        // ]
    ],

    'Relations' => (object) [
        'Product' => [
            'PROD01' => (object) [
                'before' => ['ProductCategory' => 'PRCA01','ProductSubategory' => 'PRSU01'],
                'after' => ['ProductGallery' => 'PRCA01','ProductPhoto' => 'PRSU01']
            ]
        ]
    ],

    'Class' => (object) [
        'Product' => (object)[
            'PROD01' => App\Http\Controllers\Product\PROD01Controller::class,
            'PROD02' => App\Http\Controllers\Product\PROD02Controller::class,
        ],
    ],
];
