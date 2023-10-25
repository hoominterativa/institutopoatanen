@if ($section)
    {!! Form::model($section, ['route' => ['admin.port04.content.update', $section->id],'class' => 'parsley-validate','files' => true,]) !!}
    @method('PUT')
@else
    {!! Form::model(null, ['route' => 'admin.port04.content.store', 'class' => 'parsley-validate', 'files' => true]) !!}
@endif
<div class="row col-12">
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('title_content', 'Título', ['class' => 'form-label']) !!}
                        {!! Form::text('title_content', null, ['class' => 'form-control', 'id' => 'title_content']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('subtitle_content', 'Subtítulo', ['class' => 'form-label']) !!}
                        {!! Form::text('subtitle_content', null, ['class' => 'form-control', 'id' => 'subtitle_content']) !!}
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="normal-editor__content mb-3">
                    {!! Form::label('text_content', 'Texto', ['class'=>'form-label']) !!}
                    {!! Form::textarea('text_content', null, [
                        'class'=>'form-control normal-editor',
                        'data-height'=>500,
                        'id'=>'text_content',
                    ]) !!}
                </div>
            </div>
        </div>
        {{-- end card-body --}}
        <div class="mb-3 form-check">
            {!! Form::checkbox('active_content', '1', null, ['class' => 'form-check-input', 'id' => 'active_content']) !!}
            {!! Form::label('active_content', 'Ativar exibição', ['class' => 'form-check-label']) !!}
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

