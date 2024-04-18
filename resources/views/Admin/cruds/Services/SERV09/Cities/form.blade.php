@if (isset($city))
    {!! Form::model($city, ['route' => ['admin.serv09.city.update', $city->id], 'class'=>'parsley-validate', 'files' => true]) !!}
    @method('PUT')
@else
    {!! Form::model(null, ['route' => ['admin.serv09.city.store'], 'class'=>'parsley-validate', 'files' => true]) !!}
@endif
    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                <div class="d-flex">
                    {!! Form::label('heard', 'Estado', ['class'=>'form-label']) !!}
                    <i class="text-danger">*</i>
                </div>
                {!! Form::select('state_id', $statesGet, null, [
                    'class'=>'form-select',
                    'id'=>'heard',
                    'required'=>'required',
                    'placeholder' => 'Informe o estado'
                ]) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('city', 'Cidade', ['class' => 'form-label']) !!}
                {!! Form::text('city', null, ['class' => 'form-control', 'required'=>'required', 'id' => 'city']) !!}
            </div>
            <div class="d-flex">
                <div class="mb-3 form-check me-3">
                    {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                    {!! Form::label('active', 'Ativar exibição?', ['class' => 'form-check-label']) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-3', 'type' => 'submit']) !!}
        {!! Form::button('Fechar', ['class'=>'btn btn-secondary waves-effect waves-light float-end me-0 width-lg align-items-left', 'data-bs-dismiss'=> 'modal', 'type' => 'button']) !!}
    </div>
{!! Form::close() !!}
