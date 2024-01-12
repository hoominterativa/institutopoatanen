 
 'Contacts' => (object) [
    'COTA03' => (object)[
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
            'titleMenu' => 'Contato',
            'anchor' =>  false,
            'linkMenu' => 'cota03.page',
            'iconMenu' => '',
            'titlePanel' => 'Contato',
            'iconPanel' => 'mdi-contacts'
        ],
        'IncludeSections' => (object) [
        ]
    ],
],



        
 
 @include('Client.Components.inputs', [
    'name' => 'email',
    'options' => '',
    'placeholder' => 'E-mail',
    'type' => 'text',
    'required' => 'false',
])
