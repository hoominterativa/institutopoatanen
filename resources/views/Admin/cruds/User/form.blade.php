
<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body">
            <div class="mb-3">
                {!! Form::label(null, 'Nome', ['class'=>'form-label']) !!}
                {!! Form::text('name', null, ['class'=>'form-control', 'id'=>'validationCustom01', 'required'=>'required']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label(null, 'E-mail', ['class'=>'form-label']) !!}
                {!! Form::email('email', null, [
                    'class'=>'form-control',
                    'required'=>'required',
                    'parsley-type'=>'email',
                ]) !!}
            </div>
            <div class="mb-3">
                {!! Form::label(null, 'Senha', ['class'=>'form-label']) !!}
                {!! Form::password('password', [
                        'class'=>'form-control',
                        'id'=>'pass2',
                    ])!!}
                {!! Form::password('password_confirmation', [
                        'class'=>'form-control mt-3',
                        'data-parsley-equalto'=>"#pass2",
                        'placeholder'=>'Confirmar senha',
                    ])!!}
            </div>
            <div class="mb-3 form-check">
                {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'active', 'required'=>'required']) !!}
                {!! Form::label('active', 'Ativar usuário?', ['class'=>'form-check-label']) !!}
            </div>
        </div> <!-- end card-body-->
    </div> <!-- end card-->
    <div class="col-12 col-lg-6">
        <div class="card card-body">
            <div class="mb-3">
                <div class="mb-3">
                    <div class="container-image-crop">
                        {!! Form::label('inputImage', 'Imagem', ['class'=>'form-label']) !!}
                        <small class="ms-2">Dimensões proporcionais mínimas 200x200px!</small>
                        <label class="area-input-image-crop" for="inputImage">
                            {!! Form::file('path_image', [
                                'id'=>'inputImage',
                                'class'=>'inputImage',
                                'data-status'=>'false', // px
                                'data-min-width'=>'200', // px
                                'data-min-height'=>'200', // px
                                'data-box-height'=>'225', // Input height in the form
                                'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                'data-default-file'=> isset($user)?($user->path_image<>''?url('storage/'.$user->path_image):''):'',
                            ]) !!}
                        </label>
                    </div><!-- END container image crop -->
                </div>
            </div>
        </div> <!-- end card-body-->
    </div> <!-- end card-->
</div>
<!-- end row -->
