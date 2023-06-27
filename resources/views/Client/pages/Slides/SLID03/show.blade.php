<section id="slid03__lightbox__form" class="slid03-show" style="display: none;">
    <div class="row">
        <div class="slid03-show__sideLeft col-12 col-md-6">
            <div class="slid03-show__sideLeft__content">
                <h3 class="slid03-show__sideLeft__content__title">Form Completo</h3>
                <p class="slid03-show__sideLeft__content__description">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non liberolor sit amet, consectetur adipiscing elit. Cras vel tortor
                </p>
            </div>
            {!! Form::model(null, ["class" => "slid03-show__form__item", "method" => "POST", "files" => true]) !!}
                <input type="hidden" name="target_lead" value="Razão do formulário">
                <input type="hidden" name="target_send" value="anderson@hoom.com.br">
                <div class="slid03-show__content__form__item__input col-12">
                    @include('Client.Components.inputs', [
                        'name' => 'name',
                        'options' => '',
                        'placeholder' => "Seu Nome",
                        'type' => 'text',
                        'required' => true,
                    ])
                </div>
                <div class="slid03-show__content__form__item__input col-12">
                    @include('Client.Components.inputs', [
                        'name' => 'cellphone',
                        'options' => '',
                        'placeholder' => "Celular",
                        'type' => 'cellphone',
                        'required' => true,
                    ])
                </div>
                <div class="slid03-show__content__form__item__input col-12">
                    @include('Client.Components.inputs', [
                        'name' => 'email',
                        'options' => '',
                        'placeholder' => "E-mail",
                        'type' => 'email',
                        'required' => true,
                    ])
                </div>
                <div class="slid03-show__content__form__item__input col-12">
                    @include('Client.Components.inputs', [
                        'name' => 'endereco',
                        'options' => '',
                        'placeholder' => "Endereço",
                        'type' => 'text',
                        'required' => true,
                    ])
                </div>
                <div class="slid03-show__content__form__additional">
                    <h3 class="slid03-show__content__form__additional__title">Adicionar Informações</h3>

                    <button class="slid03-show__content__form__additional__add border-0 d-flex align-items-center">
                        <i class="mdi mdi-clipboard-plus-outline font-22 me-3"></i> Adicionar
                    </button>

                    <div class="slid03-show__content__form__additional__item">

                        @include('Client.Components.inputs', [
                            'name' => 'endereco',
                            'options' => '',
                            'placeholder' => "Endereço",
                            'type' => 'text',
                            'required' => true,
                        ])
                    </div>
                </div>
                <button type="submit" class="slid03-show__form__item__submit d-flex align-items-center">
                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="30" class="me-3">
                    CTA
                </button>
            {!! Form::close() !!}
        </div>
        <div class="slid03-show__sideRight col-12 col-md-6">
            <img src="{{asset('storage/uploads/tmp/png-slide.png')}}" width="100%" class="slid03-show__sideRight__img" alt="">
        </div>
    </div>
</section>
