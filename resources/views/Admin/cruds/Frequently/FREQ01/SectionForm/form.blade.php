@if ($section)
    {!! Form::model($section, [ 'route' => ['admin.freq01.section.update', $section->id], 'class' => 'parsley-validate', 'files' => true]) !!}
    @method('PUT')
    {!! Form::hidden('active', $section->active) !!}
@else
    {!! Form::model(null, ['route' => 'admin.freq01.section.store', 'class' => 'parsley-validate', 'files' => true]) !!}
@endif

<div class="row col-12">
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                {!! Form::label('title_form', 'Título da seção formulário', ['class' => 'form-label']) !!}
                {!! Form::text('title_form', null, ['class' => 'form-control', 'id' => 'title_form']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('subtitle_form', 'Subtítulo da seção formulário', ['class' => 'form-label']) !!}
                {!! Form::text('subtitle_form', null, ['class' => 'form-control', 'id' => 'subtitle_form']) !!}
            </div>
        </div>
        <div class="mb-3 form-check">
            {!! Form::checkbox('active_form', '1', null, ['class' => 'form-check-input', 'id' => 'active_form']) !!}
            {!! Form::label('active_form', 'Ativar exibição?', ['class' => 'form-check-label']) !!}
        </div>
        {{-- end card-body --}}
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', ['class' => 'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-0', 'type' => 'submit']) !!}
    </div>
</div>
{!! Form::close() !!}

