<!-- IDEAL CONFIGURATION FOR THE MODEL -->

'SERV04' => (object)[
    'ViewHome' => true,
    'ViewListMenu' => true,
    'ViewListPanel' => true,
    'ViewListFooter' => true,
    'Viewer' => 'dropdown', // accepted values, list or dropdown
    'IncludeCore' => (object) [
        'include' => true,
        'sorting' => true,
        'limit' => 'all',
        'condition' => 'featured=1{Detaques}',
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
        'linkMenu' => 'serv04.page',
        'iconMenu' => '',
        'titlePanel' => 'Serviços',
        'iconPanel' => ''
    ],
    'IncludeSections' => (object) []
],
