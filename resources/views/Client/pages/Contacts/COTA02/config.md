<!-- IDEAL CONFIGURATION FOR THE MODEL -->

'Contacts' => (object) [
    'COTA02' => (object)[
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
            'titleList' => 'title_banner',
            'relation' => ''
        ],
        'config' => (object) [
            'titleMenu' => 'Contato',
            'anchor' =>  false,
            'linkMenu' => 'cota02.page',
            'iconMenu' => '',
            'titlePanel' => 'Contato',
            'iconPanel' => ''
        ],
        'IncludeSections' => (object) [
        ]
    ],
],
