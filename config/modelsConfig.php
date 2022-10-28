<?php

return [
    // Configure the model the header and footer, not change the module
    'InsertModelsCore' => (object)[
        'Headers' => (object)[
            'Code' => 'HEAD02'
        ],
        'Footers' => (object)[]
    ],

    // Configure existing modules and templates site-wide/system
    'InsertModelsMain' => (object) [
        'Services' => (object) [
            'SERV01' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'config' => (object) [
                    'titleMenu' => 'Serviços',
                    'anchor' =>  false,
                    'linkMenu' => 'serv01.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Serviços',
                    'iconPanel' => 'mdi-view-list'
                ]
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
