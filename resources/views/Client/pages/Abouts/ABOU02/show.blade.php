<div id="lightbox-abou02-{{ $topic->id }}" class="abou02-show">

    @if ($topic->path_image)
        <img src="{{ asset('storage/' . $topic->path_image) }}" class="abou02-show__image"
            alt="Imagem que está relacionado ao assunto {{ $topic->title }}">
    @endif
    @if ($topic->title || $topic->subtitle || $topic->text)
        <div class="abou02-show__information">
            @if ($topic->subtitle)
                <h3 class="abou02-show__information__subtitle">{{ $topic->subtitle }}</h3>
            @endif
            @if ($topic->title)
                <h2 class="abou02-show__information__title">{{ $topic->title }}</h2>
            @endif
            @if ($topic->text)
                <div class="abou02-show__information__paragraph">
                    <p>{!! $topic->text !!}</p>
                </div>
            @endif
        </div>
    @endif


</div>
