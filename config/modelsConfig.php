<?php

return [
    // Configure the model the header and footer, not change the module
    'InsertModelsCore' => (object)[
        'Headers' => (object)[
            'Code' => 'HEAD02',
            'themeMenu' => 'SIDE02'
        ],
        'Footers' => (object)[
            'Code' => 'FOOT02'
        ]
    ],

    // Configure existing modules and templates site-wide/system
    'InsertModelsMain' => (object) [
        'Frequently' => (object) [
            'FREQ01' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'ViewListFooter' => true,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'IncludeCore' => (object) [
                    'include' => false,
                    'limit' => 'all',
                    'condition' => '',
                    'relation' => '',
                ],
                'config' => (object) [
                    'titleMenu' => 'faq',
                    'anchor' =>  false,
                    'linkMenu' => 'faq',
                    'iconMenu' => 'string',
                    'titlePanel' => 'faq',
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
