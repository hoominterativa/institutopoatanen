<?php
// Change only in case of new modules or models

return [
    'Class' => (object) [
        'Abouts' => (object)[
            'ABOU01' => (object)[
                'controller' => App\Http\Controllers\Abouts\ABOU01Controller::class,
                'model' => App\Models\Abouts\ABOU01Abouts::class,
                'seedQty' => 2,
            ],
            'ABOU02' => (object)[
                'controller' => App\Http\Controllers\Abouts\ABOU02Controller::class,
                'model' => App\Models\Abouts\ABOU02Abouts::class,
                'seedQty' => 1,
            ],
            'ABOU04' => (object)[
                'controller' => App\Http\Controllers\Abouts\ABOU04Controller::class,
                'model' => App\Models\Abouts\ABOU04Abouts::class,
                'seedQty' => 2,
            ],
            'ABOU05' => (object)[
                'controller' => App\Http\Controllers\Abouts\ABOU05Controller::class,
                'model' => App\Models\Abouts\ABOU05Abouts::class,
                'seedQty' => 1,
            ],
        ],
        // END ABOUTS

        'BlankPages' => (object)[
            'BAPA01' => (object)[
                'controller' => App\Http\Controllers\BlankPages\BAPA01Controller::class,
                'model' => App\Models\BlankPages\BAPA01BlankPages::class,
                'seedQty' => 1,
            ],
        ],

        'Blogs' => (object)[
            'BLOG01' => (object)[
                'controller' => App\Http\Controllers\Blogs\BLOG01Controller::class,
                'model' => App\Models\Blogs\BLOG01Blogs::class,
                'seedQty' => 8,
                'routeName' => 'blog01.show.content',
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
                'routeName' => 'blog03.show.content',
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
            'BRAN02' => (object)[
                'controller' => App\Http\Controllers\Brands\BRAN02Controller::class,
                'model' => App\Models\Brands\BRAN02Brands::class,
                'seedQty' => 1,
            ],
            'BRAN04' => (object)[
                'controller' => App\Http\Controllers\Brands\BRAN04Controller::class,
                'model' => App\Models\Brands\BRAN04Brands::class,
                'seedQty' => 12,
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
            'CONT02V2' => (object)[
                'controller' => App\Http\Controllers\Contents\CONT02V2Controller::class,
                'model' => App\Models\Contents\CONT02V2Contents::class,
                'seedQty' => 2,
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
            'CONT06V1' => (object)[
                'controller' => App\Http\Controllers\Contents\CONT06V1Controller::class,
                'model' => App\Models\Contents\CONT06V1Contents::class,
                'seedQty' => 1,
            ],
            'CONT06V2' => (object)[
                'controller' => App\Http\Controllers\Contents\CONT06V2Controller::class,
                'model' => App\Models\Contents\CONT06V2Contents::class,
                'seedQty' => 1,
            ],
            'CONT07' => (object)[
                'controller' => App\Http\Controllers\Contents\CONT07Controller::class,
                'model' => App\Models\Contents\CONT07Contents::class,
                'seedQty' => 4,
            ],
            'CONT08' => (object)[
                'controller' => App\Http\Controllers\Contents\CONT08Controller::class,
                'model' => App\Models\Contents\CONT08Contents::class,
                'seedQty' => 1,
            ],
            'CONT09' => (object)[
                'controller' => App\Http\Controllers\Contents\CONT09Controller::class,
                'model' => App\Models\Contents\CONT09Contents::class,
                'seedQty' => 1,
            ],
            'CONT10' => (object)[
                'controller' => App\Http\Controllers\Contents\CONT10Controller::class,
                'model' => App\Models\Contents\CONT10Contents::class,
                'seedQty' => 1,
            ],
            'CONT10V1' => (object)[
                'controller' => App\Http\Controllers\Contents\CONT10V1Controller::class,
                'model' => App\Models\Contents\CONT10V1Contents::class,
                'seedQty' => 1,
            ],
            'CONT10V2' => (object)[
                'controller' => App\Http\Controllers\Contents\CONT10V2Controller::class,
                'model' => App\Models\Contents\CONT10V2Contents::class,
                'seedQty' => 1,
            ],
            'CONT11' => (object)[
                'controller' => App\Http\Controllers\Contents\CONT11Controller::class,
                'model' => App\Models\Contents\CONT11Contents::class,
                'seedQty' => 1,
            ],
            'CONT12' => (object)[
                'controller' => App\Http\Controllers\Contents\CONT12Controller::class,
                'model' => App\Models\Contents\CONT12Contents::class,
                'seedQty' => 1,
            ],
            'CONT13' => (object)[
                'controller' => App\Http\Controllers\Contents\CONT13Controller::class,
                'model' => App\Models\Contents\CONT13Contents::class,
                'seedQty' => 10,
            ],
            'CONT14' => (object)[
                'controller' => App\Http\Controllers\Contents\CONT14Controller::class,
                'model' => App\Models\Contents\CONT14Contents::class,
                'seedQty' => 8,
                'routeName' => 'cont14.show',
                'relationship' => [
                    'category' => [
                        'class' => App\Models\Contents\CONT14ContentsCategory::class,
                        'column' => 'category_id',
                        'seedQty' => 3,
                    ]
                ]
            ],
        ],
        // END CONTENTS

        'ContentPages' => (object)[
            'COPA01' => (object)[
                'controller' => App\Http\Controllers\ContentPages\COPA01Controller::class,
                'model' => App\Models\ContentPages\COPA01ContentPages::class,
                'seedQty' => 2,
            ],
            'COPA02' => (object)[
                'controller' => App\Http\Controllers\ContentPages\COPA02Controller::class,
                'model' => App\Models\ContentPages\COPA02ContentPages::class,
                'seedQty' => 2,
            ],
            'COPA03' => (object)[
                'controller' => App\Http\Controllers\ContentPages\COPA03Controller::class,
                'model' => App\Models\ContentPages\COPA03ContentPages::class,
                'seedQty' => 2,
                'routeName' => 'copa03.category.page',
            ],
            'COPA04' => (object)[
                'controller' => App\Http\Controllers\ContentPages\COPA04Controller::class,
                'model' => App\Models\ContentPages\COPA04ContentPages::class,
                'seedQty' => 2,
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
            'COTA03' => (object)[
                'controller' => App\Http\Controllers\Contacts\COTA03Controller::class,
                'model' => App\Models\Contacts\COTA03Contacts::class,
                'seedQty' => 1,
            ],
            'COTA04' => (object)[
                'controller' => App\Http\Controllers\Contacts\COTA04Controller::class,
                'model' => App\Models\Contacts\COTA04Contacts::class,
                'seedQty' => 1,
            ],
            'COTA05' => (object)[
                'controller' => App\Http\Controllers\Contacts\COTA05Controller::class,
                'model' => App\Models\Contacts\COTA05Contacts::class,
                'seedQty' => 2,
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
                'seedQty' => 10,
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
                'routeName' => 'port01.category.page',
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
                'routeName' => 'port02.category.page',
                'relationship' => [
                    'category' => [
                        'class' => App\Models\Portfolios\PORT02PortfoliosCategory::class,
                        'column' => 'category_id',
                        'seedQty' => 4,
                    ]
                ]
            ],
            'PORT03' => (object)[
                'controller' => App\Http\Controllers\Portfolios\PORT03Controller::class,
                'model' => App\Models\Portfolios\PORT03Portfolios::class,
                'seedQty' => 9,
                'routeName' => 'port02.category.page',
                'relationship' => [
                    'category' => [
                        'class' => App\Models\Portfolios\PORT03PortfoliosCategory::class,
                        'column' => 'category_id',
                        'seedQty' => 4,
                    ]
                ]
            ],
            'PORT04' => (object)[
                'controller' => App\Http\Controllers\Portfolios\PORT04Controller::class,
                'model' => App\Models\Portfolios\PORT04Portfolios::class,
                'seedQty' => 6,
                'routeName' => 'port04.category.page',
                'relationship' => [
                    'category' => [
                        'class' => App\Models\Portfolios\PORT04PortfoliosCategory::class,
                        'column' => 'category_id',
                        'seedQty' => 5,
                    ]
                ]
            ],
            'PORT05' => (object)[
                'controller' => App\Http\Controllers\Portfolios\PORT05Controller::class,
                'model' => App\Models\Portfolios\PORT05Portfolios::class,
                'seedQty' => 9,
                'routeName' => 'port05.show',
                'relationship' => [
                    'category' => [
                        'class' => App\Models\Portfolios\PORT05PortfoliosCategory::class,
                        'column' => 'category_id',
                        'seedQty' => 4,
                    ]
                ]
            ],
            'PORT06' => (object)[
                'controller' => App\Http\Controllers\Portfolios\PORT06Controller::class,
                'model' => App\Models\Portfolios\PORT06Portfolios::class,
                'seedQty' => 0,
                'routeName' => 'port06.category.page',
                'relationship' => [
                    'category' => [
                        'class' => App\Models\Portfolios\PORT04PortfoliosCategory::class,
                        'column' => 'category_id',
                        'seedQty' => 0,
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
                // 'routeName' => 'prod02.page.content',
                'routeName' => 'prod02.category.page',
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
                // 'routeName' => 'prod02v1.page.content',
                'routeName' => 'prod02v1.category.page',
                'relationship' => [
                    'category' => [
                        'class' => App\Models\Products\PROD02V1ProductsCategory::class,
                        'column' => 'category_id',
                        'seedQty' => 5,
                    ]
                ]
            ],
            'PROD05' => (object)[
                'controller' => App\Http\Controllers\Products\PROD05Controller::class,
                'model' => App\Models\Products\PROD05Products::class,
                'seedQty' => 4,
                'routeName' => 'prod05.page.content',
                'relationship' => [
                    'category' => [
                        'class' => App\Models\Products\PROD05ProductsCategory::class,
                        'column' => 'category_id',
                        'seedQty' => 5,
                    ],
                    'subcategory' => [
                        'class' => App\Models\Products\PROD05ProductsSubcategory::class,
                        'column' => 'subcategory_id',
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
                'routeName' => 'pota01.show.content',
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
            'SERV02' => (object)[
                'controller' => App\Http\Controllers\Services\SERV02Controller::class,
                'model' => App\Models\Services\SERV02Services::class,
                'seedQty' => 8,
                'routeName' => 'serv02.show',
            ],
            'SERV04' => (object)[
                'controller' => App\Http\Controllers\Services\SERV04Controller::class,
                'model' => App\Models\Services\SERV04Services::class,
                'seedQty' => 4,
                'routeName' => 'serv04.show',
                'relationship' => [
                    'category' => [
                        'class' => App\Models\Services\SERV04ServicesCategory::class,
                        'column' => 'category_id',
                        'seedQty' => 4,
                    ]
                ]
            ],
            'SERV05' => (object)[
                'controller' => App\Http\Controllers\Services\SERV05Controller::class,
                'model' => App\Models\Services\SERV05Services::class,
                'seedQty' => 12,
                'routeName' => 'serv05.show.content',
                'relationship' => [
                    'category' => [
                        'class' => App\Models\Services\SERV05ServicesCategory::class,
                        'column' => 'category_id',
                        'seedQty' => 7,
                    ]
                ]
            ],
            'SERV06' => (object)[
                'controller' => App\Http\Controllers\Services\SERV06Controller::class,
                'model' => App\Models\Services\SERV06Services::class,
                'seedQty' => 4,
            ],
            'SERV07' => (object)[
                'controller' => App\Http\Controllers\Services\SERV07Controller::class,
                'model' => App\Models\Services\SERV07Services::class,
                'seedQty' => 8,
                'routeName' => 'serv07.page.content',
                'relationship' => [
                    'category' => [
                        'class' => App\Models\Services\SERV07ServicesCategory::class,
                        'column' => 'category_id',
                        'seedQty' => 4,
                    ]
                ]
            ],
            'SERV08' => (object)[
                'controller' => App\Http\Controllers\Services\SERV08Controller::class,
                'model' => App\Models\Services\SERV08Services::class,
                'seedQty' => 28,
                'routeName' => 'serv08.category.page',
                'relationship' => [
                    'category' => [
                        'class' => App\Models\Services\SERV08ServicesCategory::class,
                        'column' => 'category_id',
                        'seedQty' => 7,
                    ]
                ]
            ],
            'SERV09' => (object)[
                'controller' => App\Http\Controllers\Services\SERV09Controller::class,
                'model' => App\Models\Services\SERV09Services::class,
                'seedQty' => 20,
                'routeName' => 'serv09.category.page',
                'relationship' => [
                    'category' => [
                        'class' => App\Models\Services\SERV09ServicesCategory::class,
                        'column' => 'category_id',
                        'seedQty' => 7,
                    ]
                ]
            ],
            'SERV10' => (object)[
                'controller' => App\Http\Controllers\Services\SERV10Controller::class,
                'model' => App\Models\Services\SERV10Services::class,
                'seedQty' => 12,
                'routeName' => 'serv10.show',
                'relationship' => [
                    'category' => [
                        'class' => App\Models\Services\SERV10ServicesCategory::class,
                        'column' => 'category_id',
                        'seedQty' => 4,
                    ]
                ]
            ],
            'SERV11' => (object)[
                'controller' => App\Http\Controllers\Services\SERV11Controller::class,
                'model' => App\Models\Services\SERV11Services::class,
                'seedQty' => 16,
                'routeName' => 'serv11.session.page',
                'relationship' => [
                    'session' => [
                        'class' => App\Models\Services\SERV11ServicesSession::class,
                        'column' => 'session_id',
                        'seedQty' => 2,
                    ]
                ]
            ],
            'SERV12' => (object)[
                'controller' => App\Http\Controllers\Services\SERV12Controller::class,
                'model' => App\Models\Services\SERV12Services::class,
                'seedQty' => 12,
                'routeName' => 'serv12.show',
                'relationship' => [
                    'category' => [
                        'class' => App\Models\Services\SERV12ServicesCategory::class,
                        'column' => 'category_id',
                        'seedQty' => 5,
                    ]
                ]
            ],
        ],
        // END SERVICES

        'Schedules' => (object)[
            'SCHE01' => (object)[
                'controller' => App\Http\Controllers\Schedules\SCHE01Controller::class,
                'model' => App\Models\Schedules\SCHE01Schedules::class,
                'seedQty' => 6,
            ],
            'SCHE02' => (object)[
                'controller' => App\Http\Controllers\Schedules\SCHE02Controller::class,
                'model' => App\Models\Schedules\SCHE02Schedules::class,
                'seedQty' => 4,
            ],
        ],
        // END Schedules

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
            'SLID03' => (object)[
                'controller' => App\Http\Controllers\Slides\SLID03Controller::class,
                'model' => App\Models\Slides\SLID03Slides::class,
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
            'TOPI09' => (object)[
                'controller' => App\Http\Controllers\Topics\TOPI09Controller::class,
                'model' => App\Models\Topics\TOPI09Topics::class,
                'seedQty' => 4,
            ],
            'TOPI10' => (object)[
                'controller' => App\Http\Controllers\Topics\TOPI10Controller::class,
                'model' => App\Models\Topics\TOPI10Topics::class,
                'seedQty' => 6,
            ],
            'TOPI10V1' => (object)[
                'controller' => App\Http\Controllers\Topics\TOPI10V1Controller::class,
                'model' => App\Models\Topics\TOPI10V1Topics::class,
                'seedQty' => 6,
            ],
            'TOPI11' => (object)[
                'controller' => App\Http\Controllers\Topics\TOPI11Controller::class,
                'model' => App\Models\Topics\TOPI11Topics::class,
                'seedQty' => 6,
            ],
            'TOPI12' => (object)[
                'controller' => App\Http\Controllers\Topics\TOPI12Controller::class,
                'model' => App\Models\Topics\TOPI12Topics::class,
                'seedQty' => 6,
            ],
            'TOPI13' => (object)[
                'controller' => App\Http\Controllers\Topics\TOPI13Controller::class,
                'model' => App\Models\Topics\TOPI13Topics::class,
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
                'seedQty' => 8,
            ],
        ],
        // END TOPICS

        'Teams' => (object)[
            'TEAM01' => (object)[
                'controller' => App\Http\Controllers\Teams\TEAM01Controller::class,
                'model' => App\Models\Teams\TEAM01Teams::class,
                'seedQty' => 12,
                // 'routeName' => 'team01.page.content',
                'routeName' => 'team01.category.page',
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
                'seedQty' => 3,
            ],
            'FEED03' => (object)[
                'controller' => App\Http\Controllers\Feedbacks\FEED03Controller::class,
                'model' => App\Models\Feedbacks\FEED03Feedbacks::class,
                'seedQty' => 3,
            ],
            'FEED05' => (object)[
                'controller' => App\Http\Controllers\Feedbacks\FEED05Controller::class,
                'model' => App\Models\Feedbacks\FEED05Feedbacks::class,
                'seedQty' => 3,
            ],
            'FEED06' => (object)[
                'controller' => App\Http\Controllers\Feedbacks\FEED06Controller::class,
                'model' => App\Models\Feedbacks\FEED06Feedbacks::class,
                'seedQty' => 3,
            ],
        ],
        // END FEEDBACKS

        'Units' => (object)[
            'UNIT01' => (object)[
                'controller' => App\Http\Controllers\Units\UNIT01Controller::class,
                'model' => App\Models\Units\UNIT01Units::class,
                'seedQty' => 12,
                'routeName' => 'unit01.show',
                'relationship' => [
                    'category' => [
                        'class' => App\Models\Units\UNIT01UnitsCategory::class,
                        'column' => 'category_id',
                        'seedQty' => 7,
                    ]
                ]
            ],
            'UNIT03' => (object)[
                'controller' => App\Http\Controllers\Units\UNIT03Controller::class,
                'model' => App\Models\Units\UNIT03Units::class,
                'seedQty' => 8,
                'routeName' => 'unit03.page.content',
                'relationship' => [
                    'category' => [
                        'class' => App\Models\Units\UNIT03UnitsCategory::class,
                        'column' => 'category_id',
                        'seedQty' => 6,
                    ]
                ]
            ],
            'UNIT05' => (object)[
                'controller' => App\Http\Controllers\Units\UNIT05Controller::class,
                'model' => App\Models\Units\UNIT05Units::class,
                'seedQty' => 8,
                'routeName' => 'unit05.category.page',
                'relationship' => [
                    'category' => [
                        'class' => App\Models\Units\UNIT05UnitsCategory::class,
                        'column' => 'category_id',
                        'seedQty' => 5,
                    ],
                    'subcategory' => [
                        'class' => App\Models\Units\UNIT05UnitsSubcategory::class,
                        'column' => 'subcategory_id',
                        'seedQty' => 5,
                    ]
                ]
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
