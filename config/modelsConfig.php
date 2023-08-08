<?php

return [
    // Configure the model the header and footer, not change the module
    'InsertModelsCore' => (object)[
        'Headers' => (object)[
            'Code' => 'HEAD02',
            'themeMenu' => 'SIDE02'
        ],
        'Footers' => (object)[
            'Code' => 'FOOT05',
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
        'Contents' => (object) [
            'CONT02V1' => (object)[
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
                    'titlePanel' => 'Conteúdo',
                    'iconPanel' => 'mdi-content-copy'
                ]
            ],
            'CONT11' => (object)[
                'ViewHome' => false,
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
        'Portfolios' => (object) [
            'PORT02' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'IncludeCore' => (object) [
                    'include' => true,
                    'sorting' => true,
                    'limit' => 'all',
                    'condition' => 'active=1{Ativos},featured=1{Detaques Home}',
                    'titleList' => 'title',
                    'relation' => (object)[
                        'category' =>(object)[
                            'name' => 'Categoria',
                            'titleList' => 'title',
                            'condition' => 'active=1{Ativos},featured=1{Detaques Home}',
                        ]
                    ],
                ],
                'config' => (object) [
                    'titleMenu' => 'Portifólio',
                    'anchor' =>  false,
                    'linkMenu' => 'port02.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Portifólio',
                    'iconPanel' => ''
                ],
                'IncludeSections' => (object) []
            ],
        ],
        'Contents.2' => (object) [
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
                    'titlePanel' => 'Conteúdo.2',
                    'iconPanel' => 'mdi-table-of-contents'
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
                ]
            ],
        ],
        'Contents.4' => (object) [
            'CONT04' => (object)[
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
                    'titlePanel' => 'Conteúdo.4',
                    'iconPanel' => ''
                ]
            ],
        ],
        'Contents.3' => (object) [
            'CONT03' => (object)[
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
                    'titlePanel' => 'Conteúdo.3',
                    'iconPanel' => 'mdi-view-split-horizontal'
                ]
            ],
        ],
        'Feedbacks' => (object) [
            'FEED06' => (object)[
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
                'titlePanel' => 'Depoimentos',
                'iconPanel' => 'mdi-android-messages'
                ]
            ],
        ],
        'Topics.3' => (object) [
            'TOPI03' => (object)[
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
                    'titlePanel' => 'Tópicos3',
                    'iconPanel' => 'mdi-book-minus-multiple'
                ]
            ],
        ],
        'Abouts' => (object) [
            'ABOU01' => (object)[
                'ViewHome' => false,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown',
                'config' => (object) [
                    'titleMenu' => 'Sobre',
                    'anchor' =>  false,
                    'linkMenu' => 'abou01.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Sobre',
                    'iconPanel' => 'mdi-information-variant'
                ],
                'IncludeSections' => (object) [
                    'Contents' => ['CONT11'],
                    'Topics.3' => ['TOPI03'],
                ]
            ],
        ],
        'ContentPages' => (object) [
            'COPA02' => (object)[
                'ViewHome' => false,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'config' => (object) [
                    'titleMenu' => 'Soluções',
                    'anchor' =>  false,
                    'linkMenu' => 'copa02.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Soluções',
                    'iconPanel' => ''
                ],
                'IncludeSections' => (object) [
                    'Topics.3' => ['TOPI03'],
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
