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
                                    <li class="breadcrumb-item"><a href="{{route('admin.port01.index')}}">{{$configModelsMain->Portfolios->PORT01->config->titlePanel}}</a></li>
                                    <li class="breadcrumb-item active">Editar {{$configModelsMain->Portfolios->PORT01->config->titlePanel}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Editar {{$configModelsMain->Portfolios->PORT01->config->titlePanel}}</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                {!! Form::model($portfolio, ['route' => ['admin.port01.update', $portfolio->id], 'class'=>'parsley-validate', 'method'=>'PUT', 'files'=>true]) !!}
                    <div class="w-100 d-table mb-3">
                        {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                        <a href="{{route('admin.port01.index')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                        <button type="button" class="btn btn-info text-dark float-end me-2" data-bs-target="#modal-gallery-create" data-bs-toggle="modal">Cadastrar Imagens na galeria <i class="mdi mdi-plus"></i></button>
                    </div>
                    @include('Admin.Cruds.Portfolios.PORT01.form')
                    <div class="w-100 d-table">
                        {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                        <a href="{{route('admin.port01.index')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                    </div>
                {!! Form::close() !!}
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    {{-- BEGIN GALLERY --}}
    <div id="modal-gallery-create" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" style="max-width: 1100px;">
            <div class="modal-content">
                <div class="modal-header p-3 pt-2 pb-2">
                    <h4 class="page-title">Cadastrar Images</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-3 pt-0 pb-3">
                    <button class="btn btn-secondary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#form-create-category" aria-expanded="false" aria-controls="collapseExample">
                        Exibir Formulário
                    </button>
                    <div class="bg-light p-3 mb-3 collapse" id="form-create-category">
                        {!! Form::model(null, ['route' => 'admin.port01.gallery.store', 'class'=>'parsley-validate', 'files' => true]) !!}
                            <input type="hidden" name="portfolio_id" value="{{$portfolio->id}}">
                            <div class="mb-3">
                                <div class="uploadMultipleImage">
                                    <label for="path_image" class="content-message">
                                        {!! Form::file('path_image[]', [ 'id' => 'path_image', 'multiple' => 'multiple', 'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp', 'class' => 'inputGetImage']) !!}
                                        <i class="mdi mdi-cloud-upload-outline mdi-36px"></i>
                                        <h4 class="title">Solte as imagens aqui ou clique para fazer upload.</h4>
                                        <span class="text-muted font-13">Carregar imagens com no máximo <strong>2mb</strong></span>
                                    </label>
                                    <div id="containerMultipleImages" class="mt-3"></div>
                                </div>
                            </div>

                            <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
                                {!! Form::button('Cadastrar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-3', 'type' => 'submit']) !!}
                                {!! Form::button('Fechar', ['class'=>'btn btn-secondary waves-effect waves-light float-end me-0 width-lg align-items-left', 'data-bs-dismiss'=> 'modal', 'type' => 'button']) !!}
                            </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="col-6">
                        <button id="btSubmitDelete" data-route="{{route('admin.port01.gallery.destroySelected')}}" type="button" class="btn btn-danger btnDeleteArchives" style="display: none;">Deletar selecionados</button>
                    </div>
                    <table data-toggle="table" data-page-size="5" data-pagination="false" class="table-bordered table-sortable">
                        <thead class="table-light">
                            <tr>
                                <th></th>
                                <th class="bs-checkbox">
                                    <label><input name="btnSelectAll" value="btnDeleteArchives" type="checkbox"></label>
                                </th>
                                <th class="text-center">Imagem</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>

                        <tbody data-route="{{route('admin.port01.gallery.sorting')}}">
                            @foreach ($galleries as $key => $gallery)
                                <tr data-code="{{$gallery->id}}">
                                    <td><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                    <td class="bs-checkbox">
                                        <label><input data-index="{{$key}}" name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$gallery->id}}"></label>
                                    </td>
                                    <td class="table-user text-center">
                                        @if ($gallery->path_image)
                                            <img src="{{ asset('storage/'.$gallery->path_image) }}" name="path_image" alt="table-user" class="me-2 rounded-circle">
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <form action="{{route('admin.port01.gallery.destroy',['PORT01PortfoliosGallery' => $gallery->id])}}" method="POST">
                                                @method('DELETE') @csrf
                                                <button type="button" class="btn-icon btSubmitDeleteItem"><i class="mdi mdi-trash-can"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- END GALLERY --}}

    @include('Admin.components.links.resourcesCreateEdit')
@endsection
