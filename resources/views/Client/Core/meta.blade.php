@if ($optimizePage)
    <title>{{$optimizePage->title}}</title>
    <meta name="title" content="{{$optimizePage->title}}">
    <meta name="description" content="{{$optimizePage->description}}">
    <meta name="keywords" content="{{$optimizePage->keywords}}" />
    <meta name="author" content="{{$optimizePage->author}}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{url(Route::current()->uri)}}">
    <meta property="og:title" content="{{$optimizePage->title}}">
    <meta property="og:description" content="{{$optimizePage->description}}">
    <meta property="og:image" content="{{asset('storage/'.$generalSetting->path_logo_share)}}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{url(Route::current()->uri)}}">
    <meta property="twitter:title" content="{{$optimizePage->title}}">
    <meta property="twitter:description" content="{{$optimizePage->description}}">
    <meta property="twitter:image" content="{{asset('storage/'.$generalSetting->path_logo_share)}}">
@else
    <title>{{$optimization->title}}</title>
    <meta name="title" content="{{$optimization->title}}">
    <meta name="description" content="{{$optimization->description}}">
    <meta name="keywords" content="{{$optimization->keywords}}" />
    <meta name="author" content="{{$optimization->author}}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{url(Route::current()->uri)}}">
    <meta property="og:title" content="{{$optimization->title}}">
    <meta property="og:description" content="{{$optimization->description}}">
    <meta property="og:image" content="{{asset('storage/'.$generalSetting->path_logo_share)}}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{url(Route::current()->uri)}}">
    <meta property="twitter:title" content="{{$optimization->title}}">
    <meta property="twitter:description" content="{{$optimization->description}}">
    <meta property="twitter:image" content="{{asset('storage/'.$generalSetting->path_logo_share)}}">
@endif

<meta property="og:image:width" content="200" />
<meta property="og:image:height" content="200" />

<meta name="robots" content="follow">
<meta name="copyright" content="© {{ date('Y') }} {{env('APP_NAME')}}." />
<meta name="generator" content="Laravel 8" />
