@if ($contents->count())
    @foreach ($contents as $content)
        <section id="CONT05" class="cont05" {{-- style="background-image: url({{ asset('storage/' . $content->path_image_desktop) }}); background-color: {{ $content->background_color }};" --}}>

            @if ($content->title || $content->subtitle)
                <header class="cont05__header">
                    @if ($content->title)
                        <h2 class="cont05__header__title">
                            {{ $content->title }}
                        </h2>
                    @endif

                    @if ($content->subtitle)
                        <h3 class="cont05__header__subtitle">{{ $content->subtitle }}</h3>
                    @endif

                </header>
            @endif

            <div class="cont05__main">
                @if ($content->description)
                    <p class="cont05__main__paragraph">{!! $content->description !!}</p>
                @endif

                @if ($content->link_button)
                    <a href="{{ getUri($content->link_button) }}" target="{{ $content->target_link_button }}"
                        class="cont05__main__cta">
                        @if ($content->title_button)
                            {{ $content->title_button }}
                        @endif
                    </a>
                @endif
            </div>

        </section>
    @endforeach
@endif
