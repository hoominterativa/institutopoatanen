<!-- IDEAL CONFIGURATION FOR THE MODEL -->

'Abouts' => (object) [
    'ABOU02' => (object)[
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
            ],
        ],
        'config' => (object) [
            'titleMenu' => 'Sobre',
            'anchor' =>  false,
            'linkMenu' => 'abou03.page',
            'iconMenu' => '',
            'titlePanel' => 'Sobre',
            'iconPanel' => ''
        ],
        'IncludeSections' => (object) [
        ]
    ],
],
