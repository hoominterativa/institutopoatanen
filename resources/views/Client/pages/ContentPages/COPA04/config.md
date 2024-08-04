<!-- IDEAL CONFIGURATION FOR THE MODEL -->

'ContentPages' => (object) [
    'COPA04' => (object)[
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
            'relation' => '',
        ],
        'config' => (object) [
            'titleMenu' => 'Página de Conteúdo',
            'anchor' =>  false,
            'linkMenu' => 'copa04.page',
            'iconMenu' => '',
            'titlePanel' => 'Página de Conteúdo',
            'iconPanel' => 'mdi-book-open-page-variant'
        ],
        'IncludeSections' => (object) []
    ],
],
