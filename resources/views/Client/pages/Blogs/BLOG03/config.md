'Blogs' => (object) [
    'BLOG03' => (object)[
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
                    'condition' => 'active=1{Ativos}',
                ]
            ],
        ],
        'config' => (object) [
            'titleMenu' => 'Artigos',
            'anchor' =>  false,
            'linkMenu' => 'blog03.page',
            'iconMenu' => '',
            'titlePanel' => 'Artigos',
            'iconPanel' => 'mdi-blogger'
        ],
        'IncludeSections' => (object) []
    ],
],
