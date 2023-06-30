<section id="slid03__lightbox__form" class="slid03-show" style="display: none;">
    <div class="row">
        <div class="slid03-show__sideLeft col-12 col-md-6">
            <div class="slid03-show__sideLeft__content">
                <h3 class="slid03-show__sideLeft__content__title">{{$form->title_lightbox}}</h3>
                <p class="slid03-show__sideLeft__content__description">{{$form->description_lightbox}}</p>
            </div>
            {!! Form::model(null, ["class" => "slid03-show__form__item parsley-validate", "method" => "POST", "files" => true]) !!}
                <input type="hidden" name="target_lead" value="Razão do formulário">
                <input type="hidden" name="target_send" value="{{$form->email_form}}">

                @foreach ($inputs as $name => $input)
                    <div class="slid03-show__form__item__input">
                        @include('Client.Components.inputs', [
                            'name' => $name,
                            'options' => $input->option,
                            'placeholder' => $input->placeholder,
                            'type' => $input->type,
                            'required' => isset($input->required) ? $input->required : false,
                        ])
                    </div>
                @endforeach
                <div class="slid03-show__form__additional">
                    <div class="slid03-show__form__additional__header d-flex align-items-center">
                        <div>
                            <h4 class="slid03-show__form__additional__title">Adicionar Informações</h4>
                            <p class="mb-0">Clique no botão adicionar para criar novos campos</p>
                        </div>
                        <button type="button" data-url="{{route('slid03.additionals')}}" class="slid03-show__form__additional__add border-0 d-flex align-items-center ms-auto">
                            <i class="mdi mdi-clipboard-plus-outline font-22 me-2"></i> Adicionar
                        </button>
                    </div>

                    <div id="receiveInputs">
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
