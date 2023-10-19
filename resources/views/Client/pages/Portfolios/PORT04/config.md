<!-- IDEAL CONFIGURATION FOR THE MODEL -->

'Portfolios' => (object) [
    'PORT04' => (object)[
        'ViewHome' => true,
        'ViewListMenu' => true,
        'ViewListPanel' => true,
        'ViewListFooter' => false,
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
                    'condition' => 'active=1{Ativos}',
                ]
            ],
        ],
        'config' => (object) [
            'titleMenu' => 'Portifólio',
            'anchor' =>  false,
            'linkMenu' => 'port04.page',
            'iconMenu' => '',
            'titlePanel' => 'Portifólio',
            'iconPanel' => ''
        ],
        'IncludeSections' => (object) []
    ],
],
