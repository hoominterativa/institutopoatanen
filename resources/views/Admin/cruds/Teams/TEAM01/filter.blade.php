<div class="dropdown">
    <div class="d-flex align-items-center">
        <button type="button" class="btn btn-light dropdown-toggle py-0 px-1 pe-2 d-flex align-items-center" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="mdi mdi-filter-variant font-28 text-primary me-2"></i>
            Filtros
        </button>
        @if (Session::has('filter'))
            <a href="{{route('admin.team01.clearFilter')}}" class="btn btn-info ms-2">Limpar Filtro</a>
        @endif
        <div class="dropdown-menu p-3 bg-light">
            {!! Form::model(null, ['route' => 'admin.team01.index.filter', 'class'=>'parsley-validate', 'method'=>'POST', 'style' => 'width:300px']) !!}
                <div class="mb-3">
                    {!! Form::label('category_id', 'Categoria', ['class'=>'form-label']) !!}
                    {!! Form::select('category_id', $categories, Session::get('filter.category_id'), [
                        'class'=>'form-select',
                        'id'=>'category_id',
                        'placeholder' => '--'
                    ]) !!}
                </div>
                <div class="mb-3">
                    {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                    {!! Form::text('title', Session::get('filter.title'), ['class'=>'form-control', 'id'=>'title']) !!}
                </div>
                <div class="mb-3">
                    {!! Form::label('subtitle', 'Subtítulo', ['class'=>'form-label']) !!}
                    {!! Form::text('subtitle', Session::get('filter.subtitle'), ['class'=>'form-control', 'id'=>'subtitle']) !!}
                </div>
                <div class="mb-3">
                    {!! Form::label('active', 'Status', ['class'=>'form-label']) !!}
                    {!! Form::select('active', [1 => 'Ativo', 0 => 'inativo'], Session::get('filter.active'), [
                        'class'=>'form-select',
                        'id'=>'active',
                        'placeholder' => '--'
                    ]) !!}
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-sm-6">
                        <div class="form-check">
                            {!! Form::checkbox('featured', '1', Session::get('filter.featured'), ['class'=>'form-check-input', 'id'=>'featured']) !!}
                            {!! Form::label('featured', 'Destaque Home', ['class'=>'form-check-label']) !!}
                        </div>
                    </div>
                </div>
                {!! Form::button('Buscar', ['class'=>'btn btn-primary waves-effect waves-light width-lg', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>
