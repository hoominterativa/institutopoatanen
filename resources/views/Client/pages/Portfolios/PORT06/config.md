<!-- IDEAL CONFIGURATION FOR THE MODEL -->

'Portfolios' => (object) [
'PORT06' => (object)[
'ViewHome' => true,
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

<!-- 'relation' => (object)[
                'category' =>(object)[
                    'name' => 'Categoria',
                    'titleList' => 'title',
                    'condition' => 'active=1{Ativos}',
                ]
            ], -->

],
'config' => (object) [
'titleMenu' => 'Portifólio',
'anchor' => false,
'linkMenu' => 'port06.page',
'iconMenu' => '',
'titlePanel' => 'Portifólio',
'iconPanel' => 'mdi-alpha-p-box'
],
'IncludeSections' => (object) []
],
],
