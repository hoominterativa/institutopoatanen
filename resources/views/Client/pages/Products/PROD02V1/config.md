<!-- IDEAL CONFIGURATION FOR THE MODEL -->

'Products' => (object) [
    'PROD02V1' => (object)[
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
            'titleMenu' => 'Produtos',
            'anchor' =>  false,
            'linkMenu' => 'prod02v1.page',
            'iconMenu' => '',
            'titlePanel' => 'Produtos',
            'iconPanel' => 'mdi-shopping-outline'
        ],
        'IncludeSections' => (object) [
        ]
    ],
],
