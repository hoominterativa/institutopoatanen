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
            <h5 class="mb-3">Modelos de formulários <small class="text-warning ms-3">Selecione um modelo abaixo para que a seção de cadastro de conteúdo apareça.</small></h5>
            <div id="ModelsFormSelect" class="mb-4">
                <div class="models-form-carousel">
                    @foreach ($modelsForm as $model => $info)
                        <div class="mb-3 mt-3 position-relative">
                            <a href="{{asset('Admin/assets/images/modelsFrom/'.$info->model)}}" class="viewModelForm" data-fancybox><i class="mdi mdi-eye font-24"></i></a>
                            {!! Form::radio('model', $model, null, ['id' => $model, 'class' => 'd-none getContentModel']) !!}
                            <label for="{{$model}}" style="cursor: pointer;">
                                <img src="{{asset('Admin/assets/images/modelsFrom/'.$info->model)}}" width="100%">
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="alert alert-warning">
                <p class="mb-0">• Caso a sessão não seja informada ou não exista na página o formulário será inserido no fim da página antes do rodapé.</p>
                <p class="mb-0">• Caso na página existe uma estrutura padrão (Ex.: Página de serviço com os box de serviços) o formulário será inserido logo após a mesma.</p>
            </div>
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="p-3 my-3 border">
                        <h5 class="mb-3">Configuração de Posicionamento <br><small class="text-warning">Informe a página onde será exibido o formulário, ou a seção e posição para indicar onde, nessa página, será impresso o formulário.</small></h5>
                        <div class="mb-3">
                            {!! Form::label(null, 'Página', ['class'=>'form-label']) !!}
                            <span class="ms-1 mb-1" data-bs-original-title="Informe em qual página o formulário será implementado." data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"><i class="mdi mdi-help-circle"></i></span>
                            {!! Form::select('page', $pages, null, ['class'=>'form-select selectTypeInput','placeholder' => '-', 'required' => true]) !!}
                        </div>
                        <div class="mb-3">
                            {!! Form::label(null, 'Sessão', ['class'=>'form-label']) !!}
                            <span class="ms-1 mb-1" data-bs-original-title="Informe qual sessão da página será a refência para o formulário ser implementado." data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"><i class="mdi mdi-help-circle"></i></span>
                            {!! Form::select('session', $sessions, null, ['class'=>'form-select selectTypeInput','placeholder' => '-']) !!}
                        </div>
                        <div class="mb-3">
                            {!! Form::label(null, 'Posição', ['class'=>'form-label']) !!}
                            <span class="ms-1 mb-1" data-bs-original-title="Informe qual a posição o formulário será implementado" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"><i class="mdi mdi-help-circle"></i></span>
                            {!! Form::select('position', ['after' => 'Depois da sessão', 'before' => 'Antes da sessão'], null, ['class'=>'form-select selectTypeInput','placeholder' => '-']) !!}
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div id="sectionContentForm">
                        @if (isset($contactForm))
                            @php
                                $code = $contactForm->model;
                            @endphp
                            @include('Admin.cruds.contactForm.formContent',[
                                'model' => $modelsForm->$code,
                                'code' => $code,
                                'content' => $content,
                            ])
                        @endif
                    </div>
                </div>
            </div>
            <div class="p-3 my-3 border">
                <div class="">
                    <h5><i class="mdi mdi-graph-outline"></i> Redes sociais <span class="ms-1 mb-1" data-bs-original-title="As redes sociais devem ser cadastradas na sessão de Redes sociais" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"><i class="mdi mdi-help-circle"></i></span></h5>
                    <p class="mb-3">Selecione as redes sociais que irão aparecer na sessão do formulário</p>
                    <div class="row ps-2">
                        @foreach ($socials as $social)
                            <div class="mb-3 form-check col">
                                <input type="checkbox" name="social_id[]" id="social{{$social->id}}" value="{{$social->id}}" class="form-check-input" {{isset($socialsCheck)?array_search($social->id, $socialsCheck)!==false?'checked':'':''}}>
                                {!! Form::label('social'.$social->id, $social->title, ['class'=>'form-check-label']) !!}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="p-3 my-3 border">
                <div class="row container-inputs-contact">
                    <div class="mb-3 d-flex align-items-center">
                        <div>
                            <h4>Campos do Formulário</h4>
                            <p>Adicione os campos ao formulário, iforme os títulos e Opções para o cliente e veja seu formulário ser contruído do seu jeito. <b>Obs.:</b> A ordenação de exbição no formulário é a mesma que está abaixo.</p>
                            <a href="javascript:void(0)" data-bs-target="#modal-legend-inputs" data-bs-toggle="modal" class="text-info">
                                <i class="mdi mdi-chat"></i>
                                Legenda dos tipos de campo nos formulário
                            </a>
                            {{-- BEGIN MODAL LEGEND INPUTS --}}
                            <div id="modal-legend-inputs" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog" style="max-width: 1100px;">
                                    <div class="modal-content">
                                        <div class="modal-header p-3 pt-2 pb-2">
                                            <h4 class="page-title">Legenda dos tipos de campo nos formulário</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body p-3 pt-0 pb-3">
                                            <ul>
                                                <li><b>Texto comum:</b> Pode ser usado para informações simples como <i>Nome, Sobrenome, Assunto livre etc</i></li>
                                                <li><b>Texto Longo:</b> Usado para informações mais extensas como <i>Mensagem, Observaçoes etc</i></li>
                                                <li><b>E-mail:</b> Usar para E-mail pois existe um validador imbutido no mesmo.</li>
                                                <li><b>Telefone:</b> Usar para telefones pois uma mascara é aplicada automaticamente</li>
                                                <li><b>Celular:</b> Usar para celuar pois uma mascara é aplicada automaticamente</li>
                                                <li><b>Opções:</b> Cria um campo com opções para escolhas e pode ser usado para informações como <i>Assuntos específicos, Setores etc </i>. Separar opções com virgula e sem espaços</li>
                                                <li><b>Opções com email:</b> Funciona igual ao campo de <b>Opções</b>, porém neste poderá incluir um snippet <b>{}</b> com o e-mail destinatário para cada opção. <i>Ex.: Suporte{suporte@exemplo.com.br}, Reclamações{reclamacoes@exemplo.com.br}</i></li>
                                                <li><b>Multiplas escolhas:</b> Cria opçoes para serem marcadas/desmarcadas estilo um checkbox, pode ser usado para informações como <i>Módulos disponíveis, Áreas pretendida etc</i></li>
                                                <li><b>Escolha única (Um ou outro):</b> Cria opçoes para serem marcadas com escolha única e uma vez marcada não poderá ser desmarcada, pode ser usado par informações como <i>Sexo, opção de sim e não etc</i></li>
                                                <li><b>Calendário:</b> Cria um campo para inserir datas com um calendário imbutido</li>
                                                <li><b>Arquivos (Anexo):</b> Campo para anexar arquivos.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- END MODAL LEGEND INPUTS --}}
                        </div>
                    </div>

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
                                                'selectEmail' => 'Opções com email',
                                                'checkbox' => 'Multiplas escolhas',
                                                'radio' => 'Escolha única (Um ou outro)',
                                                'date' => 'Calendário',
                                                'file' => 'Arquivos (Anexo)',
                                            ], $value->type, ['class'=>'form-select selectTypeInput','placeholder' => '-']) !!}
                                        </div>
                                        <a href="javascript:void(0)" class="mdi mdi-close-circle-outline font-22 ms-2 text-danger deleteTypeButton"></a>
                                    </div>
                                    <div class="infoInputs">
                                        @if ($value->placeholder)
                                            <div class="mb-3">
                                                <label class="form-label">Titulo</label>
                                                <div class="row">
                                                    <div class="col-9">
                                                        <input type="text" name="{{$key}}" class="form-control inputSetTitle" placeholder="Nome que será exibido para o cliente" value="{{$value->placeholder}}">
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="form-check mt-1">
                                                            <input type="checkbox" name="{{str_replace('column', 'required', $key)}}" class="form-check-input inputSetRequired" id="invalidCheck" value="1" {{isset($value->required)?($value->required?'checked':''):''}}>
                                                            <label for="invalidCheck" class="form-label">Obrigatório?</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($value->option)
                                            <div class="mb-3">
                                                <label class="form-label">Opções</label>
                                                <input type="text" name="{{str_replace('column', 'option', $key)}}" class="form-control inputSetOption" placeholder="Separar as opções com vírgula" value="{{$value->option}}">
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
                                        {!! Form::label(null, 'Tipo do Campo', ['class'=>'form-label']) !!}
                                        {!! Form::select('', [
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
                                        ], null, ['class'=>'form-select selectTypeInput','placeholder' => '-']) !!}
                                    </div>
                                    <a href="javascript:void(0)" class="mdi mdi-close-circle-outline font-22 ms-2 text-danger deleteTypeButton"></a>
                                </div>
                            </div>
                        </div>
                        {{-- END .container-type-input --}}
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
