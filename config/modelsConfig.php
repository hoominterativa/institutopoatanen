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
        'Galleries' => (object) [
            'GALL01' => (object)[
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
                    'titlePanel' => 'GALL01',
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
