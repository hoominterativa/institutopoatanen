<!-- IDEAL CONFIGURATION FOR THE MODEL -->

'ContentPages' => (object) [
    'COPA03' => (object)[
        'ViewHome' => false,
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
            'relation' => (object) [
                'category' =>(object)[
                    'name' => 'Categoria',
                    'titleList' => 'title',
                    'condition' => 'active=1{Ativos}',
                ],
                'subcategory' =>(object)[
                    'name' => 'Subcategoria',
                    'titleList' => 'title',
                    'condition' => 'active=1{Ativos}',
                ]
            ],
        ],
        'config' => (object) [
            'titleMenu' => 'Soluções',
            'anchor' =>  false,
            'linkMenu' => 'copa03.page',
            'iconMenu' => '',
            'titlePanel' => 'Soluções',
            'iconPanel' => 'mdi-book-open-page-variant'
        ],
        'IncludeSections' => (object) []
    ]
]
