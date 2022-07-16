<?php

return [
    // Configure the model the header and footer, not change the module
    'InsertModelsCore' => (object)[
        'Headers' => (object)[
            'Code' => 'HEAD01'
        ],
        'Footers' => (object)[
            'Code' => 'FOOT01'
        ]
    ],

    // Configure existing modules and templates site-wide/system
    'InsertModelsMain' => (object) [
        'Slides' => (object) [
            'SLID01' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => false,
                'ViewListPanel' => true,
                'IncludeCore' => (object) [
                    'include' => false,
                    'limit' => 0,
                    'condition' => null,
                    'relation' => null,
                ],
                'config' => (object) [
                    'titleMenu' => '',
                    'anchor' =>  false,
                    'linkMenu' => '',
                    'iconMenu' => '',
                    'titlePanel' => 'Banner',
                    'iconPanel' => 'mdi-aspect-ratio'
                ],
                'IncludeSections' => (object) []
            ],
        ],
        'Topics' => (object) [
            'TOPI01' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => false,
                'ViewListPanel' => true,
                'IncludeCore' => (object) [
                    'include' => false,
                    'limit' => 0,
                    'condition' => null,
                    'relation' => null,
                ],
                'config' => (object) [
                    'titleMenu' => '',
                    'anchor' =>  false,
                    'linkMenu' => '',
                    'iconMenu' => '',
                    'titlePanel' => 'Tópicos',
                    'iconPanel' => 'mdi-bookmark-multiple'
                ],
                'IncludeSections' => (object) []
            ],
        ],
        'Services' => (object) [
            'SERV01' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'IncludeCore' => (object) [
                    'include' => true,
                    'limit' => 3,
                    'condition' => 'active',
                    'relation' => 'category,subcategory',
                ],
                'config' => (object) [
                    'titleMenu' => 'Serviços',
                    'anchor' =>  false,
                    'linkMenu' => 'serv01.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Serviços',
                    'iconPanel' => 'mdi-room-service-outline'
                ],
                'IncludeSections' => (object) [
                    'Topics' => 'TOPI01'
                ],
            ],
        ],
        'Contacts' => (object) [
            'CONT01' => (object)[
                'ViewHome' => false,
                'ViewListMenu' => true,
                'ViewListPanel' => false,
                'IncludeCore' => (object) [
                    'include' => false,
                    'limit' => 0,
                    'condition' => null,
                    'relation' => null,
                ],
                'config' => (object) [
                    'titleMenu' => 'Contato',
                    'anchor' =>  false,
                    'linkMenu' => 'cont01.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Contato',
                    'iconPanel' => 'mdi-box'
                ],
                'IncludeSections' => (object) []
            ],
        ]
    ],

    'ModelsForm' => (object)[
        'FORM01' => 'Contacts_FORM01.jpg',
        'FORM02' => 'Contacts_FORM02.jpg',
        'FORM03' => 'Newsletter_FORM01.jpg',
        'FORM04' => 'Newsletter_FORM02.jpg',
    ],
];
