<!DOCTYPE html>
<html lang="{{config('app.locale')}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cálculo de Proporção</title>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{url('storage/'.$generalSetting->path_favicon)}}">

    <!-- App css -->
    <link href="{{url(('Admin/assets/css/config/bootstrap.min.css'))}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet"/>
    <link href="{{url(('Admin/assets/css/config/app.min.css'))}}" rel="stylesheet" type="text/css" id="app-default-stylesheet"/>
</head>
<body>
    <main class="container-fluid">
        <section class="container py-5">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <h3>Cálculo de proporção</h3>
                    <p>
                        • No campo <b>Largura Pretendida</b> informe a largura que deseja para o box <br>
                        • Nos campos <b>Largura atual</b> e <b>Altura Atual</b> informe as dimensões atual do box. <br>
                        O resultado será a proporção com base na <b>Largura Pretendida</b>.</p>
                    <form action="{{route('admin.calProporcion')}}" method="post" class="mt-4">
                        @csrf
                        <div class="mb-3">
                            <label for="new_width" class="form-label">Largura Pretendida</label>
                            <input type="text" class="form-control" name="new_width" value="{{$request->new_width??''}}">
                        </div>
                        <div class="row">
                            <div class="mb-3 col-12 col-lg-6">
                                <label for="current_width" class="form-label">Largura Atual</label>
                                <input type="text" class="form-control" name="current_width" value="{{$request->current_width??''}}">
                            </div>
                            <div class="mb-3 col-12 col-lg-6">
                                <label for="current_height" class="form-label">Altura Atual</label>
                                <input type="text" class="form-control" name="current_height" value="{{$request->current_height??''}}">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary float-end">Calcular</button>
                    </form>
                    <div class="result">
                        {!!$result??''!!}
                    </div>
                </div>
                <div class="col-12 col-lg-6"></div>
            </div>
        </section>
    </main>
</body>
</html>
