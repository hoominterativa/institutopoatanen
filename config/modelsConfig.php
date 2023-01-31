<?php

return [
    // Configure the model the header and footer, not change the module
    'InsertModelsCore' => (object)[
        'Headers' => (object)[
            'Code' => 'HEAD02',
            'themeMenu' => 'SIDE02'
        ],
        'Footers' => (object)[
            'Code' => 'FOOT03'
        ]
    ],

    // Configure existing modules and templates site-wide/system
    'InsertModelsMain' => (object) [
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
                    'Topics' => 'TOPI02'
                ]
            ],
        ],
        'Slides' => (object) [
            'SLID01' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => false,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown',
                'config' => (object) [
                    'titleMenu' => '',
                    'anchor' =>  false,
                    'linkMenu' => '',
                    'iconMenu' => '',
                    'titlePanel' => 'Banner',
                    'iconPanel' => 'mdi-desktop-mac-dashboard'
                ],
                'IncludeSections' => (object) []
            ],
        ],
        'Topics' => (object) [
            'TOPI01' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => false,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown',
                'config' => (object) [
                    'titleMenu' => '',
                    'anchor' =>  false,
                    'linkMenu' => '',
                    'iconMenu' => '',
                    'titlePanel' => 'Tópicos',
                    'iconPanel' => 'mdi-pin'
                ],
                'IncludeSections' => (object) []
            ],
        ],
        'Services' => (object) [
            'SERV01' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'ViewListFooter' => true,
                'Viewer' => 'dropdown',
                'IncludeCore' => (object) [
                    'include' => true,
                    'limit' => 'all',
                    'condition' => 'active=1',
                    'relation' => '',
                    'titleList' => 'title',
                    'titleSubList' => '',
                ],
                'config' => (object) [
                    'titleMenu' => 'Soluções',
                    'anchor' =>  false,
                    'linkMenu' => 'serv01.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Soluções',
                    'iconPanel' => 'mdi-cog'
                ],
                'IncludeSections' => (object) []
            ],
        ],
        'Contents' => (object) [
            'CONT03' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => false,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown',
                'config' => (object) [
                    'titleMenu' => '',
                    'anchor' =>  false,
                    'linkMenu' => '',
                    'iconMenu' => '',
                    'titlePanel' => 'Sobre Home',
                    'iconPanel' => 'mdi-information-outline'
                ],
                'IncludeSections' => (object) []
            ],
        ],
        'Blogs' => (object) [
            'BLOG01' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown',
                'config' => (object) [
                    'titleMenu' => 'Artigos',
                    'anchor' =>  false,
                    'linkMenu' => 'blog01.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Artigos',
                    'iconPanel' => 'mdi-post-outline'
                ],
                'IncludeSections' => (object) []
            ],
        ],
        'Topics.1' => (object) [
            'TOPI02' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => false,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown',
                'config' => (object) [
                    'titleMenu' => 'Diferenciais',
                    'anchor' =>  true,
                    'linkMenu' => '#TOPI02',
                    'iconMenu' => '',
                    'titlePanel' => 'Diferenciais',
                    'iconPanel' => 'mdi-fast-forward-30'
                ],
                'IncludeSections' => (object) []
            ],
        ],
        'ContentPages' => (object) [
            'COPA01' => (object)[
                'ViewHome' => false,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown',
                'config' => (object) [
                    'titleMenu' => 'Sustentabilidade',
                    'anchor' =>  false,
                    'linkMenu' => 'copa01.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Sustentabilidade',
                    'iconPanel' => 'mdi-leaf'
                ],
                'IncludeSections' => (object) []
            ],
        ],
        'WorkWith' => (object) [
            'WOWI01' => (object)[
                'ViewHome' => false,
                'ViewListMenu' => false,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown',
                'IncludeCore' => (object) [
                    'include' => true,
                    'limit' => 'all',
                    'condition' => 'featured_menu=1',
                    'relation' => '',
                    'titleList' => 'title_box',
                    'titleSubList' => 'title_box',
                ],
                'config' => (object) [
                    'titleMenu' => 'Trabalhe Conosco',
                    'anchor' =>  false,
                    'linkMenu' => 'wowi01.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Trabalhe Conosco',
                    'iconPanel' => 'mdi-check-decagram'
                ],
                'IncludeSections' => (object) []
            ],
        ],
        'Contacts' => (object) [
            'COTA01' => (object)[
                'ViewHome' => false,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown',
                'IncludeCore' => (object) [
                    'include' => true,
                    'limit' => 'all',
                    'condition' => 'active=1',
                    'relation' => '',
                    'titleList' => 'title_page',
                    'titleSubList' => '',
                ],
                'config' => (object) [
                    'titleMenu' => 'Contato',
                    'anchor' =>  false,
                    'linkMenu' => 'cota01.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Formulários de Contato',
                    'iconPanel' => 'mdi-badge-account-horizontal'
                ],
                'IncludeSections' => (object) []
            ],
        ],
    ],

    'ModelsForm' => (object)[
        'FORM101' => 'Contacts_FORM101.jpg',
    ],

    'ModelsCompliances' => (object)[
        'Code' => 'COMP01'
    ],
];
