<!-- IDEAL CONFIGURATION FOR THE MODEL -->

'Galleries' => (object) [
    'GALL03' => (object)[
        'ViewHome' => true,
        'ViewListMenu' => true,
        'ViewListPanel' => true,
        'ViewListFooter' => false,
        'Viewer' => 'dropdown', // accepted values, list or dropdown
        'IncludeCore' => (object) [
            'include' => true,
            'sorting' => true,
            'limit' => 'all',
            'condition' => 'active=1{Ativos},featured=1{Detaques}',
            'titleList' => 'title',
        ],
        'config' => (object) [
            'titleMenu' => 'Galeria',
            'anchor' =>  false,
            'linkMenu' => 'gall03.page',
            'iconMenu' => '',
            'titlePanel' => 'Galeria',
            'iconPanel' => ''
        ],
        'IncludeSections' => (object) [
        ],
    ],
],
