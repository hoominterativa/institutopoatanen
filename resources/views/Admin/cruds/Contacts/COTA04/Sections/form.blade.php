<div class="row col-12">
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <input type="hidden" name="contact_id" value="{{$contact->id}}">
            <div class="mb-3">
                {!! Form::label('title', 'Título', ['class' => 'form-label']) !!}
                {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title']) !!}
            </div>
            <div class="normal-editor__content mb-3">
                {!! Form::label('description', 'Drescrição', ['class' => 'form-label']) !!}
                {!! Form::textarea('description', null, [
                    'class' => 'form-control normal-editor',
                    'data-height' => 500,
                    'id' => 'description',
                ]) !!}
            </div>
            <div class="d-flex">
                <div class="mb-3 form-check me-3">
                    {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                    {!! Form::label('active', 'Ativar exibição?', ['class' => 'form-check-label']) !!}
                </div>
            </div>
        </div>
        {{-- end card-body --}}
    </div>
</div>
{{-- end row --}}
