@if (isset($category))
    {!! Form::model($category, ['route' => ['admin.abou04.category.update', $category->id], 'class'=>'parsley-validate', 'files' => true]) !!}
    @method('PUT')
@else
    {!! Form::model(null, ['route' => ['admin.abou04.category.store'], 'class'=>'parsley-validate', 'files' => true]) !!}
    {!! Form::hidden('about_id', $about->id) !!}
@endif
    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title', 'required' =>'required']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('description', 'Descrição', ['class'=>'form-label']) !!}
                {!! Form::textarea('description', null, [
                    'class'=>'form-control',
                    'id'=>'description',
                    'data-parsley-trigger'=>'keyup',
                    'data-parsley-maxlength'=>'900',
                    'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold'=>'10',
                ]) !!}
            </div>
            <div class="mb-3 form-check me-3">
                {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'active']) !!}
                {!! Form::label('active', 'Ativar Exibição?', ['class'=>'form-check-label']) !!}
            </div>
        </div>
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-3', 'type' => 'submit']) !!}
        {!! Form::button('Fechar', ['class'=>'btn btn-secondary waves-effect waves-light float-end me-0 width-lg align-items-left', 'data-bs-dismiss'=> 'modal', 'type' => 'button']) !!}
    </div>
{!! Form::close() !!}
