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
                    'titlePanel' => 'Slide',
                    'iconPanel' => 'mdi-projector-screen'
                ]
            ],
        ],

        'Topics' => (object) [
            'TOPI09' => (object)[
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
                'titlePanel' => 'Tópicos',
                'iconPanel' => 'mdi-apps'
                ]
            ],
        ],

        'Abouts' => (object) [
            'ABOU05' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                    'config' => (object) [
                    'titleMenu' => 'Quem somos',
                    'anchor' => false,
                    'linkMenu' => 'abou05.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Quem somos',
                    'iconPanel' => 'mdi-information'
                    ],
                'IncludeSections' => (object) [
                ],
            ],
        ],

        'Products' => (object) [
            'PROD02' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'ViewListFooter' => true,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'IncludeCore' => (object) [
                    'include' => true,
                    'sorting' => true,
                    'limit' => 'all',
                    'condition' => 'active=1{Ativos},featured=1{Detaques}',
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
                    'titleMenu' => 'Produtos',
                    'anchor' =>  false,
                    'linkMenu' => 'prod02.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Produtos',
                    'iconPanel' => 'mdi-shopping-outline'
                ],
                'IncludeSections' => (object) [
                ]
            ],
        ],

        'Services' => (object) [
            'SERV04' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'ViewListFooter' => true,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'IncludeCore' => (object) [
                    'include' => true,
                    'sorting' => true,
                    'limit' => 'all',
                    'condition' => 'active=1{Ativos},featured=1{Detaques}',
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
                    'titleMenu' => 'Serviços',
                    'anchor' =>  false,
                    'linkMenu' => 'serv04.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Serviços',
                    'iconPanel' => 'mdi-alpha-s-box-outline'
                ],
                'IncludeSections' => (object) [
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
                    'titleMenu' => 'Blog',
                    'anchor' =>  false,
                    'linkMenu' => 'blog01.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Blog',
                    'iconPanel' => 'mdi-blogger'
                ],
                'IncludeSections' => (object) [
                ]
            ],
        ],

        'Topics.1' => (object) [
            'TOPI05' => (object)[
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
                    'titlePanel' => 'Funções',
                    'iconPanel' => 'mdi-file-table-box-multiple'
                ]
            ],
        ],

        'Brands' => (object) [
            'BRAN01' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'config' => (object) [
                    'titleMenu' => 'Clientes',
                    'anchor' =>  false,
                    'linkMenu' => 'bran01.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Clientes',
                    'iconPanel' => 'mdi-google-my-business'
                ],
                'IncludeSections' => (object) [
                ]
            ],
        ],

        'Contacts' => (object) [
            'COTA02' => (object)[
                'ViewHome' => false,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'IncludeCore' => (object) [
                    'include' => true,
                    'sorting' => true,
                    'limit' => 'all',
                    'condition' => 'active=1{Ativos}',
                    'titleList' => 'title_banner',
                    'relation' => '',
                ],
                'config' => (object) [
                    'titleMenu' => 'Contato',
                    'anchor' =>  false,
                    'linkMenu' => 'cota02.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Contato',
                    'iconPanel' => 'mdi-contacts'
                ],
                'IncludeSections' => (object) [
                ]
            ],
        ],

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
