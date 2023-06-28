@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}

    <section class="prod05-show">
        <header class="prod05-show__banner" style="background-image: url({{asset('storage/uploads/tmp/bg-banner-inner.jpg')}})">
            <div class="prod05-show__banner__container container">
                <div class="prod05-show__banner__description">
                    <h3 class="prod05-show__banner__title">Título do Banner</h3>
                    <h4 class="prod05-show__banner__subtitle">Subtítulo</h4>
                    <hr class="prod05-show__banner__line">
                </div>
                {{-- END .prod05-show__banner__description --}}
            </div>
            {{-- END .prod05-show__banner__container --}}
        </header>
        {{-- END .prod05-show__banner --}}
        <main>
            <div class="prod05-show__contentTitle">
                <div class="prod05-show__contentTitle__container container">
                    <div class="prod05-show__wrapForm">
                        <button class="prod05-show__btnForm prod05-show__btnForm--showForm" type="button">Faça seu Orçamento</button>

                        {!! Form::open(['route' => 'lead.store', 'method' => 'post', 'files' => true, 'class'=>'send_form_ajax prod05-show__form parsley-validate']) !!}
                            <input type="hidden" name="target_lead" value="Produtos">
                            <input type="hidden" name="target_send" value="anderson@hoom.com.br">
                            @include('Client.Components.inputs', [
                                'name' => 'nome',
                                'options' => null,
                                'placeholder' => 'Nome',
                                'type' => 'text',
                                'required' => false
                            ])

                            @include('Client.Components.inputs', [
                                'name' => 'email',
                                'options' => null,
                                'placeholder' => 'E-mail',
                                'type' => 'email',
                                'required' => false
                            ])
                            @include('Client.Components.inputs', [
                                'name' => 'mensagem',
                                'options' => null,
                                'placeholder' => 'Mensagem',
                                'type' => 'textarea',
                                'required' => false
                            ])
                            {!! Form::submit('Enviar', ['class' => 'prod05-show__form__submit']) !!}
                        {!! Form::close() !!}
                    </div>
                    {{-- END .prod05-show__banner__wrapForm --}}

                    <div class="prod05-show__contentTitle__wrap">
                        <div class="row">
                            <div class="col-12 col-md-6"></div>
                            <div class="col-12 col-md-6 prod05-show__contentTitle__sideRight">
                                <h1 class="prod05-show__contentTitle__title">Título do Produto</h1>
                                <h3 class="prod05-show__contentTitle__subtitle">Categoria</h3>
                                <hr class="prod05-show__contentTitle__line">
                            </div>
                        </div>
                    </div>
                    {{-- END .prod05-show__contentTitle__wrap --}}
                </div>
                {{-- END .prod05-show__content__container --}}
            </div>
            {{-- END .prod05-show__contentTitle --}}
            <div class="prod05-show__info">
                    <div class="prod05-show__info__container container">
                    <div class="row">
                        <div class="col-12 col-md-6 prod05-show__info__gallery">
                            <div class="prod05-show__info__gallery__wrap">
                                <img src="{{ asset('storage/uploads/tmp/gall01_image1.png') }}" width="100%" class="prod05-show__info__gallery__imgMain" alt="Título do Produto">
                                <div class="prod05-show__info__gallery__carousel">
                                    <img src="{{ asset('storage/uploads/tmp/gall01_image1.png') }}" class="prod05-show__info__gallery__thumbnail" alt="Título do Produto">
                                    <img src="{{ asset('storage/uploads/tmp/thumbnail.png') }}" class="prod05-show__info__gallery__thumbnail" alt="Título do Produto">
                                    <img src="{{ asset('storage/uploads/tmp/thumbnail.png') }}" class="prod05-show__info__gallery__thumbnail" alt="Título do Produto">
                                    <img src="{{ asset('storage/uploads/tmp/thumbnail.png') }}" class="prod05-show__info__gallery__thumbnail" alt="Título do Produto">
                                    <img src="{{ asset('storage/uploads/tmp/thumbnail.png') }}" class="prod05-show__info__gallery__thumbnail" alt="Título do Produto">
                                    <img src="{{ asset('storage/uploads/tmp/thumbnail.png') }}" class="prod05-show__info__gallery__thumbnail" alt="Título do Produto">
                                    <img src="{{ asset('storage/uploads/tmp/thumbnail.png') }}" class="prod05-show__info__gallery__thumbnail" alt="Título do Produto">
                                    <img src="{{ asset('storage/uploads/tmp/thumbnail.png') }}" class="prod05-show__info__gallery__thumbnail" alt="Título do Produto">
                                </div>
                            </div>
                            {{-- END .prod05-show__info__gallery__wrap --}}
                            <div class="prod05-show__info__gallery__options">
                                <a href="#" class="prod05-show__info__gallery__options__item prod05-show__info__gallery__options__item--active "><span></span></a>
                                <a href="#" class="prod05-show__info__gallery__options__item"><span></span></a>
                                <a href="#" class="prod05-show__info__gallery__options__item"><span></span></a>
                            </div>
                        </div>
                        {{-- END .prod05-show__info__gallery --}}
                        <div class="col-12 col-md-6 prod05-show__info__description">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibusbero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus.
                                bero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibusbero. Vivamus commodo porta velit, vel tempus mLorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. D
                            </p>
                            <a href="#" class="prod05-show__info__description__cta">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="31px" class="me-2" alt="">
                                CTA
                            </a>
                        </div>
                        {{-- END .prod05-show__info__description --}}
                    </div>
                    {{-- END .row --}}
                </div>
                {{-- END .container --}}
            </div>
            {{-- END .prod05-show__content__info --}}
            <div class="prod05-show__galleries prod05-show__galleries__carousel row justify-content-center">
                <a href="{{ asset('storage/uploads/tmp/gall01_image1.png') }}" class="col px-0" data-fancybox="titulo-do-produto">
                    <img src="{{ asset('storage/uploads/tmp/gall01_image1.png') }}" width="100%" class="prod05-show__galleries__thumbnail" alt="Título do Produto">
                </a>
                <a href="{{ asset('storage/uploads/tmp/gall01_image2.png') }}" class="col px-0" data-fancybox="titulo-do-produto">
                    <img src="{{ asset('storage/uploads/tmp/gall01_image2.png') }}" width="100%" class="prod05-show__galleries__thumbnail" alt="Título do Produto">
                </a>
                <a href="{{ asset('storage/uploads/tmp/gall01_image1.png') }}" class="col px-0" data-fancybox="titulo-do-produto">
                    <img src="{{ asset('storage/uploads/tmp/gall01_image1.png') }}" width="100%" class="prod05-show__galleries__thumbnail" alt="Título do Produto">
                </a>
                <a href="{{ asset('storage/uploads/tmp/gall01_image2.png') }}" class="col px-0" data-fancybox="titulo-do-produto">
                    <img src="{{ asset('storage/uploads/tmp/gall01_image2.png') }}" width="100%" class="prod05-show__galleries__thumbnail" alt="Título do Produto">
                </a>
                <a href="{{ asset('storage/uploads/tmp/gall01_image1.png') }}" class="col px-0" data-fancybox="titulo-do-produto">
                    <img src="{{ asset('storage/uploads/tmp/gall01_image1.png') }}" width="100%" class="prod05-show__galleries__thumbnail" alt="Título do Produto">
                </a>
                <a href="{{ asset('storage/uploads/tmp/gall01_image2.png') }}" class="col px-0" data-fancybox="titulo-do-produto">
                    <img src="{{ asset('storage/uploads/tmp/gall01_image2.png') }}" width="100%" class="prod05-show__galleries__thumbnail" alt="Título do Produto">
                </a>
            </div>
            {{-- END .prod05-show__galleries --}}

            <div class="prod05-show__details">
                <div class="prod05-show__details__header">
                    <div class="container">
                        <h4 class="prod05-show__details__header__title">Título</h4>
                        <h4 class="prod05-show__details__header__subtitle">Subtitulo</h4>
                        <hr class="prod05-show__details__header__line">
                    </div>
                </div>
                {{-- END .prod05-show__details__header --}}
                <div class="prod05-show__details__content">
                    <div class="container">
                        <ul class="prod05-show__details__content__nav-tabs nav nav-tabs mb-3">
                            <li class="prod05-show__details__content__nav-item nav-item" role="presentation">
                                <button class="prod05-show__details__content__nav-link nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#categoria1" type="button" role="tab">
                                    Categoria 1
                                </button>
                            </li>
                            <li class="prod05-show__details__content__nav-item nav-item" role="presentation">
                                <button class="prod05-show__details__content__nav-link nav-link" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#categoria2" type="button" role="tab">
                                    Categoria 2
                                </button>
                            </li>
                        </ul>
                    </div>
                    {{-- END .container --}}
                    <div class="prod05-show__details__content__tab-content tab-content" id="pills-tabContent">
                        <div class="prod05-show__details__content__tab-pane tab-pane fade show active" id="categoria1" role="tabpanel">
                            <div class="container">
                                <div class="prod05-show__details__content__accordion accordion">
                                    <div class="prod05-show__details__content__accordion-item accordion-item">
                                        <button class="prod05-show__details__content__accordion-button accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#category1" aria-expanded="true">
                                            Título 1
                                        </button>
                                        <div id="category1" class="prod05-show__details__content__accordion-collapse accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                            </div>
                                        </div>
                                    </div>
                                    {{-- END .prod05-show__details__content__accordion-item --}}
                                    <div class="prod05-show__details__content__accordion-item accordion-item">
                                        <button class="prod05-show__details__content__accordion-button accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#category5" aria-expanded="false">
                                            Título 2
                                        </button>
                                        <div id="category5" class="prod05-show__details__content__accordion-collapse accordion-collapse collapse">
                                            <div class="accordion-body">
                                                <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                            </div>
                                        </div>
                                    </div>
                                    {{-- END .prod05-show__details__content__accordion-item --}}
                                </div>
                                {{-- END .prod05-show__details__content__accordion --}}
                            </div>
                            {{-- END .container --}}
                        </div>
                        {{-- END .prod05-show__details__content__tab-pane --}}
                        <div class="prod05-show__details__content__tab-pane tab-pane fade" id="categoria2" role="tabpanel">
                            <div class="container">
                                <div class="prod05-show__details__content__accordion accordion">
                                    <div class="prod05-show__details__content__accordion-item accordion-item">
                                        <button class="prod05-show__details__content__accordion-button accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#category2" aria-expanded="true">
                                            Accordion Item #1
                                        </button>
                                        <div id="category2" class="prod05-show__details__content__accordion-collapse accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- END .container --}}
                        </div>
                        {{-- END .prod05-show__details__content__tab-pane --}}
                    </div>
                    {{-- END .prod05-show__details__content__tab-content --}}
                </div>
                {{-- END .prod05-show__details__content --}}
            </div>
            {{-- END .prod05-show__details --}}
        </main>
    </section>
    {{-- END .prod05-show --}}

    {{-- Finish Content page Here --}}
    @foreach ($sections as $section)
        {!!$section!!}
    @endforeach
@endsection
