
<div class="row col-12">
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-3">
                        {!! Form::label('title_box', 'Título Box', ['class'=>'form-label']) !!}
                        {!! Form::text('title_box', null, ['class'=>'form-control', 'id'=>'title_box']) !!}
                    </div>
                    <div class="mb-3">
                        {!! Form::label('description', 'Descrição Box', ['class'=>'form-label']) !!}
                        {!! Form::textarea('description', null, [
                            'class'=>'form-control',
                            'id'=>'description',
                            'data-parsley-trigger'=>'keyup',
                            'data-parsley-minlength'=>'20',
                            'data-parsley-maxlength'=>'200',
                            'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                            'data-parsley-validation-threshold'=>'10',
                        ]) !!}
                    </div>
                    <div class="mb-3 form-check">
                        {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'activeWW']) !!}
                        {!! Form::label('activeWW', 'Ativar exibição', ['class'=>'form-check-label']) !!}
                    </div>
                    <div class="mb-3 form-check">
                        {!! Form::checkbox('featured_menu', '1', null, ['class'=>'form-check-input', 'id'=>'featured_menu']) !!}
                        {!! Form::label('featured_menu', 'Ativar detaque no menu do site', ['class'=>'form-check-label']) !!}
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <div class="container-image-crop">
                            {!! Form::label('inputImage', 'Ícone', ['class'=>'form-label']) !!}
                            <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_image_icon->width}}x{{$cropSetting->path_image_icon->height}}px!</small>
                            <label class="area-input-image-crop" for="inputImage">
                                {!! Form::file('path_image_icon', [
                                    'id'=>'inputImage',
                                    'class'=>'inputImage',
                                    'data-status'=>$cropSetting->path_image_icon->activeCrop, // px
                                    'data-min-width'=>$cropSetting->path_image_icon->width, // px
                                    'data-min-height'=>$cropSetting->path_image_icon->height, // px
                                    'data-box-height'=>'180', // Input height in the form
                                    'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                    'data-default-file'=> isset($workWith)?($workWith->path_image_icon<>''?url('storage/'.$workWith->path_image_icon):''):'',
                                ]) !!}
                            </label>
                        </div><!-- END container image crop -->
                    </div>
                    <div class="mb-3">
                        <div class="container-image-crop">
                            {!! Form::label('inputImage', 'Imagem Thumbnail', ['class'=>'form-label']) !!}
                            <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_image_thumbnail->width}}x{{$cropSetting->path_image_thumbnail->height}}px!</small>
                            <label class="area-input-image-crop" for="inputImage">
                                {!! Form::file('path_image_thumbnail', [
                                    'id'=>'inputImage',
                                    'class'=>'inputImage',
                                    'data-status'=>$cropSetting->path_image_thumbnail->activeCrop, // px
                                    'data-min-width'=>$cropSetting->path_image_thumbnail->width, // px
                                    'data-min-height'=>$cropSetting->path_image_thumbnail->height, // px
                                    'data-box-height'=>'180', // Input height in the form
                                    'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                    'data-default-file'=> isset($workWith)?($workWith->path_image_thumbnail<>''?url('storage/'.$workWith->path_image_thumbnail):''):'',
                                ]) !!}
                            </label>
                        </div><!-- END container image crop -->
                    </div>
                </div>
            </div>
        </div>
        {{-- end card-body --}}
        <div class="card card-body" id="tooltip-container">
            <div class="row">
                <div class="mb-3 col-lg-6">
                    {!! Form::label('titleInner', 'Título Interno', ['class'=>'form-label']) !!}
                    {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'titleInner']) !!}
                </div>
                <div class="mb-3 col-lg-6">
                    {!! Form::label('subtitleInner', 'Subtítulo Interno', ['class'=>'form-label']) !!}
                    {!! Form::text('subtitle', null, ['class'=>'form-control', 'id'=>'subtitleInner']) !!}
                </div>
            </div>
            <div class="basic-editor__content mb-3">
                {!! Form::label('text', 'Texto Interno', ['class'=>'form-label']) !!}
                {!! Form::textarea('text', null, [
                    'class'=>'form-control basic-editor',
                    'id'=>'text',
                ]) !!}
            </div>
        </div>
    </div>
</div>
{{-- end row --}}
