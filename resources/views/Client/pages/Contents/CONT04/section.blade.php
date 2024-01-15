@if ($section)
    <section id="CONT04" class="cont04 container-fluid"
        style="background-image: url({{ asset('storage/' . $section->path_image_desktop) }}); background-color: {{ $section->background_color }};">
        <div class="container">
            <header class="cont04__header w-100 d-flex flex-column align-items-center">
                @if ($section->title || $section->subtitle)
                    <h2 class="cont04__header__title text-center">{{$section->title}}</h2>
                    <h3 class="cont04__header__subtitle text-center">{{$section->subtitle}}</h3>
                    <hr class="cont04__header__line">
                @endif
                <div class="cont04__header__desc text-center">
                    @if ($section->description)
                        <p>
                            {!! $section->description !!}
                        </p>
                    @endif
                </div>
            </header>
            @if ($content)
                <main class="cont04__main w-100">
                    @if ($content->path_image)
                        <img src="{{ asset('storage/' . $content->path_image) }}" alt="" class="cont04__main__image">
                    @endif
                    <div class="cont04__main__content d-flex flex-column align-self-stretch">
                        @if ($content->title || $content->subtitle)
                            <h4 class="cont04__main__subtitle">{{$content->title}}</h4>
                            <h4 class="cont04__main__title">{{$content->subtitle}}</h4>
                            <hr class="cont04__main__line">
                        @endif
                        @if ($content->description)
                            <div class="cont04__main__desc w-100">
                                <p>
                                    {!! $content->description !!}
                                </p>
                            </div>
                        @endif
                        @if ($content->link_button)
                            <a href="{{ getUri($content->link_button) }}" target="{{ $content->target_link_button }}" class="cont04__main__cta">
                                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" class="cont04__main__content__cta__icon" alt="Ícone do botão">
                                @if ($content->title_button)
                                    {{ $content->title_button }}
                                @endif
                            </a>
                        @endif
                    </div>
                </main>
            @endif
        </div>
    </section>
@endif
