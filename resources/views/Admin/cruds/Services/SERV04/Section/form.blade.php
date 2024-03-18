@if ($section)
    {!! Form::model($section, ['route' => ['admin.serv04.section.update', $section->id], 'class' => 'parsley-validate', 'files' => true,]) !!}
    @method('PUT')
    {!! Form::hidden('active_banner', $section->active_banner) !!}
@else
    {!! Form::model(null, ['route' => 'admin.serv04.section.store', 'class' => 'parsley-validate', 'files' => true]) !!}
@endif

<div class="card card-body" id="tooltip-container">
    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('title_section', 'Título da seção', ['class' => 'form-label']) !!}
                        {!! Form::text('title_section', null, ['class' => 'form-control', 'id' => 'title_section']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('subtitle_section', 'Subtítulo da seção', ['class' => 'form-label']) !!}
                        {!! Form::text('subtitle_section', null, ['class' => 'form-control', 'id' => 'subtitle_section']) !!}
                    </div>
                </div>
            </div>
            <div class="mb-3">
                {!! Form::label('description_section', 'Descrição', ['class' => 'form-label']) !!}
                {!! Form::textarea('description_section', null, [
                    'class' => 'form-control',
                    'id' => 'description_section',
                    'required' => 'required',
                    'data-parsley-trigger' => 'keyup',
                    'data-parsley-maxlength' => '800',
                    'data-parsley-minlength-message' => 'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold' => '10',
                ]) !!}
            </div>
            <div class="mb-3 form-check me-3">
                {!! Form::checkbox('active_section', '1', null, ['class' => 'form-check-input', 'id' => 'active_section']) !!}
                {!! Form::label('active_section', 'Ativar exibição?', ['class' => 'form-check-label']) !!}
            </div>
        </div>
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', [ 'class' => 'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-0', 'type' => 'submit']) !!}
    </div>
</div>
{!! Form::close() !!}


