<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body">
            <p>Para configurar e-mails de outros provedores recomendamos pesquisar no google: <i>Como configurar SMTP hostgator</i>, por exemplo.</p>
            <div class="accordion custom-accordion mb-4" id="custom-accordion-one">
                <div class="card mb-1">
                    <div class="card-header" id="headingNine">
                        <h5 class="m-0 position-relative">
                            <a class="custom-accordion-title text-reset d-block collapsed" data-bs-toggle="collapse" href="#collapseGamail" aria-expanded="false" aria-controls="collapseNine">
                                <i class="mdi mdi-help-circle me-1 text-dark"></i>
                                Configurar conta Gmail
                                <i class="mdi mdi-chevron-down accordion-arrow"></i>
                            </a>
                        </h5>
                    </div>

                    <div id="collapseGamail" class="collapse" aria-labelledby="headingFour" data-bs-parent="#custom-accordion-one">
                        <div class="card-body">
                            <ul>
                                <li><b>Host:</b> smtp.gmail.com</li>
                                <li><b>Usuário:</b> Seu endereço completo do Gmail (ex.: you@gmail.com)</li>
                                <li><b>Senha:</b> Sua senha de app. Não sabe como configurar? clique <a href="https://support.google.com/mail/answer/185833?hl=pt-BR" target="_blank" rel="noopener noreferrer">aqui</a></li>
                                <li><b>Porta</b> 465</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card mb-1">
                    <div class="card-header" id="headingNine">
                        <h5 class="m-0 position-relative">
                            <a class="custom-accordion-title text-reset d-block collapsed" data-bs-toggle="collapse" href="#collapseOutlook" aria-expanded="false" aria-controls="collapseNine">
                                <i class="mdi mdi-help-circle me-1 text-dark"></i>
                                Configurar conta Outlook
                                <i class="mdi mdi-chevron-down accordion-arrow"></i>
                            </a>
                        </h5>
                    </div>

                    <div id="collapseOutlook" class="collapse" aria-labelledby="headingFour" data-bs-parent="#custom-accordion-one">
                        <div class="card-body">
                            <ul>
                                <li><b>Host:</b> smtp.office365.com</li>
                                <li><b>Usuário:</b> Seu endereço completo do outlook (ex.: you@outlook.com)</li>
                                <li><b>Senha:</b> Senha do email</li>
                                <li><b>Porta</b> 587</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

            <a href="{{route('admin.settingSmtp.smtpVerify')}}" id="testSmtp" class="btn btn-warning">Testar Conexão</a>
            <div class="detailsTestSmtp"></div>
        </div> <!-- end card-body-->
    </div> <!-- end card-->
    <div class="col-12 col-lg-6" id="tooltip-container">
        <div class="card card-body">
            <div class="mb-3">
                {!! Form::label(null, 'Host', ['class'=>'form-label']) !!}
                {!! Form::text('host', null, ['class'=>'form-control', 'required'=>'required']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label(null, 'Porta', ['class'=>'form-label']) !!}
                {!! Form::text('port', null, [
                    'class'=>'form-control',
                    'required'=>'required',
                    'data-toggle'=>'input-mask',
                    'data-mask-format'=>'00000',
                ]) !!}
            </div>
            <div class="mb-3">
                {!! Form::label(null, 'E-mail', ['class'=>'form-label']) !!}
                {!! Form::email('user', null, [
                    'autocomplete'=>'off',
                    'class'=>'form-control',
                    'required'=>'required',
                    'parsley-type'=>'email',
                ]) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('heard', 'Selecione a criptografia', ['class'=>'form-label']) !!}
                {!! Form::select('encryption', ['ssl' => 'SSL', 'tls' => 'TLS'], null, [
                    'class'=>'form-select',
                    'id'=>'heard'
                ]) !!}
            </div>
            <div class="mb-3">
                {!! Form::label(null, 'Senha', ['class'=>'form-label']) !!}
                <small class="text-danger ms-2">Sua senha não ficará visível por questões de segurança</small>
                {!! Form::password('password', [
                    'autocomplete'=>'off',
                    'class' =>'form-control',
                ])!!}
            </div>
        </div> <!-- end card-body-->
    </div> <!-- end card-->
</div>
<!-- end row -->
