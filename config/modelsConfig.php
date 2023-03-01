<?php

return [
    // Configure the model the header and footer, not change the module
    'InsertModelsCore' => (object)[
        'Headers' => (object)[
            'Code' => 'HEAD02'
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
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'ViewListFooter' => true,
                'Viewer' => 'list',
                'config' => (object) [
                    'titleMenu' => 'Redes Sociais',
                    'anchor' =>  true,
                    'linkMenu' => '#SLID02',
                    'iconMenu' => '',
                    'titlePanel' => 'Redes Sociais',
                    'iconPanel' => 'mdi-information'
                ],
                'IncludeSections' => (object) [
                    'Module' => '',
                    'Module' => '',
                ]
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
