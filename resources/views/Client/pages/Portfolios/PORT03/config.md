'Portfolios' => (object) [
    'PORT03' => (object)[
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
            'titleMenu' => 'Portfolios',
            'anchor' =>  false,
            'linkMenu' => 'port03.page',
            'iconMenu' => '',
            'titlePanel' => 'Portfolios',
            'iconPanel' => 'mdi-book-multiple-outline'
        ]
    ],
],
