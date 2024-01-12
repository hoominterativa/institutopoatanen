<!-- IDEAL CONFIGURATION FOR THE MODEL -->
'WorkWith' => (object) [
    'WOWI01' => (object)[
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
            'relation' => null
        ],
        'config' => (object) [
            'titleMenu' => 'Trabalhe Conosco',
            'anchor' =>  false,
            'linkMenu' => 'wowi01.page',
            'iconMenu' => '',
            'titlePanel' => 'Trabalhe Conosco',
            'iconPanel' => 'mdi-google-my-business'
        ],
        'IncludeSections' => (object) []
    ],
],
