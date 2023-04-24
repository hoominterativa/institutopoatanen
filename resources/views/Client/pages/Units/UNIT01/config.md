<!-- IDEAL CONFIGURATION FOR THE MODEL -->

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


