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
                                        {{ getTitleModel($configModelsMain, 'Topics', 'TOPI102') }}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">{{ getTitleModel($configModelsMain, 'Topics', 'TOPI102') }}</h4>
                        </div>
                    </div>
                </div>
                <!-- end row -->
                <ul class="mb-0 nav nav-tabs" id="tooltip-container">
                    <li class="nav-item">
                        <a href="#topic" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link active d-flex align-items-center">
                            {{ getTitleModel($configModelsMain, 'Topics', 'TOPI102') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#featuredtopic" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Tópicos em destaque
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Estes tópicos serão exibidos na página com a listagem de todos os serviços"></i>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane show active" id="topic">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <button id="btSubmitDelete"
                                                    data-route="{{ route('admin.topi102.destroySelected') }}" type="button"
                                                    class="btn btn-danger btnDeleteSlide" style="display: none;">Deletar
                                                    selecionados</button>
                                            </div>
                                            <div class="col-6">
                                                <a href="{{ route('admin.topi102.create') }}"
                                                    class="btn btn-success float-end">Adicionar novo <i
                                                        class="mdi mdi-plus"></i></a>
                                                <button class="btn btn-warning float-end me-2" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#topicSection"
                                                    aria-expanded="false" aria-controls="collapseExample">
                                                    Informações da Seção
                                                </button>
                                            </div>
                                            <div class="col-12 mt-3">
                                                <div class="collapse bg-light p-3 mb-3" id="topicSection">
                                                    @if ($section)
                                                        {!! Form::model($section, [
                                                            'route' => ['admin.topi102.section.update', $section->id],
                                                            'class' => 'parsley-validate',
                                                            'files' => true,
                                                        ]) !!}
                                                        @method('PUT')
                                                    @else
                                                        {!! Form::model(null, [
                                                            'route' => 'admin.topi102.section.store',
                                                            'class' => 'parsley-validate',
                                                            'files' => true,
                                                        ]) !!}
                                                    @endif
                                                    <div class="row">
                                                        <div class="col-12 col-sm-6">
                                                            <div class="card card-body">
                                                                <div class="mb-2">
                                                                    {!! Form::label('title', 'Título', ['class' => 'form-label']) !!}
                                                                    {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title']) !!}
                                                                </div>
                                                                <div class="mb-2">
                                                                    {!! Form::label('subtitle', 'Subtítulo', ['class' => 'form-label']) !!}
                                                                    {!! Form::text('subtitle', null, ['class' => 'form-control', 'id' => 'subtitle']) !!}
                                                                </div>
                                                                <div class="mb-3 form-check me-3">
                                                                    {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'activeSection']) !!}
                                                                    {!! Form::label('activeSection', 'Ativar exibição na home?', ['class' => 'form-check-label']) !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-6">
                                                            <div class="card card-body">
                                                                <div class="mb-3">
                                                                    <div class="container-image-crop">
                                                                        {!! Form::label('inputImage', 'Imagem de fundo da seção', ['class' => 'form-label']) !!}
                                                                        <small class="ms-2">Dimensões proporcionais
                                                                            mínimas
                                                                            {{ $cropSetting->Section->path_image_desktop->width }}x{{ $cropSetting->Section->path_image_desktop->height }}px!</small>
                                                                        <label class="area-input-image-crop"
                                                                            for="inputImage">
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
                                                                        {!! Form::label('inputImage', 'Imagem mobile de fundo da seção', ['class' => 'form-label']) !!}
                                                                        <small class="ms-2">Dimensões proporcionais
                                                                            mínimas
                                                                            {{ $cropSetting->Section->path_image_mobile->width }}x{{ $cropSetting->Section->path_image_mobile->height }}px!</small>
                                                                        <label class="area-input-image-crop"
                                                                            for="inputImage">
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
                                                    </div>
                                                    <div
                                                        class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
                                                        {!! Form::button('Salvar', [
                                                            'class' => 'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-0',
                                                            'type' => 'submit',
                                                        ]) !!}
                                                    </div>
                                                    {!! Form::close() !!}
                                                </div>
                                            </div> <!-- end col-->
                                        </div>
                                        <table class="table table-bordered table-sortable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="50px"></th>
                                                    <th width="30px" class="bs-checkbox">
                                                        <label><input name="btnSelectAll" value="btnDeleteSlide"
                                                                type="checkbox"></label>
                                                    </th>
                                                    <th>Imagem</th>
                                                    <th>Título</th>
                                                    <th>Texto</th>
                                                    <th width="100px">Status</th>
                                                    <th width="90px">Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody data-route="{{ route('admin.topi102.sorting') }}">
                                                @foreach ($topics as $topic)
                                                    <tr data-code="{{ $topic->id }}">
                                                        <td class="align-middle"><span
                                                                class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                        <td class="bs-checkbox align-middle">
                                                            <label><input name="btnSelectItem" class="btnSelectItem"
                                                                    type="checkbox" value="{{ $topic->id }}"></label>
                                                        </td>
                                                        <td class="align-middle avatar-group">
                                                            <div class="avatar-group-item avatar-bg rounded-circle avatar-sm"
                                                                style="background-image: url({{ asset('storage/' . $topic->path_image_desktop) }})">
                                                            </div>
                                                        </td>
                                                        <td class="align-middle">{{ $topic->title }}</td>
                                                        <td class="align-middle">{{ Str::limit($topic->text, 30) }}</td>
                                                        <td class="align-middle">
                                                            @switch($topic->active)
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
                                                                    <a href="{{ route('admin.topi102.edit', ['TOPI102Topics' => $topic->id]) }}"
                                                                        class="btn-icon mdi mdi-square-edit-outline"></a>
                                                                </div>
                                                                <form
                                                                    action="{{ route('admin.topi102.destroy', ['TOPI102Topics' => $topic->id]) }}"
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
                                            {{ $topics->links() }}
                                        </div>
                                    </div>
                                </div> <!-- end card-->
                            </div> <!-- end col-->
                        </div>
                    </div>
                    <div class="tab-pane show active" id="featuredtopic">
                        @include('Admin.cruds.Topics.TOPI102.FeaturedTopics.index')
                    </div>
                </div>
                <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesIndex')
@endsection
