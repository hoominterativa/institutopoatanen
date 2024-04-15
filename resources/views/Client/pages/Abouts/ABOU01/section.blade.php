@if ($section)
    <section id="ABOU01" class="abou01">
        @if ($section->title || $section->subtile)
            <header class="abou01__header">
                @if ($section->title)
                    <h2 class="abou01__header__title">{{ $section->title }}</h2>
                @endif

                @if ($section->subtitle)
                    <h3 class="abou01__header__subtitle">{{ $section->subtitle }}</h3>
                @endif

            </header>
        @endif

        @if ($section->description)
            <div class="abou01__paragraph">
                <p>
                    {!! $section->description !!}
                </p>
            </div>
        @endif

        @if ($section->link_button)
            <a title=" {{ $section->title_button }}" href="{{ getUri($section->link_button) }}"
                target="{{ $section->target_link_button }}" class="abou01__cta ">
                {{ $section->title_button }}
            </a>
        @endif

    </section>

@endif
