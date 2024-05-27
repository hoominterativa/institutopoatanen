<!-- IDEAL CONFIGURATION FOR THE MODEL -->

```php
'Units' => (object) [
    'UNIT05' => (object)[
        'ViewHome' => false,
        'ViewListMenu' => true,
        'ViewListPanel' => true,
        'ViewListFooter' => true,
        'Viewer' => 'dropdown', // accepted values, list or dropdown
        'IncludeCore' => (object) [
            'include' => true,
            'sorting' => true,
            'limit' => 'all',
            'condition' => 'active=1{Ativos}',
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
            'titleMenu' => 'Unidades',
            'anchor' => false,
            'linkMenu' => 'unit03.page',
            'iconMenu' => '',
            'titlePanel' => 'Unidades',
            'iconPanel' => 'mdi-warehouse'
            ],
        'IncludeSections' => (object) []
    ],
],
```
