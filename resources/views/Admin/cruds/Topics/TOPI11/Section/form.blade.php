@if ($section)
    {!! Form::model($section, ['route' => ['admin.topi11.section.update', $section->id], 'class' => 'parsley-validate', 'files' => true,]) !!}
    @method('PUT')
@else
    {!! Form::model(null, ['route' => 'admin.topi11.section.store', 'class' => 'parsley-validate', 'files' => true]) !!}
@endif

<div class="row col-12">
    <div class="col-12 col-md-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                {!! Form::label('title', 'Título da seção', ['class' => 'form-label']) !!}
                {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('subtitle', 'Subtítulo da seção', ['class' => 'form-label']) !!}
                {!! Form::text('subtitle', null, ['class' => 'form-control', 'id' => 'subtitle']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('description', 'Descrição', ['class'=>'form-label']) !!}
                {!! Form::textarea('description', null, [
                    'class'=>'form-control',
                    'id'=>'description',
                    'data-parsley-trigger'=>'keyup',
                    'data-parsley-minlength'=>'20',
                    'data-parsley-maxlength'=>'900',
                    'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold'=>'10',
                ]) !!}
            </div>
            <div class="mb-3 form-check">
                {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                {!! Form::label('active', 'Ativar exibição', ['class' => 'form-check-label']) !!}
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem', ['class'=>'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_image->width}}x{{$cropSetting->path_image->height}}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-status'=>$cropSetting->path_image->activeCrop, // px
                            'data-min-width'=>$cropSetting->path_image->width, // px
                            'data-min-height'=>$cropSetting->path_image->height, // px
                            'data-box-height'=>'225', // Input height in the form
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff',
                            'data-default-file'=> isset($section)?($section->path_image<>''?url('storage/'.$section->path_image):''):'',
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
{!! Form::close() !!}
