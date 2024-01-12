<!-- IDEAL CONFIGURATION FOR THE MODEL -->

```php
'Services' => (object) [
    'SERV02' => (object)[
        'ViewHome' => true,
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
            'relation' => "",
        ],
        'config' => (object) [
            'titleMenu' => 'Serviços',
            'anchor' =>  false,
            'linkMenu' => 'serv02.page',
            'iconMenu' => '',
            'titlePanel' => 'Serviços',
            'iconPanel' => 'mdi-alpha-s-box-outline'
        ],
        'IncludeSections' => (object) []
    ],
],
```
