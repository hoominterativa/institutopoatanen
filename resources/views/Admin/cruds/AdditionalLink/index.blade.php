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
                                    <li class="breadcrumb-item active">Links Call to Action</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Links Call to Action</h4>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-8">
                                        @if ($linksHeader > 1 || $linksFooter > 1)
                                            @if ($callToActionTitle)
                                                {!! Form::model($callToActionTitle, ['route' => ['admin.callToActionTitle.update', $callToActionTitle->id], 'class'=>'parsley-validate', 'method'=>'PUT', 'files'=>true]) !!}
                                            @else
                                                {!! Form::model(null, ['route' => 'admin.callToActionTitle.store', 'class'=>'parsley-validate', 'files'=>true]) !!}
                                            @endif
                                                <div class="row" id="tooltip-container">
                                                    @if ($linksHeader > 1)
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <div class="d-flex align-items-center mb-1">
                                                                    {!! Form::label('title_header', 'Título Links do Topo', ['class'=>'form-label']) !!}
                                                                    <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                                                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                                                        data-bs-original-title="Esse título será exibido no botão caso exista mais de um link cadastrado para o topo do site"></i>
                                                                </div>
                                                                {!! Form::text('title_header', null, ['class'=>'form-control', 'id'=>'title_header']) !!}
                                                            </div>
                                                            <div class="mb-3 form-check">
                                                                {!! Form::checkbox('active_header', 1, null, ['class'=>'form-check-input', 'id'=>'active_header']) !!}
                                                                {!! Form::label('active_header', 'Ativar links do Topo', ['class'=>'form-check-label']) !!}
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if ($linksFooter > 1)
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <div class="d-flex align-items-center mb-1">
                                                                    {!! Form::label('title_footer', 'Título Links do rodapé', ['class'=>'form-label']) !!}
                                                                    <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                                                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                                                        data-bs-original-title="Esse título será exibido no botão caso exista mais de um link cadastrado para o rodapé do site"></i>
                                                                </div>
                                                                {!! Form::text('title_footer', null, ['class'=>'form-control', 'id'=>'title_footer']) !!}
                                                            </div>
                                                            <div class="mb-3 form-check">
                                                                {!! Form::checkbox('active_footer', 1, null, ['class'=>'form-check-input', 'id'=>'active_footer']) !!}
                                                                {!! Form::label('active_footer', 'Ativar links do Topo', ['class'=>'form-check-label']) !!}
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="col-3 pt-4">
                                                        {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                                                    </div>
                                                </div>
                                            {!! Form::close() !!}
                                        @endif
                                    </div>
                                    <div class="col-4">
                                        <a href="{{route('admin.additionalLink.create')}}"  data-bs-toggle="modal" data-bs-target="#create-social-modal" class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
                                        <button id="btSubmitDelete" data-route="{{route('admin.additionalLink.destroySelected')}}" type="button" class="btn btn-danger delete-addtional-link float-end me-2" style="display: none;">Deletar selecionados</button>
                                    </div>
                                </div>

                                {{-- MODAL CREATE --}}
                                <div id="create-social-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Cadastrar Link call to Action</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            @include('Admin.cruds.AdditionalLink.form')
                                        </div>
                                    </div>
                                </div>
                                {{-- END MODAL CREATE --}}

                                <table class="table table-bordered table-sortable">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="50px"></th>
                                            <th width="30px" class="bs-checkbox">
                                                <label><input name="btnSelectAll" value="delete-addtional-link" type="checkbox"></label>
                                            </th>
                                            <th>Título</th>
                                            <th>Link</th>
                                            <th></th>
                                            <th>Posição</th>
                                            <th width="100px">Status</th>
                                            <th width="90px">Ações</th>
                                        </tr>
                                    </thead>

                                    <tbody data-route="{{route('admin.additionalLink.sorting')}}">
                                        @foreach ($additionalLinks as $additionalLink)
                                            <tr data-code="{{$additionalLink->id}}">
                                                <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                <td class="bs-checkbox align-middle">
                                                    <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$additionalLink->id}}"></label>
                                                </td>
                                                <td class="align-middle">{{$additionalLink->title}}</td>
                                                <td class="align-middle"><a href="{{getUri($additionalLink->link)}}" target="_blank">{{getUri($additionalLink->link)}}</a></td>
                                                <td class="align-middle">
                                                    @switch($additionalLink->link_target)
                                                        @case('_self')
                                                            <span class="badge bg-primary text-white">Abrir na mesma aba</span>
                                                        @break
                                                        @case('_blank')
                                                            <span class="badge bg-primary text-white">Abrir em nova aba</span>
                                                        @break
                                                    @endswitch
                                                </td>
                                                <td class="align-middle">
                                                    @switch($additionalLink->position)
                                                        @case('header')
                                                            <span class="badge bg-primary text-white">Exibir no Topo do site</span>
                                                        @break
                                                        @case('footer')
                                                            <span class="badge bg-primary text-white">Exibir no rodapé do site</span>
                                                        @break
                                                        @case('both')
                                                            <span class="badge bg-primary text-white">Exibir no Topo e rodapé</span>
                                                        @break
                                                    @endswitch
                                                </td>
                                                <td class="align-middle">
                                                    @switch($additionalLink->active)
                                                        @case(0)
                                                            <span class="badge bg-danger">Inativo</span>
                                                        @break
                                                        @case(1)
                                                            <span class="badge bg-success">Ativo</span>
                                                        @break
                                                    @endswitch
                                                </td>
                                                <td class="align-middle">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <a href="{{route('admin.additionalLink.edit',['AdditionalLink' => $additionalLink->id])}}" data-bs-toggle="modal" data-bs-target="#edit-social-modal-{{$additionalLink->id}}" class="btn-icon mdi mdi-square-edit-outline"></a>
                                                        </div>
                                                        <form action="{{route('admin.additionalLink.destroy',['AdditionalLink' => $additionalLink->id])}}" class="col-4" method="POST">
                                                            @method('DELETE') @csrf
                                                            <button type="button" class="btn-icon btSubmitDeleteItem"><i class="mdi mdi-trash-can"></i></button>
                                                        </form>

                                                        {{-- MODAL EDIT --}}
                                                        <div id="edit-social-modal-{{$additionalLink->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Editar Link call to Action</h4>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    @include('Admin.cruds.AdditionalLink.form',[
                                                                        'additionalLink' => $additionalLink
                                                                    ])
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- END MODAL EDIT --}}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div>
                <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>

    @include('Admin.components.links.resourcesIndex')
@endsection
