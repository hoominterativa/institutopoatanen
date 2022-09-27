<?php

return [
    // Configure the model the header and footer, not change the module
    'InsertModelsCore' => (object)[
        'Headers' => (object)[
            'Code' => 'HEAD01',
            'themeMenu' => 'MENU01'
        ],
        'Footers' => (object)[]
    ],

    // Configure existing modules and templates site-wide/system
    'InsertModelsMain' => (object) [
        'Slides' => (object) [
            'SLID01' => (object)[
                'ViewHome' => true,
                'ViewListMenu' => false,
                'ViewListPanel' => true,
                'config' => (object) [
                    'titleMenu' => '',
                    'anchor' =>  false,
                    'linkMenu' => '',
                    'iconMenu' => '',
                    'titlePanel' => 'Banners',
                    'iconPanel' => 'mdi-monitor-screenshot'
                ]
            ],
        ],
        // 'Services' => (object) [
        //     'SERV01' => (object)[
        //         'ViewHome' => true,
        //         'ViewListMenu' => true,
        //         'ViewListPanel' => true,
        //         'IncludeCore' => (object) [
        //             'include' => true,
        //             'limit' => 3,
        //             'condition' => 'active',
        //             'relation' => 'category,subcategory',
        //         ],
        //         'config' => (object) [
        //             'titleMenu' => 'Serviços',
        //             'anchor' =>  false,
        //             'linkMenu' => 'serv01.page',
        //             'iconMenu' => '',
        //             'titlePanel' => 'Serviços',
        //             'iconPanel' => 'mdi-room-service-outline'
        //         ],
        //         'IncludeSections' => (object) [
        //             'Topics' => 'TOPI01'
        //         ],
        //     ],
        // ],
    ],

    'ModelsForm' => (object)[
        'FORM01' => 'Contacts_FORM01.jpg',
        'FORM02' => 'Contacts_FORM02.jpg',
        'FORM03' => 'Newsletter_FORM01.jpg',
        'FORM04' => 'Newsletter_FORM02.jpg',
    ],
];
