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
                    'titlePanel' => 'Sobre Home',
                    'iconPanel' => 'mdi-folder-outline'
                ]
            ],
        ],

        'Units' => (object) [
            'UNIT05' => (object)[
                'ViewHome' => false,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'ViewListFooter' => true,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'IncludeCore' => (object) [
                    'include' => true,
                    'sorting' => true,
                    'limit' => 'all',
                    'condition' => 'active=1{Ativos}',
                    'titleList' => 'title',
                    'relation' => (object)[
                        'category' => (object)[
                            'name' => 'Categoria',
                            'titleList' => 'title',
                            'condition' => 'active=1{Ativos}',
                        ],
                        'subcategory' => (object)[
                            'name' => 'Subcategoria',
                            'titleList' => 'title',
                            'condition' => 'active=1{Ativos}',
                        ]
                    ],
                ],
                'config' => (object) [
                    'titleMenu' => 'Lojas',
                    'anchor' => false,
                    'linkMenu' => 'unit05.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Lojas',
                    'iconPanel' => 'mdi-warehouse'
                ],
                'IncludeSections' => (object) []
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
                    'titleMenu' => 'Banners de Loja',
                    'anchor' =>  false,
                    'linkMenu' => '',
                    'iconMenu' => '',
                    'titlePanel' => 'Banners de Loja',
                    'iconPanel' => 'mdi-folder-multiple-image'
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
                'IncludeSections' => (object) []
            ],
        ],

        'Schedules' => (object) [
            'SCHE01' => (object)[
                'ViewHome' => false,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'ViewListFooter' => true,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'config' => (object) [
                    'titleMenu' => 'Eventos',
                    'anchor' =>  false,
                    'linkMenu' => 'sche01.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Eventos',
                    'iconPanel' => 'mdi-calendar-month-outline'
                ],
                'IncludeSections' => (object) [],
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
                    'titleMenu' => 'Como Chegar',
                    'anchor' => false,
                    'linkMenu' => '',
                    'iconMenu' => '',
                    'titlePanel' => 'Como Chegar',
                    'iconPanel' => 'mdi-table-of-contents'
                ]
            ],
        ],

        'Services' => (object) [
            'SERV11' => (object)[
                'ViewHome' => false,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'config' => (object) [
                    'titleMenu' => 'Serviços e Facilidades',
                    'anchor' =>  false,
                    'linkMenu' => 'serv11.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Serviços e Facilidades',
                    'iconPanel' => 'mdi-alpha-s-box-outline'
                ],
                'IncludeSections' => (object) []
            ],
        ],

        'Abouts' => (object) [
            'ABOU04' => (object)[
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
                    'titleList' => 'title',
                    'relation' => '',
                ],
                'config' => (object) [
                    'titleMenu' => 'Sobre',
                    'anchor' => false,
                    'linkMenu' => 'abou04.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Sobre',
                    'iconPanel' => 'mdi-information'
                ],
                'IncludeSections' => (object) [
                    'Contents.3' => 'CONT02',
                    'Contents.4' => 'CONT06',
                ],
            ],
        ],

        'Contents.3' => (object) [
            'CONT02' => (object)[
                'ViewHome' => false,
                'ViewListMenu' => false,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'config' => (object) [
                    'titleMenu' => '',
                    'anchor' =>  false,
                    'linkMenu' => '',
                    'iconMenu' => '',
                    'titlePanel' => 'Seção Sobre',
                    'iconPanel' => 'mdi-table-of-contents'
                ]
            ],
        ],

        'Contents.4' => (object) [
            'CONT06' => (object)[
                'ViewHome' => false,
                'ViewListMenu' => false,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'config' => (object) [
                    'titleMenu' => 'Vídeo Institucional',
                    'anchor' => false,
                    'linkMenu' => '',
                    'iconMenu' => '',
                    'titlePanel' => 'Vídeo Institucional',
                    'iconPanel' => 'mdi-text-box'
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
                    'titleMenu' => 'Contatos',
                    'anchor' =>  false,
                    'linkMenu' => 'cota02.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Contatos',
                    'iconPanel' => 'mdi-contacts'
                ],
                'IncludeSections' => (object) []
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
                    'titleMenu' => 'Comercial',
                    'anchor' => false,
                    'linkMenu' => 'bapa01.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Comercial',
                    'iconPanel' => 'mdi-contacts'
                ],
                'IncludeSections' => (object) [
                    'Tópics.1' => 'TOPI09',
                    'Tópics.2' => 'TOPI10',
                    'Tópics.3' => 'TOPI10V1',
                ]
            ],
        ],

        'Topics.1' => (object) [
            'TOPI09' => (object)[
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
                    'titlePanel' => 'Chamadas Comercial',
                    'iconPanel' => 'mdi-apps'
                ]
            ],
        ],

        'Topics.2' => (object) [
            'TOPI10' => (object)[
                'ViewHome' => false,
                'ViewListMenu' => false,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'config' => (object) [
                    'titleMenu' => '',
                    'anchor' =>  false,
                    'linkMenu' => '',
                    'iconMenu' => '',
                    'titlePanel' => 'Comercialização - Comercial',
                    'iconPanel' => 'mdi-apps'
                ]
            ],
        ],

        'Topics.3' => (object) [
            'TOPI10V1' => (object)[
                'ViewHome' => false,
                'ViewListMenu' => false,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'config' => (object) [
                    'titleMenu' => '',
                    'anchor' =>  false,
                    'linkMenu' => '',
                    'iconMenu' => '',
                    'titlePanel' => 'Mídia - Comercial',
                    'iconPanel' => 'mdi-apps'
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
