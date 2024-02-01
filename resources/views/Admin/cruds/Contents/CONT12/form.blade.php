<div class="row col-12">
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                        {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('subtitle', 'Subtítulo', ['class'=>'form-label']) !!}
                        {!! Form::text('subtitle', null, ['class'=>'form-control', 'id'=>'subtitle']) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-3 form-check">
            {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
            {!! Form::label('active', 'Ativar exibição?', ['class' => 'form-check-label']) !!}
        </div>
    </div>
</div>
{{-- end row --}}
