
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

        </div> <!-- end card-body-->
    </div> <!-- end card-->
    <div class="col-12 col-lg-6">
        <div class="card card-body">
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
</div>
<!-- end row -->
