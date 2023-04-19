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
                                    <li class="breadcrumb-item active">{{getTitleModel($configModelsMain, 'ContentPages', 'COPA02')}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">{{getTitleModel($configModelsMain, 'ContentPages', 'COPA02')}}</h4>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <ul class="mb-0 nav nav-tabs" id="tooltip-container">
                    <li class="nav-item">
                        <a href="#contents" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link active d-flex align-items-center">
                            {{ getTitleModel($configModelsMain, 'ContentPages', 'COPA02') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#sections" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Cadastrar Seção
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Esta seção será exibida abaixo do conteúdo principal na página"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#topics" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Cadastrar Tópicos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#lastSections" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Cadastrar Seção adicional
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Esta seção será exibida abaixo dos tópicos"></i>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane show active" id="contents">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <button id="btSubmitDelete" data-route="{{route('admin.copa02.destroySelected')}}" type="button" class="btn btn-danger btnDeleteCOPA02" style="display: none;">Deletar selecionados</button>
                                            </div>
                                            <div class="col-6">
                                                <a href="{{route('admin.copa02.create')}}" class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
                                                <button class="btn btn-warning float-end me-2" type="button" data-bs-toggle="collapse" data-bs-target="#sectionContent" aria-expanded="false" aria-controls="collapseExample"> Informações adicionais </button>
                                            </div>
                                            <div class="col-12 mt-3">
                                                <div class="collapse bg-light p-3 mb-3" id="sectionContent">
                                                    @if ($sectionContent)
                                                        {!! Form::model($sectionContent, [
                                                            'route' => ['admin.copa02.section.content.update', $sectionContent->id],
                                                            'class' => 'parsley-validate',
                                                            'files' => true,
                                                        ]) !!}
                                                        @method('PUT')
                                                    @else
                                                        {!! Form::model(null, [
                                                            'route' => 'admin.copa02.section.content.store',
                                                            'class' => 'parsley-validate',
                                                            'files' => true,
                                                        ]) !!}
                                                    @endif
                                                    <div class="row col-12">
                                                        <div class="col-12 col-lg-6">
                                                                <div class="card card-body" id="tooltip-container">
                                                                    <div class="mb-2">
                                                                        {!! Form::label('title', 'Título da seção', ['class' => 'form-label']) !!}
                                                                        {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title']) !!}
                                                                    </div>
                                                                    <div class="mb-2">
                                                                        {!! Form::label('subtitle', 'Subtítulo da seção', ['class' => 'form-label']) !!}
                                                                        {!! Form::text('subtitle', null, ['class' => 'form-control', 'id' => 'subtitle']) !!}
                                                                    </div>
                                                                    <div class="mb-3 form-check">
                                                                        {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                                                                        {!! Form::label('active', 'Ativar exibição', ['class' => 'form-check-label']) !!}
                                                                    </div>
                                                                </div>
                                                        </div>
                                                        <div class="col-12 col-lg-6">
                                                            <div class="card card-body" id="tooltip-container">
                                                                <div class="mb-3">
                                                                    <div class="container-image-crop">
                                                                        {!! Form::label('inputImage', 'Background Desktop', ['class' => 'form-label']) !!}
                                                                        <small class="ms-2">Dimensões proporcionais mínimas
                                                                            {{ $cropSetting->SectionContent->path_image_desktop->width }}x{{ $cropSetting->SectionContent->path_image_desktop->height }}px!</small>
                                                                        <label class="area-input-image-crop" for="inputImage">
                                                                            {!! Form::file('path_image_desktop', [
                                                                                'id' => 'inputImage',
                                                                                'class' => 'inputImage',
                                                                                'data-status' => $cropSetting->SectionContent->path_image_desktop->activeCrop, // px
                                                                                'data-min-width' => $cropSetting->SectionContent->path_image_desktop->width, // px
                                                                                'data-min-height' => $cropSetting->SectionContent->path_image_desktop->height, // px
                                                                                'data-box-height' => '170', // Input height in the form
                                                                                'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                                                                'data-default-file' => isset($sectionContent)
                                                                                    ? ($sectionContent->path_image_desktop != ''
                                                                                        ? url('storage/' . $sectionContent->path_image_desktop)
                                                                                        : '')
                                                                                    : '',
                                                                            ]) !!}
                                                                        </label>
                                                                    </div><!-- END container image crop -->
                                                                </div>
                                                                <div class="mb-3">
                                                                    <div class="container-image-crop">
                                                                        {!! Form::label('inputImage', 'Background Mobile', ['class' => 'form-label']) !!}
                                                                        <small class="ms-2">Dimensões proporcionais mínimas
                                                                            {{ $cropSetting->SectionContent->path_image_mobile->width }}x{{ $cropSetting->SectionContent->path_image_mobile->height }}px!</small>
                                                                        <label class="area-input-image-crop" for="inputImage">
                                                                            {!! Form::file('path_image_mobile', [
                                                                                'id' => 'inputImage',
                                                                                'class' => 'inputImage',
                                                                                'data-status' => $cropSetting->SectionContent->path_image_mobile->activeCrop, // px
                                                                                'data-min-width' => $cropSetting->SectionContent->path_image_mobile->width, // px
                                                                                'data-min-height' => $cropSetting->SectionContent->path_image_mobile->height, // px
                                                                                'data-box-height' => '170', // Input height in the form
                                                                                'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                                                                'data-default-file' => isset($sectionContent)
                                                                                    ? ($sectionContent->path_image_mobile != ''
                                                                                        ? url('storage/' . $sectionContent->path_image_mobile)
                                                                                        : '')
                                                                                    : '',
                                                                            ]) !!}
                                                                        </label>
                                                                    </div><!-- END container image crop -->
                                                                </div>
                                                                <div class="mb-3 border px-2 py-3">
                                                                    {!! Form::label('background_color', 'Cor do background', ['class' => 'form-label']) !!}
                                                                    {!! Form::text('background_color', null, [
                                                                        'class' => 'form-control colorpicker-default',
                                                                        'id' => 'background_color',
                                                                    ]) !!}
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
                                                        <label><input name="btnSelectAll" value="btnDeleteCOPA02" type="checkbox"></label>
                                                    </th>
                                                    <th>Imagem</th>
                                                    <th>Título/Subtítulo</th>
                                                    <th>Descrição</th>
                                                    <th>Título do botão</th>
                                                    <th>Link do botão</th>
                                                    <th width="100px">Status</th>
                                                    <th width="90px">Ações</th>
                                                </tr>
                                            </thead>

                                            <tbody data-route="{{route('admin.copa02.sorting')}}">
                                                @foreach ($contents as $content)
                                                    <tr data-code="{{$content->id}}">
                                                        <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                        <td class="bs-checkbox align-middle">
                                                            <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$content->id}}"></label>
                                                        </td>
                                                        <td class="align-middle avatar-group">
                                                            @if ($content->path_image_icon)
                                                                <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/' . $content->path_image_icon)}})"></div>
                                                            @endif
                                                            @if ($content->path_image_desktop)
                                                                <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/' . $content->path_image_desktop)}})"></div>
                                                            @endif
                                                            @if ($content->path_image_mobile)
                                                                <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/' . $content->path_image_mobile)}})"></div>
                                                            @endif
                                                        </td>
                                                        <td class="align-middle">{{$content->title}} <b>/</b> {{$content->subtitle}}</td>
                                                        <td class="align-middle">{!! substr($content->description,0,50) !!}</td>
                                                        <td class="align-middle">{{$content->title_button}}</td>
                                                        <td class="align-middle"><a href="{{ $content->link_button }}" target="_blank" class="mdi mdi-link-box-variant mdi-24px"></a></td>
                                                        <td class="align-middle">
                                                            @if ($content->active)
                                                                <span class="badge bg-success">Ativo</span>
                                                            @else
                                                                <span class="badge bg-danger">Inativo</span>
                                                            @endif
                                                        </td>
                                                        <td class="align-middle">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <a href="{{route('admin.copa02.edit',['COPA02ContentPages' => $content->id])}}" class="btn-icon mdi mdi-square-edit-outline"></a>
                                                                </div>
                                                                <form action="{{route('admin.copa02.destroy',['COPA02ContentPages' => $content->id])}}" class="col-4" method="POST">
                                                                    @method('DELETE') @csrf
                                                                    <button type="button" class="btn-icon btSubmitDeleteItem"><i class="mdi mdi-trash-can"></i></button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        {{-- PAGINATION --}}
                                        <div class="mt-3 float-end">
                                            {{$contents->links()}}
                                        </div>
                                    </div>
                                </div> <!-- end card-->
                            </div> <!-- end col-->
                        </div>
                    </div>
                    <div class="tab-pane show active" id="sections">
                        @include('Admin.cruds.ContentPages.COPA02.Section.index')
                    </div>
                    <div class="tab-pane show active" id="topics">
                        @include('Admin.cruds.ContentPages.COPA02.Topics.index')
                    </div>
                    <div class="tab-pane show active" id="lastSections">
                        @include('Admin.cruds.ContentPages.COPA02.LastSection.index')
                    </div>
                </div>
                <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesIndex')
@endsection
