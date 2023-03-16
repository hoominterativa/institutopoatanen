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
        'Topics' => (object) [
            'TOPI101' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => false,
                'ViewListPanel' => true,
                'config' => (object) [
                    'titleMenu' => 'Tópicos',
                    'anchor' =>  false,
                    'linkMenu' => '',
                    'iconMenu' => '',
                    'titlePanel' => 'Tópicos',
                    'iconPanel' => 'mdi-information'
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
