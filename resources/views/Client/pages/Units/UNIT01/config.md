<!-- IDEAL CONFIGURATION FOR THE MODEL -->

'Units' => (object) [
    'UNIT01' => (object)[
        'ViewHome' => true,
        'ViewListMenu' => true,
        'ViewListPanel' => true,
        'ViewListFooter' => true,
        'Viewer' => 'dropdown', // accepted values, list or dropdown
        'IncludeCore' => (object) [
            'include' => true,
            'sorting' => true,
            'limit' => 'all',
            'condition' => 'active=1{Ativos},featured=1{Detaques Home}',
            'titleList' => 'title',
            'relation' => (object)[
                'category' =>(object)[
                    'name' => 'Categoria',
                    'titleList' => 'title',
                    'condition' => 'active=1{Ativos},featured=1{Detaques Home}',
                ]
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


