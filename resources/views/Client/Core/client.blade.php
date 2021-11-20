<!DOCTYPE html>
<html lang="{{config('app.locale')}}">
<head>
    {!!$optimization->scripts!!}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @if ($optimizePage)
        <title>{{$optimizePage->title}}</title>
        <meta name="description" content="{{$optimizePage->description}}">
        <meta name="keywords" content="{{$optimizePage->keywords}}" />
        <meta name="author" content="{{$optimizePage->author}}">
    @else
        <title>{{$optimization->title}}</title>
        <meta name="description" content="{{$optimization->description}}">
        <meta name="keywords" content="{{$optimization->keywords}}" />
        <meta name="author" content="{{$optimization->author}}">
    @endif
    <meta name="robots" content="follow">
    <meta name="copyright" content="© 2021 {{env('APP_NAME')}}." />
    <meta name="generator" content="Laravel 8" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{url('storage/'.$generalSetting->path_favicon)}}">

    <link rel="stylesheet" href="{{mix('css/app.css')}}">
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
    <script src="{{mix('js/app.js')}}"></script>
</body>
</html>
