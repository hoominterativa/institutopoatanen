@if ($contents)
    @foreach ($contents as $content)
        <section id="CONT02V1" class="cont02v1">
            @if ($content->path_image)
                <div class="cont02v1__image">
                    <img src="{{ asset('storage/' . $content->path_image) }}" class="cont02v1__image__img animation fadeInRight"
                        alt="Imagem do conteúdo {{ $content->title }}" loading="lazy" />
                </div>
            @endif

            @if ($content->title || $content->subtitle || $content->description)
                <div class="cont02v1__information">
                    @if ($content->title)
                        <h2 class="cont02v1__information__title animation fadeInLeft">{{ $content->title }}</h2>
                    @endif

                    @if ($content->subtitle)
                        <h3 class="cont02v1__information__subtitle animation fadeInLeft">{{ $content->subtitle }}</h3>
                    @endif

                    @if ($content->description)
                        <div class="cont02v1__information__paragraph animation fadeInLeft">
                            <p>
                                {!! $content->description !!}
                            </p>
                        </div>
                    @endif

                    @if ($content->link_button)
                        <a href="{{ getUri($content->link_button) }}" target="{{ $content->target_link_button }}"
                            class="cont02v1__information__cta animation fadeInLeft">
                            @if ($content->title_button)
                                <span>
                                    {{ $content->title_button }}
                                </span>
                            @endif
                        </a>
                    @endif

                </div>
            @endif
        </section>
    @endforeach
@endif
