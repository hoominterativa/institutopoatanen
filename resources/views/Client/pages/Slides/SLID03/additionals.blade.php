<div class="addedInput slid03-show__form__additional__item">
    <a href="javascript:void(0)" class="mdi mdi-trash-can-outline slid03-show__form__additional__delete"></a>
    <div class="slid03-show__form__additional__input">
        @include('Client.Components.inputs', [
            'name' => 'nome-do-pet[]',
            'options' => '',
            'placeholder' => "Nome do Pet",
            'type' => 'text',
            'required' => true,
        ])
    </div>
    <div class="slid03-show__form__additional__input">
        @include('Client.Components.inputs', [
            'name' => 'idade-do-pet[]',
            'options' => '',
            'placeholder' => "Idade do Pet",
            'type' => 'text',
            'required' => true,
        ])
    </div>
</div>
