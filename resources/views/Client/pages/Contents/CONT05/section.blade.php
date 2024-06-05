@if ($contents->count())
    @foreach ($contents as $content)
        <section id="CONT05" class="cont05" {{-- style="background-image: url({{ asset('storage/' . $content->path_image_desktop) }}); background-color: {{ $content->background_color }};" --}}>

            <header class="cont05__header">
                @if ($content->title)
                    <h2 class="cont05__header__title">
                        {{ $content->title }}
                    </h2>
                @endif

                @if ($content->subtitle)
                    <h3 class="subtitle">{{ $content->subtitle }}</h3>
                @endif

                @if ($content->description)
                    <p class="cont05__header__paragraph">{!! $content->description !!}</p>
                @endif

            </header>

            <div class="cont05__content">
                @if ($content->link_button)
                    <a href="{{ getUri($content->link_button) }}" target="{{ $content->target_link_button }}"
                        class="cont05__content__cta transition d-flex justify-content-center align-items-center">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="ìcone"
                            class="cont05__cta__icon me-3 transition">
                        @if ($content->title_button)
                            {{ $content->title_button }}
                        @endif
                    </a>
                @endif
            </div>

        </section>
    @endforeach
@endif
