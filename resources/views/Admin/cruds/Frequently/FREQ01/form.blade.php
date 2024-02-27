<div class="row col-12">
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                {!! Form::label('question', 'Pergunta', ['class'=>'form-label']) !!}
                {!! Form::text('question', null, ['class'=>'form-control', 'id'=>'question']) !!}
            </div>
            <div class="normal-editor__content mb-3">
                {!! Form::label('normal-editor', 'Resposta', ['class'=>'form-label']) !!}
                {!! Form::textarea('answer', null, [
                    'class'=>'form-control normal-editor',
                    'id'=>'normal-editor',
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
