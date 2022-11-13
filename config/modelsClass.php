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
        ],
        // END ABOUTS

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
        ],
        // END CONTENTS

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
                'relationshipSon' => [
                    ['class' => App\Models\Services\SERV01ServicesAdvantage::class, 'seedQty' => 4],
                    ['class' => App\Models\Services\SERV01ServicesAdvantageSection::class, 'seedQty' => 1],
                    ['class' => App\Models\Services\SERV01ServicesPortfolio::class, 'seedQty' => 4],
                    ['class' => App\Models\Services\SERV01ServicesPortfolioSection::class, 'seedQty' => 1],
                ]
            ],
        ],
        // END SERVICES

        'Slides' => (object)[
            'SLID01' => (object)[
                'controller' => App\Http\Controllers\Slides\SLID01Controller::class,
                'model' => App\Models\Slides\SLID01Slides::class,
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
        ],
        // END TOPICS
    ],
];
