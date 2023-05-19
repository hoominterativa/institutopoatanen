@if (isset($category))
    {!! Form::model($category, ['route' => ['admin.pota01.category.update', $category->id], 'class'=>'parsley-validate', 'files' => true]) !!}
    @method('PUT')
@else
    {!! Form::model(null, ['route' => ['admin.pota01.category.store'], 'class'=>'parsley-validate', 'files' => true]) !!}
@endif
    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('view_type', 'Quantidade de exibição por linha dos artigos.', ['class'=>'form-label']) !!}
                {!! Form::select('view_type', ['row1' => 'Um por linha', 'row2' => 'Dois por linha', 'row3' => 'Três por linha', 'row4' => 'Quatro por linha',], null, [
                    'class'=>'form-select',
                    'id'=>'view_type',
                    'placeholder' => 'Defina a quantidade de box dos artigos a serem exibidos na página da categoria'
                ]) !!}
            </div>
            <div class="d-flex">
                <div class="mb-3 form-check me-3">
                    {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'activeCategory']) !!}
                    {!! Form::label('activeCategory', 'Ativar Exibição', ['class'=>'form-check-label']) !!}
                </div>
                <div class="mb-3 form-check me-3">
                    {!! Form::checkbox('featured_home', '1', null, ['class'=>'form-check-input', 'id'=>'featured_home']) !!}
                    {!! Form::label('featured_home', 'Exibir categoria na home?', ['class'=>'form-check-label']) !!}
                </div>
                <div class="mb-3 form-check me-3">
                    {!! Form::checkbox('view_featured', '1', null, ['class'=>'form-check-input', 'id'=>'view_featuredCategory']) !!}
                    {!! Form::label('view_featuredCategory', 'Exibir seção de artigos em destaque?', ['class'=>'form-check-label']) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-3', 'type' => 'submit']) !!}
        {!! Form::button('Fechar', ['class'=>'btn btn-secondary waves-effect waves-light float-end me-0 width-lg align-items-left', 'data-bs-dismiss'=> 'modal', 'type' => 'button']) !!}
    </div>
{!! Form::close() !!}
