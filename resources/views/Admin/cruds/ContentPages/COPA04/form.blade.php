<div class="row col-12">
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="d-flex align-items-center mb-1">
                    {!! Form::label('title_page', 'Título da Página', ['class'=>'form-label']) !!}
                    <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="Título que aparecerá na url ao navegar até a página."></i>
                </div>
                {!! Form::text('title_page', null, ['class'=>'form-control', 'id'=>'title_page', 'required'=>'required']) !!}
            </div>
            <div class="mb-3 form-check">
                {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'active']) !!}
                {!! Form::label('active', 'Ativar exibição da página', ['class'=>'form-check-label']) !!}
            </div>
        </div>
        {{-- end card-body --}}
    </div>
</div>
{{-- end row --}}



