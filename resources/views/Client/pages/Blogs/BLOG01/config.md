<!-- IDEAL CONFIGURATION FOR THE MODEL -->

'Blogs' => (object) [
    'BLOG01' => (object)[
        'ViewHome' => true,
        'ViewListMenu' => true,
        'ViewListPanel' => true,
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
                    'condition' => 'active=1{Ativos}',
                ]
            ],
        ],
        'config' => (object) [
            'titleMenu' => 'Artigos',
            'anchor' =>  false,
            'linkMenu' => 'blog01.page',
            'iconMenu' => '',
            'titlePanel' => 'Artigos',
            'iconPanel' => ''
        ],
        'IncludeSections' => (object) [
            'Services' => ['SERV04'],
            'Feedbacks' => ['FEED01'],
        ]
    ],
],
