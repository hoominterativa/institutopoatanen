@if ($section)
    {!! Form::model($section, ['route' => ['admin.serv09.section.update', $section->id],'class' => 'parsley-validate', 'files' => true,]) !!}
    @method('PUT')
    {!! Form::hidden('active_banner', $section->active_banner) !!}
    {!! Form::hidden('active', $section->active) !!}
@else
    {!! Form::model(null, ['route' => 'admin.serv09.section.store', 'class' => 'parsley-validate', 'files' => true]) !!}
@endif

<div class="row col-12">
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                {!! Form::label('title_feedback', 'Título', ['class' => 'form-label']) !!}
                {!! Form::text('title_feedback', null, ['class' => 'form-control', 'id' => 'title_feedback']) !!}
            </div>
        </div>
        <div class="col-12">
            <div class="mb-3 form-check me-3">
                {!! Form::checkbox('active_feedback', '1', null, ['class' => 'form-check-input', 'id' => 'active_feedback']) !!}
                {!! Form::label('active_feedback', 'Ativar exibição?', ['class' => 'form-check-label']) !!}
            </div>
        </div>
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', ['class' => 'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-0','type' => 'submit',]) !!}
    </div>
</div>
{!! Form::close() !!}


