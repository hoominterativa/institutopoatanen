<div id="appendContent" class="p-3 my-3 border">
    <h4 class="mb-3">Informações <span class="ms-1 mb-1" data-bs-original-title="Informações, de acordo com o modelo, que serão impressas na sessão do formulário" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"><i class="mdi mdi-help-circle"></i></span></h4>
    <div class="row">
        @foreach ($model->config as $name => $config)
            @include('Admin.cruds.contactForm.inputs',[
                'name' => $name,
                'config' => $config,
                'code' => $code,
                'content' => $content??null,
                'cropSetting' => $config->type=='image'?getCropImage('ModelsForm', $code):null
            ])
        @endforeach
    </div>
</div>
