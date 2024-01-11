@if ($about)
    {!! Form::model($about, ['route' => ['admin.abou01.update', $about->id], 'class'=>'parsley-validate', 'method'=>'PUT', 'files'=>true]) !!}
    {!! Form::hidden('active_section', $about->active_section) !!}
    {!! Form::hidden('active_banner', $about->active_banner) !!}
    {!! Form::hidden('active', $about->active) !!}
    {!! Form::hidden('slug', $about->slug) !!}
@else
    {!! Form::model(null, ['route' => 'admin.abou01.store', 'class'=>'parsley-validate', 'files'=>true]) !!}
@endif
<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('title_content', 'Título', ['class'=>'form-label']) !!}
                        {!! Form::text('title_content', null, ['class'=>'form-control', 'id'=>'title_content']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('subtitle_content', 'Subtítulo', ['class'=>'form-label']) !!}
                        {!! Form::text('subtitle_content', null, ['class'=>'form-control', 'id'=>'subtitle_content']) !!}
                    </div>
                </div>
            </div>
            <div class="normal-editor__content mb-3">
                {!! Form::label('normal-editor', 'Texto', ['class'=>'form-label']) !!}
                {!! Form::textarea('text_content', null, [
                    'class'=>'form-control normal-editor',
                    'id'=>'normal-editor',
                ]) !!}
            </div>
            {{-- Color Picker --}}
            <div class="mb-3">
                {!! Form::label('background_color_content', 'Cor do background', ['class' => 'form-label']) !!}
                {!! Form::text('background_color_content', null, [ 'class' => 'form-control colorpicker-default','id' => 'background_color_content',]) !!}
            </div>
            <div class="wrapper-links my-2 border px-2 py-3">
                <ul class="nav nav-pills navtab-bg nav-justified">
                    <li class="nav-item">
                        <a href="#linkPages" data-bs-toggle="tab" aria-expanded="false" class="nav-link py-1">
                            <div class="d-flex align-items-center justify-content-center">
                                Link para página do site
                                <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                                    data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-original-title="Pode ser usado para cadastrar um link de redirecionamento para uma página do site ou conteúdo específico."></i>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#linkExternal" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
                            <div class="d-flex align-items-center justify-content-center">
                                Link para página externa
                                <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                                    data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-original-title="pode ser usado para cadastrar links de redirecionamento para outros sites"></i>
                            </div>
                        </a>
                    </li>
                </ul> {{-- END .nav-tabs --}}
                <div class="tab-content">
                    <div class="tab-pane" id="linkPages">
                        <div class="row">
                            <div class="dropdown mb-3 col-12">
                                {!! Form::label(null, 'Selecione uma página do site', ['class'=>'form-label']) !!}
                                <button class="form-control dropdown-toggle text-start" type="button" id="dropdownPages" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Páginas <i class="mdi mdi-chevron-down float-end"></i>
                                </button>
                                <ul class="dropdown-menu multi-level col-12" aria-labelledby="dropdownPages">
                                    @foreach (listPage() as $page)
                                        <li class="dropdown {{$page->dropdown?'dropdown-submenu':''}}">
                                            <a href="{{$page->route}}" class="dropdown-item" data-bs-toggle="setUrl" data-target-url="#targetUrl" data-bs-toggle="dropdown">{{$page->title}}</a>
                                            @if ($page->dropdown)
                                                <ul class="dropdown-menu">
                                                    @foreach ($page->dropdown as $itens)
                                                        <li><a href="{{$itens->route}}" class="dropdown-item" data-bs-toggle="setUrl" data-target-url="#targetUrl">{{$itens->name}}</a></li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane show active" id="linkExternal"></div>
                </div> {{-- END .tab-content --}}
                <div class="row">
                    <div class="col-12 mb-3">
                        {!! Form::label(null, 'Título Botão', ['class'=>'form-label']) !!}
                        {!! Form::text('title_button_content', null, ['class'=>'form-control', 'id' => 'title_button_content']) !!}
                    </div>
                    <div class="col-12 col-sm-8">
                        {!! Form::label(null, 'Link do botão', ['class' => 'form-label']) !!}
                        {!! Form::url('link_button_content', (isset($about) ? getUri($about->link_button_content) : null), ['class' => 'form-control', 'parsley-type' => 'url', 'id' => 'targetUrl']) !!}
                    </div>
                    <div class="col-12 col-sm-4">
                        {!! Form::label('target_link_button_content', 'Redirecionar para', ['class'=>'form-label']) !!}
                        {!! Form::select('target_link_button_content', ['_self' => 'Na mesma aba', '_blank' => 'Em nova aba'], null, ['class'=>'form-select', 'id'=>'target_link_button_content']) !!}
                    </div>
                </div>
            </div> {{-- END .wrapper-links --}}
        </div>
        {{-- end card-body --}}
        <div class="d-flex">
            <div class="mb-3 form-check me-3">
                {!! Form::checkbox('active_content', '1', null, ['class' => 'form-check-input', 'id' => 'active_content']) !!}
                {!! Form::label('active_content', 'Ativar exibição?', ['class' => 'form-check-label']) !!}
            </div>
        </div>
    </div>
    {{-- end card --}}
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem Flutuante', ['class'=>'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_image_content->width}}x{{$cropSetting->path_image_content->height}}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_content', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-status'=>$cropSetting->path_image_content->activeCrop, // px
                            'data-min-width'=>$cropSetting->path_image_content->width, // px
                            'data-min-height'=>$cropSetting->path_image_content->height, // px
                            'data-box-height'=>'225', // Input height in the form
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($about)?($about->path_image_content<>''?url('storage/'.$about->path_image_content):''):'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Background Desktop', ['class'=>'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_image_content_desktop->width}}x{{$cropSetting->path_image_content_desktop->height}}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_content_desktop', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-status'=>$cropSetting->path_image_content_desktop->activeCrop, // px
                            'data-min-width'=>$cropSetting->path_image_content_desktop->width, // px
                            'data-min-height'=>$cropSetting->path_image_content_desktop->height, // px
                            'data-box-height'=>'225', // Input height in the form
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($about)?($about->path_image_content_desktop<>''?url('storage/'.$about->path_image_content_desktop):''):'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Background Mobile', ['class'=>'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_image_content_mobile->width}}x{{$cropSetting->path_image_content_mobile->height}}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_content_mobile', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-status'=>$cropSetting->path_image_content_mobile->activeCrop, // px
                            'data-min-width'=>$cropSetting->path_image_content_mobile->width, // px
                            'data-min-height'=>$cropSetting->path_image_content_mobile->height, // px
                            'data-box-height'=>'225', // Input height in the form
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($about)?($about->path_image_content_mobile<>''?url('storage/'.$about->path_image_content_mobile):''):'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div>
    </div>
    {{-- end card --}}
</div>
{{-- end row --}}
{!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
<a href="{{route('admin.dashboard')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
{!! Form::close() !!}




