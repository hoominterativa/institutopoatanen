@if ($service)
    {!! Form::model($service, ['route' => ['admin.serv10.update', $service->id],'class' => 'parsley-validate','files' => true,]) !!}
    @method('PUT')
    {!! Form::hidden('slug', $service->slug) !!}
    {!! Form::hidden('featured', $service->featured) !!}
    {!! Form::hidden('active', $service->active) !!}
    {!! Form::hidden('active_topic',  $service->active_topic ) !!}
    {!! Form::hidden('active_banner',  $service->active_banner ) !!}
    {!! Form::hidden('active_content',  $service->active_content ) !!}
@else
    {!! Form::model(null, ['route' => 'admin.serv10.store', 'class' => 'parsley-validate', 'files' => true]) !!}
@endif

<div class="row col-12">
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                {!! Form::label('title_gallery', 'Título', ['class' => 'form-label']) !!}
                {!! Form::text('title_gallery', null, ['class' => 'form-control', 'id' => 'title_gallery']) !!}
            </div>
            <div class="normal-editor__content mb-3">
                {!! Form::label('description_gallery', 'Descrição', ['class' => 'form-label']) !!}
                {!! Form::textarea('description_gallery', null, [
                    'class' => 'form-control normal-editor',
                    'data-height' => 500,
                    'id' => 'description_gallery',
                ]) !!}
            </div>
        </div>
        {{-- end card-body --}}
        <div class="mb-3 form-check">
            {!! Form::checkbox('active_gallery', '1', null, ['class' => 'form-check-input', 'id' => 'active_gallery']) !!}
            {!! Form::label('active_gallery', 'Ativar exibição?', ['class' => 'form-check-label']) !!}
        </div>
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', ['class' => 'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-0', 'type' => 'submit', ]) !!}
    </div>
</div>
{!! Form::close() !!}
