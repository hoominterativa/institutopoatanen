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
                                                        <label for="status-select" class="form-label">Local dos Leads</label>
                                                        <select class="form-select my-1 my-md-0" name="target_lead" id="status-select">
                                                            <option selected="" value="">Todos</option>
                                                            @foreach ($contactLeadsFilter as $contactLeadFilter)
                                                                <option {{isset($request)?($request->target_lead==$contactLeadFilter->target_lead?'selected':''):''}} value="{{$contactLeadFilter->target_lead}}">{{$contactLeadFilter->target_lead}}</option>
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
                        {{-- BEGIN KAMBAN --}}
                        @if (
                            $contactLeadsUpcoming->count() ||
                            $contactLeadsInProcess->count() ||
                            $contactLeadsCompleted->count() ||
                            $contactLeadsLost->count()
                        )
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="header-title">Aguardando</h4>
                                            <p class="sub-header">
                                                Não deixe que essas oportunidades passem em branco.
                                            </p>

                                            <ul class="sortable-list tasklist list-unstyled" id="upcoming">
                                                @foreach ($contactLeadsUpcoming as $contactLeadUpcoming)
                                                    <li id="task1" class="border-0" data-code="{{$contactLeadUpcoming->id}}">
                                                        <span class="badge bg-soft-warning text-warning float-end">{{$contactLeadUpcoming->target_lead}}</span>
                                                        <div>
                                                            @php
                                                                $i=0;
                                                            @endphp
                                                            @foreach ($contactLeadUpcoming->json as $key => $informations)
                                                                @if (isset($informations->type))
                                                                    @if ($informations->type <> 'email' && $informations->type <> 'phone' && $informations->type <> 'cellphone' && $informations->type <> 'checkbox' && $informations->type <> 'file')
                                                                        @if ($i<=3)
                                                                            <p class="mb-1"><b>{{$key}}:</b> {{substr($informations->value,0,55)}}</p>
                                                                        @endif
                                                                        @php
                                                                            $i++;
                                                                        @endphp
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        </>
                                                        <div class="clearfix"></div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <p class="font-13 mt-2 mb-0"><i class="mdi mdi-calendar"></i> {{Carbon\Carbon::parse($contactLeadUpcoming->created_at)->format('d/m/Y H:i')}}</p>
                                                            </div>
                                                            <div class="col-auto">
                                                                <p class="mt-2 mb-0">
                                                                    <a href="javascript: void(0);" data-bs-target="#modal-details-leads-{{$contactLeadUpcoming->id}}" data-bs-toggle="modal" class="font-14"><i class="mdi mdi-eye"></i> Detalhes</a>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        {{-- BEGIN MODAL DETAILS LEAD --}}
                                                        <div id="modal-details-leads-{{$contactLeadUpcoming->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                            <div class="modal-dialog" style="max-width: 1300px;">
                                                                <div class="modal-content">
                                                                    <div class="modal-header p-3 pt-2 pb-2">
                                                                        <h4 class="page-title">Detalhes do Lead</h4>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>

                                                                    <div class="modal-body p-3 pt-0 pb-3">
                                                                        <div class="card mb-2">
                                                                            <div class="card-body">
                                                                                <div class="row align-items-center">
                                                                                    <div class="col-sm-4">
                                                                                        <div class="d-flex align-items-start">
                                                                                            <div class="w-100">
                                                                                                <p class="mb-1 d-flex align-items-center">
                                                                                                    <span class="badge font-14 mb-2 bg-soft-warning text-dark p-1">{{$contactLeadUpcoming->target_lead}}</span>
                                                                                                </p>
                                                                                                <p class="mb-1"><b>Data da Solicitação:</b> {{Carbon\Carbon::parse($contactLeadUpcoming->created_at)->format('d/m/Y H:i')}}</p>
                                                                                                @foreach ($contactLeadUpcoming->json as $key => $informations)
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
                                                                                        @foreach ($contactLeadUpcoming->json as $key => $informations)
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
                                                                                        @foreach ($contactLeadUpcoming->json as $key => $informations)
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
                                                                                            <small><b>Status</b></small><br>
                                                                                            @switch($contactLeadUpcoming->status_process)
                                                                                                @case('upcoming')
                                                                                                    <div class="badge mt-2 font-14 bg-soft-secondary text-dark p-1">Aguardando</div>
                                                                                                @break
                                                                                                @case('in_process')
                                                                                                    <div class="badge mt-2 font-14 bg-soft-warning text-dark p-1">Em processo</div>
                                                                                                @break
                                                                                                @case('completed')
                                                                                                    <div class="badge mt-2 font-14 bg-soft-success text-dark p-1">Completo</div>
                                                                                                @break
                                                                                                @case('lost')
                                                                                                    <div class="badge mt-2 font-14 bg-soft-danger text-dark p-1">Perdido</div>
                                                                                                @break
                                                                                            @endswitch

                                                                                        </div>
                                                                                    </div>
                                                                                </div> <!-- end row -->
                                                                            </div>
                                                                        </div> <!-- end card-->
                                                                    </div>
                                                                    {{-- END BODY MODAL --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- END MODAL ADVANTAGE CREATE --}}
                                                    </li>
                                                @endforeach
                                            </ul>
                                            {{-- <a href="javascript: void(0);" class="btn btn-primary w-100 mt-3 waves-effect waves-light"><i class="mdi mdi-plus-circle"></i> Adicionar Lead</a> --}}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="header-title text-warning">Em processo</h4>
                                            <p class="sub-header">
                                                Disponibilize aquele atendimento que só os seu clientes merecem.
                                            </p>

                                            <ul class="sortable-list tasklist list-unstyled" id="in_process">
                                                @foreach ($contactLeadsInProcess as $contactLeadInProcess)
                                                    <li id="task1" class="border-0" data-code="{{$contactLeadInProcess->id}}">
                                                        <span class="badge bg-soft-warning text-warning float-end">{{$contactLeadInProcess->target_lead}}</span>
                                                        <div>
                                                            @php
                                                                $i=0;
                                                            @endphp
                                                            @foreach ($contactLeadInProcess->json as $key => $informations)
                                                                @if (isset($informations->type))
                                                                    @if ($informations->type <> 'email' && $informations->type <> 'phone' && $informations->type <> 'cellphone' && $informations->type <> 'checkbox' && $informations->type <> 'file')
                                                                        @if ($i<=3)
                                                                            <p class="mb-1"><b>{{$key}}:</b> {{substr($informations->value,0,55)}}</p>
                                                                            @php
                                                                                $i++;
                                                                            @endphp
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        </>
                                                        <div class="clearfix"></div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <p class="font-13 mt-2 mb-0"><i class="mdi mdi-calendar"></i> {{Carbon\Carbon::parse($contactLeadInProcess->created_at)->format('d/m/Y H:i')}}</p>
                                                            </div>
                                                            <div class="col-auto">
                                                                <p class="mt-2 mb-0">
                                                                    <a href="javascript: void(0);" data-bs-target="#modal-details-leads-{{$contactLeadInProcess->id}}" data-bs-toggle="modal" class="font-14"><i class="mdi mdi-eye"></i> Detalhes</a>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        {{-- BEGIN MODAL DETAILS LEAD --}}
                                                        <div id="modal-details-leads-{{$contactLeadInProcess->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                            <div class="modal-dialog" style="max-width: 1300px;">
                                                                <div class="modal-content">
                                                                    <div class="modal-header p-3 pt-2 pb-2">
                                                                        <h4 class="page-title">Detalhes do Lead</h4>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>

                                                                    <div class="modal-body p-3 pt-0 pb-3">
                                                                        <div class="card mb-2">
                                                                            <div class="card-body">
                                                                                <div class="row align-items-center">
                                                                                    <div class="col-sm-4">
                                                                                        <div class="d-flex align-items-start">
                                                                                            <div class="w-100">
                                                                                                <p class="mb-1 d-flex align-items-center">
                                                                                                    <span class="badge font-14 mb-2 bg-soft-warning text-dark p-1">{{$contactLeadInProcess->target_lead}}</span>
                                                                                                </p>
                                                                                                <p class="mb-1"><b>Data da Solicitação:</b> {{Carbon\Carbon::parse($contactLeadInProcess->created_at)->format('d/m/Y H:i')}}</p>
                                                                                                @foreach ($contactLeadInProcess->json as $key => $informations)
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
                                                                                        @foreach ($contactLeadInProcess->json as $key => $informations)
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
                                                                                        @foreach ($contactLeadInProcess->json as $key => $informations)
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
                                                                                            <small><b>Status</b></small><br>
                                                                                            @switch($contactLeadInProcess->status_process)
                                                                                                @case('upcoming')
                                                                                                    <div class="badge mt-2 font-14 bg-soft-secondary text-dark p-1">Aguardando</div>
                                                                                                @break
                                                                                                @case('in_process')
                                                                                                    <div class="badge mt-2 font-14 bg-soft-warning text-dark p-1">Em processo</div>
                                                                                                @break
                                                                                                @case('completed')
                                                                                                    <div class="badge mt-2 font-14 bg-soft-success text-dark p-1">Completo</div>
                                                                                                @break
                                                                                                @case('lost')
                                                                                                    <div class="badge mt-2 font-14 bg-soft-danger text-dark p-1">Perdido</div>
                                                                                                @break
                                                                                            @endswitch

                                                                                        </div>
                                                                                    </div>
                                                                                </div> <!-- end row -->
                                                                            </div>
                                                                        </div> <!-- end card-->
                                                                    </div>
                                                                    {{-- END BODY MODAL --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- END MODAL ADVANTAGE CREATE --}}
                                                    </li>
                                                @endforeach
                                            </ul>
                                            {{-- <a href="javascript: void(0);" class="btn btn-warning w-100 mt-3 waves-effect waves-light"><i class="mdi mdi-plus-circle"></i> Adicionar Lead</a> --}}
                                        </div>
                                    </div> <!-- end card -->
                                </div>

                                <div class="col-lg-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="header-title text-success">Concluido</h4>
                                            <p class="sub-header">
                                                Abaixo estão os leads que foram concluídos ou ganhos, <b>Parabêns</b>
                                            </p>

                                            <ul class="sortable-list tasklist list-unstyled" id="completed">
                                                @foreach ($contactLeadsCompleted as $contactLeadCompleted)
                                                    <li id="task1" class="border-0" data-code="{{$contactLeadCompleted->id}}">
                                                        <span class="badge bg-soft-warning text-warning float-end">{{$contactLeadCompleted->target_lead}}</span>
                                                        <div>
                                                            @php
                                                                $i=0;
                                                            @endphp
                                                            @foreach ($contactLeadCompleted->json as $key => $informations)
                                                                @if (isset($informations->type))
                                                                    @if ($informations->type <> 'email' && $informations->type <> 'phone' && $informations->type <> 'cellphone' && $informations->type <> 'checkbox' && $informations->type <> 'file')
                                                                        @if ($i<=3)
                                                                            <p class="mb-1"><b>{{$key}}:</b> {{substr($informations->value,0,55)}}</p>
                                                                            @php
                                                                                $i++;
                                                                            @endphp
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <p class="font-13 mt-2 mb-0"><i class="mdi mdi-calendar"></i> {{Carbon\Carbon::parse($contactLeadCompleted->created_at)->format('d/m/Y H:i')}}</p>
                                                            </div>
                                                            <div class="col-auto">
                                                                <p class="mt-2 mb-0">
                                                                    <a href="javascript: void(0);" data-bs-target="#modal-details-leads-{{$contactLeadCompleted->id}}" data-bs-toggle="modal" class="font-14"><i class="mdi mdi-eye"></i> Detalhes</a>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        {{-- BEGIN MODAL DETAILS LEAD --}}
                                                        <div id="modal-details-leads-{{$contactLeadCompleted->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                            <div class="modal-dialog" style="max-width: 1300px;">
                                                                <div class="modal-content">
                                                                    <div class="modal-header p-3 pt-2 pb-2">
                                                                        <h4 class="page-title">Detalhes do Lead</h4>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>

                                                                    <div class="modal-body p-3 pt-0 pb-3">
                                                                        <div class="card mb-2">
                                                                            <div class="card-body">
                                                                                <div class="row align-items-center">
                                                                                    <div class="col-sm-4">
                                                                                        <div class="d-flex align-items-start">
                                                                                            <div class="w-100">
                                                                                                <p class="mb-1 d-flex align-items-center">
                                                                                                    <span class="badge font-14 mb-2 bg-soft-warning text-dark p-1">{{$contactLeadCompleted->target_lead}}</span>
                                                                                                </p>
                                                                                                <p class="mb-1"><b>Data da Solicitação:</b> {{Carbon\Carbon::parse($contactLeadCompleted->created_at)->format('d/m/Y H:i')}}</p>
                                                                                                @foreach ($contactLeadCompleted->json as $key => $informations)
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
                                                                                        @foreach ($contactLeadCompleted->json as $key => $informations)
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
                                                                                        @foreach ($contactLeadCompleted->json as $key => $informations)
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
                                                                                            <small><b>Status</b></small><br>
                                                                                            @switch($contactLeadCompleted->status_process)
                                                                                                @case('upcoming')
                                                                                                    <div class="badge mt-2 font-14 bg-soft-secondary text-dark p-1">Aguardando</div>
                                                                                                @break
                                                                                                @case('in_process')
                                                                                                    <div class="badge mt-2 font-14 bg-soft-warning text-dark p-1">Em processo</div>
                                                                                                @break
                                                                                                @case('completed')
                                                                                                    <div class="badge mt-2 font-14 bg-soft-success text-dark p-1">Completo</div>
                                                                                                @break
                                                                                                @case('lost')
                                                                                                    <div class="badge mt-2 font-14 bg-soft-danger text-dark p-1">Perdido</div>
                                                                                                @break
                                                                                            @endswitch

                                                                                        </div>
                                                                                    </div>
                                                                                </div> <!-- end row -->
                                                                            </div>
                                                                        </div> <!-- end card-->
                                                                    </div>
                                                                    {{-- END BODY MODAL --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- END MODAL ADVANTAGE CREATE --}}
                                                    </li>
                                                @endforeach
                                            </ul>
                                            {{-- <a href="javascript: void(0);" class="btn btn-success w-100 mt-3 waves-effect waves-light"><i class="mdi mdi-plus-circle"></i> Adicionar Lead</a> --}}
                                        </div>
                                    </div> <!-- end card -->
                                </div>

                                <div class="col-lg-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="header-title text-danger">Perdidos</h4>
                                            <p class="sub-header">
                                                Não fique triste, você terá outras oportunidades.
                                            </p>

                                            <ul class="sortable-list tasklist list-unstyled" id="lost">
                                                @foreach ($contactLeadsLost as $contactLeadLost)
                                                    <li id="task1" class="border-0" data-code="{{$contactLeadLost->id}}">
                                                        <span class="badge bg-soft-warning text-warning float-end">{{$contactLeadLost->target_lead}}</span>
                                                        <div>
                                                            @php
                                                                $i=0;
                                                            @endphp
                                                            @foreach ($contactLeadLost->json as $key => $informations)
                                                                @if (isset($informations->type))
                                                                    @if ($informations->type <> 'email' && $informations->type <> 'phone' && $informations->type <> 'cellphone' && $informations->type <> 'checkbox' && $informations->type <> 'file')
                                                                        @if ($i<=3)
                                                                            <p class="mb-1"><b>{{$key}}:</b> {{substr($informations->value,0,55)}}</p>
                                                                            @php
                                                                                $i++;
                                                                            @endphp
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <p class="font-13 mt-2 mb-0"><i class="mdi mdi-calendar"></i> {{Carbon\Carbon::parse($contactLeadLost->created_at)->format('d/m/Y H:i')}}</p>
                                                            </div>
                                                            <div class="col-auto">
                                                                <p class="mt-2 mb-0">
                                                                    <a href="javascript: void(0);" data-bs-target="#modal-details-leads-{{$contactLeadLost->id}}" data-bs-toggle="modal" class="font-14"><i class="mdi mdi-eye"></i> Detalhes</a>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        {{-- BEGIN MODAL DETAILS LEAD --}}
                                                        <div id="modal-details-leads-{{$contactLeadLost->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                            <div class="modal-dialog" style="max-width: 1300px;">
                                                                <div class="modal-content">
                                                                    <div class="modal-header p-3 pt-2 pb-2">
                                                                        <h4 class="page-title">Detalhes do Lead</h4>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>

                                                                    <div class="modal-body p-3 pt-0 pb-3">
                                                                        <div class="card mb-2">
                                                                            <div class="card-body">
                                                                                <div class="row align-items-center">
                                                                                    <div class="col-sm-4">
                                                                                        <div class="d-flex align-items-start">
                                                                                            <div class="w-100">
                                                                                                <p class="mb-1 d-flex align-items-center">
                                                                                                    <span class="badge font-14 mb-2 bg-soft-warning text-dark p-1">{{$contactLeadLost->target_lead}}</span>
                                                                                                </p>
                                                                                                <p class="mb-1"><b>Data da Solicitação:</b> {{Carbon\Carbon::parse($contactLeadLost->created_at)->format('d/m/Y H:i')}}</p>
                                                                                                @foreach ($contactLeadLost->json as $key => $informations)
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
                                                                                        @foreach ($contactLeadLost->json as $key => $informations)
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
                                                                                        @foreach ($contactLeadLost->json as $key => $informations)
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
                                                                                            <small><b>Status</b></small><br>
                                                                                            @switch($contactLeadLost->status_process)
                                                                                                @case('upcoming')
                                                                                                    <div class="badge mt-2 font-14 bg-soft-secondary text-dark p-1">Aguardando</div>
                                                                                                @break
                                                                                                @case('in_process')
                                                                                                    <div class="badge mt-2 font-14 bg-soft-warning text-dark p-1">Em processo</div>
                                                                                                @break
                                                                                                @case('completed')
                                                                                                    <div class="badge mt-2 font-14 bg-soft-success text-dark p-1">Completo</div>
                                                                                                @break
                                                                                                @case('lost')
                                                                                                    <div class="badge mt-2 font-14 bg-soft-danger text-dark p-1">Perdido</div>
                                                                                                @break
                                                                                            @endswitch

                                                                                        </div>
                                                                                    </div>
                                                                                </div> <!-- end row -->
                                                                            </div>
                                                                        </div> <!-- end card-->
                                                                    </div>
                                                                    {{-- END BODY MODAL --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- END MODAL ADVANTAGE CREATE --}}
                                                    </li>
                                                @endforeach
                                            </ul>
                                            {{-- <a href="javascript: void(0);" class="btn btn-success w-100 mt-3 waves-effect waves-light"><i class="mdi mdi-plus-circle"></i> Adicionar Lead</a> --}}
                                        </div>
                                    </div> <!-- end card -->
                                </div>
                            </div>
                            {{-- END KAMBAN --}}
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
    @if (request()->get('code'))
        <script>
            setTimeout(() => {
                var offSet =  $("[data-code={{request()->get('code')}}]").offset().top
                $('body, html').animate({
                    scrollTop: (offSet-200)
                }, 'fast', function(){
                    $("[data-code={{request()->get('code')}}]").addClass('animate__pulse')
                    setTimeout(() => {
                        $("[data-code={{request()->get('code')}}]").removeClass('animate__pulse')
                    }, 1000);
                })
            }, 2000);
        </script>
    @endif

    <style>
        .animate__pulse{
            -webkit-animation-name:pulse;
            animation-name:pulse;
            -webkit-animation-timing-function:ease-in-out;
            animation-timing-function:ease-in-out;
            animation-duration: 1s;
        }

        @keyframes pulse{
            0%{-webkit-transform:scaleX(1);transform:scaleX(1)}
            50%{-webkit-transform:scale3d(1.2,1.2,1.2);transform:scale3d(1.2,1.2,1.2)}
            to{-webkit-transform:scaleX(1);transform:scaleX(1)}}
    </style>

    @push('createEditJs')
        <script src="{{url(mix('Admin/assets/libs/Sortable.min.js'))}}"></script>
        <script src="{{url(mix('Admin/assets/js/pages/kanban.init.js'))}}"></script>
    @endpush
@endsection
