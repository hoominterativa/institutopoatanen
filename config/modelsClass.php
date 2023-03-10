<?php
// Change only in case of new modules or models

return [
    'Class' => (object) [
        'Abouts' => (object)[
            'ABOU01' => (object)[
                'controller' => App\Http\Controllers\Abouts\ABOU01Controller::class,
                'model' => App\Models\Abouts\ABOU01Abouts::class,
                'seedQty' => 1,
            ],
            'ABOU02' => (object)[
                'controller' => App\Http\Controllers\Abouts\ABOU02Controller::class,
                'model' => App\Models\Abouts\ABOU02Abouts::class,
                'seedQty' => 1,
            ],
        ],
        // END ABOUTS

        'Blogs' => (object)[
            'BLOG01' => (object)[
                'controller' => App\Http\Controllers\Blogs\BLOG01Controller::class,
                'model' => App\Models\Blogs\BLOG01Blogs::class,
                'seedQty' => 8,
                'relationship' => [
                    'category' => [
                        'class' => App\Models\Blogs\BLOG01BlogsCategory::class,
                        'column' => 'category_id',
                        'seedQty' => 4,
                    ]
                ]
            ],
        ],
        // END BLOGS

        'Contents' => (object)[
            'CONT01' => (object)[
                'controller' => App\Http\Controllers\Contents\CONT01Controller::class,
                'model' => App\Models\Contents\CONT01Contents::class,
                'seedQty' => 1,
            ],
            'CONT03' => (object)[
                'controller' => App\Http\Controllers\Contents\CONT03Controller::class,
                'model' => App\Models\Contents\CONT03Contents::class,
                'seedQty' => 1,
            ],
            'CONT06' => (object)[
                'controller' => App\Http\Controllers\Contents\CONT06Controller::class,
                'model' => App\Models\Contents\CONT06Contents::class,
                'seedQty' => 1,
            ],
            'CONT10' => (object)[
                'controller' => App\Http\Controllers\Contents\CONT10Controller::class,
                'model' => App\Models\Contents\CONT10Contents::class,
                'seedQty' => 1,
            ],
        ],
        // END CONTENTS

        'ContentPages' => (object)[
            'COPA01' => (object)[
                'controller' => App\Http\Controllers\ContentPages\COPA01Controller::class,
                'model' => App\Models\ContentPages\COPA01ContentPages::class,
                'seedQty' => 1,
            ],
        ],
        // END CONTENT PAGES

        'Contacts' => (object)[
            'COTA01' => (object)[
                'controller' => App\Http\Controllers\Contacts\COTA01Controller::class,
                'model' => App\Models\Contacts\COTA01Contacts::class,
                'seedQty' => 1,
            ],
        ],
        // END CONTACTS

        'Compliances' => (object)[
            'COMP01' => (object)[
                'controller' => App\Http\Controllers\Compliances\COMP01Controller::class,
                'model' => App\Models\Compliances\COMP01Compliances::class,
                'seedQty' => 1,
            ],
        ],
        // END COMPLIANCES

        'Portfolios' => (object)[
            'PORT01' => (object)[
                'controller' => App\Http\Controllers\Portfolios\PORT01Controller::class,
                'model' => App\Models\Portfolios\PORT01Portfolios::class,
                'seedQty' => 10,
                'relationship' => [
                    'category' => [
                        'class' => App\Models\Portfolios\PORT01PortfoliosCategory::class,
                        'column' => 'category_id',
                        'seedQty' => 4,
                    ],
                    'subcategory' => [
                        'class' => App\Models\Portfolios\PORT01PortfoliosSubategory::class,
                        'column' => 'subcategory_id',
                        'seedQty' => 4,
                    ]
                ]
            ],
        ],
        // END PORTFOLIOS

        'Services' => (object)[
            'SERV01' => (object)[
                'controller' => App\Http\Controllers\Services\SERV01Controller::class,
                'model' => App\Models\Services\SERV01Services::class,
                'seedQty' => 4,
            ],
            'SERV04' => (object)[
                'controller' => App\Http\Controllers\Services\SERV04Controller::class,
                'model' => App\Models\Services\SERV04Services::class,
                'seedQty' => 4,
            ],
        ],
        // END SERVICES

        'Products' => (object)[
            'PROD02' => (object)[
                'controller' => App\Http\Controllers\Products\PROD02Controller::class,
                'model' => App\Models\Products\PROD02Products::class,
                'seedQty' => 1,
            ],
        ],
        // END PRODUCTS


        'Slides' => (object)[
            'SLID01' => (object)[
                'controller' => App\Http\Controllers\Slides\SLID01Controller::class,
                'model' => App\Models\Slides\SLID01Slides::class,
                'seedQty' => 1,
            ],
            'SLID02' => (object)[
                'controller' => App\Http\Controllers\Slides\SLID02Controller::class,
                'model' => App\Models\Slides\SLID02Slides::class,
                'seedQty' => 1,
            ],
        ],
        // END SLIDES

        'Topics' => (object)[
            'TOPI01' => (object)[
                'controller' => App\Http\Controllers\Topics\TOPI01Controller::class,
                'model' => App\Models\Topics\TOPI01Topics::class,
                'seedQty' => 5,
            ],
            'TOPI02' => (object)[
                'controller' => App\Http\Controllers\Topics\TOPI02Controller::class,
                'model' => App\Models\Topics\TOPI02Topics::class,
                'seedQty' => 4,
            ],
            'TOPI04' => (object)[
                'controller' => App\Http\Controllers\Topics\TOPI04Controller::class,
                'model' => App\Models\Topics\TOPI04Topics::class,
                'seedQty' => 4,
            ],
            'TOPI05' => (object)[
                'controller' => App\Http\Controllers\Topics\TOPI05Controller::class,
                'model' => App\Models\Topics\TOPI05Topics::class,
                'seedQty' => 4,
            ],
            'TOPI102' => (object)[
                'controller' => App\Http\Controllers\Topics\TOPI102Controller::class,
                'model' => App\Models\Topics\TOPI102Topics::class,
                'seedQty' => 4,
            ],
        ],
        // END TOPICS

        'Feedbacks' => (object)[
            'FEED03' => (object)[
                'controller' => App\Http\Controllers\Feedbacks\FEED03Controller::class,
                'model' => App\Models\Feedbacks\FEED03Abouts::class,
                'seedQty' => 1,
            ],
        ],
        // END FEEDBACKS

        'Units' => (object)[
            'UNIT01' => (object)[
                'controller' => App\Http\Controllers\Units\UNIT01Controller::class,
                'model' => App\Models\Units\UNIT01Units::class,
                'seedQty' => 1,
            ],
        ],
        // END UNITS

        'WorkWith' => (object)[
            'WOWI01' => (object)[
                'controller' => App\Http\Controllers\WorkWith\WOWI01Controller::class,
                'model' => App\Models\WorkWith\WOWI01WorkWith::class,
                'seedQty' => 1,
            ],
        ],
        // END TOPICS
    ],
];
