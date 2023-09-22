<div class="col-12">
    <div class="card card-body" id="tooltip-container">
        <div class="mb-3">
            <div class="d-flex align-items-center mb-1">
                {!! Form::label('title_form', 'Título', ['class' => 'form-label mb-0']) !!}
                <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon"
                    data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-original-title="Título que é exibido no formulário"></i>
            </div>
            {!! Form::text('title_form', null, ['class' => 'form-control', 'id' => 'title_form']) !!}
        </div>
        <div class="col-12">
            <div class="normal-editor__content mb-3">
                {!! Form::label('description_form', 'Texto Artigo', ['class'=>'form-label']) !!}
                <small class="ms-1"><b>Recomendamos salvar de tempo em tempo caso a matéria seja extensa</b></small>
                {!! Form::textarea('description_form', null, [
                    'class'=>'form-control normal-editor',
                    'id'=>'normal-editor',
                ]) !!}
            </div>
        </div>
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', [
            'class' => 'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-0',
            'type' => 'submit',
        ]) !!}
    </div>
    {{-- end card-body --}}
</div>
