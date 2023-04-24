<?php

return [
    // Configure the model the header and footer, not change the module
    'InsertModelsCore' => (object)[
        'Headers' => (object)[
        ],
        'Footers' => (object)[
        ]
    ],

    // Configure existing modules and templates site-wide/system
    'InsertModelsMain' => (object) [
        'Units' => (object) [
            'UNIT01' => (object)[
                'ViewHome' => false,
                'ViewListMenu' => true,
                'ViewListPanel' => true,
                'ViewListFooter' => true,
                'Viewer' => 'dropdown', // accepted values, list or dropdown
                'IncludeCore' => (object) [
                    'include' => true,
                    'sorting' => true,
                    'limit' => 'all',
                    'condition' => 'active=1{Ativos}',
                    'titleList' => 'title',
                    'relation' => (object)[
                    ],
                ],
                'config' => (object) [
                    'titleMenu' => 'Unidades',
                    'anchor' =>  false,
                    'linkMenu' => 'unit01.page',
                    'iconMenu' => '',
                    'titlePanel' => 'Unidades',
                    'iconPanel' => ''
                ],
                'IncludeSections' => (object) [
                ]
            ],
        ],        
    ],

    'ModelsForm' => (object)[
        'FORM101' => 'Contacts_FORM101.jpg',
    ],

    'ModelsCompliances' => (object)[
    ],
];
