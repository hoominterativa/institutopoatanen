<!-- IDEAL CONFIGURATION FOR THE MODEL -->

'Services' => (object) [
    'SERV05' => (object)[
        'ViewHome' => true,
        'ViewListMenu' => true,
        'ViewListPanel' => true,
        'ViewListFooter' => true,
        'Viewer' => 'dropdown', // accepted values, list or dropdown
        'IncludeCore' => (object) [
            'include' => true,
            'sorting' => true,
            'limit' => 'all',
            'condition' => 'active=1{Ativos},featured=1{Detaques}',
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
            'titleMenu' => 'Serviços',
            'anchor' =>  false,
            'linkMenu' => 'serv05.page',
            'iconMenu' => '',
            'titlePanel' => 'Serviços',
            'iconPanel' => 'mdi-alpha-s-box-outline'
        ],
        'IncludeSections' => (object) [
        ]
    ],
],
