@if ($section)
    {!! Form::model($section, [
        'route' => ['admin.serv05.section.update', $section->id],
        'class' => 'parsley-validate',
        'files' => true,
    ]) !!}
    @method('PUT')
@else
    {!! Form::model(null, ['route' => 'admin.serv05.section.store', 'class' => 'parsley-validate', 'files' => true]) !!}
@endif

<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="alert alert-warning">
                <p class="mb-0">• As informações cadastradas nestes campos serão mostradas em destaque na seção home.</p>
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('title', 'Título da seção', ['class' => 'form-label']) !!}
                        {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('subtitle', 'Subtítulo da seção', ['class' => 'form-label']) !!}
                        {!! Form::text('subtitle', null, ['class' => 'form-control', 'id' => 'subtitle']) !!}
                    </div>
                </div>
            </div>
            <div class="mb-3">
                {!! Form::label('description', 'Descrição', ['class' => 'form-label']) !!}
                {!! Form::textarea('description', null, [
                    'class' => 'form-control',
                    'id' => 'description',
                    'required' => 'required',
                    'data-parsley-trigger' => 'keyup',
                    'data-parsley-minlength' => '20',
                    'data-parsley-maxlength' => '900',
                    'data-parsley-minlength-message' => 'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold' => '10',
                ]) !!}
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="alert alert-warning">
                <p class="mb-0">• As informações cadastradas nestes campos serão mostradas em destaque na seção "SOBRE" da página interna.</p>
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('title_about', 'Título Sobre', ['class' => 'form-label']) !!}
                        {!! Form::text('title_about', null, ['class' => 'form-control', 'id' => 'title_about']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('subtitle_about', 'Subtítulo Sobre', ['class' => 'form-label']) !!}
                        {!! Form::text('subtitle_about', null, ['class' => 'form-control', 'id' => 'subtitle_about']) !!}
                    </div>
                </div>
            </div>
            <div class="mb-3">
                {!! Form::label('description_about', 'Descrição', ['class' => 'form-label']) !!}
                {!! Form::textarea('description_about', null, [
                    'class' => 'form-control',
                    'id' => 'description_about',
                    'required' => 'required',
                    'data-parsley-trigger' => 'keyup',
                    'data-parsley-minlength' => '20',
                    'data-parsley-maxlength' => '900',
                    'data-parsley-minlength-message' => 'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold' => '10',
                ]) !!}
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="alert alert-warning">
                <p class="mb-0">• As informações cadastradas nestes campos serão mostradas em destaque na seção "BANNER" da página interna.</p>
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('title_banner', 'Título do banner', ['class' => 'form-label']) !!}
                        {!! Form::text('title_banner', null, ['class' => 'form-control', 'id' => 'title_banner']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('subtitle_banner', 'Subtítulo do banner', ['class' => 'form-label']) !!}
                        {!! Form::text('subtitle_banner', null, ['class' => 'form-control', 'id' => 'subtitle_banner']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="mb-3 form-check me-3">
            {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
            {!! Form::label('active', 'Ativar exibição dos campos?', ['class' => 'form-check-label']) !!}
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


