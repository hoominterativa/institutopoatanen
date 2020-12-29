<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Module Headers</title>

       {{-- Laravel Mix - CSS File --}}
       <link rel="stylesheet" href="{{ mix('css/headers.css') }}">

    </head>
    <body>
        @yield('content')

        {{-- Laravel Mix - JS File --}}
        <script src="{{ mix('js/headers.js') }}"></script>
    </body>
</html>
