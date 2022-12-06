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
        'WorkWith' => (object) [
            'WOWI01' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'list',
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
