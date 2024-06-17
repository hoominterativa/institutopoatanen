<!-- IDEAL CONFIGURATION FOR THE MODEL -->

'Portfolios' => (object) [
    'PORT05' => (object)[
        'ViewHome' => true,
        'ViewListMenu' => true,
        'ViewListPanel' => true,
        'ViewListFooter' => false,
        'Viewer' => 'dropdown', // accepted values, list or dropdown
        'IncludeCore' => (object) [
            'include' => true,
            'sorting' => true,
            'limit' => 'all',
            'condition' => 'active=1{Ativos}',
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
            'linkMenu' => 'port05.page',
            'iconMenu' => '',
            'titlePanel' => 'Portifólio',
            'iconPanel' => 'mdi-alpha-p-box'
        ],
        'IncludeSections' => (object) []
    ],
],
