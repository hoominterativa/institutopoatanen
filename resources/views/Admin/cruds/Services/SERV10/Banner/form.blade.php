@if ($section)
    {!! Form::model($section, ['route' => ['admin.serv10.section.update', $section->id], 'class' => 'parsley-validate', 'files' => true,]) !!}
    @method('PUT')
    {!! Form::hidden('active_section', $section->active_section) !!}
@else
    {!! Form::model(null, ['route' => 'admin.serv10.section.store', 'class' => 'parsley-validate', 'files' => true]) !!}
@endif

<div class="row col-12">
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                {!! Form::label('title_banner', 'Título', ['class' => 'form-label']) !!}
                {!! Form::text('title_banner', null, ['class' => 'form-control', 'id' => 'title_banner']) !!}
            </div>
            <div class="normal-editor__content mb-3">
                {!! Form::label('description_banner', 'Descrição', ['class' => 'form-label']) !!}
                {!! Form::textarea('description_banner', null, [
                    'class' => 'form-control normal-editor',
                    'data-height' => 500,
                    'id' => 'description_banner',
                ]) !!}
            </div>
        </div>
        <div class="col-12">
            <div class="mb-3 form-check me-3">
                {!! Form::checkbox('active_banner', '1', null, ['class' => 'form-check-input', 'id' => 'active_banner']) !!}
                {!! Form::label('active_banner', 'Ativar exibição dos campos?', ['class' => 'form-check-label']) !!}
            </div>
        </div>
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', ['class' => 'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-0','type' => 'submit',]) !!}
    </div>
</div>
{!! Form::close() !!}
