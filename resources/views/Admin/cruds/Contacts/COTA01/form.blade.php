<div class="row col-12">
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-1">
                            {!! Form::label('title_page', 'Título da Página', ['class'=>'form-label mb-0']) !!}
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Título que é exibido no menu do site"></i>
                        </div>
                        {!! Form::text('title_page', null, ['class'=>'form-control', 'id'=>'title_page', 'required'=>true]) !!}
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-1">
                            {!! Form::label('title_button_form', 'Nome do botão no formulário', ['class'=>'form-label mb-0']) !!}
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Nome que aparecerá no botão do formulário"></i>
                        </div>
                        {!! Form::text('title_button_form', null, ['class'=>'form-control', 'id'=>'title_button_form', 'required'=>true]) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <h4 class="mb-3">Informações do Formulário</h4>
            <div class="mb-3">
                <div class="d-flex align-items-center mb-1">
                    {!! Form::label('title_form', 'Título', ['class'=>'form-label mb-0']) !!}
                    <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon"
                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="Título que é exibido logo acima do formulário"></i>
                </div>
                {!! Form::text('title_form', null, ['class'=>'form-control', 'id'=>'title_form']) !!}
            </div>
            <div class="mb-3">
                <div class="d-flex align-items-center mb-1">
                    {!! Form::label('description_form', 'Descrição', ['class'=>'form-label mb-0']) !!}
                    <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon"
                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="Informação que é exibido logo acima do formulário"></i>
                </div>
                {!! Form::textarea('description_form', null, [
                    'class'=>'form-control',
                    'id'=>'message',
                    'data-parsley-trigger'=>'keyup',
                    'rows'=>'6',
                    'data-parsley-minlength'=>'20',
                    'data-parsley-maxlength'=>'300',
                    'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold'=>'10',
                ]) !!}
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    {{-- end col-lg-6 --}}

    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <h4 class="mb-3">Informações da Página</h4>
            <div class="mb-3">
                <div class="d-flex align-items-center mb-1">
                    {!! Form::label('title_section', 'Título', ['class'=>'form-label mb-0']) !!}
                    <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon"
                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="Título que é exibido logo abaixo do banner da página"></i>
                </div>
                {!! Form::text('title_section', null, ['class'=>'form-control', 'id'=>'title_section']) !!}
            </div>
            <div class="mb-3">
                <div class="d-flex align-items-center mb-1">
                    {!! Form::label('description_section', 'Descrição', ['class'=>'form-label mb-0']) !!}
                    <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon"
                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="Informação que é exibida logo abaixo do banner da página"></i>
                </div>
                {!! Form::textarea('description_section', null, [
                    'class'=>'form-control',
                    'id'=>'message',
                    'data-parsley-trigger'=>'keyup',
                    'rows'=>'6',
                    'data-parsley-minlength'=>'20',
                    'data-parsley-maxlength'=>'300',
                    'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold'=>'10',
                ]) !!}
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    {{-- end col-lg-6 --}}
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="row">
                <div class="mb-3 col-12 col-lg-6">
                    <div class="d-flex align-items-center mb-1">
                        {!! Form::label('compliance_id', 'Termos do formulário', ['class'=>'form-label mb-0']) !!}
                        <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                            data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-original-title="Escolha qual compliance será exigido de aceite no formulário. Caso não aparecça nenhuma opção abaixo você deverá cadastrar na área de Conpliance."></i>
                    </div>
                    {!! Form::select('compliance_id', $compliances, null, [
                        'class'=>'form-select',
                        'id'=>'compliance_id',
                        'required'=>'required',
                        'placeholder' => '--'
                    ]) !!}
                </div>
                <div class="mb-3 col-12 col-lg-6">
                    <div class="d-flex align-items-center mb-1">
                        {!! Form::label('email_form', 'E-mail para recebimento dos Leads', ['class'=>'form-label mb-0']) !!}
                        <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                            data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-original-title="Insira um email destinatário para o recebimentos dos leads deste formulário"></i>
                    </div>
                    {!! Form::email('email_form', null, [
                        'class'=>'form-control',
                        'required'=>'required',
                        'parsley-type'=>'email',
                    ]) !!}
                </div>
            </div>
            <div class="mb-3 d-flex align-items-center">
                <div>
                    <h4>Campos do Formulário</h4>
                    <p>Adicione os campos ao formulário, iforme os títulos e Opções para o cliente e veja seu formulário ser contruído do seu jeito. <b>Obs.:</b> A ordenação de exbição no formulário é a mesma que está abaixo.</p>
                </div>
            </div>

            <div class="row container-inputs-contact">
                @if (isset($configForm))
                    @foreach ($configForm as $key => $value)
                        <div class="container-type-input col-12 col-lg-6 p-1">
                            <div class="border p-2">
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
                                            <input type="text" name="{{str_replace('column', 'option', $key)}}" class="form-control inputSetOption" placeholder="Separar as opções com vírgula" value="{{$value->option}}">
                                        </div>
                                    @endif
                                </div>
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
            <h4 class="mt-3">
                <a href="javascript:void(0)" class="cloneTypeButton font-18 btn btn-info d-flex align-items-center justify-content-center"
                    data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-original-title="Clique para inserir um novo campo ao formulário">
                    Adicionar novo campo
                    <i class="mdi mdi-plus-circle font-22 ms-1"></i>
                </a>
            </h4>
        </div>
    </div>
</div>
{{-- end row --}}
