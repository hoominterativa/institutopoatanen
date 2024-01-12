<!-- IDEAL CONFIGURATION FOR THE MODEL -->

'Abouts' => (object) [
    'ABOU04' => (object)[
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
            'relation' => '',
        ],
        'config' => (object) [
        'titleMenu' => 'Sobre',
        'anchor' => false,
        'linkMenu' => 'abou04.page',
        'iconMenu' => '',
        'titlePanel' => 'Sobre',
        'iconPanel' => 'mdi-information'
        ],
        'IncludeSections' => (object) [
        ],
    ],
],
