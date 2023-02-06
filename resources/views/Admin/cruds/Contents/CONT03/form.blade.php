
<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('subtitle', 'Título', ['class'=>'form-label']) !!}
                {!! Form::text('subtitle', null, ['class'=>'form-control', 'id'=>'subtitle']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('link', 'Link', ['class'=>'form-label']) !!}
                {!! Form::text('link', null, ['class'=>'form-control', 'id'=>'link']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('heard', 'Abrir link', ['class'=>'form-label']) !!}
                {!! Form::select('options', ['_self' => 'Mesma Aba', '_blank' => 'Aba diferente'], null, [
                    'class'=>'form-select',
                    'id'=>'heard',
                ]) !!}
            </div>
            <div class="mb-3 form-check">
                {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'active']) !!}
                {!! Form::label('active', 'Ativar exibição', ['class'=>'form-check-label']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('description', 'Descrição', ['class'=>'form-label']) !!}
                {!! Form::textarea('description', null, [
                    'class'=>'form-control',
                    'id'=>'description',
                    'data-parsley-trigger'=>'keyup',
                    'data-parsley-minlength'=>'20',
                    'data-parsley-maxlength'=>'300',
                    'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold'=>'10',
                ]) !!}
            </div>
        </div>
        {{-- end card-body --}}
    </div>

    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem do Centro', ['class'=>'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_image_center->width}}x{{$cropSetting->path_image_center->height}}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_center', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-status'=>$cropSetting->path_image_center->activeCrop, // px
                            'data-min-width'=>$cropSetting->path_image_center->width, // px
                            'data-min-height'=>$cropSetting->path_image_center->height, // px
                            'data-box-height'=>'170', // Input height in the form
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($content)?($content->path_image_center<>''?url('storage/'.$content->path_image_center):''):'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>

            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem da Esquerda', ['class'=>'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_image_right->width}}x{{$cropSetting->path_image_right->height}}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_right', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-status'=>$cropSetting->path_image_right->activeCrop, // px
                            'data-min-width'=>$cropSetting->path_image_right->width, // px
                            'data-min-height'=>$cropSetting->path_image_right->height, // px
                            'data-box-height'=>'170', // Input height in the form
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($content)?($content->path_image_right<>''?url('storage/'.$content->path_image_right):''):'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>

            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem Background', ['class'=>'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_image_background->width}}x{{$cropSetting->path_image_background->height}}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_background', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-status'=>$cropSetting->path_image_background->activeCrop, // px
                            'data-min-width'=>$cropSetting->path_image_background->width, // px
                            'data-min-height'=>$cropSetting->path_image_background->height, // px
                            'data-box-height'=>'170', // Input height in the form
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($content)?($content->path_image_background<>''?url('storage/'.$content->path_image_background):''):'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    {{-- end card --}}
</div>
{{-- end row --}}
