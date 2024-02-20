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
            'titleList' => 'title_page',
        ],
        'config' => (object) [
            'titleMenu' => 'Página de contato',
            'anchor' =>  false,
            'linkMenu' => 'copa03.page',
            'iconMenu' => '',
            'titlePanel' => 'Página de contato',
            'iconPanel' => 'mdi-book-open-page-variant'
        ],
        'IncludeSections' => (object) []
    ]
]
