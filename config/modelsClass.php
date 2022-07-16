<?php
return [
    // Change only in case of new modules or models
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
