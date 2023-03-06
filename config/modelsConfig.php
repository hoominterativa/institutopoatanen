<?php

return [
    // Configure the model the header and footer, not change the module
    'InsertModelsCore' => (object)[
        'Headers' => (object)[
            'Code' => 'HEAD03'
        ],
        'Footers' => (object)[
            'Code' => 'FOOT04'
        ]
    ],

    // Configure existing modules and templates site-wide/system
    'InsertModelsMain' => (object) [
        'Slides' => (object) [
            'SLID02' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => false,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'list',
                'config' => (object) [
                    'titleMenu' => 'Slides',
                    'anchor' =>  true,
                    'linkMenu' => '#SLID02',
                    'iconMenu' => '',
                    'titlePanel' => 'Slides',
                    'iconPanel' => 'mdi-information'
                ],
            ],
        ],

        'Topics' => (object) [
            'TOPI102' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => false,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'list',
                'config' => (object) [
                    'titleMenu' => 'Tópicos',
                    'anchor' =>  false,
                    'linkMenu' => '#TOPI102',
                    'iconMenu' => '',
                    'titlePanel' => 'Tópicos',
                    'iconPanel' => 'mdi-information'
                ],
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
