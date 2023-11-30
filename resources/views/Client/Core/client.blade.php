<!DOCTYPE html>
<html lang="{{config('app.locale')}}">
<head>
    {!!$optimization->scripts!!}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="device" content="{{ deviceDetect() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @include('Client.Core.meta',[
        'optimization' => $optimization,
        'optimizePage' => $optimizePage
    ])

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{url('storage/'.$generalSetting->path_favicon)}}">
    <link rel="canonical" href="{{url(Route::current()->uri)}}">
    <link rel="stylesheet" href="{{asset(mix('css/libraries.css'))}}">
    <link rel="stylesheet" href="{{asset(mix('css/app.css'))}}">
    <link rel="stylesheet" href="{{asset(mix('css/icons.css'))}}">
    <script>
        $url = "{{url('')}}";
    </script>

</head>
{{-- <body data-device=""> --}}
<body data-device="{{ deviceDetect() }}">
    {!!$optimization->other_scripts!!}
    <header id="mainHeader" class="header-{{$classCores}} {{$classCores<>'home'?'custom-header':''}}">
        {!!$renderHeader!!}
    </header>
    @yield('content')
    <footer id="mainFooter" class="footer-{{$classCores}} {{$classCores<>'home'?'custom-footer':''}}">
        {!!$renderFooter!!}
    </footer>


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
