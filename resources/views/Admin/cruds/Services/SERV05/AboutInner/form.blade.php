@if ($service)
    {!! Form::model($service, ['route' => ['admin.serv05.update', $service->id], 'class' => 'parsley-validate', 'files' => true,]) !!}
    @method('PUT')
    {!! Form::hidden('active_banner', $service->active_banner) !!}
    {!! Form::hidden('active_topic', $service->active_topic) !!}
    {!! Form::hidden('featured', $service->featured) !!}
    {!! Form::hidden('active', $service->active) !!}
    {!! Form::hidden('slug', $service->slug) !!}
    {!! Form::hidden('link_topic', getUri($service->link_topic)) !!}
@else
    {!! Form::model(null, ['route' => 'admin.serv05.store', 'class' => 'parsley-validate', 'files' => true]) !!}
@endif

<div class="row col-12">
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('title_about_inner', 'Título', ['class' => 'form-label']) !!}
                        {!! Form::text('title_about_inner', null, ['class' => 'form-control', 'id' => 'title_about_inner']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('subtitle_about_inner', 'Subtítulo', ['class' => 'form-label']) !!}
                        {!! Form::text('subtitle_about_inner', null, ['class' => 'form-control', 'id' => 'subtitle_about_inner']) !!}
                    </div>
                </div>
            </div>
            <div class="mb-3">
                {!! Form::label('description_about_inner', 'Descrição', ['class' => 'form-label']) !!}
                {!! Form::textarea('description_about_inner', null, [
                    'class' => 'form-control',
                    'id' => 'description_about_inner',
                    'data-parsley-trigger' => 'keyup',
                    'data-parsley-minlength' => '20',
                    'data-parsley-maxlength' => '900',
                    'data-parsley-minlength-message' => 'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold' => '10',
                ]) !!}
            </div>
            <div class="col-12">
                <div class="mb-3 form-check me-3">
                    {!! Form::checkbox('active_about_inner', '1', null, ['class' => 'form-check-input', 'id' => 'active_about_inner']) !!}
                    {!! Form::label('active_about_inner', 'Ativar exibição?', ['class' => 'form-check-label']) !!}
                </div>
            </div>
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


