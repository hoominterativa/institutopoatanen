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

            'SLID01' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => false,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'list',
                'config' => (object) [
                    'titleMenu' => 'Redes',
                    'anchor' =>  true,
                    'linkMenu' => '#SLID01',
                    'iconMenu' => '',
                    'titlePanel' => 'Redes',
                    'iconPanel' => 'mdi-information'
                ],
            ],

        ],

        'Services' => (object) [
            'SERV01' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => false,
                'ViewListPanel' => true,
                'ViewListFooter' => false,
                'Viewer' => 'list',
                'config' => (object) [
                    'titleMenu' => 'Services',
                    'anchor' =>  true,
                    'linkMenu' => '#SERV01',
                    'iconMenu' => '',
                    'titlePanel' => 'Services',
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
