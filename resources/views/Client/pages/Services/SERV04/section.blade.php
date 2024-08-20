@if ($section)
    <section id="SERV04" class="serv04" {{-- BACKEND: Ocultar do painel style="background-image: url({{ asset('storage/' . $section->path_image_section_desktop) }});"
         --}}>
        @if ($section->title_section || $section->subtitle_section || $section->description_section)
            <header class="serv04__header">
                @if ($section->title_section)
                    <h2 class="serv04__header__title">{{ $section->title_section }}</h2>
                @endif
                @if ($section->subtitle_section)
                    <h3 class="serv04__header__subtitle">{{ $section->subtitle_section }}</h3>
                @endif


                @if ($section->description_section)
                    <div class="serv04__header__paragraph">
                        <p>
                            {!! $section->description_section !!}
                        </p>
                    </div>
                @endif

            </header>
        @endif
        @if ($services->count())
            <div class="serv04__services">
                <div class="serv04__services__swiper-wrapper swiper-wrapper">
                    @foreach ($services as $service)
                        <div class="serv04__services__item swiper-slide">
                            <a title="{{ $service->title }}"
                                href="{{ route('serv04.show', ['SERV04ServicesCategory' => $service->category->slug, 'SERV04Services' => $service->slug]) }}"
                                class="link-full"></a>

                            @if ($service->path_image_box)
                                <img class="serv04__services__item__bg"
                                    src="{{ asset('storage/' . $service->path_image_box) }}"
                                    alt="Imagem de fundo do serviço {{ $service->title }}" loading="lazy">
                            @endif

                            @if ($service->path_image_icon)
                                <img class="serv04__services__item__icon"
                                    src="{{ asset('storage/' . $service->path_image_icon) }}" alt="Logo"
                                    loading="lazy">
                            @endif

                            @if ($service->title)
                                <h4 class="serv04__services__item__title">{{ $service->title }}</h4>
                            @endif

                            @if ($service->description)
                                <div class="serv04__services__item__paragraph">
                                    <p>
                                        {!! $service->description !!}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endforeach

                </div>


            </div>
        @endif
        <a class="serv04__cta" title="Ver todos"
            href="{{ route('serv04.category.page', ['SERV04ServicesCategory' => $category->slug]) }}"
            class="serv04__cta transition justify-content-center align-items-center">
            CTA
        </a>
    </section>
@endif
