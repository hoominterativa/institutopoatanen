<!DOCTYPE html>
<html lang="{{config('app.locale')}}">
    <head>
        <meta charset="utf-8" />
        <title>{{env('APP_NAME')}} - Painel Gerenciador</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <meta name="author" content="Hoom interativa">
        <meta name="description" content="Sistema de gerenciamento do site {{env('APP_NAME')}}">
        <meta name="copyright" content="© 2021 Hoom insterativa." />
        <meta name="robots" content="none">
        <meta name="googlebot" content="noarchive">

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{url('storage/'.$generalSetting->path_favicon)}}">

        @stack('createEditCss')
        @stack('indexCss')
        @stack('dashboardCss')
        <link href="{{url(mix('admin/assets/libs/jquery.toast.min.css'))}}" rel="stylesheet" type="text/css" />
        <link href="{{url(mix('admin/assets/libs/fancybox.css'))}}" rel="stylesheet" type="text/css" />

		<!-- App css -->
		<link href="{{url(mix('admin/assets/css/config/bootstrap.min.css'))}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" disabled/>
		<link href="{{url(mix('admin/assets/css/config/app.min.css'))}}" rel="stylesheet" type="text/css" id="app-default-stylesheet"  disabled/>

		<link href="{{url(mix('admin/assets/css/config/bootstrap-dark.min.css'))}}" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" />
		<link href="{{url(mix('admin/assets/css/config/app-dark.min.css'))}}" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />
		<!-- icons -->
		<link href="{{url(mix('admin/assets/css/icons.min.css'))}}" rel="stylesheet" type="text/css" />

        <!-- Custom -->
        <link href="{{url(mix('admin/assets/css/custom.css'))}}" rel="stylesheet" type="text/css" />

        <script>
            $url = "{{url('')}}";
        </script>

    </head>

    <!-- body start -->
    <body class="loading" data-layout='{"mode": "{{$settingTheme->color_scheme_mode}}", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "{{$settingTheme->leftsidebar_color}}", "size": "{{$settingTheme->leftsidebar_size}}", "showuser": false}, "topbar": {"color": "{{$settingTheme->topbar_color}}"}, "showRightSidebarOnPageLoad": false}'>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
            <div class="navbar-custom">
                <div class="container-fluid">
                    <ul class="list-unstyled topnav-menu float-end mb-0">

                        <li class="dropdown d-none d-lg-inline-block">
                            <a class="nav-link arrow-none waves-effect waves-light" data-toggle="fullscreen" href="#">
                                <i class="fe-maximize noti-icon"></i>
                            </a>
                        </li>

                        <li class="dropdown d-none d-lg-inline-block topbar-dropdown">
                            <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="fe-grid noti-icon"></i>
                            </a>
                            <div class="dropdown-menu dropdown-lg dropdown-menu-end">

                                <div class="p-lg-1">
                                    <div class="row g-0">
                                        <div class="col">
                                            <a class="dropdown-icon-item" href="#">
                                                <img src="{{asset('admin/assets/images/brands/dropbox.png')}}" alt="dropbox">
                                                <span>Dropbox</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </li>

                        <li class="dropdown notification-list topbar-dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="fe-bell noti-icon"></i>
                                <span class="badge bg-danger rounded-circle noti-icon-badge">9</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-lg">

                                <!-- item-->
                                <div class="dropdown-item noti-title">
                                    <h5 class="m-0">
                                        <span class="float-end">
                                            <a href="" class="text-dark">
                                                <small>Limpar todos</small>
                                            </a>
                                        </span>Notificações
                                    </h5>
                                </div>

                                <div class="noti-scroll" data-simplebar>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item active">
                                        <div class="notify-icon">
                                            <img src="{{asset('admin/assets/images/users/user-1.jpg')}}" class="img-fluid rounded-circle" alt="" /> </div>
                                        <p class="notify-details">Cristina Pride</p>
                                        <p class="text-muted mb-0 user-msg">
                                            <small>Hi, How are you? What about our next meeting</small>
                                        </p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-primary">
                                            <i class="mdi mdi-comment-account-outline"></i>
                                        </div>
                                        <p class="notify-details">Caleb Flakelar commented on Admin
                                            <small class="text-muted">1 min ago</small>
                                        </p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon">
                                            <img src="{{asset('admin/assets/images/users/user-4.jpg')}}" class="img-fluid rounded-circle" alt="" /> </div>
                                        <p class="notify-details">Karen Robinson</p>
                                        <p class="text-muted mb-0 user-msg">
                                            <small>Wow ! this admin looks good and awesome design</small>
                                        </p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-warning">
                                            <i class="mdi mdi-account-plus"></i>
                                        </div>
                                        <p class="notify-details">New user registered.
                                            <small class="text-muted">5 hours ago</small>
                                        </p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-info">
                                            <i class="mdi mdi-comment-account-outline"></i>
                                        </div>
                                        <p class="notify-details">Caleb Flakelar commented on Admin
                                            <small class="text-muted">4 days ago</small>
                                        </p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-secondary">
                                            <i class="mdi mdi-heart"></i>
                                        </div>
                                        <p class="notify-details">Carlos Crouch liked
                                            <b>Admin</b>
                                            <small class="text-muted">13 days ago</small>
                                        </p>
                                    </a>
                                </div>

                                <!-- All-->
                                <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                                    View all
                                    <i class="fe-arrow-right"></i>
                                </a>

                            </div>
                        </li>

                        <li class="dropdown notification-list topbar-dropdown">
                            <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <img src="{{asset('admin/assets/images/users/user-1.jpg')}}" alt="user-image" class="rounded-circle">
                                <span class="pro-user-name ms-1">
                                    {{explode(' ', Auth::user()->name)[0]}}
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                                <!-- item-->
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Bem Vindo !</h6>
                                </div>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item right-bar-toggle notify-item">
                                    <i class="fe-settings"></i>
                                    <span>Configurações</span>
                                </a>

                                <div class="dropdown-divider"></div>

                                <!-- item-->
                                <a href="{{route('admin.user.logout')}}" class="dropdown-item notify-item">
                                    <i class="fe-log-out"></i>
                                    <span>Sair</span>
                                </a>

                            </div>
                        </li>

                    </ul>

                    <!-- LOGO -->
                    <div class="logo-box">
                        <a href="{{route('admin.dashboard')}}" class="logo logo-dark text-center">
                            <span class="logo-sm">
                                <img src="{{url('storage/'.$generalSetting->path_favicon)}}" alt="" height="22">
                                <!-- <span class="logo-lg-text-light">UBold</span> -->
                            </span>
                            <span class="logo-lg">
                                <img src="{{url('storage/'.$generalSetting->path_logo_header_dark)}}" alt="" height="30">
                                <!-- <span class="logo-lg-text-light">U</span> -->
                            </span>
                        </a>

                        <a href="{{route('admin.dashboard')}}" class="logo logo-light text-center">
                            <span class="logo-sm">
                                <img src="{{url('storage/'.$generalSetting->path_favicon)}}" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="{{url('storage/'.$generalSetting->path_logo_header_light)}}" alt="" height="40">
                            </span>
                        </a>
                    </div>

                    <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                        <li>
                            <button class="button-menu-mobile waves-effect waves-light">
                                <i class="fe-menu"></i>
                            </button>
                        </li>

                        <li>
                            <!-- Mobile menu toggle (Horizontal Layout)-->
                            <a class="navbar-toggle nav-link" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                                <div class="lines">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </a>
                            <!-- End mobile menu toggle-->
                        </li>

                        <li class="dropdown d-none d-xl-block">
                            <a class="nav-link dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                Cadastre novo
                            </a>
                            <div class="dropdown-menu">
                                @foreach ($modelsMain as $module => $models)
                                    @foreach ($models as $code => $model)
                                        @if ($model->ViewListPanel)
                                            <!-- item-->
                                            <a href="{{route('admin.'.Str::lower($code).'.create')}}" class="dropdown-item">
                                                <i class="{{$model->config->iconPanel<>''?$model->config->iconPanel:'mdi-cancel'}} mdi me-1"></i>
                                                <span>{{$model->config->titlePanel}}</span>
                                            </a>
                                        @endif
                                    @endforeach
                                @endforeach

                                <a href="{{route('admin.user.create')}}" class="dropdown-item">
                                    <i class="mdi-account mdi me-1"></i>
                                    <span>Usuário</span>
                                </a>

                                <div class="dropdown-divider"></div>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">
                                    <i class="mdi mdi-help-box"></i>
                                    <span>Tutoriais</span>
                                </a>

                            </div>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
            <div class="left-side-menu">

                <div class="h-100" data-simplebar>
                    <!--- Sidemenu -->
                    <div id="sidebar-menu">

                        <ul id="side-menu">

                            <li class="menu-title">Navegação</li>

                            <li>
                                <a nofollow href="{{route('admin.dashboard')}}">
                                    <i class="mdi mdi-view-dashboard-outline"></i>
                                    <span> Dashboard </span>
                                </a>
                            </li>

                            @foreach ($modelsMain as $module => $models)
                                @foreach ($models as $code => $model)
                                    @if ($model->ViewListPanel)
                                        <li>
                                            <a nofollow href="{{route('admin.'.Str::lower($code).'.index')}}">
                                                <i class="{{$model->config->iconPanel<>''?$model->config->iconPanel:'mdi-cancel'}} mdi"></i>
                                                <span> {{$model->config->titlePanel}} </span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            @endforeach

                            <li>
                                <a nofollow href="{{route('admin.contact.index')}}">
                                    <i class="mdi-handshake-outline mdi"></i>
                                    <span> Lead Contato </span>
                                </a>
                            </li>

                            <li>
                                <a nofollow href="{{route('admin.contactForm.index')}}">
                                    <i class="mdi mdi-content-paste"></i>
                                    <span> Formulários </span>
                                </a>
                            </li>

                            <li class="menu-title mt-2">Configurações</li>

                            <li>
                                <a nofollow href="{{route('admin.optimization.index')}}">
                                    <i class="mdi-google-analytics mdi"></i>
                                    <span> SEO </span>
                                </a>
                            </li>

                            <li>
                                <a nofollow href="{{route('admin.generalSetting.index')}}">
                                    <i class="mdi mdi-hammer-wrench"></i>
                                    <span> Gerais </span>
                                </a>
                            </li>

                            <li>
                                <a nofollow href="{{route('admin.user.index')}}">
                                    <i class="mdi-account mdi"></i>
                                    <span> Usuários </span>
                                </a>
                            </li>

                            <li>
                                <a nofollow href="{{route('admin.icons')}}">
                                    <i class="mdi mdi-bullseye"></i>
                                    <span> Icones </span>
                                </a>
                            </li>

                            <li class="menu-title mt-2">Suporte</li>

                            <li>
                                <a nofollow href="#">
                                    <i class="mdi mdi-headphones"></i>
                                    <span> Chamados </span>
                                </a>
                            </li>

                            <li>
                                <a nofollow href="#">
                                    <i class="mdi mdi-help-box"></i>
                                    <span> Tutoriais </span>
                                </a>
                            </li>
                        </ul>

                    </div>
                    <!-- End Sidebar -->

                    <div class="clearfix"></div>

                </div>
                <!-- Sidebar -left -->

            </div>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->
            @yield('content')
            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->
        @include('Admin.components.models.settingsTheme')

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        <script src="{{url(mix('admin/assets/js/vendor.min.js'))}}"></script>

        <script src="{{url(mix('admin/assets/libs/fancybox.js'))}}"></script>
        <script src="{{url(mix('admin/assets/libs/tippy.all.min.js'))}}"></script>
        <script src="{{url(mix('admin/assets/libs/jquery.sortable.min.js'))}}"></script>
        <script src="{{url(mix('admin/assets/libs/jquery.toast.min.js'))}}"></script>
        <script src="{{url(mix('admin/assets/js/pages/toastr.init.js'))}}"></script>

        @stack('createEditJs')
        @stack('indexJs')
        @stack('dashboardJs')

        <!-- App js -->
        <script src="{{url(mix('admin/assets/js/app.min.js'))}}"></script>
        <script src="{{url(mix('admin/assets/js/custom.js'))}}"></script>

        @if(Session::has('success'))
            <script>
                $.NotificationApp.send("Sucesso!", "{{Session::get('success')}}", "bottom-left", "#00000080", "success", '8000')
            </script>
        @endif
        @if(Session::has('error'))
            <script>
                $.NotificationApp.send("Erro!", "{{Session::get('error')}}", "bottom-left", "#00000080", "error", '8000');
            </script>
        @endif
        @if(Session::has('info'))
            <script>
                $.NotificationApp.send("Atenção!", "{{Session::get('info')}}", "bottom-left", "#00000080", "info", '8000');
            </script>
        @endif

        @if(count($errors)>0)
            <ul class="list-group">
                @foreach($errors->all() as $error)
                    <script>
                        $.NotificationApp.send("Erro!", "{{$error}}", "bottom-left", "#00000080", "error", '8000');
                    </script>
                @endforeach
            </ul>
        @endif

        @if (Session::has('reopenModal'))
            <script>
                var modal = document.getElementById('{{Session::get("reopenModal")}}')
                var myModal = new bootstrap.Modal(modal, {
                    keyboard: false
                })
                myModal.show(modal)
            </script>
        @endif
        <script>
            $.each($('.modal'), function(i, value){
                if($(this).find('.modal').length){
                    $(this).find('.modal').appendTo("body");
                }
            })
        </script>
    </body>
</html>
