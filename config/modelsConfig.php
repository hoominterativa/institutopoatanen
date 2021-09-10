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
        'Products' => (object)[
            'PROD01' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => true,
                'IncludeCore' => [false],
                'config' => (object) [
                    'titleMenu' => 'Produtos',
                    'achor' =>  false,
                    'linkMenu' => 'home',
                    'iconMenu' => 'mdi-home',
                    'titlePanel' => 'Produtos',
                    'iconPanel' => 'mdi-box'
                ],
                'IncludeSections' => (object) []
            ]
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
