@if (isset($section))
    {!! Form::model($section, ['route' => ['admin.blog03.section.update', $section->id], 'class'=>'parsley-validate', 'files' => true]) !!}
    @method('PUT')
    {!! Form::hidden('active_banner', $section->active_banner) !!}
@else
    {!! Form::model(null, ['route' => ['admin.blog03.section.store'], 'class'=>'parsley-validate', 'files' => true]) !!}
@endif
<div class="row col-12">
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('title_section', 'Título', ['class'=>'form-label']) !!}
                        {!! Form::text('title_section', null, ['class'=>'form-control', 'id'=>'title_section']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('subtitle_section', 'Subtítulo', ['class'=>'form-label']) !!}
                        {!! Form::text('subtitle_section', null, ['class'=>'form-control', 'id'=>'subtitle_section']) !!}
                    </div>
                </div>
            </div>
            <div class="mb-3">
                {!! Form::label('description_section', 'Descrição', ['class'=>'form-label']) !!}
                {!! Form::textarea('description_section', null, [
                    'class'=>'form-control',
                    'id'=>'description_section',
                    'data-parsley-trigger'=>'keyup',
                    'data-parsley-maxlength'=>'800',
                    'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold'=>'10',
                ]) !!}
            </div>
        </div>
        <div class="d-flex">
            <div class="mb-3 form-check me-3">
                {!! Form::checkbox('active_section', '1', null, ['class' => 'form-check-input', 'id' => 'active_section']) !!}
                {!! Form::label('active_section', 'Ativar exibição?', ['class' => 'form-check-label']) !!}
            </div>
        </div>
    </div>
</div>
{!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
<a href="{{route('admin.dashboard')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
{!! Form::close() !!}
