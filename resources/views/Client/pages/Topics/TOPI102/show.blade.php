<section id="lightbox-topi102-{{ $topic->id }}" class="topi102-show">

    @if ($topic->title_lightbox || $topic->subtitle || $topic->text)
        <div class="topi102-show__information">
            @if ($topic->title_lightbox || $topic->subtitle)
                @if ($topic->title_lightbox)
                    <h4 class="topi102-show__information__title">{{ $topic->title_lightbox }}</h4>
                @endif
                @if ($topic->subtitle)
                    <h5 class="topi102-show__information__subtitle">{{ $topic->subtitle }}</h5>
                @endif

                <hr class="topi102-show__information__line">
            @endif

            @if ($topic->text)
                <div class="topi102-show__information__paragraph">
                    <p>
                        {!! $topic->text !!}
                    </p>
                </div>
            @endif

            @if ($topic->link_button)
                <a title="{{ $topic->title_button }}" href="{{ getUri($topic->link_button) }}"
                    target="{{ $topic->target_link_button }}" class="topi102-show__information__cta">
                    {{ $topic->title_button }}
                </a>
            @endif
        </div>
    @endif

    @if ($topic->path_image_lightbox)
        <img src="{{ asset('storage/' . $topic->path_image_lightbox) }}" alt="título do tópico" loading="lazy"
            class="topi102-show__image">
    @endif
</section>
