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
        'Slides' => (object) [
            'SLID01' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => false,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'IncludeCore' => (object) [
                    'include' => false,
                    'limit' => 'all',
                    'condition' => '',
                    'relation' => '',
                ],
                'config' => (object) [
                    'titleMenu' => '',
                    'anchor' =>  false,
                    'linkMenu' => '',
                    'iconMenu' => 'string',
                    'titlePanel' => 'SLID01',
                    'iconPanel' => 'string'
                ],
                'IncludeSections' => (object) []
            ],
        ],
        'Contents' => (object) [
            'CONT01' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => false,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'IncludeCore' => (object) [
                    'include' => false,
                    'limit' => 'all',
                    'condition' => '',
                    'relation' => '',
                ],
                'config' => (object) [
                    'titleMenu' => '',
                    'anchor' =>  false,
                    'linkMenu' => '',
                    'iconMenu' => 'string',
                    'titlePanel' => 'CONT01',
                    'iconPanel' => 'string'
                ],
                'IncludeSections' => (object) []
            ],
            'CONT03' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => false,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'IncludeCore' => (object) [
                    'include' => false,
                    'limit' => 'all',
                    'condition' => '',
                    'relation' => '',
                ],
                'config' => (object) [
                    'titleMenu' => '',
                    'anchor' =>  false,
                    'linkMenu' => '',
                    'iconMenu' => 'string',
                    'titlePanel' => 'CONT03',
                    'iconPanel' => 'string'
                ],
                'IncludeSections' => (object) []
            ],
            'CONT06' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => false,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'IncludeCore' => (object) [
                    'include' => false,
                    'limit' => 'all',
                    'condition' => '',
                    'relation' => '',
                ],
                'config' => (object) [
                    'titleMenu' => '',
                    'anchor' =>  false,
                    'linkMenu' => '',
                    'iconMenu' => 'string',
                    'titlePanel' => 'CONT06',
                    'iconPanel' => 'string'
                ],
                'IncludeSections' => (object) []
            ],
        ],
        'Portfolios' => (object) [
            'PORT01' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'IncludeCore' => (object) [
                    'include' => false,
                    'limit' => 'all',
                    'condition' => '',
                    'relation' => '',
                ],
                'config' => (object) [
                    'titleMenu' => 'PORT01',
                    'anchor' =>  false,
                    'linkMenu' => 'port01.page',
                    'iconMenu' => 'string',
                    'titlePanel' => 'PORT01',
                    'iconPanel' => 'string'
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
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'IncludeCore' => (object) [
                    'include' => false,
                    'limit' => 'all',
                    'condition' => '',
                    'relation' => '',
                ],
                'config' => (object) [
                    'titleMenu' => '',
                    'anchor' =>  false,
                    'linkMenu' => '',
                    'iconMenu' => 'string',
                    'titlePanel' => 'TOPI01',
                    'iconPanel' => 'string'
                ],
                'IncludeSections' => (object) []
            ],
            'TOPI02' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => false,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'IncludeCore' => (object) [
                    'include' => false,
                    'limit' => 'all',
                    'condition' => '',
                    'relation' => '',
                    'titleList' => 'title_page',
                    'titleSubList' => ''
                ],
                'config' => (object) [
                    'titleMenu' => '',
                    'anchor' =>  false,
                    'linkMenu' => '',
                    'iconMenu' => 'string',
                    'titlePanel' => 'TOPI02',
                    'iconPanel' => 'string'
                ],
                'IncludeSections' => (object) []
            ],
            'TOPI04' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => false,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'IncludeCore' => (object) [
                    'include' => false,
                    'limit' => 'all',
                    'condition' => '',
                    'relation' => '',
                ],
                'config' => (object) [
                    'titleMenu' => '',
                    'anchor' =>  false,
                    'linkMenu' => '',
                    'iconMenu' => 'string',
                    'titlePanel' => 'TOPI04',
                    'iconPanel' => 'string'
                ],
                'IncludeSections' => (object) []
            ],
            'TOPI05' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => false,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'IncludeCore' => (object) [
                    'include' => false,
                    'limit' => 'all',
                    'condition' => '',
                    'relation' => '',
                ],
                'config' => (object) [
                    'titleMenu' => '',
                    'anchor' =>  false,
                    'linkMenu' => '',
                    'iconMenu' => 'string',
                    'titlePanel' => 'TOPI05',
                    'iconPanel' => 'string'
                ],
                'IncludeSections' => (object) []
            ],
        ],
        'Services' => (object) [
            'SERV01' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'IncludeCore' => (object) [
                    'include' => true,
                    'limit' => 'all',
                    'condition' => '',
                    'relation' => '',
                ],
                'config' => (object) [
                    'titleMenu' => 'SERV01',
                    'anchor' =>  false,
                    'linkMenu' => 'serv01.page',
                    'iconMenu' => 'string',
                    'titlePanel' => 'SERV01',
                    'iconPanel' => 'string'
                ],
                'IncludeSections' => (object) []
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
                    'include' => false,
                    'limit' => 'all',
                    'condition' => '',
                    'relation' => '',
                ],
                'config' => (object) [
                    'titleMenu' => 'ABOU01',
                    'anchor' =>  false,
                    'linkMenu' => 'abou01.page',
                    'iconMenu' => 'string',
                    'titlePanel' => 'ABOU01',
                    'iconPanel' => 'string'
                ],
                'IncludeSections' => (object) []
            ],
            'ABOU02' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'IncludeCore' => (object) [
                    'include' => false,
                    'limit' => 'all',
                    'condition' => '',
                    'relation' => '',
                ],
                'config' => (object) [
                    'titleMenu' => 'ABOU02',
                    'anchor' =>  false,
                    'linkMenu' => 'abou02.page',
                    'iconMenu' => 'string',
                    'titlePanel' => 'ABOU02',
                    'iconPanel' => 'string'
                ],
                'IncludeSections' => (object) []
            ],
        ],
        'Products' => (object) [
            'PROD02' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'IncludeCore' => (object) [
                    'include' => false,
                    'limit' => 'all',
                    'condition' => '',
                    'relation' => '',
                ],
                'config' => (object) [
                    'titleMenu' => 'PROD02',
                    'anchor' =>  false,
                    'linkMenu' => 'prod02.page',
                    'iconMenu' => 'string',
                    'titlePanel' => 'PROD02',
                    'iconPanel' => 'string'
                ],
                'IncludeSections' => (object) []
            ],
        ],
        'Units' => (object) [
            'UNIT01' => (object)[
                'ViewHome' => false,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'IncludeCore' => (object) [
                    'include' => false,
                    'limit' => 'all',
                    'condition' => '',
                    'relation' => '',
                ],
                'config' => (object) [
                    'titleMenu' => 'UNIT01',
                    'anchor' =>  false,
                    'linkMenu' => 'unit01.page',
                    'iconMenu' => 'string',
                    'titlePanel' => 'UNIT01',
                    'iconPanel' => 'string'
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
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'IncludeCore' => (object) [
                    'include' => true,
                    'limit' => 'all',
                    'condition' => '',
                    'relation' => '',
                    'titleList' => 'title_page',
                    'titleSubList' => ''
                ],
                'config' => (object) [
                    'titleMenu' => 'COTA01',
                    'anchor' =>  false,
                    'linkMenu' => 'cota01.page',
                    'iconMenu' => 'string',
                    'titlePanel' => 'COTA01',
                    'iconPanel' => 'string'
                ],
                'IncludeSections' => (object) []
            ],
        ],
        'WorkWith' => (object) [
            'WOWI01' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'IncludeCore' => (object) [
                    'include' => true,
                    'limit' => 'all',
                    'condition' => '',
                    'relation' => '',
                    'titleList' => 'title_page',
                    'titleSubList' => ''
                ],
                'config' => (object) [
                    'titleMenu' => 'WOWI01',
                    'anchor' =>  false,
                    'linkMenu' => 'wowi01.page',
                    'iconMenu' => 'string',
                    'titlePanel' => 'WOWI01',
                    'iconPanel' => 'string'
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
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'IncludeCore' => (object) [
                    'include' => true,
                    'limit' => 'all',
                    'condition' => '',
                    'relation' => '',
                    'titleList' => 'title_page',
                    'titleSubList' => ''
                ],
                'config' => (object) [
                    'titleMenu' => 'COPA01',
                    'anchor' =>  false,
                    'linkMenu' => 'copa01.page',
                    'iconMenu' => 'string',
                    'titlePanel' => 'COPA01',
                    'iconPanel' => 'string'
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
