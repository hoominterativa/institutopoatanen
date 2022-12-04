@extends('Admin.core.admin')
@section('content')
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Oprtunidades</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Oprtunidades</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->


                <div class="row">
                    <div class="col-12 order-xl-1 order-2">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="row justify-content-between">
                                    <div class="col-8">
                                        <form action="{{route('admin.contact.filter')}}" method="post">
                                            @csrf
                                            <div class="row  align-items-end">
                                                <div class="col-3">
                                                    <div>
                                                        <label for="date_start" class="form-label">Leads de</label>
                                                        <input type="date" name="date_start" class="form-control my-1 my-md-0" id="date_start" value="{{isset($request)?$request->date_start:''}}">
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <label for="date_end" class="form-label">até</label>
                                                </div>
                                                <div class="col-3">
                                                    <div>
                                                        <input type="date" name="date_end" class="form-control my-1 my-md-0" id="date_end" value="{{isset($request)?$request->date_end:''}}">
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div>
                                                        <label for="status-select" class="form-label">Leads vindo de </label>
                                                        <select class="form-select my-1 my-md-0" name="target_lead" id="status-select">
                                                            <option selected="" value="">Todos</option>
                                                            @foreach ($contactLeadsFilter as $contactLeadFilter)
                                                                <option {{isset($request)?($request->target_lead==$contactLeadFilter?'selected':''):''}} value="{{$contactLeadFilter}}">{{$contactLeadFilter}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-1">
                                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Buscar</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-md-end mt-3 mt-md-0 ps-5">
                                            <form action="{{route('admin.contact.export')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="date_start" value="{{isset($request)?$request->date_start:''}}">
                                                <input type="hidden" name="date_end" value="{{isset($request)?$request->date_end:''}}">
                                                <input type="hidden" name="target_lead" value="{{isset($request)?$request->target_lead:''}}">
                                                <div class="row align-items-end">
                                                    <div class="col">
                                                        <label for="" class="form-label w-100 text-start">Extensão</label>
                                                        <select name="extension" class="form-select">
                                                            <option value="xlsx">xlsx</option>
                                                            <option value="csv">csv</option>
                                                            <option value="xls">xls</option>
                                                            <option value="tsv">tsv</option>
                                                            <option value="ods">ods</option>
                                                        </select>
                                                    </div>
                                                    <button type="submit" class="btn btn-info waves-effect waves-light col"><i class="mdi mdi-application-export me-1 font-18"></i> Exportar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div><!-- end col-->
                                </div> <!-- end row -->
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                        <div class="alert alert-warning my-2">
                            <p class="mb-0">Antes de exportar os leads aconselhamos selecionar a área do mesmo nas opções "<b>Leads vindo de:</b>" acima, pois cada formulário tem sua ordem de campo e importar todos os leads não garantirá que cada coluna no excel represente o mesmo conteúdo.</p>
                        </div>
                        @if ($contactLeads->count())
                            @foreach ($contactLeads as $contactLead)
                                <div class="card mb-2">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-sm-4">
                                                <div class="d-flex align-items-start">
                                                    <div class="w-100">
                                                        <p class="mb-1"><b>Data da Solicitação:</b> {{Carbon\Carbon::parse($contactLead->created_at)->format('d/m/Y H:i')}}</p>
                                                        @foreach ($contactLead->json as $key => $informations)
                                                            @if (isset($informations->type))
                                                                @if ($informations->type <> 'email' && $informations->type <> 'phone' && $informations->type <> 'cellphone' && $informations->type <> 'checkbox' && $informations->type <> 'file')
                                                                    <p class="mb-1"><b>{{$key}}:</b> {{$informations->value}}</p>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                @foreach ($contactLead->json as $key => $informations)
                                                    @if (isset($informations->type))
                                                        @switch($informations->type)
                                                            @case('email')
                                                                <p class="mb-1 mt-3 mt-sm-0"><a href="mailto:{{$informations->value}}"><i class="mdi mdi-email me-2 font-18"></i> {{$informations->value}}</a></p>
                                                            @break
                                                            @case('phone')
                                                                <p class="mb-1"><a href="tel:{{$informations->value}}"><i class="mdi mdi-phone me-2 font-18"></i> {{$informations->value}}</a></p>
                                                            @break
                                                            @case('cellphone')
                                                                <p class="mb-1"><a href="tel:{{$informations->value}}"><i class="mdi mdi-cellphone me-2 font-18"></i> {{$informations->value}}</a></p>
                                                            @break
                                                            @case('file')
                                                                <p class="mb-0"><a href="{{asset('storage/'.$informations->value)}}" download=""><i class="mdi mdi-attachment me-2 font-18"></i> Baixar Anexo</a></p>
                                                            @break
                                                        @endswitch
                                                    @endif
                                                @endforeach
                                            </div>
                                            <div class="col-sm-3">
                                                @foreach ($contactLead->json as $key => $informations)
                                                    @if (isset($informations->type))
                                                        @switch($informations->type)
                                                            @case('checkbox')
                                                                <h5 class="mb-1">{{$key}}</h5>
                                                                <ul>
                                                                    @foreach ($informations->value as $item)
                                                                        <li><p class="mb-0">{{$item}}</p></li>
                                                                    @endforeach
                                                                </ul>
                                                            @break
                                                        @endswitch
                                                    @endif
                                                @endforeach
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="text-center mt-3 mt-sm-0">
                                                    <small><b>Lead vindo de</b></small><br>
                                                    <div class="badge mt-2 font-14 bg-soft-info text-dark p-1">{{$contactLead->json->target_lead}}</div>
                                                </div>
                                            </div>
                                        </div> <!-- end row -->
                                    </div>
                                </div> <!-- end card-->
                            @endforeach
                        @else
                            <div class="w-100 bg-light d-flex align-items-center justify-content-center p-4 flex-column text-center rounded">
                                <i class="mb-1 mdi mdi-handshake-outline mdi-48px"></i>
                                <h3>Leads</h3>
                                <p>
                                    Veja quais são os clientes que tem interesses no seu site ou que querem receber alguma notificação.<br>
                                    Não perca essas oportunidades.
                                </p>
                            </div>
                        @endif
                    </div> <!-- end col -->
                </div>
                <!-- end row -->

            </div> <!-- container -->

        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesIndex')
@endsection
