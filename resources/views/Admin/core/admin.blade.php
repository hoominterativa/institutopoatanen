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

        <link href="{{url(mix('Admin/assets/libs/jquery.toast.min.css'))}}" rel="stylesheet" type="text/css" />
        <link href="{{url(mix('Admin/assets/libs/fancybox.css'))}}" rel="stylesheet" type="text/css" />

		<!-- App css -->
		<link href="{{url(mix('Admin/assets/css/config/bootstrap.min.css'))}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" disabled/>
		<link href="{{url(mix('Admin/assets/css/config/app.min.css'))}}" rel="stylesheet" type="text/css" id="app-default-stylesheet"  disabled/>

		<link href="{{url(mix('Admin/assets/css/config/bootstrap-dark.min.css'))}}" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" />
		<link href="{{url(mix('Admin/assets/css/config/app-dark.min.css'))}}" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />
		<!-- icons -->
		<link href="{{url(mix('Admin/assets/css/icons.min.css'))}}" rel="stylesheet" type="text/css" />

        <!-- Custom -->
        <link href="{{url(mix('Admin/assets/css/custom.css'))}}" rel="stylesheet" type="text/css" />

        <script>
            $url = "{{url('')}}";
        </script>

        <!-- Vendor js -->
        <script src="{{url(mix('Admin/assets/js/vendor.min.js'))}}"></script>
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
                                                <img src="{{asset('Admin/assets/images/brands/dropbox.png')}}" alt="dropbox">
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
                                @if ($contactLeadsUpcoming->count())
                                    <span class="badge bg-danger rounded-circle noti-icon-badge">{{$contactLeadsUpcoming->count()}}</span>
                                @endif
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-lg">

                                <!-- item-->
                                <div class="dropdown-item noti-title">
                                    <h5 class="m-0">Notificações</h5>
                                </div>

                                <div class="noti-scroll" data-simplebar>

                                    <!-- item-->
                                    @foreach ($contactLeadsUpcoming as $contactLeadUpcoming)
                                        <a href="{{route('admin.contact.index', ['code' => $contactLeadUpcoming->id])}}" class="d-flex notify-item">
                                            <div class="notify-icon bg-secondary">
                                                <i class="mdi mdi-handshake-outline"></i>
                                            </div>
                                            <p class="text-dark">
                                                Você recebeu um novo lead de <b>{{$contactLeadUpcoming->target_lead}}</b><br>
                                                <small class="text-muted">{{Carbon\Carbon::parse($contactLeadUpcoming->created_at)->format('d/m/Y H:i')}}</small>
                                            </p>
                                        </a>
                                    @endforeach
                                </div>

                            </div>
                        </li>

                        <li class="dropdown notification-list topbar-dropdown">
                            <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                @if (Auth::user()->path_image)
                                    <img src="{{asset('storage/'.Auth::user()->path_image)}}" alt="user-image" class="rounded-circle">
                                @else
                                    <img src="{{asset('Admin/assets/images/profile-image-null.jpg')}}" alt="user-image" class="rounded-circle">
                                @endif

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
                                <img src="{{url('Admin/assets/images/hoom-interativa-slogan-dark.png')}}" alt="" height="42">
                                <!-- <span class="logo-lg-text-light">UBold</span> -->
                            </span>
                            <span class="logo-lg">
                                <img src="{{url('Admin/assets/images/hoom-interativa-samall-dark.png')}}" alt="" height="45">
                                <!-- <span class="logo-lg-text-light">U</span> -->
                            </span>
                        </a>

                        <a href="{{route('admin.dashboard')}}" class="logo logo-light text-center">
                            <span class="logo-sm">
                                <img src="{{url('Admin/assets/images/hoom-interativa-salogan-light.png')}}" alt="" height="42">
                            </span>
                            <span class="logo-lg">
                                <img src="{{url('Admin/assets/images/hoom-interativa-small-light.png')}}" alt="" height="45">
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

                        <li class="dropdown d-none d-xl-block"></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
            <div class="left-side-menu">

                <div class="h-100" data-simplebar>
                    @if (!$compliancesValidate)
                        <div class="px-2 alert-compliance">
                            <div class="alert alert-danger mb-3 p-1 text-center">
                                <i class="mdi mdi-alert mdi-48px"></i>
                                <p class="mb-0">
                                    A sua área de <a href="{{$complianceModel?route('admin.'.$complianceModel.'.index'):''}}"><b>Compliance</b></a> está vazia, caso matenha nesse estado não será possível receber leads dos formulários no site.<br>
                                    Confira a <a href="https://www.planalto.gov.br/ccivil_03/_ato2015-2018/2018/lei/l13709.htm" target="_blank">LEI Nº 13.709, DE 14 DE AGOSTO DE 2018</a>
                                </p>
                            </div>
                        </div>
                    @endif
                    <!--- Sidemenu -->
                    <div id="sidebar-menu">

                        <ul id="side-menu">

                            <li class="menu-title text-primary"><b>Navegação</b></li>

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

                            <li class="menu-title text-primary mt-2"><b>Funil</b></li>

                            <li>
                                <a nofollow href="{{route('admin.contact.index')}}">
                                    <i class="mdi-handshake-outline mdi"></i>
                                    <span> Oportunidades </span>
                                </a>
                            </li>

                            <li>
                                <a nofollow href="{{route('admin.contactForm.index')}}">
                                    <i class="mdi mdi-content-paste"></i>
                                    <span> Formulários </span>
                                </a>
                            </li>

                            <li class="menu-title text-primary mt-2"><b>Configurações</b></li>

                            <li>
                                <a nofollow href="{{route('admin.header.index')}}">
                                    <i class="mdi mdi-microsoft-xbox-controller-menu"></i>
                                    <span> Menu </span>
                                </a>
                            </li>

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
                                <a nofollow href="{{route('admin.settingSmtp.index')}}">
                                    <i class="mdi mdi-email-edit"></i>
                                    <span> SMTP </span>
                                </a>
                            </li>
                            <li>
                                <a nofollow href="{{route('admin.social.index')}}">
                                    <i class="mdi mdi-graph-outline"></i>
                                    <span> Redes Sociais </span>
                                </a>
                            </li>

                            @if ($complianceModel)
                                <li>
                                    <a nofollow href="{{route('admin.'.$complianceModel.'.index')}}">
                                        <i class="mdi mdi-notebook-check"></i>
                                        <span> Compliances <span class="text-danger">*</span></span>
                                    </a>
                                </li>
                            @endif

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

        <script src="{{url(mix('Admin/assets/libs/fancybox.js'))}}"></script>
        <script src="{{url(mix('Admin/assets/libs/tippy.all.min.js'))}}"></script>
        <script src="{{url(mix('Admin/assets/libs/jquery.sortable.min.js'))}}"></script>
        <script src="{{url(mix('Admin/assets/libs/jquery.toast.min.js'))}}"></script>
        <script src="{{url(mix('Admin/assets/js/pages/toastr.init.js'))}}"></script>

        <script>
            class MyUploadAdapter {
                constructor( loader ) {
                    this.loader = loader;
                }

                upload() {
                    return this.loader.file
                        .then( file => new Promise( ( resolve, reject ) => {
                            this._initRequest();
                            this._initListeners( resolve, reject, file );
                            this._sendRequest( file );
                        } ) );
                }

                abort() {
                    if ( this.xhr ) {
                        this.xhr.abort();
                    }
                }

                _initRequest() {
                    const xhr = this.xhr = new XMLHttpRequest();

                    xhr.open( 'POST', "{{route('editor.upload.archive', ['_token' => csrf_token() ])}}", true );
                    xhr.responseType = 'json';
                }

                _initListeners( resolve, reject, file ) {
                    const xhr = this.xhr;
                    const loader = this.loader;
                    const genericErrorText = `Couldn't upload file: ${ file.name }.`;

                    xhr.addEventListener( 'error', () => reject( genericErrorText ) );
                    xhr.addEventListener( 'abort', () => reject() );
                    xhr.addEventListener( 'load', () => {
                        const response = xhr.response;

                        if ( !response || response.error ) {
                            return reject( response && response.error ? response.error.message : genericErrorText );
                        }

                        resolve( response );
                    } );

                    if ( xhr.upload ) {
                        xhr.upload.addEventListener( 'progress', evt => {
                            if ( evt.lengthComputable ) {
                                loader.uploadTotal = evt.total;
                                loader.uploaded = evt.loaded;
                            }
                        } );
                    }
                }

                _sendRequest( file ) {
                    const data = new FormData();

                    data.append( 'upload', file );

                    this.xhr.send( data );
                }
            }

            function MyCustomUploadAdapterPlugin( editor ) {
                editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
                    return new MyUploadAdapter( loader );
                };
            }

        </script>

        <link href="{{url(mix('Admin/assets/libs/owl.carousel.min.css'))}}" rel="stylesheet" type="text/css" />
        <script src="{{url(mix('Admin/assets/libs/owl.carousel.min.js'))}}"></script>

        @stack('createEditJs')
        @stack('indexJs')
        @stack('dashboardJs')

        <!-- App js -->
        <script src="{{url(mix('Admin/assets/js/app.min.js'))}}"></script>
        <script src="{{url(mix('Admin/assets/js/custom.js'))}}"></script>
        <script src="{{url(mix('Admin/assets/js/ajax.js'))}}"></script>


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
            @if (is_array(Session::get('reopenModal')))
                @foreach (Session::get('reopenModal') as $modal)
                    <script>
                        var modal = document.getElementById('{{$modal}}')
                        var myModal = new bootstrap.Modal(modal, {
                            keyboard: false
                        })
                        myModal.show(modal)
                    </script>
                @endforeach
            @else
                <script>
                    var modal = document.getElementById('{{Session::get("reopenModal")}}')
                    var myModal = new bootstrap.Modal(modal, {
                        keyboard: false
                    })
                    myModal.show(modal)
                </script>
            @endif
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
