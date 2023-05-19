<!-- IDEAL CONFIGURATION FOR THE MODEL -->

'Portals' => (object) [
    'POTA01' => (object)[
        'ViewHome' => true,
        'ViewListMenu' => true,
        'ViewListPanel' => true,
        'CustomPanelView' => [true, '#ffa500'], // [boolean, hexadecimal]
        'ViewListFooter' => true,
        'Viewer' => 'dropdown', // accepted values, list or dropdown
        'IncludeCore' => (object) [
            'include' => true,
            'sorting' => true,
            'limit' => 'all',
            'condition' => 'active=1{Ativos},featured_home=1{Detaques Home},featured_page=1{Detaques Página}',
            'titleList' => 'title',
            'relation' => (object)[
                'category' =>(object)[
                    'name' => 'Categoria',
                    'titleList' => 'title',
                    'condition' => 'active=1{Ativos},featured_home=1{Detaques Home}',
                ]
            ],
        ],
        'pages' => (object) [
            'podcast' =>(object)[
                'name' => 'Podcast',
                'route' => 'pota01.podcast',
            ]
        ],
        'config' => (object) [
            'titleMenu' => 'Portal',
            'anchor' =>  false,
            'linkMenu' => 'pota01.page',
            'iconMenu' => '',
            'titlePanel' => 'Portais',
            'iconPanel' => 'mdi-filter-plus'
        ],
        'IncludeSections' => (object) []
    ],
],
