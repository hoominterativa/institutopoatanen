@if ($contents->count())
    @foreach ($contents as $content)
        <section class="cont11" id="CONT11">
            <div class="cont11__carousel owl-carousel">
                @foreach ($content->galleries as $gallery)
                    <div class="cont11__corousel__item">
                        @if ($gallery->path_image)
                            <img src="{{ asset('storage/' . $gallery->path_image) }}" alt="">
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="cont11__right d-flex flex-column align-items-start justify-content-center">
                @if ($content->title || $content->subtitle)
                    <h2 class="cont11__title">{{$content->title}}</h2>
                    <h3 class="cont11__subtitle">{{$content->subtitle}}</h3>
                    <hr class="cont11__line">
                @endif
                <div class="cont11__text">
                    @if ($content->text)
                        <p>
                            {!! $content->text !!}
                        </p>
                    @endif
                </div>
                @if ($content->link_button)
                    <a href="{{getUri($content->link_button)}}" target="{{$content->target_link_button}}" class="cont11__cta">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="cont11__cta__icon">
                       @if ($content->title_button)
                            {{ $content->title_button}}
                       @endif
                    </a>
                @endif
            </div>
        </section>
    @endforeach
@endif
