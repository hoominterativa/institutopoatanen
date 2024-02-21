<?php

return [
    // Configure the model the header and footer, not change the module
    'InsertModelsCore' => (object)[
        'Headers' => (object)[
            'Code' => 'HEAD02',
            'themeMenu' => 'SIDE02'
        ],
        'Footers' => (object)[
            'Code' => 'FOOT02',
        ]
    ],

    // Configure existing modules and templates site-wide/system
    'InsertModelsMain' => (object) [
        // 'Products' => (object) [
        //     'PROD05' => (object)[
        //         'ViewHome' => true,
        //         'ViewListMenu' => true,
        //         'ViewListPanel' => true,
        //         'ViewListFooter' => true,
        //         'Viewer' => 'dropdown', // accepted values, list or dropdown
        //         'IncludeCore' => (object) [
        //             'include' => true,
        //             'sorting' => true,
        //             'limit' => 'all',
        //             'condition' => 'active=1{Ativos},featured_home=1{Detaques Home}',
        //             'titleList' => 'title',
        //             'relation' => (object) [
        //                 'category' =>(object)[
        //                     'name' => 'Categoria',
        //                     'titleList' => 'title',
        //                     'condition' => 'active=1{Ativos},featured_home=1{Detaques Home}',
        //                 ],
        //                 'subcategory' =>(object)[
        //                     'name' => 'Subcategoria',
        //                     'titleList' => 'title',
        //                     'condition' => 'active=1{Ativos}',
        //                 ]
        //             ],
        //         ],
        //         'config' => (object) [
        //             'titleMenu' => 'Produtos',
        //             'anchor' =>  false,
        //             'linkMenu' => 'prod05.page',
        //             'iconMenu' => '',
        //             'titlePanel' => 'Produtos',
        //             'iconPanel' => 'mdi-shopping-outline'
        //         ],
        //         'IncludeSections' => (object) [

        //         ]
        //     ],
        // ],
        'Topics' => (object)[
            'TOPI101' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => false,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'config' => (object) [
                    'titleMenu' => '',
                    'anchor' => false,
                    'linkMenu' => '',
                    'iconMenu' => '',
                    'titlePanel' => 'Topicos',
                    'iconPanel' => 'mdi-apps'
                ]
            ],
        ],
        'ContentPages' => (object) [
            'COPA03' => (object)[
                'ViewHome' => false,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                // 'IncludeCore' => (object) [
                //     'include' => true,
                //     'sorting' => true,
                //     'limit' => 'all',
                //     'condition' => 'active=1{Ativos}',
                //     'titleList' => 'title',
                //     'relation' => (object) [
                //         'category' =>(object)[
                //             'name' => 'Categoria',
                //             'titleList' => 'title',
                //             'condition' => 'active=1{Ativos}',
                //         ],
                //         'subcategory' =>(object)[
                //             'name' => 'Subcategoria',
                //             'titleList' => 'title',
                //             'condition' => 'active=1{Ativos}',
                //         ]
                //     ],
                // ],
                'config' => (object) [
                    'titleMenu' => 'Soluções',
                    'anchor' =>  false,
                    'linkMenu' => 'copa03.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Soluções',
                    'iconPanel' => 'mdi-book-open-page-variant'
                ],
                'IncludeSections' => (object) []
            ]
        ]
    ],

    'ModelsForm' => (object)[
        'FORM01' => (object) [
            'model' => 'FORM01.jpg',
            'config' => (object) [
                'title' => (object) ['name' => 'Título Seção', 'type' => 'text'],
                'description' => (object) ['name' => 'Descrição Seção',  'type' => 'textarea'],
                'path_image_content' => (object) ['name' => 'Imagem',  'type' => 'image'],
            ],
        ],
        'FORM02' => (object) [
            'model' => 'FORM02.jpg',
            'config' => (object) [
                'title' => (object) ['name' => 'Título Seção', 'type' => 'text'],
                'description' => (object) ['name' => 'Descrição Seção',  'type' => 'textarea'],
                'title_inner' => (object) ['name' => 'Título Lightbox',  'type' => 'text'],
                'description_inner' => (object) ['name' => 'Descrição Lightbox',  'type' => 'textarea'],
                'path_image_inner' => (object) ['name' => 'Imagem Lightbox',  'type' => 'image'],
            ],
        ],
        'FORM03' => (object) [
            'model' => 'FORM03.jpg',
            'config' => (object) [
                'title' => (object) ['name' => 'Título', 'type' => 'text'],
                'subtitle' => (object) ['name' => 'Subtítulo',  'type' => 'text'],
                'description' => (object) ['name' => 'Descrição',  'type' => 'textarea'],
                'title_inner' => (object) ['name' => 'Título Formulário ',  'type' => 'text'],
                'description_inner' => (object) ['name' => 'Descrição Formulário',  'type' => 'textarea'],
                'path_image_inner' => (object) ['name' => 'Background',  'type' => 'image'],
            ]
        ],
        'FORM101' => (object) [
            'model' => 'FORM101.jpg',
            'config' => (object) [
                'title' => (object) ['name' => 'Título',  'type' => 'text'],
                'subtitle' => (object) ['name' => 'Subtítulo',  'type' => 'text'],
                'description' => (object) ['name' => 'Descrição',  'type' => 'textarea'],
            ],
        ],
        'FORM102' => (object) [
            'model' => 'FORM102.jpg',
            'config' => (object) [
                'title' => (object) ['name' => 'Título',  'type' => 'text'],
            ],
        ],
    ],

    'ModelsCompliances' => (object)[
        'Code' => 'COMP01',
    ],
];
