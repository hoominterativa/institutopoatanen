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
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active">
                                        {{ getTitleModel($configModelsMain, 'Feedbacks', 'FEED01') }}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">{{ getTitleModel($configModelsMain, 'Feedbacks', 'FEED01') }}</h4>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <ul class="mb-0 nav nav-tabs" id="tooltip-container">
                    <li class="nav-item">
                        <a href="#feedbacks" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link active d-flex align-items-center">
                            {{ getTitleModel($configModelsMain, 'Feedbacks', 'FEED01') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#section" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Informações para home
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Informações que serão exibidas, caso esteja ativa, na seção que é exibida na Home"></i>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane show active" id="feedbacks">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <button id="btSubmitDelete"
                                                    data-route="{{ route('admin.feed01.destroySelected') }}" type="button"
                                                    class="btn btn-danger btnDeleteFEED01" style="display: none;">Deletar
                                                    selecionados</button>
                                            </div>
                                            <div class="col-6">
                                                <a href="{{ route('admin.feed01.create') }}"
                                                    class="btn btn-success float-end">Adicionar novo <i
                                                        class="mdi mdi-plus"></i></a>
                                            </div>
                                        </div>
                                        <table class="table table-bordered table-sortable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="50px"></th>
                                                    <th width="30px" class="bs-checkbox">
                                                        <label><input name="btnSelectAll" value="btnDeleteFEED01"
                                                                type="checkbox"></label>
                                                    </th>
                                                    <th>Imagem</th>
                                                    <th>Nome do usuário</th>
                                                    <th>Cargo</th>
                                                    <th>Depoimento</th>
                                                    <th width="100px">Status</th>
                                                    <th width="90px">Ações</th>
                                                </tr>
                                            </thead>

                                            <tbody data-route="{{ route('admin.feed01.sorting') }}">
                                                @foreach ($feedbacks as $feedback)
                                                    <tr data-code="{{ $feedback->id }}">
                                                        <td class="align-middle"><span
                                                                class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                        <td class="bs-checkbox align-middle">
                                                            <label><input name="btnSelectItem" class="btnSelectItem"
                                                                    type="checkbox" value="{{ $feedback->id }}"></label>
                                                        </td>
                                                        <td class="align-middle avatar-group">
                                                            <div class="avatar-group-item avatar-bg rounded-circle avatar-sm"
                                                                style="background-image: url({{ asset('storage/' . $feedback->path_image) }})">
                                                            </div>
                                                        </td>
                                                        <td class="align-middle">{{ $feedback->name }}</td>
                                                        <td class="align-middle">{{ $feedback->profession }}</td>
                                                        <td class="align-middle">{!! $feedback->testimony !!}</td>
                                                        <td class="align-middle">
                                                            @switch($feedback->active)
                                                                @case(1)
                                                                    <span class="badge bg-success">Ativo</span>
                                                                @break

                                                                @case(0)
                                                                    <span class="badge bg-danger">Inativo</span>
                                                                @break
                                                            @endswitch
                                                        </td>
                                                        <td class="align-middle">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <a href="{{ route('admin.feed01.edit', ['FEED01Feedbacks' => $feedback->id]) }}"
                                                                        class="btn-icon mdi mdi-square-edit-outline"></a>
                                                                </div>
                                                                <form
                                                                    action="{{ route('admin.feed01.destroy', ['FEED01Feedbacks' => $feedback->id]) }}"
                                                                    class="col-4" method="POST">
                                                                    @method('DELETE') @csrf
                                                                    <button type="button"
                                                                        class="btn-icon btSubmitDeleteItem"><i
                                                                            class="mdi mdi-trash-can"></i></button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        {{-- PAGINATION --}}
                                        <div class="mt-3 float-end">
                                            {{ $feedbacks->links() }}
                                        </div>
                                    </div>
                                </div> <!-- end card-->
                            </div> <!-- end col-->
                        </div>
                    </div>
                    <div class="tab-pane" id="section">
                        @if ($section)
                            {!! Form::model($section, [
                                'route' => ['admin.feed01.section.update', $section->id],
                                'class' => 'parsley-validate',
                                'files' => true,
                            ]) !!}
                            @method('PUT')
                        @else
                            {!! Form::model(null, ['route' => 'admin.feed01.section.store', 'class' => 'parsley-validate', 'files' => true]) !!}
                        @endif
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <h3 class="mb-3">Informações da Seção</h3>
                                            <div class="col-12 col-lg-6">
                                                <div class="mb-2">
                                                    {!! Form::label('title', 'Título', ['class' => 'form-label']) !!}
                                                    {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title']) !!}
                                                </div>
                                                <div class="mb-3">
                                                    {!! Form::label('colorpicker-default', 'Cor de fundo', ['class' => 'form-label']) !!}
                                                    {!! Form::text('background_color', null, [
                                                        'class' => 'form-control colorpicker-default',
                                                        'id' => 'colorpicker-default',
                                                    ]) !!}
                                                </div>

                                                <div class="mb-3 form-check me-3">
                                                    {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                                                    {!! Form::label('active', 'Ativar exibição na home?', ['class' => 'form-check-label']) !!}
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <div class="mb-3">
                                                    <div class="container-image-crop">
                                                        {!! Form::label('inputImage', 'Imagem Desktop', ['class' => 'form-label']) !!}
                                                        <small class="ms-2">Dimensões proporcionais mínimas
                                                            {{ $cropSetting->Section->path_image_desktop->width }}x{{ $cropSetting->Section->path_image_desktop->height }}px!</small>
                                                        <label class="area-input-image-crop" for="inputImage">
                                                            {!! Form::file('path_image_desktop', [
                                                                'id' => 'inputImage',
                                                                'class' => 'inputImage',
                                                                'data-status' => $cropSetting->Section->path_image_desktop->activeCrop, // px
                                                                'data-min-width' => $cropSetting->Section->path_image_desktop->width, // px
                                                                'data-min-height' => $cropSetting->Section->path_image_desktop->height, // px
                                                                'data-box-height' => '225', // Input height in the form
                                                                'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                                                'data-default-file' => isset($section)
                                                                    ? ($section->path_image_desktop != ''
                                                                        ? url('storage/' . $section->path_image_desktop)
                                                                        : '')
                                                                    : '',
                                                            ]) !!}
                                                        </label>
                                                    </div><!-- END container image crop -->
                                                </div>
                                                <div class="mb-3">
                                                    <div class="container-image-crop">
                                                        {!! Form::label('inputImage', 'Imagem Mobile', ['class' => 'form-label']) !!}
                                                        <small class="ms-2">Dimensões proporcionais mínimas
                                                            {{ $cropSetting->Section->path_image_mobile->width }}x{{ $cropSetting->Section->path_image_mobile->height }}px!</small>
                                                        <label class="area-input-image-crop" for="inputImage">
                                                            {!! Form::file('path_image_mobile', [
                                                                'id' => 'inputImage',
                                                                'class' => 'inputImage',
                                                                'data-status' => $cropSetting->Section->path_image_mobile->activeCrop, // px
                                                                'data-min-width' => $cropSetting->Section->path_image_mobile->width, // px
                                                                'data-min-height' => $cropSetting->Section->path_image_mobile->height, // px
                                                                'data-box-height' => '225', // Input height in the form
                                                                'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                                                'data-default-file' => isset($section)
                                                                    ? ($section->path_image_mobile != ''
                                                                        ? url('storage/' . $section->path_image_mobile)
                                                                        : '')
                                                                    : '',
                                                            ]) !!}
                                                        </label>
                                                    </div><!-- END container image crop -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
                                            {!! Form::button('Salvar', [
                                                'class' => 'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-0',
                                                'type' => 'submit',
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesIndex')
@endsection
