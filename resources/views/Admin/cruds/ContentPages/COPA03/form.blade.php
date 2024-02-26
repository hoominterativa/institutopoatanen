<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                {!! Form::label('title_page', 'Título página', ['class'=>'form-label']) !!}
                <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                    data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-original-title="Defina o título da página que será usado para criar a rota.">
                </i>
                {!! Form::text('title_page', null, ['class'=>'form-control', 'id'=>'title_page', 'required'=>'required', 'placeholder' => 'Ex: Página de contato']) !!}
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('title_topic_section', 'Título da seção tópicos', ['class'=>'form-label']) !!}
                        {!! Form::text('title_topic_section', null, ['class'=>'form-control', 'id'=>'title_topic_section']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('subtitle_topic_section', 'Subtítulo da seção tópicos', ['class'=>'form-label']) !!}
                        {!! Form::text('subtitle_topic_section', null, ['class'=>'form-control', 'id'=>'subtitle_topic_section']) !!}
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('title_video_section', 'Título da seção vídeos', ['class'=>'form-label']) !!}
                        {!! Form::text('title_video_section', null, ['class'=>'form-control', 'id'=>'title_video_section']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('subtitle_video_section', 'Subítulo da seção vídeos', ['class'=>'form-label']) !!}
                        {!! Form::text('subtitle_video_section', null, ['class'=>'form-control', 'id'=>'subtitle_video_section']) !!}
                    </div>
                </div>
            </div>
            <div class="mb-3 border px-2 py-3">
                {!! Form::label('background_color_banner', 'Cor do background', ['class' => 'form-label']) !!}
                {!! Form::text('background_color_banner', null, ['class' => 'form-control colorpicker-default','id' => 'background_color_banner',]) !!}
            </div>
        </div>
        <div class="mb-3 form-check">
            {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
            {!! Form::label('active', 'Ativar exibição?', ['class' => 'form-check-label']) !!}
        </div>
        {{-- end card-body --}}
    </div>
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Background Desktop', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->path_image_banner_desktop->width }}x{{ $cropSetting->path_image_banner_desktop->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_banner_desktop', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->path_image_banner_desktop->activeCrop, // px
                            'data-min-width' => $cropSetting->path_image_banner_desktop->width, // px
                            'data-min-height' => $cropSetting->path_image_banner_desktop->height, // px
                            'data-box-height' => '170', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($contentPage)
                                ? ($contentPage->path_image_banner_desktop != ''
                                    ? url('storage/' . $contentPage->path_image_banner_desktop)
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
                        {{ $cropSetting->path_image_banner_mobile->width }}x{{ $cropSetting->path_image_banner_mobile->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_banner_mobile', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->path_image_banner_mobile->activeCrop, // px
                            'data-min-width' => $cropSetting->path_image_banner_mobile->width, // px
                            'data-min-height' => $cropSetting->path_image_banner_mobile->height, // px
                            'data-box-height' => '170', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($contentPage)
                                ? ($contentPage->path_image_banner_mobile != ''
                                    ? url('storage/' . $contentPage->path_image_banner_mobile)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div>
    </div>
</div>
{{-- end row --}}
