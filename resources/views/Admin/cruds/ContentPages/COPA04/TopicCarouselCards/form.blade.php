<div class="row col-12">
    <div class="col-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3 col-12">
                {!! Form::label('validationCustom01', 'Título', ['class'=>'form-label']) !!}
                {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'validationCustom01', 'placeholder'=>'Título', 'required'=>'required']) !!}
            </div>

            <div class="basic-editor__content mb-3 col-12">
                {!! Form::label('basic-editor', 'Descrição', ['class'=>'form-label']) !!}
                {!! Form::textarea('description', null, [
                    'class'=>'form-control basic-editor',
                    'id'=>'basic-editor',
                ]) !!}
            </div>

            <div class="mb-3 form-check me-3">
                {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                {!! Form::label('active', 'Ativo?', ['class' => 'form-check-label']) !!}
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    <div class="col-6">
        <div class="card card-body">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem', ['class'=>'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->TopicCar->path_image->width}}x{{$cropSetting->TopicCar->path_image->height}}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-status'=>$cropSetting->TopicCar->path_image->activeCrop, // px
                            'data-min-width'=>$cropSetting->TopicCar->path_image->width, // px
                            'data-min-height'=>$cropSetting->TopicCar->path_image->height, // px
                            'data-box-height'=>'225', // Input height in the form
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff',
                            'data-default-file'=> isset($topicCarousselCards)?($topicCarousselCards->path_image<>''?url('storage/'.$topicCarousselCards->path_image):''):'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div>
    </div>
</div>
{{-- end row --}}

