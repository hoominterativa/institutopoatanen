@if ($contents->count())
    @foreach ($contents as $content)
        <section id="CONT05" class="cont05 container-fluid px-0"
        style="background-image: url({{ asset('storage/' . $content->path_image_desktop) }}); background-color: {{ $content->background_color }};">
            <div class="d-flex justify-content-center align-content-center flex-column">
                <header class="cont05__header">
                    @if ($content->title)
                        <h3 class="cont05__header__title">
                            {{$content->title}}
                        </h3>
                        <hr class="cont05__header__line">
                    @endif
                    @if ($content->description)
                        <p class="cont05__header__paragraph">{!! $content->description !!}</p>
                    @endif
                    @if ($content->subtitle)
                        <h2 class="subtitle">{{$content->subtitle}}</h2>
                    @endif
                </header>
                <div class="cont05__content">
                    <a href="{{$content->link_button ? getUri($content->link_button) : 'javascript:void(0)'}}" target="{{$content->target_link_button}}"
                        class="cont05__content__cta transition d-flex justify-content-center align-items-center">
                        <img src="" alt="" class="cont05__cta__icon me-3 transition">
                        @if ($content->title_button)
                            {{$content->title_button}}
                        @endif
                    </a>
                </div>
            </div>
        </section>
    @endforeach
@endif

{{-- END #CONT05 --}}
