<?php
return [
    // Change only in case of new modules or models
    'Class' => (object) [
        'Services' => (object)[
            'SERV01' => (object)[
                'controller' => App\Http\Controllers\Services\SERV01Controller::class,
                'model' => App\Models\Services\SERV01Services::class,
                'relationship' => [
                    'category' => [
                        'class' => App\Models\Services\SERV01ServicesCategories::class,
                        'column' => 'category_id'
                    ],
                    'subcategory' => [
                        'class' => App\Models\Services\SERV01ServicesSubcategories::class,
                        'column' => 'subcategory_id'
                    ]
                ]
            ],
        ],
    ],
];
