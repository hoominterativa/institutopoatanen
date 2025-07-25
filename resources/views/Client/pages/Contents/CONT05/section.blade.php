@if ($contents->count())
    @foreach ($contents as $content)
        <section id="CONT05" class="cont05">
            <img src="{{asset('images/cont05-firula.png')}}" alt="Firula">
            <div class="cont05__center">
                @if ($content->title || $content->subtitle)
                    <header class="cont05__header">
                        @if ($content->title)
                            <h2 class="cont05__header__title animation fadeInLeft">
                                {{ $content->title }}
                            </h2>
                        @endif
                        @if ($content->subtitle)
                            <h3 class="cont05__header__subtitle">{{ $content->subtitle }}</h3>
                        @endif
                    </header>
                @endif

                <div class="cont05__main animation fadeInLeft">
                    @if ($content->description)
                        {!! $content->description !!}
                    @endif
                    @if ($content->link_button)
                        <a href="{{ getUri($content->link_button) }}" target="{{ $content->target_link_button }}"
                            class="cont05__main__cta animation fadeInRight">
                            @if ($content->title_button)
                                <span>
                                    {{ $content->title_button }}
                                </span>
                            @endif
                        </a>
                    @endif
                </div>
            </div>
        </section>
    @endforeach
@endif
