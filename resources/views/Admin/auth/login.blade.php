@extends('Admin.core.auth')
@section('content')
<style>
    .auth-fluid {
        background-position: center right -50px;
        background-size: 100%;
    }
</style>
    <div class="auth-fluid" style="background-image: url({{asset('Admin/assets/images/bg-material.jpg')}})">
        <!--Auth fluid left content -->
        <div class="auth-fluid-form-box bg-dark">
            <div class="align-items-center d-flex h-100">
                <div class="card-body">

                    <!-- Logo -->
                    <div class="auth-brand text-center text-lg-start position-relative mb-5" style="top: 0;">
                        <div class="auth-logo-light">
                            <a href="{{route('admin.dashboard')}}" class="logo logo-dark text-center">
                                <span class="logo-lg">
                                    <img src="{{url('Admin/assets/images/hoom-interativa-dark.png')}}" alt="" height="90">
                                </span>
                            </a>

                            <a href="{{route('admin.dashboard')}}" class="logo logo-light text-center">
                                <span class="logo-lg">
                                    <img src="{{url('Admin/assets/images/hoom-interativa-light.png')}}" alt="" height="90">
                                </span>
                            </a>
                        </div>
                    </div>

                    <!-- title-->
                    <h4 class="mt-0">Entrar</h4>
                    <p class="text-muted mb-4" style="color: #c3c3c3 !important;">Digite seu endereço de e-mail e senha para acessar a conta.</p>

                    <!-- form -->
                    <form action="{{route('admin.user.authenticate')}}" method="POST">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @csrf
                        <div class="mb-3">
                            <label for="emailaddress" class="form-label" style="color: #c3c3c3;">E-mail</label>
                            <input class="form-control" type="email" name="email" id="emailaddress" required="">
                        </div>
                        <div class="mb-3">
                            <a href="auth-recoverpw-2.html" class="text-muted float-end" style="color: #c3c3c3;"><small>Esqueceu sua senha?</small></a>
                            <label for="password" class="form-label" style="color: #c3c3c3;">Senha</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" name="password" class="form-control">
                                <div class="input-group-text" data-password="false">
                                    <span class="password-eye"></span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="remember" value="1" class="form-check-input" id="checkbox-signin">
                                <label class="form-check-label" for="checkbox-signin" style="color: #c3c3c3;">Lembre de mim</label>
                            </div>
                        </div>
                        <div class="text-center d-grid">
                            <button class="btn btn-primary" type="submit">Entrar</button>
                        </div>
                    </form>
                    <!-- end form-->

                </div> <!-- end .card-body -->
            </div> <!-- end .align-items-center.d-flex.h-100-->
        </div>
        <!-- end auth-fluid-form-box-->
    </div>
    <!-- end auth-fluid-->
@endsection
