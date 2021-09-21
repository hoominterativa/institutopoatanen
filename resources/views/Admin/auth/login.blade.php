@extends('Admin.core.auth')
@section('content')
    <div class="auth-fluid" style="background-image: url({{asset('admin/assets/images/bg-material.png')}})">
        <!--Auth fluid left content -->
        <div class="auth-fluid-form-box">
            <div class="align-items-center d-flex h-100">
                <div class="card-body">

                    <!-- Logo -->
                    <div class="auth-brand text-center text-lg-start">
                        <div class="auth-logo">
                            <a href="index.html" class="logo logo-dark text-center">
                                <span class="logo-lg">
                                    <img src="{{asset('admin/assets/images/logo-dark.png')}}" alt="" height="22">
                                </span>
                            </a>

                            <a href="index.html" class="logo logo-light text-center">
                                <span class="logo-lg">
                                    <img src="{{asset('admin/assets/images/logo-light.png')}}" alt="" height="22">
                                </span>
                            </a>
                        </div>
                    </div>

                    <!-- title-->
                    <h4 class="mt-0">Entrar</h4>
                    <p class="text-muted mb-4">Digite seu endereço de e-mail e senha para acessar a conta.</p>

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
                            <label for="emailaddress" class="form-label">E-mail</label>
                            <input class="form-control" type="email" name="email" id="emailaddress" required="">
                        </div>
                        <div class="mb-3">
                            <a href="auth-recoverpw-2.html" class="text-muted float-end"><small>Esqueceu sua senha?</small></a>
                            <label for="password" class="form-label">Senha</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" name="password" class="form-control">
                                <div class="input-group-text" data-password="false">
                                    <span class="password-eye"></span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkbox-signin">
                                <label class="form-check-label" name="remember" value="1" for="checkbox-signin">Lembre de mim</label>
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

        <!-- Auth fluid right content -->
        <div class="auth-fluid-right text-center">
            <div class="auth-user-testimonial">
                <h2 class="mb-3 text-white">I love the color!</h2>
                <p class="lead"><i class="mdi mdi-format-quote-open"></i> I've been using your theme from the previous developer for our web app, once I knew new version is out, I immediately bought with no hesitation. Great themes, good documentation with lots of customization available and sample app that really fit our need. <i class="mdi mdi-format-quote-close"></i>
                </p>
                <h5 class="text-white">
                    - Fadlisaad (Ubold Admin User)
                </h5>
            </div> <!-- end auth-user-testimonial-->
        </div>
        <!-- end Auth fluid right content -->
    </div>
    <!-- end auth-fluid-->
@endsection
