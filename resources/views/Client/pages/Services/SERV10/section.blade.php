<section id="serv10" class="serv10">
    @if ($section)
        <header class="serv10__header">
            @if ($section->title_section)
                <h2 class="serv10__header__title">{{ $section->title_section }}</h2>
            @endif
            @if ($section->subtitle_section)
                <h3 class="serv10__header__subtitle">{{ $section->subtitle_section }}</h3>
            @endif
            @if ($section->description_section)
                <div class="serv10__header__paragraph">
                    <p>
                        {!! $section->description_section !!}
                    </p>
                </div>
            @endif
        </header>
    @endif
    @if ($services->count())
        <main class="serv10__main">
            <div class="serv10__main__carousel">
                <div class="serv10__main__carousel__swiper-wrapper swiper-wrapper">
                    @foreach ($services as $service)
                        <div class="serv10__main__item swiper-slide">
                            <a title="{{ $service->title_box }}"
                                href="{{ route('serv10.show', ['SERV10ServicesCategory' => $service->categories->slug, 'SERV10Services' => $service->slug]) }}"
                                class="link-full">
                            </a>
                            @if ($service->path_image_box)
                                <img src="{{ asset('storage/' . $service->path_image_box) }}"
                                    alt="imagem de background do {{ $service->title_box }}"
                                    class="serv10__main__item__bg">
                            @endif
                            @if ($service->path_image_icon_box)
                                <img src="{{ asset('storage/' . $service->path_image_icon_box) }}"
                                    alt="ícone do serviço {{ $service->title_box }}"
                                    class="serv10__main__item__icon">
                            @endif
                            @if ($service->title_box)
                                <h4 class="serv10__main__item__title">{{ $service->title_box }}
                                </h4>
                            @endif
                            @if ($service->description_box)
                                <div class="serv10__main__item__paragraph">
                                    <p>
                                        {!! $service->description_box !!}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="serv10__main__swiper-pagination swiper-pagination"></div>
        </main>
    @endif
</section>
