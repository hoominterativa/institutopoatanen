@if ($contents->count())
    @foreach ($contents as $content)
        <section class="cont08" id="#CONT08"
            style="background-image: url({{ asset('storage/' . $content->path_image_desktop) }}); background-color: {{ $content->background_color }};">
            @if ($content->path_image)
                <figure class="cont08__image">
                    <img class="cont08__image__img" src="{{ asset('storage/' . $content->path_image) }}" alt="Imagem">
                </figure>
            @endif
            <div class="cont08__information">
                @if ($content->title || $content->subtitle)
                    <header class="cont08__information__header">
                        <h2 class="cont08__information__header__title">{{ $content->title }}</h2>
                        <h3 class="cont08__information__header__subtitle">{{ $content->subtitle }}</h3>
                        <hr class="cont08__information__header__line">
                    </header>
                @endif
                @if ($content->text)
                    <div class="cont08__information__description">
                        {!! $content->text !!}
                    </div>
                @endif
                @if ($content->topics->count())
                    <div class="cont08__information__content">
                        <div class="cont08__information__content__carousel">
                            @foreach ($content->topics as $topic)
                                <article class="cont08__information__content__item">
                                    @if ($topic->path_image)
                                        <img class="cont08__information__content__item__icon"
                                            src="{{ asset('storage/' . $topic->path_image) }}" alt="Ícone">
                                    @endif
                                    @if ($topic->description)
                                        <div class="cont08__information__content__item__description">
                                            {!! $topic->description !!}
                                        </div>
                                    @endif
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if ($content->link_button)
                    <a href="{{ getUri($content->link_button) }}" target="{{ $content->target_link_button }}" class="cont08__information__cta">
                        <img src="{{ asset('storage/uploads/tmp/icon-black.svg') }}" alt="Ícone" class="cont08__information__cta__icon">
                        {{ $content->title_button }}
                    </a>
                @endif
            </div>
        </section>
    @endforeach
@endif
