@if ($section)
    {!! Form::model($section, ['route' => ['admin.abou02.section-topics.update', $section->id], 'class' => 'parsley-validate','files' => true,]) !!}
    @method('PUT')
    {!! Form::hidden('active_section', $section->active_section) !!}
    {!! Form::hidden('active_banner', $section->active_banner) !!}
    {!! Form::hidden('active_content', $section->active_content) !!}
@else
    {!! Form::model(null, ['route' => 'admin.abou02.section-topics.store','class' => 'parsley-validate','files' => true,]) !!}
@endif
<div class="row col-12">
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-2">
                {!! Form::label('title_topics', 'Título da seção', ['class' => 'form-label']) !!}
                {!! Form::text('title_topics', null, ['class' => 'form-control', 'id' => 'title_topics']) !!}
            </div>
            <div class="mb-2">
                {!! Form::label('subtitle_topics', 'Subtítulo da seção', ['class' => 'form-label']) !!}
                {!! Form::text('subtitle_topics', null, ['class' => 'form-control', 'id' => 'subtitle_topics']) !!}
            </div>
        </div>
        <div class="d-flex">
            <div class="mb-3 form-check me-3">
                {!! Form::checkbox('active_topic', '1', null, ['class' => 'form-check-input', 'id' => 'active_topic']) !!}
                {!! Form::label('active_topic', 'Ativar exibição?', ['class' => 'form-check-label']) !!}
            </div>
        </div>
    </div>
</div>
{!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
<a href="{{route('admin.dashboard')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
{!! Form::close() !!}

