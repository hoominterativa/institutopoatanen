<div class="row col-12">
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                {!! Form::label(null, 'Data do evento', ['class'=>'form-label']) !!}
                {!! Form::text('date', null, [
                        'class'=>'form-control',
                        'required'=>'required',
                        'data-provide'=>'datepicker',
                        'data-date-autoclose'=>'true',
                        'data-date-format'=>'dd/mm/yyyy',
                        'data-date-language'=>'pt-BR',
                        'required'=>'required'
                    ])!!}
            </div>
            <div class="mb-3">
                {!! Form::label('locale', 'Local do evento', ['class'=>'form-label']) !!}
                {!! Form::text('locale', null, ['class'=>'form-control', 'id'=>'locale', 'placeholder' => 'Salvador-BA', 'required'=>'required']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label(null, 'Link', ['class' => 'form-label']) !!}
                {!! Form::url('link', null, ['class' => 'form-control', 'parsley-type' => 'url', 'id' => 'targetUrl']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('link_target', 'Redirecionar para', ['class'=>'form-label']) !!}
                {!! Form::select('link_target', ['_self' => 'Na mesma aba', '_blank' => 'Em nova aba'], null, ['class'=>'form-select', 'id'=>'link_target']) !!}
            </div>
            <div class="mb-3 form-check">
                {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'active']) !!}
                {!! Form::label('active', 'Ativar exibição', ['class'=>'form-check-label']) !!}
            </div>
        </div>
        {{-- end card-body --}}
    </div>
</div>
{{-- end row --}}
