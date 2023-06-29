<!-- IDEAL CONFIGURATION FOR THE MODEL -->

'Products' => (object) [
    'PROD05' => (object)[
        'ViewHome' => true,
        'ViewListMenu' => true,
        'ViewListPanel' => true,
        'ViewListFooter' => true,
        'Viewer' => 'dropdown', // accepted values, list or dropdown
        'IncludeCore' => (object) [
            'include' => true,
            'sorting' => true,
            'limit' => 'all',
            'condition' => 'active=1{Ativos},featured_home=1{Detaques Home}',
            'titleList' => 'title',
            'relation' => (object) [
                'category' =>(object)[
                    'name' => 'Categoria',
                    'titleList' => 'title',
                    'condition' => 'active=1{Ativos},featured_home=1{Detaques Home}',
                ],
                'subcategory' =>(object)[
                    'name' => 'Subcategoria',
                    'titleList' => 'title',
                    'condition' => 'active=1{Ativos}',
                ]
            ],
        ],
        'config' => (object) [
            'titleMenu' => 'Produtos',
            'anchor' =>  false,
            'linkMenu' => 'prod05.page',
            'iconMenu' => '',
            'titlePanel' => 'Produtos',
            'iconPanel' => 'mdi-shopping-outline'
        ],
        'IncludeSections' => (object) [

        ]
    ],
],
