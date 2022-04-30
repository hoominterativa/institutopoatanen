<div class="row col-12">
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                {!! Form::label(null, 'E-mail destinatário', ['class'=>'form-label']) !!}
                {!! Form::email('email', null, [
                    'class'=>'form-control',
                    'required'=>true,
                    'parsley-type'=>'email',
                ]) !!}
            </div>
            <div class="alert alert-warning">
                <p class="mb-0">• Caso a sessão não seja informada ou não exista na página o formulário será inserido no fim da página antes do rodapé.</p>
                <p class="mb-0">• Caso na página existe uma estrutura padrão (Ex.: Página de serviço com os box de serviços) o formulário será inserido logo após a mesma.</p>
            </div>
            <div class="mb-3">
                {!! Form::label(null, 'Na página', ['class'=>'form-label']) !!}
                <span class="ms-1 mb-1" data-bs-original-title="Informe em qual página o formulário será implementado." data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"><i class="mdi mdi-help-circle"></i></span>
                {!! Form::select('page', $pages, null, ['class'=>'form-select selectTypeInput','placeholder' => '-', 'required' => true]) !!}
            </div>
            <div class="mb-3">
                {!! Form::label(null, 'Após a Sessão', ['class'=>'form-label']) !!}
                <span class="ms-1 mb-1" data-bs-original-title="Informe após qual sessão da página o formulário será implementado." data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"><i class="mdi mdi-help-circle"></i></span>
                {!! Form::select('after_session', $sessions, null, ['class'=>'form-select selectTypeInput','placeholder' => '-']) !!}
            </div>
            <div class="p-3 my-3 border">
                <div class="row container-inputs-contact">
                    <h4 class="mb-3">
                        Campos do Formulário
                    </h4>

                    @if ($configForm)
                        @foreach ($configForm as $key => $value)
                            <div class="container-type-input col-12 col-lg-6 mb-2 pb-2 border-bottom">
                                <div class="d-flex align-items-center">
                                    <div class="mb-3 w-100">
                                        {!! Form::label(null, 'Tipo do Campo', ['class'=>'form-label']) !!}
                                        {!! Form::select('', [
                                            'text' => 'Texto comum',
                                            'textarea' => 'Texto Longo',
                                            'email' => 'E-mail',
                                            'phone' => 'Telefone',
                                            'cellphone' => 'Celular',
                                            'select' => 'Opções',
                                            'checkbox' => 'Multiplas escolhas',
                                            'radio' => 'Escolha única (Um ou outro)',
                                            'date' => 'Calendário',
                                        ], $value->type, ['class'=>'form-select selectTypeInput','placeholder' => '-']) !!}
                                    </div>
                                    <a href="javascript:void(0)" class="mdi mdi-close-circle-outline font-22 ms-2 text-danger deleteTypeButton"></a>
                                </div>
                                <div class="infoInputs">
                                    @if ($value->placeholder)
                                        <div class="mb-3">
                                            <label class="form-label">Titulo</label>
                                            <input type="text" name="{{$key}}" class="form-control inputSetTitle" placeholder="Nome que será exibido para o cliente" value="{{$value->placeholder}}">
                                        </div>
                                    @endif
                                    @if ($value->option)
                                        <div class="mb-3">
                                            <label class="form-label">Opções</label>
                                            <input type="text" name="{{str_replace('title', 'option', $key)}}" class="form-control inputSetOption" placeholder="Separar as opções com vírgula" value="{{$value->option}}">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="container-type-input col-12 col-lg-6 mb-2 pb-2 border-bottom">
                            <div class="d-flex align-items-center">
                                <div class="mb-3 w-100">
                                    {!! Form::label(null, 'Tipo do Campo', ['class'=>'form-label']) !!}
                                    {!! Form::select('', [
                                        'text' => 'Texto comum',
                                        'textarea' => 'Texto Longo',
                                        'email' => 'E-mail',
                                        'phone' => 'Telefone',
                                        'cellphone' => 'Celular',
                                        'select' => 'Opções',
                                        'checkbox' => 'Multiplas escolhas',
                                        'radio' => 'Escolha única (Um ou outro)',
                                        'date' => 'Calendário',
                                    ], null, ['class'=>'form-select selectTypeInput','placeholder' => '-']) !!}
                                </div>
                                <a href="javascript:void(0)" class="mdi mdi-close-circle-outline font-22 ms-2 text-danger deleteTypeButton"></a>
                            </div>
                        </div>
                    @endif
                </div>
                <h4 class="mb-3">

                    <a href="javascript:void(0)" class="text-success cloneTypeButton"
                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="Clique para inserir um novo campo ao formulário">
                        Adicionar
                        <i class="mdi mdi-plus-circle font-22 ms-1"></i>
                    </a>
                </h4>
            </div>

            <div class="mb-3">
                <div class="d-flex align-items-center mb-2">
                    {!! Form::label('message', 'Estrutura externa', ['class'=>'form-label mb-0']) !!}
                    <i data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="Inserir uma estrutura de formulário externo. Ex.: mailchimp, sendinblue (Opcional)"
                    class="mdi mdi-help-circle font-18 ms-1 btn-icon"></i>
                </div>
                {!! Form::textarea('external_structure', null, [
                    'class'=>'form-control',
                    'id'=>'message',
                ]) !!}
            </div>
        </div> <!-- end card-body-->
    </div> <!-- end card-->
</div>
<!-- end row -->
