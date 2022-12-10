<?php

return [
    // Configure the model the header and footer, not change the module
    'InsertModelsCore' => (object)[
        'Headers' => (object)[
            'Code' => 'HEAD02'
        ],
        'Footers' => (object)[
            'Code' => 'FOOT02'
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
                    'iconPanel' => 'mdi-information'
                ],
                'IncludeSections' => (object) []
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
                    'iconPanel' => 'mdi-information'
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
                    'iconPanel' => 'mdi-information'
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
                    'limit' => 5,
                    'condition' => 'active=1',
                    'relation' => '',
                ],
                'config' => (object) [
                    'titleMenu' => 'Serviços',
                    'anchor' =>  false,
                    'linkMenu' => 'serv01.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Serviços',
                    'iconPanel' => 'mdi-information'
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
                    'titleMenu' => 'Conteúdo',
                    'anchor' =>  false,
                    'linkMenu' => '',
                    'iconMenu' => '',
                    'titlePanel' => 'Conteúdo',
                    'iconPanel' => 'mdi-information'
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
                    'iconPanel' => 'mdi-information'
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
                    'titleMenu' => 'Tópicos 1',
                    'anchor' =>  false,
                    'linkMenu' => '',
                    'iconMenu' => '',
                    'titlePanel' => 'Tópicos 1',
                    'iconPanel' => 'mdi-information'
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
                    'iconPanel' => 'mdi-information'
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
                ],
                'config' => (object) [
                    'titleMenu' => 'Contato',
                    'anchor' =>  false,
                    'linkMenu' => 'cota01.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Contato',
                    'iconPanel' => 'mdi-information'
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
                'config' => (object) [
                    'titleMenu' => 'Trabalhe Conosco',
                    'anchor' =>  false,
                    'linkMenu' => 'wowi01.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Trabalhe Conosco',
                    'iconPanel' => 'mdi-information'
                ],
                'IncludeSections' => (object) []
            ],
        ],
    ],

    'ModelsForm' => (object)[
        'FORM01' => 'Contacts_FORM01.jpg',
    ],

    'ModelsCompliances' => (object)[
        'Code' => 'COMP01'
    ],
];
