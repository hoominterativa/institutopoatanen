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
            'ABOU04' => (object)[
                'controller' => App\Http\Controllers\Abouts\ABOU04Controller::class,
                'model' => App\Models\Abouts\ABOU04Abouts::class,
                'seedQty' => 1,
            ],
        ],
        // END ABOUTS

        'Blogs' => (object)[
            'BLOG01' => (object)[
                'controller' => App\Http\Controllers\Blogs\BLOG01Controller::class,
                'model' => App\Models\Blogs\BLOG01Blogs::class,
                'seedQty' => 8,
                'routeName' => 'blog01.page.content',
                'relationship' => [
                    'category' => [
                        'class' => App\Models\Blogs\BLOG01BlogsCategory::class,
                        'column' => 'category_id',
                        'seedQty' => 4,
                    ]
                ]
            ],
            'BLOG03' => (object)[
                'controller' => App\Http\Controllers\Blogs\BLOG03Controller::class,
                'model' => App\Models\Blogs\BLOG03Blogs::class,
                'seedQty' => 8,
                'routeName' => 'blog03.page.content',
                'relationship' => [
                    'category' => [
                        'class' => App\Models\Blogs\BLOG03BlogsCategory::class,
                        'column' => 'category_id',
                        'seedQty' => 4,
                    ]
                ]
            ],
        ],
        // END BLOGS
        'Brands' => (object)[
            'BRAN01' => (object)[
                'controller' => App\Http\Controllers\Brands\BRAN01Controller::class,
                'model' => App\Models\Brands\BRAN01Brands::class,
                'seedQty' => 4,
            ],
        ],
        // END BRANDS
        'Contents' => (object)[
            'CONT01' => (object)[
                'controller' => App\Http\Controllers\Contents\CONT01Controller::class,
                'model' => App\Models\Contents\CONT01Contents::class,
                'seedQty' => 1,
            ],
            'CONT02' => (object)[
                'controller' => App\Http\Controllers\Contents\CONT02Controller::class,
                'model' => App\Models\Contents\CONT02Contents::class,
                'seedQty' => 1,
            ],
            'CONT02V1' => (object)[
                'controller' => App\Http\Controllers\Contents\CONT02V1Controller::class,
                'model' => App\Models\Contents\CONT02V1Contents::class,
                'seedQty' => 1,
            ],
            'CONT03' => (object)[
                'controller' => App\Http\Controllers\Contents\CONT03Controller::class,
                'model' => App\Models\Contents\CONT03Contents::class,
                'seedQty' => 1,
            ],
            'CONT04' => (object)[
                'controller' => App\Http\Controllers\Contents\CONT04Controller::class,
                'model' => App\Models\Contents\CONT04Contents::class,
                'seedQty' => 1,
            ],
            'CONT05' => (object)[
                'controller' => App\Http\Controllers\Contents\CONT05Controller::class,
                'model' => App\Models\Contents\CONT05Contents::class,
                'seedQty' => 1,
            ],
            'CONT06' => (object)[
                'controller' => App\Http\Controllers\Contents\CONT06Controller::class,
                'model' => App\Models\Contents\CONT06Contents::class,
                'seedQty' => 1,
            ],
            'CONT07' => (object)[
                'controller' => App\Http\Controllers\Contents\CONT07Controller::class,
                'model' => App\Models\Contents\CONT07Contents::class,
                'seedQty' => 4,
            ],
            'CONT09' => (object)[
                'controller' => App\Http\Controllers\Contents\CONT09Controller::class,
                'model' => App\Models\Contents\CONT09Contents::class,
                'seedQty' => 1,
            ],
            'CONT10' => (object)[
                'controller' => App\Http\Controllers\Contents\CONT10Controller::class,
                'model' => App\Models\Contents\CONT10Contents::class,
                'seedQty' => 15,
            ],
        ],
        // END CONTENTS

        'ContentPages' => (object)[
            'COPA01' => (object)[
                'controller' => App\Http\Controllers\ContentPages\COPA01Controller::class,
                'model' => App\Models\ContentPages\COPA01ContentPages::class,
                'seedQty' => 1,
            ],
            'COPA02' => (object)[
                'controller' => App\Http\Controllers\ContentPages\COPA02Controller::class,
                'model' => App\Models\ContentPages\COPA02ContentPages::class,
                'seedQty' => 3,
            ],
        ],
        // END CONTENT PAGES

        'Contacts' => (object)[
            'COTA01' => (object)[
                'controller' => App\Http\Controllers\Contacts\COTA01Controller::class,
                'model' => App\Models\Contacts\COTA01Contacts::class,
                'seedQty' => 1,
            ],
            'COTA02' => (object)[
                'controller' => App\Http\Controllers\Contacts\COTA02Controller::class,
                'model' => App\Models\Contacts\COTA02Contacts::class,
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

        'Frequently' => (object)[
            'FREQ01' => (object)[
                'controller' => App\Http\Controllers\Frequently\FREQ01Controller::class,
                'model' => App\Models\Frequently\FREQ01Frequently::class,
                'seedQty' => 2,
            ],
        ],
        // END FREQUENTLY

        'Galleries' => (object)[
            'GALL01' => (object)[
                'controller' => App\Http\Controllers\Galleries\GALL01Controller::class,
                'model' => App\Models\Galleries\GALL01Galleries::class,
                'seedQty' => 1,
            ],
            'GALL02' => (object)[
                'controller' => App\Http\Controllers\Galleries\GALL02Controller::class,
                'model' => App\Models\Galleries\GALL02Galleries::class,
                'seedQty' => 4,
            ],
            'GALL03' => (object)[
                'controller' => App\Http\Controllers\Galleries\GALL03Controller::class,
                'model' => App\Models\Galleries\GALL03Galleries::class,
                'seedQty' => 12,
            ],
        ],
        // END GALLERIES

        'Portfolios' => (object)[
            'PORT01' => (object)[
                'controller' => App\Http\Controllers\Portfolios\PORT01Controller::class,
                'model' => App\Models\Portfolios\PORT01Portfolios::class,
                'seedQty' => 10,
                'routeName' => 'port01.page.content',
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
            'PORT02' => (object)[
                'controller' => App\Http\Controllers\Portfolios\PORT02Controller::class,
                'model' => App\Models\Portfolios\PORT02Portfolios::class,
                'seedQty' => 4,
                'routeName' => 'port02.page.content',
                'relationship' => [
                    'category' => [
                        'class' => App\Models\Portfolios\PORT02PortfoliosCategory::class,
                        'column' => 'category_id',
                        'seedQty' => 4,
                    ]
                ]
            ],
            'PORT101' => (object)[
                'controller' => App\Http\Controllers\Portfolios\PORT101Controller::class,
                'model' => App\Models\Portfolios\PORT101Portfolios::class,
                'seedQty' => 4,
            ],
        ],
        // END PORTFOLIOS

        'Products' => (object)[
            'PROD02' => (object)[
                'controller' => App\Http\Controllers\Products\PROD02Controller::class,
                'model' => App\Models\Products\PROD02Products::class,
                'seedQty' => 12,
                'routeName' => 'prod02.page.content',
                'relationship' => [
                    'category' => [
                        'class' => App\Models\Products\PROD02ProductsCategory::class,
                        'column' => 'category_id',
                        'seedQty' => 5,
                    ]
                ]
            ],
            'PROD02V1' => (object)[
                'controller' => App\Http\Controllers\Products\PROD02V1Controller::class,
                'model' => App\Models\Products\PROD02V1Products::class,
                'seedQty' => 12,
                'routeName' => 'prod02v1.page.content',
                'relationship' => [
                    'category' => [
                        'class' => App\Models\Products\PROD02V1ProductsCategory::class,
                        'column' => 'category_id',
                        'seedQty' => 5,
                    ]
                ]
            ],
        ],
        // END PRODUCTS

        'Portals' => (object)[
            'POTA01' => (object)[
                'controller' => App\Http\Controllers\Portals\POTA01Controller::class,
                'model' => App\Models\Portals\POTA01Portals::class,
                'seedQty' => 12,
                'routeName' => 'pota01.page.content',
                'relationship' => [
                    'category' => [
                        'class' => App\Models\Portals\POTA01PortalsCategory::class,
                        'column' => 'category_id',
                        'seedQty' => 5,
                    ]
                ]
            ],
        ],
        // END PRODUCTS

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
                'routeName' => 'serv04.page.content',
                'relationship' => [
                    'category' => [
                        'class' => App\Models\Services\SERV04ServicesCategory::class,
                        'column' => 'category_id',
                        'seedQty' => 4,
                    ]
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
            'TOPI03' => (object)[
                'controller' => App\Http\Controllers\Topics\TOPI03Controller::class,
                'model' => App\Models\Topics\TOPI03Topics::class,
                'seedQty' => 4,
            ],
            'TOPI04' => (object)[
                'controller' => App\Http\Controllers\Topics\TOPI04Controller::class,
                'model' => App\Models\Topics\TOPI04Topics::class,
                'seedQty' => 1,
            ],
            'TOPI05' => (object)[
                'controller' => App\Http\Controllers\Topics\TOPI05Controller::class,
                'model' => App\Models\Topics\TOPI05Topics::class,
                'seedQty' => 3,
            ],
            'TOPI06' => (object)[
                'controller' => App\Http\Controllers\Topics\TOPI06Controller::class,
                'model' => App\Models\Topics\TOPI06Topics::class,
                'seedQty' => 2,
            ],
            'TOPI08' => (object)[
                'controller' => App\Http\Controllers\Topics\TOPI08Controller::class,
                'model' => App\Models\Topics\TOPI08Topics::class,
                'seedQty' => 4,
            ],
            'TOPI10' => (object)[
                'controller' => App\Http\Controllers\Topics\TOPI10Controller::class,
                'model' => App\Models\Topics\TOPI10Topics::class,
                'seedQty' => 6,
            ],
            'TOPI101' => (object)[
                'controller' => App\Http\Controllers\Topics\TOPI101Controller::class,
                'model' => App\Models\Topics\TOPI101Topics::class,
                'seedQty' => 4,
            ],
            'TOPI102' => (object)[
                'controller' => App\Http\Controllers\Topics\TOPI102Controller::class,
                'model' => App\Models\Topics\TOPI102Topics::class,
                'seedQty' => 4,
            ],
        ],
        // END TOPICS

        'Teams' => (object)[
            'TEAM01' => (object)[
                'controller' => App\Http\Controllers\Teams\TEAM01Controller::class,
                'model' => App\Models\Teams\TEAM01Teams::class,
                'seedQty' => 12,
                'routeName' => 'team01.page.content',
                'relationship' => [
                    'category' => [
                        'class' => App\Models\Teams\TEAM01TeamsCategory::class,
                        'column' => 'category_id',
                        'seedQty' => 4,
                    ]
                ]
            ]
        ],
        // END TEAMS

        'Feedbacks' => (object)[
            'FEED01' => (object)[
                'controller' => App\Http\Controllers\Feedbacks\FEED01Controller::class,
                'model' => App\Models\Feedbacks\FEED01Feedbacks::class,
                'seedQty' => 1,
            ],
            'FEED03' => (object)[
                'controller' => App\Http\Controllers\Feedbacks\FEED03Controller::class,
                'model' => App\Models\Feedbacks\FEED03Feedbacks::class,
                'seedQty' => 3,
            ],
        ],
        // END FEEDBACKS

        'Units' => (object)[
            'UNIT01' => (object)[
                'controller' => App\Http\Controllers\Units\UNIT01Controller::class,
                'model' => App\Models\Units\UNIT01Units::class,
                'seedQty' => 2,
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
