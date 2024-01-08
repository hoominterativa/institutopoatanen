@if ($section)
    {!! Form::model($section, ['route' => ['admin.copa02.section.update', $section->id], 'class' => 'parsley-validate', 'files' => true,]) !!}
    @method('PUT')
    {!! Form::hidden('active_content', $section->active_content) !!}
    {!! Form::hidden('active_banner', $section->active_banner) !!}
    {!! Form::hidden('active_last_section', $section->active_last_section) !!}
@else
    {!! Form::model(null, ['route' => 'admin.copa02.section.store', 'class' => 'parsley-validate', 'files' => true]) !!}
@endif

<div class="row col-12">
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('title_section_topic', 'Título', ['class' => 'form-label']) !!}
                        {!! Form::text('title_section_topic', null, ['class' => 'form-control', 'id' => 'title_section_topic']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('subtitle_section_topic', 'Subtítulo', ['class' => 'form-label']) !!}
                        {!! Form::text('subtitle_section_topic', null, ['class' => 'form-control', 'id' => 'subtitle_section_topic']) !!}
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <div class="complete-editor__content mb-3">
                    {!! Form::label('complete-editor', 'Descrição', ['class'=>'form-label']) !!}
                    {!! Form::textarea('description_section_topic', null, [
                        'class'=>'form-control complete-editor',
                        'id'=>'complete-editor',
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-3 form-check me-3">
                {!! Form::checkbox('active_section_topic', '1', null, ['class' => 'form-check-input', 'id' => 'active_section_topic']) !!}
                {!! Form::label('active_section_topic', 'Ativar exibição dos campos?', ['class' => 'form-check-label']) !!}
            </div>
        </div>
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', ['class' => 'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-0','type' => 'submit',]) !!}
    </div>
</div>
{!! Form::close() !!}
