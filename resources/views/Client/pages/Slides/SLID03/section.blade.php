<section id="SLID03" class="slid03" style="background-image: url({{ asset('storage/' . $slide->path_image_desktop) }})">
    <div class="container slid03__container h-100">
        <div class="d-flex align-items-center slid03__content h-100">
            <div class="slid03__leftside col-12 col-md-6">
                <div class="slid03__content__text">
                    {!!$slide->description!!}
                </div>
                @if ($slide->link)
                    <a href="{{$slide->link}}" target="{{$slide->target_link}}" class="slid03__content__cta">{{$slide->title_button}}</a>
                @endif
            </div>
            <div class="slid03__rightside col-12 col-md-6">
                @if ($form)
                    <div class="slid03__content__form">
                        <h4 class="slid03__content__form__title">{{$form->title}}</h4>
                        {!! Form::model(null, ["class" => "slid03__form__item", "method" => "POST", "files" => true]) !!}
                            @foreach ($inputs as $name => $input)
                                <div class="slid03__content__form__item__input col-12">
                                    @include('Client.Components.inputs', [
                                        'name' => $name,
                                        'options' => $input->option,
                                        'placeholder' => $input->placeholder,
                                        'type' => $input->type,
                                        'required' => isset($input->required) ? $input->required : false,
                                    ])
                                </div>
                            @endforeach
                            <button type="submit" class="slid03__content__form__item__submit d-flex align-items-center">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="30" class="me-3">
                                Continuar
                            </button>
                        {!! Form::close() !!}

                        @include('Client.pages.Slides.SLID03.show',[
                            'form' => $form,
                            'inputs' => $inputs,
                            'inputsAdditionals' => $inputsAdditionals,
                        ])
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
