<!-- IDEAL CONFIGURATION FOR THE MODEL -->

'Contacts' => (object) [
    'COTA01' => (object)[
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
            'relation' => null,
        ],
        'config' => (object) [
            'titleMenu' => 'Contato',
            'anchor' =>  false,
            'linkMenu' => 'cota01.page',
            'iconMenu' => '',
            'titlePanel' => 'Contato',
            'iconPanel' => 'mdi-contacts'
        ],
        'IncludeSections' => (object) [
        ]
    ],
],
