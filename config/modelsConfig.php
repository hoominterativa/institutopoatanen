<?php

return [
    // Configure the model the header and footer, not change the module
    'InsertModelsCore' => (object)[
        'Headers' => (object)[
            'Code' => 'HEAD02'
        ],
        'Footers' => (object)[

        ]
    ],

    // Configure existing modules and templates site-wide/system
    'InsertModelsMain' => (object) [
        'Abouts' => (object) [
            'ABOU02' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'config' => (object) [
                    'titleMenu' => 'Sobre',
                    'anchor' =>  false,
                    'linkMenu' => 'abou02.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Sobre',
                    'iconPanel' => 'mdi-information'
                ],
                'IncludeSections' => (object) []
            ],
        ],
    ],

    'ModelsForm' => (object)[
        'FORM01' => 'Contacts_FORM01.jpg',
        'FORM02' => 'Contacts_FORM02.jpg',
        'FORM03' => 'Newsletter_FORM01.jpg',
        'FORM04' => 'Newsletter_FORM02.jpg',
    ],
];
