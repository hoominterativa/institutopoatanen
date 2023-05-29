@if ($contents->count())
    @foreach ($contents as $content)
        <section id="CONT09" class="cont09 container-fluid px-0" style="background-image: url({{ asset('storage/' . $content->path_image_desktop) }}); background-color: {{ $content->background_color }};">
            <div class="container container--pd">
                <header class="cont09__encompass text-center">
                    @if ($content->title || $content->subtitle)
                        <h4 class="cont09__encompass__title">{{$content->title}}</h4>
                        <h5 class="cont09__encompass__subtitle">{{$content->subtitle}}</h5>
                    @endif
                </header>
                <div class="cont09__content row justify-content-between d-flex">
                    @if ($section)
                        <div class="cont09__content__boxLeft col-sm-5 px-0 text-center d-flex flex-column align-items-center justify-content-center">
                            <div class="cont09__content__boxLeft__description">
                                @if ($section->title)
                                    <h4 class="cont09__content__boxLeft__description__title">{{$section->title}}</h4>
                                @endif
                                @if ($topics->count())
                                    <div class="cont09__content__boxLeft__description__link">
                                        @foreach ($topics as $topic)
                                            <a href="{{getUri($topic->link)}}" target="{{$topic->link_target}}" class="transition">
                                                <img src="{{ asset('storage/' . $topic->path_image_icon) }}" />
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            @if ($section->subtitle)
                                <div class="cont09__content__boxLeft__description__paragraph">
                                    <p>{{$section->subtitle}}</p>
                                </div>
                            @endif
                        </div>
                    @endif
                    @if ($content->link)
                        <div class="cont09__content__boxRight col-sm-5 px-0">
                            <div class="cont09__content__boxRight__iframe">
                                <iframe src="{{getUri($content->link)}}" height="500" title="Iframe Example"></iframe>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endforeach
@endif
