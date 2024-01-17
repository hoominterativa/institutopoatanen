<!-- IDEAL CONFIGURATION FOR THE MODEL -->

'Services' => (object) [
    'SERV10' => (object)[
        'ViewHome' => true,
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
            'linkMenu' => 'serv10.page',
            'iconMenu' => '',
            'titlePanel' => 'Serviços',
            'iconPanel' => 'mdi-alpha-s-box-outline'
        ],
        'IncludeSections' => (object) [
        ]
    ],
],
