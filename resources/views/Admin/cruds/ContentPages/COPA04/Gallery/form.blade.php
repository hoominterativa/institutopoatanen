@if (isset($gallery))
    {!! Form::model($gallery, ['route' => ['admin.copa04.gallery.update', $gallery->id], 'class' => 'parsley-validate', 'files' => true,]) !!}
    @method('PUT')
@else
    @if (isset($contentPage))
        {!! Form::model(null, ['route' => 'admin.copa04.gallery.store', 'class' => 'parsley-validate', 'files' => true]) !!}
        {!! Form::hidden('contentpage_id', $contentPage->id) !!}
    @endif
@endif
<div class="row col-12">
    <div class="col-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3 col-12">
                {!! Form::label('validationCustom01', 'Título', ['class'=>'form-label']) !!}
                {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'validationCustom01', 'placeholder'=>'Título', 'required'=>'required']) !!}
            </div>  
            <div class="mb-3 col-12">
                {!! Form::label('validationCustom02', 'Subtitulo', ['class'=>'form-label']) !!}
                {!! Form::text('subtitle', null, ['class'=>'form-control', 'id'=>'validationCustom02', 'placeholder'=>'Subtitulo', 'required'=>'required']) !!}
            </div>
            <div class="mb-3 col-12">
                {!! Form::label('colorpicker-default', 'Cor primária', ['class'=>'form-label']) !!}
                {!! Form::text('color_one', null, [
                        'class'=>'form-control colorpicker-default',
                        'id'=>'colorpicker-default',
                        'required'=>'required',
                    ])!!}
            </div>           
            <div class="mb-3 form-check me-3">
                {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                {!! Form::label('active', 'Ativo?', ['class' => 'form-check-label']) !!}
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    <div class="col-6">
        <div class="card card-body">
            <div class="basic-editor__content mb-3 col-12">
                {!! Form::label('basic-editor', 'Descrição', ['class'=>'form-label']) !!}
                {!! Form::textarea('description', null, [
                    'class'=>'form-control basic-editor',
                    'id'=>'basic-editor',
                ]) !!}
            </div>
        </div>
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', ['class' => 'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-0','type' => 'submit',]) !!}
    </div>
</div>
{{-- end row --}}
{!! Form::close() !!}

