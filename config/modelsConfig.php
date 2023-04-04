<?php

return [
    // Configure the model the header and footer, not change the module
    'InsertModelsCore' => (object)[
        'Headers' => (object)[
            'Code' => '',
            'themeMenu' => ''

        ],
        'Footers' => (object)[
            'Code' => ''
        ]
    ],

    // Configure existing modules and templates site-wide/system
    'InsertModelsMain' => (object) [

    ],

    'ModelsForm' => (object)[
        'FORM101' => 'Contacts_FORM101.jpg',
    ],

    'ModelsCompliances' => (object)[
        'Code' => 'COMP01'
    ],
];
