@if ($topic)
    {!! Form::model($topic, [
        'route' => ['admin.serv04.topic.update', $topic->id],
        'class' => 'parsley-validate',
        'files' => true,
    ]) !!}
    @method('PUT')
@else
    {!! Form::model(null, ['route' => 'admin.serv04.topic.store', 'class' => 'parsley-validate', 'files' => true]) !!}
    <input type="hidden" name="service_id" value="{{ $service->id }}">
@endif

<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="row">
                <div class="col-12 ">
                    <div class="mb-3">
                        {!! Form::label('title', 'Título', ['class' => 'form-label']) !!}
                        {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title']) !!}
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="basic-editor__content mb-3">
                    {!! Form::label('text', 'Texto', ['class' => 'form-label']) !!}
                    {!! Form::textarea('text', null, [
                        'class' => 'form-control basic-editor',
                        'data-height' => 500,
                        'id' => 'text',
                    ]) !!}
                </div>
            </div>
            <div class="d-flex">
                <div class="mb-3 form-check me-3">
                    {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                    {!! Form::label('active', 'Ativar exibição', ['class' => 'form-check-label']) !!}
                </div>
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', [
            'class' => 'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-3',
            'type' => 'submit',
        ]) !!}
        {!! Form::button('Fechar', [
            'class' => 'btn btn-secondary waves-effect waves-light float-end me-0 width-lg align-items-left',
            'data-bs-dismiss' => 'modal',
            'type' => 'button',
        ]) !!}
    </div>
    {!! Form::close() !!}
</div>
{{-- end row --}}
