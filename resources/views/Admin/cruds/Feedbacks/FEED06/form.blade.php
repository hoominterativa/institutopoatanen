
<div class="row col-12">
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                {!! Form::label('name', 'Nome', ['class' => 'form-label']) !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('testimony', 'Depoimento', ['class' => 'form-label']) !!}
                {!! Form::textarea('testimony', null, [
                    'class' => 'form-control',
                    'id' => 'testimony',
                    'data-parsley-trigger' => 'keyup',
                    'data-parsley-maxlength' => '800',
                    'data-parsley-minlength-message' => 'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold' => '10',
                ]) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('classification', 'Classificação', ['class'=>'form-label']) !!}
                {!! Form::select('classification', ['1' => '1 estrela', '2' => '2 estrelas', '3' => '3 estrelas', '4' => '4 estrelas', '5' => '5 estrelas'], null, [
                    'class'=>'form-select',
                    'id'=>'classification',
                    'placeholder' => 'Insira a classificação...'
                ]) !!}
            </div>
        </div>
        <div class="mb-3 form-check">
            {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
            {!! Form::label('active', 'Ativar exibição?', ['class' => 'form-check-label']) !!}
        </div>
        {{-- end card-body --}}
    </div>
</div>
{{-- end row --}}

