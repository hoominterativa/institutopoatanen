@extends('Client.Core.client')
@section('content')
    @if ($units->count())
        <main id="root" class="unit01-page">
            @if ($section)
                @if ($section->title_banner || $section->subtitle_banner)
                    <section class="unit01-page__banner"
                        style="background-image: url({{ asset('storage/' . $section->path_image_desktop_banner) }})">
                        @if ($section->title_banner)
                            <h1 class="unit01-page__banner__title ">{{ $section->title_banner }}</h1>
                        @endif
                        @if ($section->subtitle_banner)
                            <h2 class="unit01-page__banner__subtitle">{{ $section->subtitle_banner }}</h2>
                        @endif
                    </section>
                @endif
            @endif

            @if ($units->count() > 0)
                <div class="unit01-page__main">
                    @foreach ($units as $unit)
                        <article class="unit01-page__main__item">
                            <div class="unit01-page__main__item__information">

                                @if ($unit->title_unit)
                                    <h4 class="unit01-page__main__item__information__title">{{ $unit->title_unit }}</h4>
                                @endif

                                @if ($unit->title)
                                    <h5 class="unit01-page__main__item__information__subtitle">{{ $unit->title }}</h5>
                                @endif

                                @if ($unit->description)
                                    <div class="">
                                        {!! $unit->description !!}
                                    </div>
                                @endif
                                @if ($unit->topics->count() > 0)
                                    <div class="unit01-page__main__item__information__topics">
                                        @foreach ($unit->topics as $topic)
                                            <div class="unit01-page__main__item__information__topics__item">
                                                @if ($topic->path_image_icon)
                                                    <img loading='lazy'
                                                        src="{{ asset('storage/' . $topic->path_image_icon) }}"
                                                        alt="Ícone do tópico  {{ $topic->title }}"
                                                        class="unit01-page__main__item__information__topics__item__image">
                                                @endif

                                                @if ($topic->title)
                                                    <h6 class="unit01-page__main__item__information__topics__item__title">
                                                        {{ $topic->title }}</h6>
                                                @endif
                                                @if (!empty($topic->link))
                                                    <a href="{{ getUri($topic->link) }}" target="_blank"
                                                        class="link-full"></a>
                                                @else
                                                    <a data-fancybox="{{ $topic->title }}"
                                                        href="#unit01-show-{{ $topic->id }}" class="link-full"></a>
                                                    @include('Client.pages.Units.UNIT01.show', [
                                                        'topic' => $topic,
                                                        'galleries' => $unit->galleries,
                                                    ])
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            @if ($unit->galleries->count() > 0)
                                <div class="unit01-page__main__item__gallery">
                                    <div class="unit01-page__main__item__gallery__swiper-wrapper swiper-wrapper">
                                        @foreach ($unit->galleries as $gallery)
                                            <img class="unit01-page__main__item__gallery__item" loading='lazy'
                                                src="{{ asset('storage/' . $gallery->path_image) }}"
                                                alt="Imagem relacionada ao {{ $unit->title }}">
                                        @endforeach
                                    </div>

                                    <div class="unit01-page__main__item__gallery__swiper-button-prev swiper-button-prev">
                                    </div>
                                    <div class="unit01-page__main__item__gallery__swiper-button-next swiper-button-next">
                                    </div>
                                </div>
                            @endif

                        </article>
                    @endforeach
                </div>
            @endif


            @foreach ($sections as $section)
                {!! $section !!}
            @endforeach
        </main>
    @endif

@endsection
