@if ($contents)
    @foreach ($contents as $content)
        <section id="CONT02V2" class="cont02v2">
            @if ($content->path_image)
                <div class="cont02v2__image">
                    <img src="{{ asset('storage/' . $content->path_image) }}" class="cont02v2__image__img animation fadeInUp"
                        alt="Imagem do conteúdo {{ $content->title }}" loading="lazy" />
                </div>
            @endif

            @if ($content->title || $content->subtitle || $content->description)
                <div class="cont02v2__information">
                    @if ($content->title)
                        <h2 class="cont02v2__information__title animation fadeInUp">{{ $content->title }}</h2>
                    @endif

                    @if ($content->subtitle)
                        <h3 class="cont02v2__information__subtitle animation fadeInUp">{{ $content->subtitle }}</h3>
                    @endif

                    @if ($content->description)
                        <div class="cont02v2__information__paragraph animation fadeInUp">
                            {!! $content->description !!}
                        </div>
                    @endif

                    @if ($content->link_button)
                        <a href="{{ getUri($content->link_button) }}" target="{{ $content->target_link_button }}"
                            class="cont02v2__information__cta animation fadeInUp">
                            @if ($content->title_button)
                                {{ $content->title_button }}
                            @endif
                        </a>
                    @endif

                </div>
            @endif
        </section>
    @endforeach
@endif
