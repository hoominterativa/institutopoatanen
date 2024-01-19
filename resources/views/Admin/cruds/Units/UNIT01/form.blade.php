<div class="row col-12">
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('title_unit', 'Título da Unidade', ['class'=>'form-label']) !!}
                        {!! Form::text('title_unit', null, ['class'=>'form-control', 'id'=>'title_unit']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('title', 'Título secundário', ['class'=>'form-label']) !!}
                        {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title']) !!}
                    </div>
                </div>
            </div>
            <div class="mb-3">
                {!! Form::label('description', 'Descrição', ['class'=>'form-label']) !!}
                {!! Form::textarea('description', null, [
                    'class'=>'form-control',
                    'id'=>'description',
                    'data-parsley-trigger'=>'keyup',
                    'data-parsley-minlength'=>'20',
                    'data-parsley-maxlength'=>'800',
                    'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold'=>'10',
                ]) !!}
            </div>
            <div class="d-flex">
                <div class="mb-3 form-check me-3">
                    {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                    {!! Form::label('active', 'Ativar exibição?', ['class' => 'form-check-label']) !!}
                </div>
                <div class="mb-3 form-check me-3">
                    {!! Form::checkbox('featured', '1', null, ['class' => 'form-check-input', 'id' => 'featured']) !!}
                    {!! Form::label('featured', 'Destacar na home?', ['class' => 'form-check-label']) !!}
                </div>
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    {{-- end card --}}
</div>
{{-- end row --}}
