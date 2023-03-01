@switch($type)
    @case('text')
        <div class="input__item input__item--text">
            {!! Form::text($name, null, [
                'class' => 'form-control mb-3 ps-3',
                'required'=> $required,
                'placeholder' => $placeholder
            ]) !!}
            <input type="hidden" name="{{str_replace('_'.$type,'',$name)}}" value="{{$placeholder}}">
        </div>
    @break
    @case('textarea')
        <div class="input__item input__item--textarea">
            {!! Form::textarea($name, null, [
                'class'=>'form-control mb-3 ps-3',
                'id'=>'message',
                'required'=> $required,
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
        <div class="input__item input__item--email">
            {!! Form::email($name, null, [
                'class'=>'form-control mb-3 ps-3',
                'required'=> $required,
                'parsley-type'=>'email',
                'placeholder' => $placeholder
            ]) !!}
            <input type="hidden" name="{{str_replace('_'.$type,'',$name)}}" value="{{$placeholder}}">
        </div>
    @break
    @case('phone')
        <div class="input__item input__item--phone">
            {!! Form::text($name, null, [
                'class'=>'form-control mb-3 ps-3',
                'data-toggle'=>'input-mask',
                'required'=> $required,
                'data-mask-format'=>'(00) 0000-0000',
                'placeholder' => $placeholder
            ]) !!}
            <input type="hidden" name="{{str_replace('_'.$type,'',$name)}}" value="{{$placeholder}}">
        </div>
    @break
    @case('cellphone')
        <div class="input__item input__item--cellphone">
            {!! Form::text($name, null, [
                'class'=>'form-control mb-3 ps-3',
                'data-toggle'=>'input-mask',
                'required'=> $required,
                'data-mask-format'=>'(00) 00000-0000',
                'placeholder' => $placeholder
            ]) !!}
            <input type="hidden" name="{{str_replace('_'.$type,'',$name)}}" value="{{$placeholder}}">
        </div>
    @break
    @case('select')
        <div class="input__item input__item--select">
            @php
                $selectOptions = [];
                foreach (explode(',', $options) as $option) {
                    $selectOptions = array_merge($selectOptions, [trim($option) => trim($option)]);
                }
            @endphp
            {!! Form::select($name, $selectOptions, null, [
                'class'=>'form-select mb-3 ps-3',
                'id'=>'heard',
                'required'=> $required,
                'placeholder' => $placeholder
            ]) !!}
            <input type="hidden" name="{{str_replace('_'.$type,'',$name)}}" value="{{$placeholder}}">
        </div>
    @break
    @case('selectEmail')
        <div class="input__item input__item--select">
            @php
                $selectOptions = [];
                foreach (explode(',', $options) as $option) {
                    $emails = explode('{', $option);
                    if(count($emails) > 1){
                        $email = str_replace('}','',$emails[1]);
                        $selectOptions = array_merge($selectOptions, [trim($emails[0].'|'.$email) => trim($emails[0])]);
                    }
                }
            @endphp
            {!! Form::select($name, $selectOptions, null, [
                'class'=>'form-select mb-3 ps-3',
                'id'=>'heard',
                'required'=> $required??false,
                'placeholder' => $placeholder
            ]) !!}
            <input type="hidden" name="{{str_replace('_'.$type,'',$name)}}" value="{{$placeholder}}">
        </div>
    @break
    @case('checkbox')
        <div class="input__item input__item--checkbox">
            {!! Form::label(null, $placeholder, ['class'=>'form-label']) !!}
            <div class="d-flex align-items-center">
                @foreach (explode(',', $options) as $key => $option)
                    @if ($option)
                        <div class="col-12 col-lg-6 mb-3 form-check d-flex align-items-center">
                            {!! Form::checkbox($name.'[]', trim($option), null, ['class'=>'form-check-input me-2', 'id'=> $name.$key]) !!}
                            {!! Form::label($name.$key, trim($option), ['class'=>'form-check-label']) !!}
                        </div>
                    @endif
                @endforeach
            </div>
            <input type="hidden" name="{{str_replace('_'.$type,'',$name)}}" value="{{$placeholder}}">
        </div>
    @break
    @case('radio')
        <div class="input__item input__item--radio">
            {!! Form::label($name, $placeholder, ['class'=>'form-label']) !!}
            <div class="d-flex align-items-center">
                @foreach (explode(',', $options) as $key => $option)
                    <div class="me-3 mb-3 form-check d-flex align-items-center">
                        {!! Form::radio($name, trim($option), null, ['class'=>'form-check-input me-2', 'id'=> $name.$key]) !!}
                        {!! Form::label($name.$key, trim($option), ['class'=>'form-check-label']) !!}
                    </div>
                @endforeach
            </div>
            <input type="hidden" name="{{str_replace('_'.$type,'',$name)}}" value="{{$placeholder}}">
        </div>
    @break
    @case('date')
        <div class="input__item input__item--date">
            {!! Form::text($name, null, [
                'class'=>'form-control',
                'required'=> $required,
                'data-provide'=>'datepicker',
                'data-date-autoclose'=>'true',
                'placeholder' => $placeholder
            ])!!}
            <input type="hidden" name="{{str_replace('_'.$type,'',$name)}}" value="{{$placeholder}}">
        </div>
    @break
    @case('file')
        <div class="form__file mb-3 input__item input__item--file">
            {!! Form::label($name, $placeholder, ['class'=>'form-label']) !!}
            <label for="{{$name}}" class="form__file__item form-control">
                Clique para abexar o arquivo
            </label>
            {!! Form::file($name, [
                'required'=> $required,
                'accept'=>'.pdf',
                'id' => $name
            ]) !!}
            <input type="hidden" name="{{str_replace('_'.$type,'',$name)}}" value="{{$placeholder}}">
        </div>
    @break
@endswitch
