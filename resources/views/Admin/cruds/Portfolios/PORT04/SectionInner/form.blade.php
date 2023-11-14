@if ($section)
    {!! Form::model($section, ['route' => ['admin.port04.section.update', $section->id],'class' => 'parsley-validate','files' => true,]) !!}
    @method('PUT')
    {!! Form::hidden('active_banner', $section->active_banner) !!}
    {!! Form::hidden('active_content', $section->active_content) !!}
    {!! Form::hidden('active_section', $section->active_section) !!}
@else
    {!! Form::model(null, ['route' => 'admin.port04.section.store', 'class' => 'parsley-validate', 'files' => true]) !!}
@endif

<div class="row col-12">
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('title_relationship', 'Título', ['class' => 'form-label']) !!}
                        {!! Form::text('title_relationship', null, ['class' => 'form-control', 'id' => 'title_relationship',]) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('subtitle_relationship', 'Subtítulo', ['class' => 'form-label']) !!}
                        {!! Form::text('subtitle_relationship', null, ['class' => 'form-control', 'id' => 'subtitle_relationship']) !!}
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="normal-editor__content mb-3">
                    {!! Form::label('description_relationship', 'Texto', ['class'=>'form-label']) !!}
                    {!! Form::textarea('description_relationship', null, [
                        'class'=>'form-control normal-editor',
                        'data-height'=>500,
                        'id'=>'description_relationship',
                    ]) !!}
                </div>
            </div>
        </div>
        {{-- end card-body --}}
        <div class="mb-3 form-check">
            {!! Form::checkbox('active_relationship', '1', null, ['class' => 'form-check-input', 'id' => 'active_relationship']) !!}
            {!! Form::label('active_relationship', 'Ativar exibição?', ['class' => 'form-check-label']) !!}
        </div>
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', [
            'class' => 'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-0',
            'type' => 'submit',
        ]) !!}
    </div>
</div>
{!! Form::close() !!}
