@extends('Client.Core.client')
@section('content')
    <main id="root" class="unit03-show">

        @if ($bannerShow)
            <section class="unit03-show__banner"
                style="background-image: url({{ asset('storage/' . $bannerShow->path_image_desktop) }}); background-color: {{ $bannerShow->background_color }}">
                @if ($bannerShow->title)
                    <h1 class="unit03-show__banner__title">{{ $bannerShow->title }}</h1>
                @endif

                @if ($bannerShow->subtitle)
                    <h2 class="unit03-show__banner__subtitle">{{ $bannerShow->subtitle }}</h2>
                @endif

            </section>
        @endif

        <section class="unit03-show__contact">

            <div class="unit03-show__contact__socials">
                @if ($unit->path_image_icon_show)
                    <img src="{{ asset('storage/' . $unit->path_image_icon_show) }}" alt=""
                        class="unit03-show__contact__socials__image">
                @endif

                <div class="unit03-show__contact__socials__information">
                    @if ($unit->title_show || $unit->subtitle_show)
                        <h3 class="unit03-show__contact__socials__information__subtitle">{{ $unit->subtitle_show }}</h3>
                        <h2 class="unit03-show__contact__socials__information__title">{{ $unit->title_show }}</h2>
                    @endif
                    <span class="unit03-show__contact__socials__information__category">
                        <img src="{{ asset('storage/' . $unit->category->path_image_icon) }}" alt=""
                            class="unit03-show__contact__socials__information__category__icon">
                        {{ $unit->category->title }}
                    </span>

                    @if ($socials->count())
                        <ul class="unit03-show__contact__socials__information__list">
                            @foreach ($socials as $social)
                                <li class="unit03-show__contact__socials__information__list__item">
                                    <a href="{{ $social->link ? getUri($social->link) : 'javascript:void(0)' }}"
                                        class="link-full" target="{{ $social->target_link }}" rel="prev">
                                    </a>
                                    @if ($social->path_image_icon)
                                        <img src="{{ asset('storage/' . $social->path_image_icon) }}" alt="">
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            @if ($topics->count())
                <div class="unit03-show__contact__topics">
                    <div class="unit03-show__contact__topics__carousel">
                        <div class="unit03-show__contact__topics__carousel__swiper-wrapper swiper-wrapper">

                            @foreach ($topics as $topic)
                                <div class="unit03-show__contact__topics__carousel__item swiper-slide">
                                    @if ($topic->path_image_icon)
                                        <img src="{{ asset('storage/' . $topic->path_image_icon) }}"
                                            alt=".unit03-show__contact__topics__carousel__item__icon"
                                            class="unit03-show__contact__topics__carousel__item__icon">
                                    @endif

                                    @if ($topic->title)
                                        <h3 class="unit03-show__contact__topics__carousel__item__title">{{ $topic->title }}
                                        </h3>
                                    @endif
                                    @if ($topic->description)
                                        <p class="unit03-show__contact__topics__carousel__item__paragraph">
                                            {!! $topic->description !!}</p>
                                    @endif
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            @endif

            @if ($contact)
                {!! Form::open([
                    'route' => 'lead.store',
                    'method' => 'post',
                    'files' => true,
                    'class' => 'send_form_ajax form-contact parsley-validate unit03-show__contact__form',
                ]) !!}

                @if ($contact->subtitle)
                    <h4 class="unit03-show__contact__form__subtitle">{{ $contact->subtitle }}</h4>
                @endif
                @if ($contact->title)
                    <h3 class="unit03-show__contact__form__title">{{ $contact->title }}</h3>
                @endif

                <input type="hidden" name="target_lead" value="{{ $contact->title }}">
                <input type="hidden" name="target_send" value="{{ base64_encode($contact->email) }}">

                @foreach ($inputs as $name => $input)
                    @include('Client.Components.inputs', [
                        'name' => $name,
                        'options' => $input->option,
                        'placeholder' => $input->placeholder,
                        'type' => $input->type,
                        'required' => isset($input->required) ? $input->required : false,
                    ])
                @endforeach

                <button type="submit" class="unit03-show__contact__form__cta">
                    @if ($contact->title_button)
                        {{ $contact->title_button }}
                    @endif
                </button>
                {!! Form::close() !!}
            @endif
        </section>

        @if ($contents->count())
            @foreach ($contents as $content)
                <section class="unit03-show__content" {{-- style="background-image: url({{ asset('storage/' . $content->path_image_desktop) }}); background-color: {{ $content->background_color }}" --}}>

                    <div class="unit03-show__content__carousel">
                        <div class="unit03-show__content__carousel__swiper-wrapper swiper-wrapper">

                            <div class="unit03-show__content__carousel__item swiper-slide">
                                @if ($content->path_image)
                                    <img src="{{ asset('storage/' . $content->path_image) }}" alt="Thumbnail">
                                @endif
                            </div>

                            @foreach ($content->galleryContents as $galleryContent)
                                <div class="unit03-show__content__carousel__item swiper-slide">
                                    @if ($galleryContent->path_image)
                                        <img src="{{ asset('storage/' . $galleryContent->path_image) }}"
                                            alt="Carousel image">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="unit03-show__content__information">
                        @if ($content->subtitle)
                            <h4 class="unit03-show__content__information__subtitle">{{ $content->subtitle }}</h4>
                        @endif
                        @if ($content->title)
                            <h3 class="unit03-show__content__information__title">{{ $content->title }}</h3>
                        @endif

                        @if ($content->text)
                            <div class="unit03-show__content__information__paragraph">
                                {!! $content->text !!}
                            </div>
                        @endif

                        @if ($content->link_button)
                            <a rel="next"
                                href="{{ $content->link_button ? getUri($content->link_button) : 'javascript:void(0)' }}"
                                target="{{ $content->target_link_button }}" class="unit03-show__content__information__cta">
                                @if ($content->title_button)
                                    {{ $content->title_button }}
                                @endif
                            </a>
                        @endif
                    </div>

                </section>
            @endforeach
        @endif

        <section class="unit03-show__gallery">

            @if ($sectionGallery)
                <header class="unit03-show__gallery__header">
                    @if ($sectionGallery->subtitle)
                        <h4 class="unit03-show__gallery__header__subtitle">{{ $sectionGallery->subtitle }}</h4>
                    @endif
                    @if ($sectionGallery->title)
                        <h3 class="unit03-show__gallery__header__title">{{ $sectionGallery->title }}</h3>
                    @endif
                </header>
            @endif

            @if ($galleries->count())
                <div class="unit03-show__gallery__list">

                    @foreach ($galleries as $gallery)
                        <div class="unit03-show__gallery__list__item {{ $gallery->link_video ? ' video' : '' }}">
                            <a class="link-full"
                                href="{{ getUri($gallery->link_video != '' ? $gallery->link_video : asset('storage/' . $gallery->path_image)) }}"
                                data-fancybox>
                            </a>
                            <img src="{{ asset('storage/' . $gallery->path_image) }}"
                                lass="unit03-show__gallery__list__item__image" alt="">
                            @if ($gallery->title)
                                <h3 class="unit03-show__gallery__list__item__title">{{ $gallery->title }}</h3>
                            @endif
                        </div>
                    @endforeach

                    <div class="unit03-show__gallery__list__item--big {{ $unit->link_video ? ' video' : '' }}">
                        <a href="{{ getUri($unit->link_video != '' ? $unit->link_video : asset('storage/' . $unit->path_image_gallery)) }}"
                            class="link-full" data-fancybox>
                        </a>
                        <img src="{{ asset('storage/' . $unit->path_image_gallery) }}"
                            class="unit03-show__gallery__list__item__image" alt="{{ $unit->title_gallery }}">
                        @if ($unit->title_gallery)
                            <h3 class="unit03-show__gallery__list__item__title">{{ $unit->title_gallery }}</h3>
                        @endif
                    </div>
                </div>
            @endif

        </section>

        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
