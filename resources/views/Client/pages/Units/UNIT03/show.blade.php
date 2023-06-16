@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    @if ($bannerShow)
        <section class="unit03-show__banner"
        style="background-image: url({{ asset('storage/' . $bannerShow->path_image_desktop) }}); background-color: {{$bannerShow->background_color}}">
            <header class="unit03-show__banner__content container d-flex flex-column align-items-center justify-content-center">
                @if ($bannerShow->title || $bannerShow->subtitle)
                    <h1 class="unit03-show__banner__title text-center">{{$bannerShow->title}}</h1>
                    <h2 class="unit03-show__banner__subtitle text-center">{{$bannerShow->subtitle}}</h2>
                    <hr class="unit03-show__banner__line">
                @endif
            </header>
        </section>
    @endif

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

                    @if ($socials->count())
                        <ul class="unit03-show__top__social">
                            @foreach ( $socials as $social)
                                <li class="unit03-show__top__social__item">
                                    <a href="{{$social->link ? getUri($social->link) : 'javascript:void(0)'}}" target="{{ $social->target_link }}" rel="prev">
                                        @if ($social->path_image_icon)
                                            <img src="{{ asset('storage/' . $social->path_image_icon) }}" alt="">
                                        @endif
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
            @if ($topics->count())
                <div class="unit03-show__top__carousel owl-carousel">
                   @foreach ($topics as $topic)
                        <div class="unit03-show__top__carousel__item d-flex justify-content-start align-items-center">
                            @if ($topic->path_image_icon)
                                <img src="{{ asset('storage/' . $topic->path_image_icon) }}" alt="" class="unit03-show__top__carousel__item__icon">
                            @endif
                            <div
                                class="unit03-show__top__carousel__item__content d-flex flex-column justify-content-center align-items-start">
                                @if ($topic->title || $topic->description)
                                    <h3 class="unit03-show__top__carousel__item__title">{{$topic->title}}</h3>
                                    <p class="unit03-show__top__carousel__item__desc">{!! $topic->description!!}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
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

    @if ($contents->count())
        @foreach ($contents as $content)
            <section class="unit03-show__content" style="background-image: url({{ asset('storage/' . $content->path_image_desktop) }}); background-color: {{$content->background_color}}">
                <div class="container unit03-show__content__container">

                    {{-- @if ($galleryContents->count()) --}}
                        <div class="unit03-show__content__carousel owl-carousel">
                            @foreach ($content->galleryContents as $galleryContent)
                                <div class="unit03-show__content__carousel__item">
                                    @if ($galleryContent->path_image)
                                        <img src="{{ asset('storage/' . $galleryContent->path_image) }}" alt="">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    {{-- @endif --}}

                    <div class="unit03-show__content__right">
                        @if ($content->subtitle || $content->title)
                            <h4 class="unit03-show__content__subtitle">{{$content->subtitle}}</h4>
                            <h3 class="unit03-show__content__title">{{$content->title}}</h3>
                            <hr class="unit03-show__content__line">
                        @endif

                        <div class="unit03-show__content__text">
                            @if ($content->text)
                                <p>
                                    {!! $content->text !!}
                                </p>
                            @endif
                        </div>

                        <a rel="next" href="{{$content->link_button ? getUri($content->link_button) : 'javascript:void(0)'}}" target="{{ $content->target_link_button }}" class="unit03-show__content__cta">
                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                class="unit03-show__content__cta__icon">
                            @if ($content->title_button)
                                {{$content->title_button}}
                            @endif
                        </a>
                    </div>
                </div>
            </section>
        @endforeach
    @endif

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
