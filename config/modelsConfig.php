<?php

return [
    // Configure the model the header and footer, not change the module
    'InsertModelsCore' => (object)[
        'Headers' => (object)[
            'Code' => 'HEAD03',
            'themeMenu' => 'SIDE03'
        ],
        'Footers' => (object)[
            'Code' => 'FOOT04',
        ]
    ],


    // Configure existing modules and templates site-wide/system
    'InsertModelsMain' => (object) [
        'Slides' => (object) [
            'SLID01' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => false,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'config' => (object) [
                    'titleMenu' => '',
                    'anchor' =>  false,
                    'linkMenu' => '',
                    'iconMenu' => '',
                    'titlePanel' => 'Banner',
                    'iconPanel' => 'mdi-projector-screen'
                ]
            ],
        ],
        'Topics' => (object) [
            'TOPI102' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'config' => (object) [
                    'titleMenu' => 'Próximos Eventos',
                    'anchor' =>  true,
                    'linkMenu' => '#TOPI102',
                    'iconMenu' => '',
                    'titlePanel' => 'Próximos Eventos',
                    'iconPanel' => 'mdi-book-multiple-outline'
                ]
            ],
        ],
        'Galleries' => (object) [
            'GALL02' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'config' => (object) [
                    'titleMenu' => 'Eventos Realizados',
                    'anchor' =>  true,
                    'linkMenu' => '#GALL02',
                    'iconMenu' => '',
                    'titlePanel' => 'Eventos Realizados',
                    'iconPanel' => 'mdi-folder-multiple-image'
                ]
            ],
        ], 
        'Portfolios' => (object) [
            'PORT101' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => false,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'config' => (object) [
                    'titleMenu' => 'Menu',
                    'anchor' =>  false,
                    'linkMenu' => '',
                    'iconMenu' => '',
                    'titlePanel' => 'Menu',
                    'iconPanel' => ''
                ],
            ],
        ],
        'Contents' => (object) [
            'CONT11' => (object)[
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
                'titlePanel' => 'Conteúdo',
                'iconPanel' => 'mdi-table-of-contents'
                ]
            ],
        ],
        'Blogs' => (object) [
            'BLOG01' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'ViewListFooter' => true,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'IncludeCore' => (object) [
                    'include' => true,
                    'sorting' => true,
                    'limit' => 'all',
                    'condition' => 'active=1{Ativos},featured_home=1{Detaques Home},featured_page=1{Detaques Página}',
                    'titleList' => 'title',
                    'relation' => (object)[
                        'category' =>(object)[
                            'name' => 'Categoria',
                            'titleList' => 'title',
                            'condition' => 'active=1{Ativos}',
                        ]
                    ],
                ],
                'config' => (object) [
                    'titleMenu' => 'Artigos',
                    'anchor' =>  false,
                    'linkMenu' => 'blog01.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Artigos',
                    'iconPanel' => ''
                ],
                'IncludeSections' => (object) [
                ]
            ],
        ],
        'Galleries.1' => (object) [
            'GALL01' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => false,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'config' => (object) [
                    'titleMenu' => '',
                    'anchor' =>  false,
                    'linkMenu' => '',
                    'iconMenu' => '',
                    'titlePanel' => 'Galeria',
                    'iconPanel' => 'mdi-folder-multiple-image'
                ]
            ],
        ], 
    ],

    'ModelsForm' => (object)[
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
