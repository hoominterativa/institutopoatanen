@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    <section class="unit03-show__banner"
        style="background-image: url({{ asset('storage/uploads/tmp/bg-section-dark-gray.jpg') }})">
        <header class="unit03-show__banner__content container d-flex flex-column align-items-center justify-content-center">
            <h1 class="unit03-show__banner__title text-center">Título da Página</h1>
            <h2 class="unit03-show__banner__subtitle text-center">Subtítulo</h2>
            <hr class="unit03-show__banner__line">
        </header>
    </section>

    <section class="unit03-show__top">
        <div class="unit03-show__top__left d-flex flex-column align-items-stretch">

            <div class="unit03-show__top__upper">
                <img src="{{ asset('storage/uploads/tmp/thumbnail.png') }}" alt="" class="unit03-show__top__img">

                <div class="unit03-show__top__ttl-grp d-flex flex-column align-items-start">
                    <h3 class="unit03-show__top__subtitle">Subtítulo</h3>
                    <h2 class="unit03-show__top__title">Título</h2>
                    <span class="unit03-show__top__category d-flex align-items-center">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                            class="unit03-show__top__category__icon">
                        Categoria
                    </span>
                    <hr class="unit03-show__top__line">

                    <ul class="unit03-show__top__social">

                        @for ($i = 0; $i < 5; $i++)
                            <li class="unit03-show__top__social__item">
                                <a href="#" target="_blank">
                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="">
                                </a>
                            </li>
                        @endfor

                    </ul>

                </div>
            </div>

            <div class="unit03-show__top__carousel owl-carousel">

                @for ($i = 0; $i < 4; $i++)
                    <div class="unit03-show__top__carousel__item d-flex justify-content-start align-items-center">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                            class="unit03-show__top__carousel__item__icon">

                        <div
                            class="unit03-show__top__carousel__item__content d-flex flex-column justify-content-center align-items-start">
                            <h3 class="unit03-show__top__carousel__item__title">Título</h3>
                            <p class="unit03-show__top__carousel__item__desc">Descrição</p>
                        </div>
                    </div>
                @endfor

            </div>
        </div>

        <div class="unit03-show__top__form">

            <h4 class="unit03-show__top__form__subtitle">Subtítulo</h4>
            <h3 class="unit03-show__top__form__title">Título</h3>
            <hr class="unit03-show__top__form__line">

            {!! Form::open([
                'route' => 'lead.store',
                'method' => 'post',
                'files' => true,
                'class' =>
                    'send_form_ajax unit03-show__top__form__item d-flex w-100 flex-column align-items-stretch form-contact parsley-validate align-items-center',
            ]) !!}

            <div class="sche01-form__form__inputs d-flex flex-column w-100 align-items-stretch">
                <input type="hidden" name="target_lead" value="TITULO COM DESCRIÇÃO Subtitulo">
                {{-- <input type="hidden" name="target_send" value="{{ base64_encode($contactForm->email) }}"> --}}

                @for ($i = 0; $i < 3; $i++)
                    @include('Client.Components.inputs', [
                        'name' => 'name',
                        // 'options' => $input->option,
                        'placeholder' => 'Nome',
                        'required' => false,
                        'type' => 'text',
                        'class' => 'col-md-8',
                    ])
                @endfor

                @include('Client.Components.inputs', [
                    'name' => 'name',
                    // 'options' => $input->option,
                    'placeholder' => 'Nome',
                    'required' => false,
                    'type' => 'textarea',
                    'class' => 'col-md-8',
                ])

            </div>

            <button type="submit" class="unit03-show__top__form__cta">
                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" class="unit03-show__top__form__cta__icon"
                    alt="Ícone">
                CTA
            </button>
            {!! Form::close() !!}

        </div>
    </section>

    <section class="unit03-show__content" style="background-image: url({{ asset('storage/uploads/tmp/box-branco.png') }})">
        <div class="container unit03-show__content__container">

            <div class="unit03-show__content__carousel owl-carousel">

                @for ($i = 0; $i < 4; $i++)
                    <div class="unit03-show__content__carousel__item">
                        <img src="{{ asset('storage/uploads/tmp/thumbnail-b.png') }}" alt="">
                    </div>
                @endfor

            </div>

            <div class="unit03-show__content__right">
                <h4 class="unit03-show__content__subtitle">Subtítulo</h4>
                <h3 class="unit03-show__content__title">Título</h3>
                <hr class="unit03-show__content__line">

                <div class="unit03-show__content__text">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida
                        sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu
                        eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet,
                        consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero.
                        Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere.
                        Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel
                        tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec </p>
                </div>

                <a href="#" class="unit03-show__content__cta">
                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                        class="unit03-show__content__cta__icon">
                    CTA
                </a>
            </div>

        </div>
    </section>

    <section class="unit03-show__content" style="background-image: url({{ asset('storage/uploads/tmp/box2copa02.png') }})">
        <div class="container unit03-show__content__container">

            <div class="unit03-show__content__carousel owl-carousel">

                @for ($i = 0; $i < 4; $i++)
                    <div class="unit03-show__content__carousel__item">
                        <img src="{{ asset('storage/uploads/tmp/thumbnail-b.png') }}" alt="">
                    </div>
                @endfor

            </div>

            <div class="unit03-show__content__right">
                <h4 class="unit03-show__content__subtitle">Subtítulo</h4>
                <h3 class="unit03-show__content__title">Título</h3>
                <hr class="unit03-show__content__line">

                <div class="unit03-show__content__text">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida
                        sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu
                        eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet,
                        consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero.
                        Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere.
                        Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel
                        tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec </p>
                </div>

                <a href="#" class="unit03-show__content__cta">
                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                        class="unit03-show__content__cta__icon">
                    CTA
                </a>
            </div>

        </div>
    </section>

    <section class="unit03-show__gallery">
        <div class="container">

            <header class="unit03-show__gallery__header d-flex flex-column align-items-center">
                <h4 class="unit03-show__gallery__subtitle">Subtítulo</h4>
                <h3 class="unit03-show__gallery__title">Título</h3>
                <hr class="unit03-show__gallery__line">
            </header>

            <div class="unit03-show__gallery__list">

                @for ($i = 0; $i < 8; $i++)
                    <div class="unit03-show__gallery__item">
                        <img src="{{ asset('storage/uploads/tmp/thumbnail.png') }}" alt="">

                        <h3 class="unit03-show__gallery__item__title">Título</h3>
                    </div>
                @endfor

                <div class="unit03-show__gallery__item--big">
                    <img src="{{ asset('storage/uploads/tmp/thumbnail-b.png') }}" alt="">

                    <h3 class="unit03-show__gallery__item__title">Título</h3>
                </div>

            </div>

        </div>
    </section>

    {{-- Finish Content page Here --}}
    @foreach ($sections as $section)
        {!! $section !!}
    @endforeach
@endsection
