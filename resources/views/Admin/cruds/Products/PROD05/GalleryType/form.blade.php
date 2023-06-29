@if (isset($galleryType))
    {!! Form::model($galleryType, ['route' => ['admin.prod05.galleryType.update', $galleryType->id], 'class'=>'parsley-validate', 'files' => true]) !!}
    @method('PUT')
@else
    {!! Form::model(null, ['route' => ['admin.prod05.galleryType.store'], 'class'=>'parsley-validate', 'files' => true]) !!}
@endif
    {!! Form::hidden('product_id', $product->id) !!}
    <div class="row">
        <div class="col-12 col-lg-6 ">
            <div class="card card-body border" id="tooltip-container">
                <div class="mb-3">
                    {!! Form::label('color', 'Cor', ['class'=>'form-label']) !!}
                    {!! Form::text('color', '#cccccc', [
                        'class'=>'form-control colorpicker-default',
                        'id'=>'colorpicker-default',
                    ])!!}
                </div>
                <div class="d-flex">
                    <div class="mb-3 form-check me-3">
                        {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                        {!! Form::label('active', 'Ativar exibição', ['class' => 'form-check-label']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-3', 'type' => 'submit']) !!}
        {!! Form::button('Fechar', ['class'=>'btn btn-secondary waves-effect waves-light float-end me-0 width-lg align-items-left', 'data-bs-dismiss'=> 'modal', 'type' => 'button']) !!}
    </div>
{!! Form::close() !!}
