<div class="row col-12">
    <div class="col-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3 col-12">
                {!! Form::label('validationCustom01', 'Link', ['class'=>'form-label']) !!}
                {!! Form::text('link_video', null, ['class'=>'form-control', 'id'=>'validationCustom01', 'placeholder'=>'Link', 'required'=>'required']) !!}
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
                    <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->AdditionalContent->path_image->width}}x{{$cropSetting->AdditionalContent->path_image->height}}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-status'=>$cropSetting->AdditionalContent->path_image->activeCrop, // px
                            'data-min-width'=>$cropSetting->AdditionalContent->path_image->width, // px
                            'data-min-height'=>$cropSetting->AdditionalContent->path_image->height, // px
                            'data-box-height'=>'225', // Input height in the form
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff',
                            'data-default-file'=> isset($AdditionalContentImages)?($AdditionalContentImages->path_image<>''?url('storage/'.$AdditionalContentImages->path_image):''):'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div>
    </div>
</div>
{{-- end row --}}

