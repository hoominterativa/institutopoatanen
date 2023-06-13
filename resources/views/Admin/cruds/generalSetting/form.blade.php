<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body">
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
                {!! Form::label(null, 'E-mail', ['class'=>'form-label']) !!}
                {!! Form::email('email', null, [
                    'class'=>'form-control',
                    'parsley-type'=>'email',
                    'placeholder'=> 'exemplo@exemplo.com',
                ]) !!}
            </div>
            <div class="mb-3">
                {!! Form::label(null, 'Informações complementares', ['class'=>'form-label']) !!}
                {!! Form::textarea('address', null, [
                    'class'=>'form-control',
                    'id'=>'message',
                ]) !!}
            </div>
        </div> <!-- end card-body-->
    </div> <!-- end card-->
    <div class="col-12 col-lg-6" id="tooltip-container">
        <div class="card card-body">
            <p class="mt-2 mb-3 alert-warning p-2">
                As logos são usadas para o site recomendamos cadastrar todas as versões para que as mesmas não aparceçam quebradas em alguma parte do site.
            </p>
            <div class="mb-3">
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="d-flex align-items-center mb-1">
                            {!! Form::label('file', 'Logo normal Topo ', ['class'=>'form-label mb-0']) !!}
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Logo para ser aplicada em fundos escuros, aparecerá no topo do site"></i>
                        </div>
                        {!! Form::file('path_logo_header_light', [
                            'data-plugins'=>'dropify',
                            'data-height'=>'150',
                            'data-max-file-size-preview'=>'2M',
                            'accept'=>'image/*',
                            'data-default-file'=> $generalSetting->path_logo_header_light?asset('storage/'.$generalSetting->path_logo_header_light):'',
                        ]) !!}
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="d-flex align-items-center mb-1">
                            {!! Form::label('file', 'Logo escura Topo ', ['class'=>'form-label mb-0']) !!}
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Logo para ser aplicada em fundos claros, aparecerá no topo do site"></i>
                        </div>
                        {!! Form::file('path_logo_header_dark', [
                            'data-plugins'=>'dropify',
                            'data-height'=>'150',
                            'data-max-file-size-preview'=>'2M',
                            'accept'=>'image/*',
                            'data-default-file'=> $generalSetting->path_logo_header_dark?asset('storage/'.$generalSetting->path_logo_header_dark):'',
                        ]) !!}
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="d-flex align-items-center mb-1">
                            {!! Form::label('file', 'Logo normal Rodapé', ['class'=>'form-label mb-0']) !!}
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Logo para ser aplicada em fundos escuros, aparecerá no final do site"></i>
                        </div>
                        {!! Form::file('path_logo_footer_light', [
                            'data-plugins'=>'dropify',
                            'data-height'=>'150',
                            'data-max-file-size-preview'=>'2M',
                            'accept'=>'image/*',
                            'data-default-file'=> $generalSetting->path_logo_footer_light?asset('storage/'.$generalSetting->path_logo_footer_light):'',
                        ]) !!}
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="d-flex align-items-center mb-1">
                            {!! Form::label('file', 'Logo escura Rodapé', ['class'=>'form-label mb-0']) !!}
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Logo para ser aplicada em fundos claros, aparecerá no final do site"></i>
                        </div>
                        {!! Form::file('path_logo_footer_dark', [
                            'data-plugins'=>'dropify',
                            'data-height'=>'150',
                            'data-max-file-size-preview'=>'2M',
                            'accept'=>'image/*',
                            'data-default-file'=> $generalSetting->path_logo_footer_dark?asset('storage/'.$generalSetting->path_logo_footer_dark):'',
                        ]) !!}
                    </div>
                </div>
            </div>

            <p class="mt-2 mb-3 alert-info p-2">
                Veja uma prévia de como o link do seu site irá aparecer quando for compartilhado, clicando <a href="https://developers.facebook.com/tools/debug/?q={{url('/home')}}" target="_blank"><b>AQUI</b></a>.
            </p>

            <div class="mb-3">
                <div class="d-flex align-items-center mb-1">
                    {!! Form::label('file', 'Imagem de compartilhamento', ['class'=>'form-label mb-0 me-1']) !!}
                    <small>Tamanho mínimo para a imagem: 250x250 pixel</small>
                    <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="Imagem que aparece quando o link do site é compartilhado"></i>

                </div>
                {!! Form::file('path_logo_share', [
                    'data-plugins'=>'dropify',
                    'data-height'=>'150',
                    'data-max-file-size-preview'=>'2M',
                    'accept'=>'image/*',
                    'data-default-file'=> $generalSetting->path_logo_share?asset('storage/'.$generalSetting->path_logo_share):'',
                ]) !!}
            </div>
            <div class="mb-3">
                <div class="d-flex align-items-center mb-1">
                    {!! Form::label('file', 'Icone de Favoritos (Favicon)', ['class'=>'form-label mb-0 me-1']) !!}
                    <small>Tamanho mínimo para a imagem: 100x100 pixel</small>
                    <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="Icone que aparece na aba do navegador e/ou nos favoritos"></i>
                </div>
                {!! Form::file('path_favicon', [
                    'data-plugins'=>'dropify',
                    'data-height'=>'150',
                    'data-max-file-size-preview'=>'2M',
                    'accept'=>'image/*',
                    'data-default-file'=> $generalSetting->path_favicon?asset('storage/'.$generalSetting->path_favicon):'',
                ]) !!}
            </div>
        </div> <!-- end card-body-->
    </div> <!-- end card-->
</div>
<!-- end row -->
