@foreach ($contents as $content)
    <section id="CONT02" class="cont02 container-fluid px-0"
        style="background-image: url({{ asset('storage/' . $content->path_image_background_desktop) }})">
        <div class="container px-0 mx-auto">
            <div class="row px-0 mx-auto d-flex justify-content-between">
                <div class="cont02__left d-flex col-auto px-0">
                    <div class="cont02__image px-0">
                        <img src="{{ asset('storage/' . $content->path_image) }}" rel="" loading="lazy" />
                    </div>
                </div>
                {{-- END .cont02__left --}}
                <div class="cont02__right col d-flex align-items-center">
                    <div class="cont02__description">
                        <h3 class="cont02__title">{{$content->title}}</h3>
                        <h2 class="cont02__subtitle">{{$content->subtitle}}</h2>
                        <hr class="cont02__line">
                        <div class="cont02__paragraph">
                            <p>
                                {{ $content->description }}
                            </p>
                        </div>
                        <a href="{{getUri($content->link_button)}}" target="{{$content->target_link_button}}"
                            class="cont02__cta transition d-flex justify-content-center align-items-center">
                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                class="cont02__cta__icon me-3 transition">
                            CTA
                        </a>
                    </div>
                </div>
                {{-- END .cont02__right --}}
            </div>
            {{-- END .row --}}
        </div>
        {{-- END .container --}}
    </section>
    {{-- END #CONT02 --}}
@endforeach