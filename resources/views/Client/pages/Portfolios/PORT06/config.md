<!-- IDEAL CONFIGURATION FOR THE MODEL -->

```php
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
```
