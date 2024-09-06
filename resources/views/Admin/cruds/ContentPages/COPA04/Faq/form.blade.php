@if ($faq)
    {!! Form::model($faq, ['route' => ['admin.copa04.faq.update', $faq->id], 'class' => 'parsley-validate', 'files' => true,]) !!}
    @method('PUT')
@else
    {!! Form::model(null, ['route' => 'admin.copa04.faq.store', 'class' => 'parsley-validate', 'files' => true]) !!}
    {!! Form::hidden('contentpage_id', $contentPage->id) !!}
@endif
<div class="row col-12">
    <div class="col-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3 col-12">
                {!! Form::label('validationCustom01', 'Título', ['class'=>'form-label']) !!}
                {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'validationCustom01', 'placeholder'=>'Título']) !!}
            </div>

            <div class="mb-3 col-12">
                {!! Form::label('validationCustom02', 'Subtitulo', ['class'=>'form-label']) !!}
                {!! Form::text('subtitle', null, ['class'=>'form-control', 'id'=>'validationCustom02', 'placeholder'=>'Subtitulo']) !!}
            </div>
            <div class="mb-3 col-12">
                {!! Form::label('colorpicker-default', 'Cor primária', ['class'=>'form-label']) !!}
                {!! Form::text('color_one', null, [
                        'class'=>'form-control colorpicker-default',
                        'id'=>'colorpicker-default',
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
</div>
{!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
<a href="{{route('admin.copa04.index')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>

{{-- end row --}}
{!! Form::close() !!}
