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
            <div class="row">
                <div class="col-4 mb-3">
                    {!! Form::label(null, 'Na página', ['class'=>'form-label']) !!}
                    <span class="ms-1 mb-1" data-bs-original-title="Informe em qual página o formulário será implementado." data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"><i class="mdi mdi-help-circle"></i></span>
                    {!! Form::select('page', $pages, null, ['class'=>'form-select selectTypeInput','placeholder' => '-', 'required' => true]) !!}
                </div>
                <div class="col-4 mb-3">
                    {!! Form::label(null, 'Na sessão', ['class'=>'form-label']) !!}
                    <span class="ms-1 mb-1" data-bs-original-title="Informe qual sessão da página será a refência para o formulário ser implementado." data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"><i class="mdi mdi-help-circle"></i></span>
                    {!! Form::select('session', $sessions, null, ['class'=>'form-select selectTypeInput','placeholder' => '-']) !!}
                </div>
                <div class="col-4 mb-3">
                    {!! Form::label(null, 'Na posição', ['class'=>'form-label']) !!}
                    <span class="ms-1 mb-1" data-bs-original-title="Informe qual a posição o formulário será implementado" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"><i class="mdi mdi-help-circle"></i></span>
                    {!! Form::select('position', ['after' => 'Depois da sessão', 'before' => 'Antes da sessão'], null, ['class'=>'form-select selectTypeInput','placeholder' => '-']) !!}
                </div>
            </div>
            <h5 class="mb-3">Modelos de formulários</h5>
            <div id="ModelsFormSelect" class="row">
                @foreach ($modelsForm as $model => $info)
                    <div class="col-12 col-lg-3">
                        <div class="mb-3 position-relative">
                            <a href="{{asset('Admin/assets/images/modelsFrom/'.$info)}}" class="viewModelForm" data-fancybox><i class="mdi mdi-eye font-24"></i></a>
                            {!! Form::radio('model', $model, null, ['id'=>$model, 'class' => 'd-none']) !!}
                            <label for="{{$model}}" style="cursor: pointer;">
                                <img src="{{asset('Admin/assets/images/modelsFrom/'.$info)}}" width="100%">
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="p-3 my-3 border">
                <h4 class="mb-3">Informações <span class="ms-1 mb-1" data-bs-original-title="Informações, de acordo com o modelo, que serão impressas na sessão do formulário" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"><i class="mdi mdi-help-circle"></i></span></h4>
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="mb-3">
                            {!! Form::label('section_title', 'Título', ['class'=>'form-label']) !!}
                            {!! Form::text('section_title', null, ['class'=>'form-control', 'id'=>'section_title']) !!}
                        </div>
                        <div class="mb-3">
                            {!! Form::label('description', 'Descrição', ['class'=>'form-label']) !!}
                            {!! Form::textarea('description', null, [
                                'class'=>'form-control',
                                'id'=>'description',
                                'data-parsley-trigger'=>'keyup',
                                'data-parsley-minlength'=>'20',
                                'data-parsley-maxlength'=>'100',
                                'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                                'data-parsley-validation-threshold'=>'10',
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="mb-3">
                            {!! Form::label('file', 'Imagem', ['class'=>'form-label']) !!}
                            {!! Form::file('path_image', [
                                'data-plugins'=>'dropify',
                                'data-height'=>'300',
                                'data-max-file-size-preview'=>'2M',
                                'accept'=>'image/*',
                                'data-default-file'=> isset($contactForm)?$contactForm->path_image<>''?url('storage/'.$contactForm->path_image):'':'',
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-12">
                        <h5>Redes sociais <span class="ms-1 mb-1" data-bs-original-title="As redes sociais devem ser cadastradas na sessão de Configurações Gerais" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"><i class="mdi mdi-help-circle"></i></span></h5>
                        <p class="mb-3">Selecione as redes sociais que iram aparecer na sessão do formulário</p>
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
            </div>
            <div class="p-3 my-3 border">
                <div class="row container-inputs-contact">
                    <h4 class="mb-3">Campos do Formulário</h4>

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
                                                <input type="text" name="{{str_replace('title', 'option', $key)}}" class="form-control inputSetOption" placeholder="Separar as opções com vírgula" value="{{$value->option}}">
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
