@if (isset($topic))
    {!! Form::model($topic, ['route' => ['admin.prod05.topic.update', $topic->id], 'class'=>'parsley-validate', 'files' => true]) !!}
    @method('PUT')
@else
    {!! Form::model(null, ['route' => ['admin.prod05.topic.store'], 'class'=>'parsley-validate', 'files' => true]) !!}
@endif
    <div class="row">
        <div class="col-12">
            <div class="card card-body border" id="tooltip-container">
                <div class="mb-3">
                    {!! Form::label('category_id', 'Categoria', ['class'=>'form-label']) !!}
                    {!! Form::select('category_id', $topicSelectCategories, null, [
                        'class'=>'form-select',
                        'id'=>'category_id',
                        'required'=>'required',
                        'placeholder' => 'Selecione uma categoria'
                    ]) !!}
                </div>
                <div class="mb-3">
                    {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                    {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title','required'=>'required',]) !!}
                </div>
                <div class="mb-3 form-check me-3">
                    {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'active']) !!}
                    {!! Form::label('active', 'Ativar Exibição', ['class'=>'form-check-label']) !!}
                </div>
                <div class="complete-editor__content mb-3">
                    {!! Form::label('complete-editor', 'Texto', ['class'=>'form-label']) !!}
                    {!! Form::textarea('text', null, [
                        'class'=>'form-control complete-editor',
                        'id'=>'complete-editor',
                    ]) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-3', 'type' => 'submit']) !!}
        {!! Form::button('Fechar', ['class'=>'btn btn-secondary waves-effect waves-light float-end me-0 width-lg align-items-left', 'data-bs-dismiss'=> 'modal', 'type' => 'button']) !!}
    </div>
{!! Form::close() !!}
