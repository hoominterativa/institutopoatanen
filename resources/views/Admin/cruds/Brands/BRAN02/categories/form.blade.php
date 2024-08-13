<div class="row col-12">
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="row">
                <div class="mb-3">
                    {!! Form::label('category', 'Nome da Categoria', ['class' => 'form-label']) !!}
                    {!! Form::text('category', null, ['class' => 'form-control', 'id' => 'title', 'required' => 'required']) !!}
                </div>
            </div>
            <div class="d-flex mt-3">
                <div class="form-check me-3">
                    {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                    {!! Form::label('active', 'Ativar Exibição?', ['class' => 'form-check-label']) !!}
                </div>
                <div class="form-check me-3">
                    {!! Form::checkbox('highlighted', '1', null, ['class' => 'form-check-input', 'id' => 'featured']) !!}
                    {!! Form::label('highlighted', 'Destacar na home?', ['class' => 'form-check-label']) !!}
                </div>
            </div>
        </div>
        {{-- end card-body --}}
    </div>
</div>
