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
                                    <li class="breadcrumb-item active">Configurações Gerais</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Configurações Gerais</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                {!! Form::model($generalSetting, ['autocomplete' => 'off', 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'route' => ['admin.generalSetting.update', $generalSetting->id], 'class'=>'parsley-validate']) !!}
                    @include('Admin.cruds.generalSetting.form',[
                        'generalSetting' => $generalSetting
                    ])
                    {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                {!! Form::close() !!}

            </div> <!-- container -->
        </div> <!-- content -->
    </div>

    {{-- BEGIN LINKS CTA HEADER --}}
    <div id="modal-links-cta-header-create" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" style="max-width: 1100px;">
            <div class="modal-content">
                <div class="modal-header p-3 pt-2 pb-2">
                    <h4 class="page-title">Cadastrar Links Call to action do Header</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-3 pt-0 pb-3">

                    <button class="btn btn-primary mb-4" data-target="#containerLinksCtaheader" data-clone-element="#taregtCloneLinksHeader" data-plugin="clone">Adicionar Link <i class="mdi mdi-plus"></i></button>

                    {!! Form::model(null, ['route' => ['admin.cta.header', $generalSetting->id], 'class'=>'parsley-validate', 'files' => true]) !!}
                        <div class="mb-4 col-12 col-lg-4">
                            <div class="d-flex align-items-center mb-1">
                                {!! Form::label('title_cta_btn', 'Título Principal', ['class'=>'form-label mb-0']) !!}
                                <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                                    data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-original-title="Usar caso cadastre mais de um link, será exibido como título pricipal do botão dropdown."></i>
                            </div>
                            {!! Form::text('title_cta_btn', $linksCtaHeader->title??null, ['class'=>'form-control', 'id'=>'title_cta_btn', 'required' => true]) !!}
                        </div>
                        <div id="containerLinksCtaheader">
                            @if ($linksCtaHeader)
                                @foreach ($linksCtaHeader as $title => $linkCtaHeader)
                                    @if ($title <> 'title')
                                        <div class="row">
                                            <div class="mb-3 col-12 col-lg-4">
                                                {!! Form::label('title_btn_cta', 'Título Botão', ['class'=>'form-label']) !!}
                                                {!! Form::text('title_btn_cta[]', $title, ['class'=>'form-control', 'id'=>'title_btn_cta', 'required' => true]) !!}
                                            </div>
                                            <div class="mb-3 col-12 col-lg-5">
                                                {!! Form::label('link_btn_cta', 'Link', ['class'=>'form-label']) !!}
                                                {!! Form::text('link_btn_cta[]', $linkCtaHeader[0], ['class'=>'form-control', 'id'=>'link_btn_cta', 'required' => true]) !!}
                                            </div>
                                            <div class="mb-3 col-12 col-lg-2">
                                                {!! Form::label('heard', 'Abrir link', ['class'=>'form-label']) !!}
                                                {!! Form::select('link_target[]', ['_self' => 'na mesma aba', '_blank' => 'em outra aba', '_lightbox' => 'no lightbox'], $linkCtaHeader[1], [
                                                    'class'=>'form-select',
                                                    'id'=>'heard',
                                                    'required'=> true,
                                                    'placeholder' => '--'
                                                ]) !!}
                                            </div>
                                            <div class="mb-3 col-12 col-lg-1 mt-3">
                                                <a href="javascript:void(0)" data-delete-clone class="mdi mdi-trash-can mdi-24px text-danger d-table"></a>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>

                        <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
                            {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-3', 'type' => 'submit']) !!}
                            {!! Form::button('Fechar', ['class'=>'btn btn-secondary waves-effect waves-light float-end me-0 width-lg align-items-left', 'data-bs-dismiss'=> 'modal', 'type' => 'button']) !!}
                        </div>
                    {!! Form::close() !!}

                    <div id="taregtCloneLinksHeader" class="d-none">
                        <div class="row">
                            <div class="mb-3 col-12 col-lg-4">
                                {!! Form::label('title_btn_cta', 'Título Botão', ['class'=>'form-label']) !!}
                                {!! Form::text('title_btn_cta[]', null, ['class'=>'form-control', 'id'=>'title_btn_cta', 'required' => true]) !!}
                            </div>
                            <div class="mb-3 col-12 col-lg-5">
                                {!! Form::label('link_btn_cta', 'Link', ['class'=>'form-label']) !!}
                                {!! Form::text('link_btn_cta[]', null, ['class'=>'form-control', 'id'=>'link_btn_cta', 'required' => true]) !!}
                            </div>
                            <div class="mb-3 col-12 col-lg-2">
                                {!! Form::label('heard', 'Abrir link', ['class'=>'form-label']) !!}
                                {!! Form::select('link_target[]', ['_self' => 'na mesma aba', '_blank' => 'em outra aba', '_lightbox' => 'no lightbox'], null, [
                                    'class'=>'form-select',
                                    'id'=>'heard',
                                    'required'=> true,
                                    'placeholder' => '--'
                                ]) !!}
                            </div>
                            <div class="mb-3 col-12 col-lg-1 mt-3">
                                <a href="javascript:void(0)" data-delete-clone class="mdi mdi-trash-can mdi-24px text-danger d-table"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- END LINKS CTA HEADER --}}

    {{-- BEGIN LINKS CTA FOOTER --}}
    <div id="modal-links-cta-footer-create" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" style="max-width: 1100px;">
            <div class="modal-content">
                <div class="modal-header p-3 pt-2 pb-2">
                    <h4 class="page-title">Cadastrar Links Call to action do Footer</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-3 pt-0 pb-3" id="tooltip-container">

                    <button class="btn btn-info mb-4" data-target="#containerLinksCtaFooter" data-clone-element="#taregtCloneLinksFooter" data-plugin="clone">Adicionar Link <i class="mdi mdi-plus"></i></button>

                    {!! Form::model(null, ['route' => ['admin.cta.footer', $generalSetting->id], 'class'=>'parsley-validate', 'files' => true]) !!}
                        <div class="mb-4 col-12 col-lg-4">
                            <div class="d-flex align-items-center mb-1">
                                {!! Form::label('title_cta_btn', 'Título Principal', ['class'=>'form-label mb-0']) !!}
                                <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                                    data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-original-title="Usar caso cadastre mais de um link, será exibido como título pricipal do botão dropdown."></i>
                            </div>
                            {!! Form::text('title_cta_btn', $linksCtaFooter->title??null, ['class'=>'form-control', 'id'=>'title_cta_btn', 'required' => true]) !!}
                        </div>
                        <div id="containerLinksCtaFooter">
                            @if ($linksCtaFooter)
                                @foreach ($linksCtaFooter as $title => $linkCtaFooter)
                                    @if ($title <> 'title')
                                        <div class="row">
                                            <div class="mb-3 col-12 col-lg-4">
                                                {!! Form::label('title_btn_cta', 'Título Botão', ['class'=>'form-label']) !!}
                                                {!! Form::text('title_btn_cta[]', $title, ['class'=>'form-control', 'id'=>'title_btn_cta', 'required' => true]) !!}
                                            </div>
                                            <div class="mb-3 col-12 col-lg-5">
                                                {!! Form::label('link_btn_cta', 'Link', ['class'=>'form-label']) !!}
                                                {!! Form::text('link_btn_cta[]', $linkCtaFooter[0], ['class'=>'form-control', 'id'=>'link_btn_cta', 'required' => true]) !!}
                                            </div>
                                            <div class="mb-3 col-12 col-lg-2">
                                                {!! Form::label('heard', 'Abrir link', ['class'=>'form-label']) !!}
                                                {!! Form::select('link_target[]', ['_self' => 'na mesma aba', '_blank' => 'em outra aba', '_lightbox' => 'no lightbox'], $linkCtaFooter[1], [
                                                    'class'=>'form-select',
                                                    'id'=>'heard',
                                                    'required'=> true,
                                                    'placeholder' => '--'
                                                ]) !!}
                                            </div>
                                            <div class="mb-3 col-12 col-lg-1 mt-3">
                                                <a href="javascript:void(0)" data-delete-clone class="mdi mdi-trash-can mdi-24px text-danger d-table"></a>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>

                        <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
                            {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-3', 'type' => 'submit']) !!}
                            {!! Form::button('Fechar', ['class'=>'btn btn-secondary waves-effect waves-light float-end me-0 width-lg align-items-left', 'data-bs-dismiss'=> 'modal', 'type' => 'button']) !!}
                        </div>
                    {!! Form::close() !!}

                    <div id="taregtCloneLinksFooter" class="d-none">
                        <div class="row">
                            <div class="mb-3 col-12 col-lg-4">
                                {!! Form::label('title_btn_cta', 'Título Botão', ['class'=>'form-label']) !!}
                                {!! Form::text('title_btn_cta[]', null, ['class'=>'form-control', 'id'=>'title_btn_cta', 'required' => true]) !!}
                            </div>
                            <div class="mb-3 col-12 col-lg-5">
                                {!! Form::label('link_btn_cta', 'Link', ['class'=>'form-label']) !!}
                                {!! Form::text('link_btn_cta[]', null, ['class'=>'form-control', 'id'=>'link_btn_cta', 'required' => true]) !!}
                            </div>
                            <div class="mb-3 col-12 col-lg-2">
                                {!! Form::label('heard', 'Abrir link', ['class'=>'form-label']) !!}
                                {!! Form::select('link_target[]', ['_self' => 'na mesma aba', '_blank' => 'em outra aba', '_lightbox' => 'no lightbox'], null, [
                                    'class'=>'form-select',
                                    'id'=>'heard',
                                    'required'=> true,
                                    'placeholder' => '--'
                                ]) !!}
                            </div>
                            <div class="mb-3 col-12 col-lg-1 mt-3">
                                <a href="javascript:void(0)" data-delete-clone class="mdi mdi-trash-can mdi-24px text-danger d-table"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- END LINKS CTA FOOTER --}}

    <style>
        .breakText{
            white-space: nowrap;
            max-width: 38em;
            overflow: hidden;
            text-overflow: ellipsis;
            display: block;
        }
    </style>
    @include('Admin.components.links.resourcesCreateEdit')
@endsection
