@switch($type)
    @case('text')
        <div>
            {!! Form::text($name, null, [
                'class' => 'form-control mb-3 ps-3',
                'required'=>'required',
                'placeholder' => $placeholder
            ]) !!}
            <input type="hidden" name="{{str_replace('_'.$type,'',$name)}}" value="{{$placeholder}}">
        </div>
    @break
    @case('textarea')
        <div>
            {!! Form::textarea($name, null, [
                'class'=>'form-control mb-3 ps-3',
                'id'=>'message',
                'required'=>'required',
                'placeholder' => $placeholder,
                'data-parsley-trigger'=>'keyup',
                'data-parsley-minlength'=>'20',
                'data-parsley-maxlength'=>'500',
                'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                'data-parsley-validation-threshold'=>'10',
            ]) !!}
            <input type="hidden" name="{{str_replace('_'.$type,'',$name)}}" value="{{$placeholder}}">
        </div>
    @break
    @case('email')
        <div>
            {!! Form::email($name, null, [
                'class'=>'form-control mb-3 ps-3',
                'required'=>'required',
                'parsley-type'=>'email',
                'placeholder' => $placeholder
            ]) !!}
            <input type="hidden" name="{{str_replace('_'.$type,'',$name)}}" value="{{$placeholder}}">
        </div>
    @break
    @case('phone')
        <div>
            {!! Form::text($name, null, [
                'class'=>'form-control mb-3 ps-3',
                'data-toggle'=>'input-mask',
                'data-mask-format'=>'(00) 0000-0000',
                'placeholder' => $placeholder
            ]) !!}
            <input type="hidden" name="{{str_replace('_'.$type,'',$name)}}" value="{{$placeholder}}">
        </div>
    @break
    @case('cellphone')
        <div>
            {!! Form::text($name, null, [
                'class'=>'form-control mb-3 ps-3',
                'data-toggle'=>'input-mask',
                'data-mask-format'=>'(00) 00000-0000',
                'placeholder' => $placeholder
            ]) !!}
            <input type="hidden" name="{{str_replace('_'.$type,'',$name)}}" value="{{$placeholder}}">
        </div>
    @break
    @case('select')
        <div>
            @php
                $selectOptions = [];
                foreach (explode(',', $options) as $option) {
                    $selectOptions = array_merge($selectOptions, [trim($option) => trim($option)]);
                }
            @endphp
            {!! Form::select($name, $selectOptions, null, [
                'class'=>'form-select mb-3 ps-3',
                'id'=>'heard',
                'required'=>'required',
                'placeholder' => $placeholder
            ]) !!}
            <input type="hidden" name="{{str_replace('_'.$type,'',$name)}}" value="{{$placeholder}}">
        </div>
    @break
    @case('checkbox')
        <div class="row">
            {!! Form::label($name, $placeholder, ['class'=>'form-label']) !!}
            @foreach (explode(',', $options) as $option)
                <div class="col-12 col-lg-6 mb-3 form-check">
                    {!! Form::checkbox($name.'[]', $option, null, ['class'=>'form-check-input', 'id'=> Str::slug($option)]) !!}
                    {!! Form::label(Str::slug($option), $option, ['class'=>'form-check-label']) !!}
                </div>
            @endforeach
            <input type="hidden" name="{{str_replace('_'.$type,'',$name)}}" value="{{$placeholder}}">
        </div>
    @break
    @case('radio')
        <div class="row">
            {!! Form::label($name, $placeholder, ['class'=>'form-label']) !!}
            @foreach (explode(',', $options) as $option)
                <div class="col-12 col-lg-6 mb-3 form-check">
                    {!! Form::radio($name, $option, null, ['class'=>'form-check-input', 'id'=> Str::slug($option)]) !!}
                    {!! Form::label(Str::slug($option), $option, ['class'=>'form-check-label']) !!}
                </div>
            @endforeach
            <input type="hidden" name="{{str_replace('_'.$type,'',$name)}}" value="{{$placeholder}}">
        </div>
    @break
    @case('date')
        <div>
            {!! Form::text($name, null, [
                'class'=>'form-control',
                'required'=>'required',
                'data-provide'=>'datepicker',
                'data-date-autoclose'=>'true',
                'placeholder' => $placeholder
            ])!!}
            <input type="hidden" name="{{str_replace('_'.$type,'',$name)}}" value="{{$placeholder}}">
        </div>
    @break
@endswitch
