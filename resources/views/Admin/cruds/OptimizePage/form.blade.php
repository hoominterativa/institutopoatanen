<input type="hidden" name="_previous" value="{{url()->previous()}}">
<div class="row col-12">
    <div class="card col-12 col-lg-6">
        <div class="card-body" id="tooltip-container">
            <div class="mb-3">
                {!! Form::label(null, 'Página', ['class'=>'form-label']) !!}
                {!! Form::select('page', $listPages, null, [
                    'class'=>'form-select',
                    'required'=>'required',
                    'placeholder' => '--'
                ]) !!}
            </div>
            <div class="mb-3">
                <div class="d-flex justify-content-start align-items-center">
                    {!! Form::label(null, 'Título', ['class'=>'form-label']) !!}
                    <span class="ms-1 mb-1" data-bs-original-title="O título será usado para as informações da página selecionada acima" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top" ><i class="mdi mdi-help-circle"></i></span>
                </div>
                {!! Form::text('title', null, ['class'=>'form-control', 'required'=>'required']) !!}
            </div>
            <div class="mb-3">
                <div class="d-flex justify-content-start align-items-center">
                    {!! Form::label(null, 'Autor', ['class'=>'form-label']) !!}
                    <span class="ms-1 mb-1" data-bs-original-title="Autor da criação de conteúdo da página selecionada acima" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"><i class="mdi mdi-help-circle"></i></span>
                </div>
                {!! Form::text('author', null, ['class'=>'form-control', 'required'=>'required']) !!}
            </div>
        </div> <!-- end card-body-->
    </div> <!-- end card-->
    <div class="card col-12 col-lg-6">
        <div class="card-body" id="tooltip-container">
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
                    <span class="ms-1 mb-1" data-bs-original-title="A descrição será usada para as informações da página selecionada acima" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"><i class="mdi mdi-help-circle"></i></span>
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
        </div> <!-- end card-body-->
    </div> <!-- end card-->
</div>
<!-- end row -->
