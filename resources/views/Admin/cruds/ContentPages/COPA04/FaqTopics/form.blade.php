<div class="row col-12">
    <div class="col-12">
        <input type="hidden" name="contentpage_id" value="{{$contentPage->id}}">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-0 col-12">
                {!! Form::label('validationCustom01', 'Título', ['class'=>'form-label']) !!}
                {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'validationCustom01', 'placeholder'=>'Título', 'required'=>'required']) !!}
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    <div class="col-12">
        <div class="card card-body">
            <div class="basic-editor__content mb-3 col-12">
                {!! Form::label('basic-editor', 'Descrição', ['class'=>'form-label']) !!}
                {!! Form::textarea('description', null, [
                    'class'=>'form-control basic-editor',
                    'id'=>'basic-editor',
                ]) !!}
            </div>
        </div>
        <div class="mb-3 form-check me-3">
            {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
            {!! Form::label('active', 'Ativo?', ['class' => 'form-check-label']) !!}
        </div>
    </div>
</div>
{{-- end row --}}

