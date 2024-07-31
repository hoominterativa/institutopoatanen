<div class="row col-12">
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3 col-12">
                {!! Form::label('validationCustom01', 'Título', ['class'=>'form-label']) !!}
                {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'validationCustom01', 'placeholder'=>'Título', 'required'=>'required']) !!}
            </div>
            <div class="row">
                <div class="mb-3 col-8">
                    {!! Form::label('validationCustom02', 'Subtitulo', ['class'=>'form-label']) !!}
                    {!! Form::text('subtitle', null, ['class'=>'form-control', 'id'=>'validationCustom02', 'placeholder'=>'Subtitulo', 'required'=>'required']) !!}
                </div>
                <div class="mb-3 col-4">
                    {!! Form::label('colorpicker-default', 'Cor primária', ['class'=>'form-label']) !!}
                    {!! Form::text('color_one', null, [
                            'class'=>'form-control colorpicker-default',
                            'id'=>'colorpicker-default',
                            'required'=>'required',
                        ])!!}
                </div>
            </div>
            <div class="basic-editor__content mb-3 col-12">
                {!! Form::label('basic-editor', 'Descrição', ['class'=>'form-label']) !!}
                {!! Form::textarea('description', null, [
                    'class'=>'form-control basic-editor',
                    'id'=>'basic-editor',
                ]) !!}
            </div>
            <div class="mb-3 form-check me-3">
                {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                {!! Form::label('active', 'Ativo?', ['class' => 'form-check-label']) !!}
            </div>
        </div>
        {{-- end card-body --}}
    </div>
</div>
{{-- end row --}}

