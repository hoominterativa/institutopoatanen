@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    <div class="sche01-show">
        <section class="sche01-show__banner w-100"
            style="background-image: url({{ asset('storage/uploads/tmp/bg-banner-inner.jpg') }})">
            <header
                class="sche01-show__banner__content container d-flex flex-column align-items-center justify-content-center">
                <h1 class="sche01-show__banner__title text-center">Título do banner</h1>
                <h2 class="sche01-show__banner__subtitle text-center">Subtítulo</h2>
                <hr class="sche01-show__banner__line">
            </header>
        </section>

        <section class="sche01-show__cont">
            <div class="sche01-show__cont__body container">

                <article class="sche01-show__content d-flex flex-column">

                    <header class="sche01-show__content__header w-100 d-flex flex-row">
                        <div
                            class="sche01-show__content__date d-flex flex-column align-items-center justify-content-center">
                            <span class="sche01-show__content__day">Dia</span>
                            <span class="sche01-show__content__month">Mês</span>
                            <span class="sche01-show__content__year">Ano</span>
                        </div>

                        <div class="sche01-show__content__right d-flex flex-column align-items-start justify-content-start">
                            <h2 class="sche01-show__content__title">Título</h2>

                            <hr class="sche01-show__content__line">

                            <ul class="sche01-show__content__header__topics">
                                <li class="sche01-show__content__header__topics__item">
                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                        class="sche01-show__content__header__topics__item__icon">
                                    Horário
                                </li>
                                <li class="sche01-show__content__header__topics__item">
                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                        class="sche01-show__content__header__topics__item__icon">
                                    Descrição
                                </li>
                            </ul>
                        </div>
                    </header>

                    <main class="sche01-show__content__main d-flex flex-column">

                        <img src="{{ asset('storage/uploads/tmp/bg-gray.png') }}" alt=""
                            class="sche01-show__content__img">

                        <h3 class="sche01-show__content__subtitle">Descrição</h3>

                        <div class="sche01-show__content__desc">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida
                                sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et
                                arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit
                                amet, consecteturpretium sed. In et arcu eget purus mattis posuere. Donec tincidunt
                                dignissim faucibus. Lorem ipsum dolor sit amet, consecteturLorem ipsum dolor sit amet,
                                consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero.
                                Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis
                                posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consecteturpretium
                                sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum
                                dolor sit amet, consectetur</p>
                        </div>

                        <h3 class="sche01-show__content__subtitle">Local</h3>

                        <div class="sche01-show__content__desc">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida
                                sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et
                                arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit
                                amet, consecteturpretium sed. In et arc</p>
                        </div>

                        <a href="#" class="sche01-show__content__cta">
                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                class="sche01-show__content__cta__icon">
                            CTA
                        </a>
                    </main>

                </article>

                <aside class="sche01-show__cont__aside d-flex flex-column align-items-stretch justify-content-start">

                    <div class="sche01-form d-flex flex-column align-items-start justify-content-start">
                        <h4 class="sche01-form__subtitle">Subtitulo</h4>
                        <h3 class="sche01-form__title">Título</h3>

                        <div class="sche01-form__desc">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida
                                sollicitudin vel non</p>
                        </div>

                        {!! Form::open([
                            'route' => 'lead.store',
                            'method' => 'post',
                            'files' => true,
                            'class' =>
                                'send_form_ajax sche01-form__form d-flex w-100 flex-column align-items-stretch form-contact parsley-validate align-items-center',
                        ]) !!}

                        <div class="sche01-form__form__inputs d-flex flex-column w-100 align-items-stretch">
                            <input type="hidden" name="target_lead" value="TITULO COM DESCRIÇÃO Subtitulo">
                            {{-- <input type="hidden" name="target_send" value="{{ base64_encode($contactForm->email) }}"> --}}

                            @for ($i = 0; $i < 2; $i++)
                                @include('Client.Components.inputs', [
                                    'name' => 'name',
                                    // 'options' => $input->option,
                                    'placeholder' => 'Nome',
                                    'required' => false,
                                    'type' => 'text',
                                    'class' => 'col-md-8',
                                ])
                            @endfor

                            <label for="" class="sche01-form__form__checkbox-label">
                                <input type="checkbox" name='checkbox' id=""> Lorem ipsum dolor sit amet,
                                consectetur a
                            </label>
                        </div>

                        <button type="submit" class="sche01-form__cta">
                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" class="sche01-form__cta__icon"
                                alt="Ícone">
                            CTA
                        </button>
                        {!! Form::close() !!}
                    </div>

                    <ul class="sche01-month-categories w-100 d-flex flex-column align-items-stretch">
                        <li
                            class="sche01-month-categories__item w-100 position-relative d-flex align-items-center justify-content-between">
                            <a href="#" class="link-full"></a>

                            <h3 class="sche01-month-categories__item__title">Abril</h3>
                            <h4 class="sche01-month-categories__item__subtitle">
                                Eventos <span class="sche01-month-categories__item__counter">3</span>
                            </h4>
                        </li>

                        <li
                            class="sche01-month-categories__item w-100 position-relative d-flex align-items-center justify-content-between">
                            <a href="#" class="link-full"></a>

                            <h3 class="sche01-month-categories__item__title">Maio</h3>
                            <h4 class="sche01-month-categories__item__subtitle">
                                Eventos <span class="sche01-month-categories__item__counter">3</span>
                            </h4>
                        </li>


                    </ul>

                </aside>

            </div>
        </section>
    </div>
    {{-- Finish Content page Here --}}
    @foreach ($sections as $section)
        {!! $section !!}
    @endforeach
@endsection
