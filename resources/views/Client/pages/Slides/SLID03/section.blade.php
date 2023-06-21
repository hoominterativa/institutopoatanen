<section id="SLID03" class="slid03" style="background-image: url({{ asset('storage/uploads/tmp/bg-slide.jpg') }})">
    <div class="container slid03__container h-100">
        <div class="d-flex align-items-center slid03__content h-100">
            <div class="slid03__leftside col-12 col-md-6">
                <div class="slid03__content__text">
                    <h2>Armazzém <br><b>Clube pet</b></h2><br>
                    <h5>Mime seu pet com economia 🐶🐱😍</h5><br>
                    <p>
                        ✓ Ofertas exclusivas <b>no</b> seu CPF<br>
                        ✓ Compre na loja física, site ou app<br>
                        ✓ Promoções e parceria com grandes marcas
                    </p>
                </div>
                <a href="#" class="slid03__content__cta">e muito mais</a>
            </div>
            <div class="slid03__rightside col-12 col-md-6">
                <div class="slid03__content__form">
                    <h4 class="slid03__content__form__title">Cadastre-se no Club Pet</h4>
                    {!! Form::model(null, ["class" => "slid03__form__item", "method" => "POST", "files" => true]) !!}
                        <input type="hidden" name="target_lead" value="Razão do formulário">
                        <input type="hidden" name="target_send" value="anderson@hoom.com.br">
                        <div class="slid03__content__form__item__input col-12">
                            @include('Client.Components.inputs', [
                                'name' => 'name',
                                'options' => '',
                                'placeholder' => "Seu Nome",
                                'type' => 'text',
                                'required' => true,
                            ])
                        </div>
                        <div class="slid03__content__form__item__input col-12">
                            @include('Client.Components.inputs', [
                                'name' => 'cellphone',
                                'options' => '',
                                'placeholder' => "Celular",
                                'type' => 'cellphone',
                                'required' => true,
                            ])
                        </div>
                        <div class="slid03__content__form__item__input col-12">
                            @include('Client.Components.inputs', [
                                'name' => 'email',
                                'options' => '',
                                'placeholder' => "E-mail",
                                'type' => 'email',
                                'required' => true,
                            ])
                        </div>
                        <button type="submit" class="slid03__content__form__item__submit d-flex align-items-center">
                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="30" class="me-3">
                            Continuar
                        </button>
                        <a href="#slid03__lightbox__form" class="slid03__content__form__targetLightnbox" data-fancybox="formulario-de-cadastro">asdas</a>
                        @include('Client.pages.Slides.SLID03.show')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</section>
<hr>
