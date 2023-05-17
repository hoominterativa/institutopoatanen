<div class="tab-content">
    <div class="tab-pane show active" id="slideDesktop">
        <div class="row col-12">
            <div class="col-12 ">
                <div class="card card-body" id="tooltip-container">
                    <div class="mb-3">
                        {!! Form::label('title', 'Título', ['class' => 'form-label']) !!}
                        {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title']) !!}
                    </div>
                    <div class="mb-3">
                        {!! Form::label('quantity', 'Quantidade', ['class' => 'form-label']) !!}
                        {!! Form::text('quantity', null, ['class' => 'form-control', 'id' => 'quantity']) !!}
                    </div>
                    <div class="mb-3 form-check">
                        {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                        {!! Form::label('active', 'Ativar Tópico em destaque', ['class' => 'form-check-label']) !!}
                    </div>
                </div>
                {{-- end card-body --}}
            </div>
        </div>
        {{-- end row --}}
    </div>
</div>
