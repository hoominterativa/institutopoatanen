@if ($section)
    {!! Form::model($section, ['route' => ['admin.cont13.section.update', $section->id],'class' => 'parsley-validate','files' => true,]) !!}
    @method('PUT')
    {!! Form::hidden('active', $section->active) !!}
@else
    {!! Form::model(null, ['route' => 'admin.cont13.section.store', 'class' => 'parsley-validate', 'files' => true]) !!}
@endif

<div class="row col-12">
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                {!! Form::label('title_topic', 'Título', ['class' => 'form-label']) !!}
                {!! Form::text('title_topic', null, ['class' => 'form-control', 'id' => 'title_topic']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('description_topic', 'Descrição', ['class'=>'form-label']) !!}
                {!! Form::textarea('description_topic', null, [
                    'class'=>'form-control',
                    'id'=>'description_topic',
                    'data-parsley-trigger'=>'keyup',
                    'data-parsley-maxlength'=>'300',
                    'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold'=>'10',
                ]) !!}
            </div>
        </div>
    </div>

    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', ['class' => 'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-0','type' => 'submit',]) !!}
    </div>
</div>
{!! Form::close() !!}

