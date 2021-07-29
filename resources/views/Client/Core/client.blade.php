<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
    <title>Painel Hoom</title>
</head>
<body>
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
