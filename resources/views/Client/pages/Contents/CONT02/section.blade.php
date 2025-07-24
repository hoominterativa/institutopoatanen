@if ($contents)
    @foreach ($contents as $content)
        <section id="CONT02" class="cont02">
            @if ($content->path_image)
                <div class="cont02__image">
                    <img src="{{ asset('storage/' . $content->path_image) }}" class="cont02__image__img"
                        alt="Imagem do conteúdo {{ $content->title }}" loading="lazy" />
                </div>
            @endif

            @if ($content->title || $content->subtitle || $content->description)
                <div class="cont02__information">
                    @if ($content->title)
                        <h2 class="cont02__information__title">{!! $content->title !!}</h2>
                    @endif

                    {{-- @if ($content->subtitle)
                        <h3 class="cont02__information__subtitle">{{ $content->subtitle }}</h3>
                    @endif --}}

                    @if ($content->description)
                        <div class="cont02__information__paragraph">
                            <p>
                                {!! $content->description !!}
                            </p>
                        </div>
                    @endif

                    @if ($content->link_button)
                        <a href="{{ getUri($content->link_button) }}" target="{{ $content->target_link_button }}"
                            class="cont02__information__cta">
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
