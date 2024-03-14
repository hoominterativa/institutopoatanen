<div class="row">
    <div class="col-12 order-xl-1 order-2">
        @if (
            $contactLeadsUpcoming->count()
        )
            <div class="row">
                @foreach ($contactLeadsUpcoming as $contactLeadUpcoming)
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body p-0">
                                <ul class="sortable-list tasklist list-unstyled" id="upcoming">
                                    <li id="task1" class="border-0" data-code="{{$contactLeadUpcoming->id}}">
                                        <span class="badge bg-soft-warning text-warning w-100 mb-2">{{$contactLeadUpcoming->target_lead}}</span>
                                        <div>
                                            @php
                                                $i=0;
                                            @endphp
                                            @if (is_array($contactLeadUpcoming->json) || is_object($contactLeadUpcoming->json))
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
                                            @endif
                                        </div>
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
                                                                        <div class="w-100">
                                                                            <p class="mb-1 d-flex align-items-center">
                                                                                <span class="badge font-14 mb-2 bg-soft-warning text-dark p-1">{{$contactLeadUpcoming->target_lead}}</span>
                                                                            </p>
                                                                            <p class="mb-1"><b>Data da Solicitação:</b> {{Carbon\Carbon::parse($contactLeadUpcoming->created_at)->format('d/m/Y H:i')}}</p>
                                                                            @if (is_array($contactLeadUpcoming->json) || is_object($contactLeadUpcoming->json))
                                                                                @foreach ($contactLeadUpcoming->json as $key => $informations)
                                                                                    @if (isset($informations->type))
                                                                                        @if ($informations->type <> 'email' && $informations->type <> 'phone' && $informations->type <> 'cellphone' && $informations->type <> 'checkbox' && $informations->type <> 'file')
                                                                                            <p class="mb-1"><b>{{$key}}:</b> {{$informations->value}}</p>
                                                                                        @endif
                                                                                    @endif
                                                                                @endforeach
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-3">
                                                                        @if (is_array($contactLeadUpcoming->json) || is_object($contactLeadUpcoming->json))
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
                                                                        @endif
                                                                    </div>
                                                                    <div class="col-sm-3">
                                                                        @if (is_array($contactLeadUpcoming->json) || is_object($contactLeadUpcoming->json))
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
                                                                        @endif
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

                                                        @if ($contactLeadUpcoming->json->additionals ?? null)
                                                            <div class="card mb-2">
                                                                <div class="card-body">
                                                                    <h5 class="text-warning mt-0">Informações Adicionais</h5>
                                                                    <div class="row">
                                                                        @if (is_array($contactLeadUpcoming->json) || is_object($contactLeadUpcoming->json))
                                                                            @foreach ($contactLeadUpcoming->json->additionals as $additional)
                                                                                <div class="col-12 col-md-3">
                                                                                    <div class="bg-light p-2 mb-2" style="border-radius: 5px;">
                                                                                        @foreach ($additional as $key => $value)
                                                                                            <p class="mb-1"><b>{{$key}}:</b> {{$value}}</p>
                                                                                        @endforeach
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        @endif
                                                                    </div>
                                                                    {{-- END .row --}}
                                                                </div>
                                                                {{-- END .card-body --}}
                                                            </div>
                                                            {{-- END .card --}}
                                                        @endif
                                                    </div>
                                                    {{-- END BODY MODAL --}}
                                                </div>
                                            </div>
                                        </div>
                                        {{-- END MODAL ADVANTAGE CREATE --}}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
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

@push('createEditJs')
    <script src="{{url(mix('Admin/assets/libs/Sortable.min.js'))}}"></script>
    <script src="{{url(mix('Admin/assets/js/pages/kanban.init.js'))}}"></script>
@endpush
