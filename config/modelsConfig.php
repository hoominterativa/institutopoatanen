<?php

return [
    // Configure the model the header and footer, not change the module
    'InsertModelsCore' => (object)[
        'Headers' => (object)[
            'Code' => 'HEAD05',
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
                'titlePanel' => 'Tópicos09',
                'iconPanel' => 'mdi-apps'
                ]
            ],
        ],
        'Contents' => (object) [
            'CONT02' => (object)[
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
                    'titlePanel' => 'Conteúdo02',
                    'iconPanel' => 'mdi-table-of-contents'
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
                    'Contents' => ['CONT08'],
                ]
            ],
        ],
        'Topics.1' => (object) [
            'TOPI04' => (object)[
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
                    'titlePanel' => 'Tópicos04',
                    'iconPanel' => 'mdi-book-multiple'
                ]
            ],
        ],
        'Teams' => (object) [
            'TEAM01' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
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
                    'titleMenu' => 'Equipe',
                    'anchor' =>  false,
                    'linkMenu' => 'team01.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Equipe',
                    'iconPanel' => ''
                ],
                'IncludeSections' => (object) [
                    'Contents' => ['CONT08'],
                ],
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
                    'iconPanel' => 'mdi-blogger'
                ],
                'IncludeSections' => (object) [
                    'Contents' => ['CONT08'],
                ]
            ],
        ],
        'Contents.1' => (object) [
            'CONT08' => (object)[
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
                    'titlePanel' => 'Conteúdo08',
                    'iconPanel' => 'mdi-view-split-horizontal'
                ]
            ],
        ],
        'Topics.1' => (object) [
            'TOPI10' => (object)[
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
                    'titlePanel' => 'Tópicos10',
                    'iconPanel' => 'mdi-apps'
                ]
            ],
        ],
        'BlankPages' => (object) [
            'BAPA01' => (object)[
                'ViewHome' => false,
                'ViewListMenu' => false,
                'ViewListPanel' => false,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'config' => (object) [
                    'titleMenu' => 'Pagina em branco',
                    'anchor' => false,
                    'linkMenu' => 'bapa01.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Pagina em branco',
                    'iconPanel' => 'mdi-contacts'
                ],
                'IncludeSections' => (object) [
                    'Topics' => ['TOPI10'],
                    'Contents' => ['CONT08'],
                ]
            ],
        ],
        'ContentPages' => (object) [
            'COPA04' => (object)[
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
                    'titleList' => 'title_page',
                    'relation' => '',
                ],
                'config' => (object) [
                    'titleMenu' => 'Página de Conteúdo04',
                    'anchor' =>  false,
                    'linkMenu' => 'copa04.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Página de Conteúdo04',
                    'iconPanel' => 'mdi-book-open-page-variant'
                ],
                'IncludeSections' => (object) [
                    'Contents' => ['CONT08'],
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
                    'titleMenu' => 'Marcas',
                    'anchor' =>  false,
                    'linkMenu' => 'bran01.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Marcas',
                    'iconPanel' => 'mdi-google-my-business'
                ],
                'IncludeSections' => (object) [
                    'Contents' => ['CONT08'],
                ]
            ],
        ],
        'Galleries' => (object) [
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
        'Contents.2' => (object)[
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
            'titlePanel' => 'Conteúdo11',
            'iconPanel' => 'mdi-table-of-contents'
            ]
            ],

        ],
        'Abouts' => (object) [
            'ABOU01' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'IncludeCore' => (object) [
                    'include' => true,
                    'sorting' => true,
                    'limit' => 'all',
                    'condition' => 'active=1{Ativos}',
                    'titleList' => 'title',
                    'relation' => '',
                ],
                'config' => (object) [
                'titleMenu' => 'Sobre',
                'anchor' => false,
                'linkMenu' => 'abou01.page',
                'iconMenu' => '',
                'titlePanel' => 'Sobre',
                'iconPanel' => 'mdi-information'
                ],
                'IncludeSections' => (object) [
                    'Galleries' => ['GALL01'],
                    'Contents' => ['CONT08'],
                    'Contents.2' => ['CONT11'],
                ],
            ],
        ],
        'ContentPages.1' => (object) [
            'COPA02' => (object)[
                'ViewHome' => false,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'config' => (object) [
                    'titleMenu' => 'Soluções02',
                    'anchor' =>  false,
                    'linkMenu' => 'copa02.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Soluções02',
                    'iconPanel' => 'mdi-book-open-page-variant'
                ],
                'IncludeSections' => (object) [
                    'Contents' => ['CONT08'],
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
                    'Contents' => ['CONT08'],
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
