<div class="addedInput slid03-show__form__additional__item">
    <a href="javascript:void(0)" class="mdi mdi-trash-can-outline slid03-show__form__additional__delete"></a>
    @foreach ($inputsAdditionals as $name => $input)
        <div class="slid03-show__form__additional__input">
            @include('Client.Components.inputs', [
                'name' => $name,
                'options' => $input->option,
                'placeholder' => $input->placeholder,
                'type' => $input->type,
                'required' => isset($input->required) ? $input->required : false,
            ])
        </div>
    @endforeach
</div>
