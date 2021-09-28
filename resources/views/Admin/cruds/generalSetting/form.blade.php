<div class="row col-12">
    <div class="card col-12 col-lg-6">
        <div class="card-body">
            <h4 class="mb-3">Infomações de Contato</h4>
            <div class="mb-3">
                {!! Form::label(null, 'Telefone', ['class'=>'form-label']) !!}
                {!! Form::text('phone', null, [
                    'class'=>'form-control',
                    'data-toggle'=>'input-mask',
                    'data-mask-format'=>'(00) 0000-0000',
                ]) !!}
            </div>
            <div class="mb-3">
                {!! Form::label(null, 'Celular (Whatsapp)', ['class'=>'form-label']) !!}
                {!! Form::text('whatsapp', null, [
                    'class'=>'form-control',
                    'data-toggle'=>'input-mask',
                    'data-mask-format'=>'(00) 00000-0000',
                ]) !!}
            </div>
            <div class="mb-3">
                {!! Form::label(null, 'Endereço', ['class'=>'form-label']) !!}
                {!! Form::textarea('address', null, [
                    'class'=>'form-control',
                    'id'=>'message',
                ]) !!}
            </div>
        </div> <!-- end card-body-->
    </div> <!-- end card-->
    <div class="card col-12 col-lg-6">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="mb-3">
                        {!! Form::label('file', 'Logo Topo', ['class'=>'form-label']) !!}
                        {!! Form::file('path_logo_header', [
                            'data-plugins'=>'dropify',
                            'data-height'=>'150',
                            'data-max-file-size-preview'=>'2M',
                            'accept'=>'image/*',
                            'data-default-file'=> asset('storage/'.$generalSetting->path_logo_header),
                        ]) !!}
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-3">
                        {!! Form::label('file', 'Logo Rodapé', ['class'=>'form-label']) !!}
                        {!! Form::file('path_logo_footer', [
                            'data-plugins'=>'dropify',
                            'data-height'=>'150',
                            'data-max-file-size-preview'=>'2M',
                            'accept'=>'image/*',
                            'data-default-file'=> asset('storage/'.$generalSetting->path_logo_footer),
                        ]) !!}
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-3">
                        {!! Form::label('file', 'Logo compartilhar', ['class'=>'form-label']) !!}
                        {!! Form::file('path_logo_share', [
                            'data-plugins'=>'dropify',
                            'data-height'=>'150',
                            'data-max-file-size-preview'=>'2M',
                            'accept'=>'image/*',
                            'data-default-file'=> asset('storage/'.$generalSetting->path_logo_share),
                        ]) !!}
                    </div>
                </div>
            </div>
            <h4 class="mb-3 mt-3">SMTP</h4>

            <div class="mb-3">
                {!! Form::label(null, 'Host', ['class'=>'form-label']) !!}
                {!! Form::text('smtp_host', null, ['class'=>'form-control', 'required'=>'required']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label(null, 'Porta', ['class'=>'form-label']) !!}
                {!! Form::text('smtp_port', null, [
                    'class'=>'form-control',
                    'required'=>'required',
                    'data-toggle'=>'input-mask',
                    'data-mask-format'=>'00000',
                ]) !!}
            </div>
            <div class="mb-3">
                {!! Form::label(null, 'E-mail', ['class'=>'form-label']) !!}
                {!! Form::email('smtp_user', null, [
                    'autocomplete'=>'off',
                    'class'=>'form-control',
                    'required'=>'required',
                    'parsley-type'=>'email',
                ]) !!}
            </div>
            <div class="mb-3">
                {!! Form::label(null, 'Senha', ['class'=>'form-label']) !!}
                {!! Form::password('smtp_password', [
                        'autocomplete'=>'false',
                        'class'=>'form-control',
                        'required'=>'required',
                    ])!!}
            </div>
        </div> <!-- end card-body-->
    </div> <!-- end card-->
</div>
<!-- end row -->
