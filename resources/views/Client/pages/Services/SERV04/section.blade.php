@if ($section)
    <section id="SERV04" class="serv04 container-fluid position-absolute"
        style="background-image: url({{ asset('storage/' . $section->path_image_section_desktop) }}); background-color: {{ $section->background_color_section }};">
        <div class="serv04__mask"></div>
        <header class="serv04__header">
            @if ($section->title_section || $section->subtitle_section)
                <h2 class="container container--serv04 d-block text-center">
                    <span class="serv04__header__title d-block">{{ $section->title_section }}</span>
                    <span class="serv04__header__subtitle d-block">{{ $section->subtitle_section }}</span>
                    <hr class="serv04__header__line mb-0">
                </h2>
            @endif
            <div class="serv04__header__paragraph mx-auto text-center">
                @if ($section->description_section)
                    <p>
                        {!! $section->description_section !!}
                    </p>
                @endif
            </div>
        </header>
        <main class="serv04__content">
            <div class="container">
                <div class="carousel-serv04 owl-carousel">
                    @foreach ($services as $service)
                        <div class="serv04__box w-100">
                            <div class="serv04__box__content">
                                <a href="{{ route('serv04.page.content', ['SERV04ServicesCategory' => $service->category->slug, 'SERV04Services' => $service->slug]) }}"
                                    rel="next" class="link-full"></a>
                                <div class="serv04__box__bg">
                                    @if ($service->path_image_box)
                                        <img src="{{ asset('storage/' . $service->path_image_box) }}" alt="Logo"
                                            loading="lazy">
                                    @endif
                                </div>
                                <div class="serv04__box__description">
                                    <div class="serv04__box__image">
                                        @if ($service->path_image_icon)
                                            <img src="{{ asset('storage/' . $service->path_image_icon) }}"
                                                alt="Logo" loading="lazy">
                                        @endif
                                    </div>
                                    @if ($service->title)
                                        <h4 class="serv04__box__title">{{ $service->title }}</h4>
                                    @endif
                                    <div class="serv04__box__paragraph">
                                        @if ($service->description)
                                            <p>
                                                {!! $service->description !!}
                                            </p>
                                        @endif
                                    </div>
                                    <a rel="next" href="{{ route('serv04.page.content', ['SERV04ServicesCategory' => $service->category->slug, 'SERV04Services' => $service->slug]) }}"
                                        class="serv04__box__cta transition justify-content-center align-items-center">
                                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="Icone CTA"
                                            class="serv04__box__cta__icon me-3 transition">
                                        CTA
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{-- END .serv04__box --}}
                </div>
                <a rel="next" href="{{route('serv04.category.page', ['SERV04ServicesCategory' => $category->slug])}}"
                    class="serv04__cta transition justify-content-center align-items-center">
                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="Icone CTA"
                        class="serv04__cta__icon me-3 transition">
                    CTA
                </a>
            </div>
        </main>
    </section>
@endif
