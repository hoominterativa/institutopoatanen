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
        'Topics.1' => (object) [
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
                    'titlePanel' => 'Destaques Home',
                    'iconPanel' => 'mdi-book-minus-multiple'
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
                        'category' => (object)[
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
                'IncludeSections' => (object) []
            ],
        ],
        'Topics.2' => (object) [
            'TOPI01' => (object)[
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
                    'titlePanel' => 'Como Fazemos',
                    'iconPanel' => 'mdi-book-multiple-outline'
                ]
            ],
        ],
        'Topics.3' => (object) [
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
                    'titlePanel' => 'Números',
                    'iconPanel' => 'mdi-apps'
                ]
            ],
        ],
        'Topics.4' => (object) [
            'TOPI02' => (object)[
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
                    'titlePanel' => 'Vantagens',
                    'iconPanel' => 'mdi-book-multiple-outline'
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
                    'titlePanel' => 'Galeria Home',
                    'iconPanel' => 'mdi-folder-multiple-image'
                ]
            ],
        ],
        'Contents.1' => (object) [
            'CONT05' => (object)[
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
                    'titlePanel' => 'Slogan',
                    'iconPanel' => 'mdi-folder-outline'
                ]
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
                    'titlePanel' => 'Público-alvo MTM',
                    'iconPanel' => 'mdi-folder-outline'
                ]
            ],
        ],
        'Topics.5' => (object) [
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
                    'titlePanel' => 'Blog',
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
                'IncludeSections' => (object) []
            ],
        ],
        // NOTE: ESPERANDO ESPOSTA SOBRE O CONT02V2

        'BlankPages' => (object) [
            'BAPA01' => (object)[
                'ViewHome' => false,
                'ViewListMenu' => false,
                'ViewListPanel' => false,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'config' => (object) [
                    'titleMenu' => 'Quem somos',
                    'anchor' => false,
                    'linkMenu' => 'bapa01.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Quem somos',
                    'iconPanel' => 'mdi-contacts'
                ],
                'IncludeSections' => (object) [
                    'Contents.3' => 'CONT06',
                    'Topics.6' => 'TOPI101',
                    'Topics.7' => 'TOPI08',
                    'Topics.8' => 'TOPI10',
                ]
            ],
        ],
        'Contents.3' => (object) [
            'CONT06' => (object)[
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
                    'titlePanel' => 'Manifesto',
                    'iconPanel' => 'mdi-text-box'
                ]
            ],
        ],
        'Topics.6' => (object)[
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
                    'titlePanel' => 'Conquistas',
                    'iconPanel' => 'mdi-apps'
                ]
            ],
        ],
        'Topics.7' => (object) [
            'TOPI08' => (object)[
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
                    'titlePanel' => 'Equipe',
                    'iconPanel' => 'mdi-book-multiple-outline'
                ]
            ],
        ],
        'Topics.8' => (object) [
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
                    'titlePanel' => 'Valores',
                    'iconPanel' => 'mdi-apps'
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
                'IncludeSections' => (object) []
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
                    'titleMenu' => 'Método MTM',
                    'anchor' =>  false,
                    'linkMenu' => 'copa04.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Método MTM',
                    'iconPanel' => 'mdi-book-open-page-variant'
                ],
                'IncludeSections' => (object) []
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
