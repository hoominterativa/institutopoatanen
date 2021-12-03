<div class="row col-12">
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="d-flex justify-content-start align-items-center">
                    {!! Form::label(null, 'Título', ['class'=>'form-label']) !!}
                    <span class="ms-1 mb-1" data-bs-original-title="O título será usado para as informações da página home do site" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top" ><i class="mdi mdi-help-circle"></i></span>
                </div>
                {!! Form::text('title', null, ['class'=>'form-control', 'required'=>'required']) !!}
            </div>
            <div class="mb-3">
                <div class="d-flex justify-content-start align-items-center">
                    {!! Form::label(null, 'Autor', ['class'=>'form-label']) !!}
                    <span class="ms-1 mb-1" data-bs-original-title="Autor da criação de conteúdo da página home" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"><i class="mdi mdi-help-circle"></i></span>
                </div>
                {!! Form::text('author', null, ['class'=>'form-control', 'required'=>'required']) !!}
            </div>
            <div class="mb-3">
                <div class="d-flex justify-content-start align-items-center">
                    {!! Form::label(null, 'Palavras Chaves', ['class'=>'form-label']) !!}
                    <span class="ms-1 mb-1" data-bs-original-title="Serapar as palavras chaves com vírgula (,)" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"><i class="mdi mdi-help-circle"></i></span>
                </div>
                {!! Form::text('keywords', null, ['class'=>'form-control', 'required'=>'required']) !!}
            </div>
            <div class="mb-3">
                <div class="d-flex justify-content-start align-items-center">
                    {!! Form::label(null, 'Descrição', ['class'=>'form-label']) !!}
                    <span class="ms-1 mb-1" data-bs-original-title="A descrição será usada para as informações da página home do site" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"><i class="mdi mdi-help-circle"></i></span>
                </div>
                {!! Form::textarea('description', null, [
                    'class'=>'form-control',
                    'required'=>'required',
                    'data-parsley-trigger'=>'keyup',
                    'data-parsley-minlength'=>'50',
                    'data-parsley-maxlength'=>'190',
                    'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 50 caracteres.',
                    'data-parsley-validation-threshold'=>'10',
                    'rows' => '5'
                ]) !!}
            </div>
            <div class="mb-3">
                <div class="d-flex justify-content-start align-items-center">
                    {!! Form::label(null, 'Scripts Head', ['class'=>'form-label']) !!}
                    <span class="ms-1 mb-1" data-bs-original-title="Inserir os scripts que deverão aparecer na tag <HEAD> do site" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"><i class="mdi mdi-help-circle"></i></span>
                </div>
                {!! Form::textarea('scripts', null, [
                    'class'=>'form-control',
                    'placeholder' => 'Inserir um após o outro',
                    'rows' => '20'
                ]) !!}
            </div>
            <div class="mb-3">
                <div class="d-flex justify-content-start align-items-center">
                    {!! Form::label(null, 'Scripts Body', ['class'=>'form-label']) !!}
                    <span class="ms-1 mb-1" data-bs-original-title="Inserir os scripts que deverão aparecer na tag <BODY></BODY> do site" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"><i class="mdi mdi-help-circle"></i></span>
                </div>
                {!! Form::textarea('other_scripts', null, [
                    'class'=>'form-control',
                    'placeholder' => 'Inserir um após o outro',
                    'rows' => '20'
                ]) !!}
            </div>
        </div> <!-- end card-body-->
    </div> <!-- end card-->
</div>
<!-- end row -->
