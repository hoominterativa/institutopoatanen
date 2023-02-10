<!DOCTYPE html>
<html lang="{{config('app.locale')}}">
<head>
    {!!$optimization->scripts!!}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @if (!yield('title'))
        <script>alert('sadasdas')</script>
    @endif

    @include('Client.Core.meta',[
        'optimization' => $optimization,
        'optimizePage' => $optimizePage
    ])

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{url('storage/'.$generalSetting->path_favicon)}}">
    <link rel="canonical" href="{{url(Route::current()->uri)}}">
    <link rel="stylesheet" href="{{asset(mix('css/libraries.css'))}}">

</head>
<body>
    {!!$optimization->other_scripts!!}
    <header id="mainHeader">
        {!!$renderHeader!!}
    </header>
    @yield('content')
    <footer id="mainFooter">
        {!!$renderFooter!!}
    </footer>

    <link rel="stylesheet" href="{{asset(mix('css/app.css'))}}">
    <link rel="stylesheet" href="{{asset(mix('css/icons.css'))}}">
    <script src="{{asset(mix('js/app.js'))}}"></script>

    @if ($themeMenu)
        @include('Client.Components.themeMenu.'.$themeMenu.'.structure',[
            "listMenu" => $listMenu,
            "generalSetting" => $generalSetting,
            "linksCtaHeader" => $linksCtaHeader,
            "linksCtaFooter" => $linksCtaFooter,
            "socials" => $socials,
        ])
    @endif
</body>
</html>
