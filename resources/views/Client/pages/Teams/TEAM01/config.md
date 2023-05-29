<!-- IDEAL CONFIGURATION FOR THE MODEL -->

'InsertModelsMain' => (object) [
    'Teams' => (object) [
        'TEAM01' => (object)[
            'ViewHome' => true,
            'ViewListMenu' => false,
            'ViewListPanel' => true,
            'ViewListFooter' => false,
            'Viewer' => 'dropdown', // accepted values, list or dropdown
            'IncludeCore' => (object) [
                'include' => true,
                'sorting' => true,
                'limit' => 'all',
                'condition' => 'active=1{Ativos},featured=1{Detaques}',
                'titleList' => 'title',
                'relation' => (object)[
                    'category' =>(object)[
                        'name' => 'Categoria',
                        'titleList' => 'title',
                        'condition' => 'active=1{Ativos}',
                    ]
                ],
            ],
            'config' => (object) [
                'titleMenu' => 'Equipe',
                'anchor' =>  false,
                'linkMenu' => 'team01.page',
                'iconMenu' => '',
                'titlePanel' => 'Equipe',
                'iconPanel' => ''
            ]
        ],
    ],
],