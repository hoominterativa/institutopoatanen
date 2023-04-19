<div class="row col-12">
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                {!! Form::label('question', 'Pergunta', ['class'=>'form-label']) !!}
                {!! Form::text('question', null, ['class'=>'form-control', 'id'=>'question']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('answer', 'Resposta', ['class'=>'form-label']) !!}
                {!! Form::textarea('answer', null, [
                    'class'=>'form-control',
                    'id'=>'answer',
                    'data-parsley-trigger'=>'keyup',
                    'data-parsley-minlength'=>'20',
                    'data-parsley-maxlength'=>'800',
                    'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold'=>'10',
                ]) !!}
            </div>
            <div class="mb-3 form-check">
                {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                {!! Form::label('active', 'Ativar exibição', ['class' => 'form-check-label']) !!}
            </div>
        </div>
        {{-- end card-body --}}
    </div>
</div>
{{-- end row --}}
