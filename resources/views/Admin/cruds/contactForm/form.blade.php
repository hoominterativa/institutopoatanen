<div class="row col-12">
    <div class="card col-12">
        <div class="card-body" id="tooltip-container">
            <div>
                {!! Form::label(null, 'E-mail destinatário', ['class'=>'form-label']) !!}
                {!! Form::email('email', null, [
                    'class'=>'form-control',
                    'required'=>'required',
                    'parsley-type'=>'email',
                ]) !!}
            </div>
            <div class="p-3 my-3 border">
                <h4 class="mb-3">
                    Campos do Formulário
                    <a href="javascript:void(0)" class="mdi mdi-plus-circle font-22 ms-2 text-success cloneTypeButton"
                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="Clique para inserir um novo campo ao formulário"></a>
                </h4>

                <div class="row container-inputs-contact">
                    @if ($configForm)
                        @foreach ($configForm as $key => $value)
                            <div class="container-type-input col-12 col-lg-6 mb-2 pb-2 border-bottom">
                                <div class="d-flex align-items-center">
                                    <div class="mb-3 w-100">
                                        {!! Form::label(null, 'Tipo do Campo', ['class'=>'form-label']) !!}
                                        {!! Form::select('typeInput[]', [
                                            'name' => 'Nome',
                                            'email' => 'E-mail',
                                            'phone' => 'Telefone',
                                            'cellphone' => 'Celular',
                                            'subject' => 'Assunto',
                                            'met_us' => 'Como Conheceu',
                                            'description' => 'Mensagem',
                                        ], $key, ['class'=>'form-select selectTypeInput','placeholder' => '-']) !!}
                                    </div>
                                    <a href="javascript:void(0)" class="mdi mdi-close-circle-outline font-22 ms-2 text-danger deleteTypeButton"></a>
                                </div>
                                <div class="infoInputs">
                                    @if ($value->title)
                                        <div class="mb-3">
                                            <label class="form-label">Titulo</label>
                                            <input type="text" name="title_{{$key}}" class="form-control" placeholder="Nome que será exibido para o cliente" value="{{$value->title}}">
                                        </div>
                                    @endif
                                    @if ($value->option)
                                        <div class="mb-3">
                                            <label class="form-label">Opções</label>
                                            <input type="text" name="option_{{$key}}" class="form-control" placeholder="Separar as opções com vírgula" value="{{$value->option}}">
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
                                    {!! Form::select('typeInput[]', [
                                        'name' => 'Nome',
                                        'email' => 'E-mail',
                                        'phone' => 'Telefone',
                                        'cellphone' => 'Celular',
                                        'subject' => 'Assunto',
                                        'met_us' => 'Como Conheceu',
                                        'description' => 'Mensagem',
                                    ], null, ['class'=>'form-select selectTypeInput','placeholder' => '-']) !!}
                                </div>
                                <a href="javascript:void(0)" class="mdi mdi-close-circle-outline font-22 ms-2 text-danger deleteTypeButton"></a>
                            </div>
                        </div>
                    @endif
                </div>
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
