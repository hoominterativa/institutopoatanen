<section id="lightbox-topi102-{{ $topic->id }}" class="topi102-show"
    style="background: url({{ asset('storage/' . $topic->path_image_background_lightbox) }});">
    <div class="topi102-show__left">
        @if ($topic->title || $topic->subtitle)
            <h2 class="topi102-show__title">{{$topic->title}}</h2>
            <h3 class="topi102-show__subtitle">{{$topic->subtitle}}</h3>
            <hr class="topi102-show__line">
        @endif
        <div class="topi102-show__description">
            <p>
                {!! $topic->text !!}
            </p>
        </div>
        @if ($topic->link_button)
            <a href="{{getUri($topic->link_button)}}" target="{{$topic->target_link_button}}" class="topi102-show__cta">
                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="ícone do botão"class="topi102-show__cta__icon">
                {{$topic->title_button}}
            </a>
        @endif
    </div>
    @if ($topic->path_image_lightbox)
        <img src="{{ asset('storage/' . $topic->path_image_lightbox) }}" alt="título do tópico" class="topi102-show__image">
    @endif
</section>
