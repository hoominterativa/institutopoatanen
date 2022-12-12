<?php

return [
    // Configure the model the header and footer, not change the module
    'InsertModelsCore' => (object)[
        'Headers' => (object)[
            'Code' => 'HEAD02'
        ],
        'Footers' => (object)[
            'Code' => 'FOOT03'
        ]
    ],

    // Configure existing modules and templates site-wide/system
    'InsertModelsMain' => (object) [

        'Units' => (object) [
            'UNIT01' => (object)[
                'ViewHome' => false,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'config' => (object) [
                    'titleMenu' => '',
                    'anchor' =>  false,
                    'linkMenu' => '',
                    'iconMenu' => '',
                    'titlePanel' => 'Unidades',
                    'iconPanel' => 'mdi-information'
                ],
                'IncludeSections' => (object) []
            ],
        ],
    ],

    'ModelsForm' => (object)[
        'FORM101' => 'Contacts_FORM101.jpg',
    ],
];
