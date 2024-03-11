<div class="row col-12">
    <div class="col-12">
        {!! Form::hidden('active_form', isset($contact) ? $contact->active_form : null) !!}
        {!! Form::hidden('active_banner', isset($contact) ? $contact->active_banner : null) !!}
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
            <div class="row">
                <div class="mb-3 col-12 col-lg-6">
                    <div class="d-flex align-items-center mb-1">
                        {!! Form::label('compliance_id', 'Termos do formulário', ['class' => 'form-label mb-0']) !!}
                        <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                            data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-original-title="Escolha qual compliance será exigido de aceite no formulário. Caso não aparecça nenhuma opção abaixo você deverá cadastrar na área de Compliance."></i>
                    </div>
                    {!! Form::select('compliance_id', $compliances, null, [
                        'class' => 'form-select',
                        'id' => 'compliance_id',
                        'required' => 'required',
                        'placeholder' => '--',
                    ]) !!}
                </div>
                <div class="mb-3 col-12 col-lg-6">
                    <div class="d-flex align-items-center mb-1">
                        {!! Form::label('email_form', 'E-mail para recebimento dos Leads', ['class' => 'form-label mb-0']) !!}
                        <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                            data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-original-title="Insira um email destinatário para o recebimentos dos leads deste formulário"></i>
                    </div>
                    {!! Form::email('email_form', null, [
                        'class' => 'form-control',
                        'required' => 'required',
                        'parsley-type' => 'email',
                    ]) !!}
                </div>
            </div>
            <div class="mb-3 form-check">
                {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'active']) !!}
                {!! Form::label('active', 'Ativar exbição da página no site?', ['class'=>'form-check-label']) !!}
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3 d-flex align-items-center">
                <div>
                    <h4>Campos do Formulário</h4>
                    <p>Adicione os campos ao formulário, iforme os títulos e Opções para o cliente e veja seu formulário
                        ser contruído do seu jeito. <b>Obs.:</b> A ordenação de exbição no formulário é a mesma que está
                        abaixo.</p>
                    <a href="javascript:void(0)" data-bs-target="#modal-legend-inputs" data-bs-toggle="modal"
                        class="text-info">
                        <i class="mdi mdi-chat"></i>
                        Legenda dos tipos de campo nos formulário
                    </a>
                    {{-- BEGIN MODAL LEGEND INPUTS --}}
                    <div id="modal-legend-inputs" class="modal fade" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog" style="max-width: 1100px;">
                            <div class="modal-content">
                                <div class="modal-header p-3 pt-2 pb-2">
                                    <h4 class="page-title">Legenda dos tipos de campo nos formulário</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body p-3 pt-0 pb-3">
                                    <ul>
                                        <li><b>Texto comum:</b> Pode ser usado para informações simples como <i>Nome,
                                                Sobrenome, Assunto livre etc</i></li>
                                        <li><b>Texto Longo:</b> Usado para informações mais extensas como <i>Mensagem,
                                                Observaçoes etc</i></li>
                                        <li><b>E-mail:</b> Usar para E-mail pois existe um validador imbutido no mesmo.
                                        </li>
                                        <li><b>Telefone:</b> Usar para telefones pois uma mascara é aplicada
                                            automaticamente</li>
                                        <li><b>Celular:</b> Usar para celuar pois uma mascara é aplicada automaticamente
                                        </li>
                                        <li><b>Opções:</b> Cria um campo com opções para escolhas e pode ser usado para
                                            informações como <i>Assuntos específicos, Setores etc </i>. Separar opções
                                            com virgula e sem espaços</li>
                                        <li><b>Opções com email:</b> Funciona igual ao campo de <b>Opções</b>, porém
                                            neste poderá incluir um snippet <b>{}</b> com o e-mail destinatário para
                                            cada opção. <i>Ex.: Suporte{suporte@exemplo.com.br},
                                                Reclamações{reclamacoes@exemplo.com.br}</i></li>
                                        <li><b>Multiplas escolhas:</b> Cria opçoes para serem marcadas/desmarcadas
                                            estilo um checkbox, pode ser usado para informações como <i>Módulos
                                                disponíveis, Áreas pretendida etc</i></li>
                                        <li><b>Escolha única (Um ou outro):</b> Cria opçoes para serem marcadas com
                                            escolha única e uma vez marcada não poderá ser desmarcada, pode ser usado
                                            par informações como <i>Sexo, opção de sim e não etc</i></li>
                                        <li><b>Calendário:</b> Cria um campo para inserir datas com um calendário
                                            imbutido</li>
                                        <li><b>Arquivos (Anexo):</b> Campo para anexar arquivos.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- END MODAL LEGEND INPUTS --}}
                </div>
            </div>
            <div class="row container-inputs-contact">
                @if (isset($configForm))
                    @foreach ($configForm as $key => $value)
                        <div class="container-type-input col-12 col-lg-6 p-1">
                            <div class="border p-2">
                                <div class="d-flex align-items-center">
                                    <div class="mb-3 w-100">
                                        {!! Form::label(null, 'Tipo do Campo', ['class' => 'form-label']) !!}
                                        {!! Form::select(
                                            '',
                                            [
                                                'text' => 'Texto comum',
                                                'textarea' => 'Texto Longo',
                                                'email' => 'E-mail',
                                                'phone' => 'Telefone',
                                                'cellphone' => 'Celular',
                                                'select' => 'Opções',
                                                'selectEmail' => 'Opções com email',
                                                'checkbox' => 'Multiplas escolhas',
                                                'radio' => 'Escolha única (Um ou outro)',
                                                'date' => 'Calendário',
                                                'file' => 'Arquivos (Anexo)',
                                            ],
                                            $value->type,
                                            ['class' => 'form-select selectTypeInput', 'placeholder' => '-'],
                                        ) !!}
                                    </div>
                                    <a href="javascript:void(0)"
                                        class="mdi mdi-close-circle-outline font-22 ms-2 text-danger deleteTypeButton"></a>
                                </div>
                                <div class="infoInputs">
                                    @if ($value->placeholder)
                                        <div class="mb-3">
                                            <label class="form-label">Titulo</label>
                                            <div class="row">
                                                <div class="col-9">
                                                    <input type="text" name="{{ $key }}"
                                                        class="form-control inputSetTitle"
                                                        placeholder="Nome que será exibido para o cliente"
                                                        value="{{ $value->placeholder }}">
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-check mt-1">
                                                        <input type="checkbox"
                                                            name="{{ str_replace('column', 'required', $key) }}"
                                                            class="form-check-input inputSetRequired" id="invalidCheck"
                                                            value="1"
                                                            {{ isset($value->required) ? ($value->required ? 'checked' : '') : '' }}>
                                                        <label for="invalidCheck"
                                                            class="form-label">Obrigatório?</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($value->option)
                                        <div class="mb-3">
                                            <label class="form-label">Opções</label>
                                            <input type="text" name="{{ str_replace('column', 'option', $key) }}"
                                                class="form-control inputSetOption"
                                                placeholder="Separar as opções com vírgula"
                                                value="{{ $value->option }}">
                                        </div>
                                    @endif
                                </div>
                                {{-- END .infoInputs --}}
                            </div>
                        </div>
                        {{-- END .container-type-input --}}
                    @endforeach
                @else
                    <div class="container-type-input col-12 col-lg-6 p-1">
                        <div class="border p-2">
                            <div class="d-flex align-items-center">
                                <div class="mb-3 w-100">
                                    {!! Form::label(null, 'Tipo do Campo', ['class' => 'form-label']) !!}
                                    {!! Form::select(
                                        '',
                                        [
                                            'text' => 'Texto comum',
                                            'textarea' => 'Texto Longo',
                                            'email' => 'E-mail',
                                            'phone' => 'Telefone',
                                            'cellphone' => 'Celular',
                                            'select' => 'Opções',
                                            'selectEmail' => 'Opções com email',
                                            'checkbox' => 'Multiplas escolhas',
                                            'radio' => 'Escolha única (Um ou outro)',
                                            'date' => 'Calendário',
                                            'file' => 'Arquivos (Anexo)',
                                        ],
                                        null,
                                        ['class' => 'form-select selectTypeInput', 'placeholder' => '-'],
                                    ) !!}
                                </div>
                                <a href="javascript:void(0)"
                                    class="mdi mdi-close-circle-outline font-22 ms-2 text-danger deleteTypeButton"></a>
                            </div>
                        </div>
                    </div>
                    {{-- END .container-type-input --}}
                @endif
            </div>
            <h4 class="mt-3">
                <a href="javascript:void(0)"
                    class="cloneTypeButton font-18 btn btn-info d-flex align-items-center justify-content-center"
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
