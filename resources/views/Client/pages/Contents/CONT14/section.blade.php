@if ($section)
    <section id="CONT14" class="cont14"
        style="background-image: url({{ asset('storage/' . $section->path_image_desktop) }}); background-color: {{ $section->background_color }};">
        <div class="container container--cont14">
            <div class="row row---cont14  mx-auto">
                <div class="cont14__left col-auto px-0">
                    @if ($section->title)
                        <h4 class="cont14__left__titleDest">{{$section->title}}</h4>
                    @endif
                    @if ($categories->count())
                        <nav class="cont14__left__navigation">
                            <ul class="cont14__left__list">
                                @foreach ($categories as $category)
                                    <li class="cont14__left__item">
                                        <button  url="{{route('cont14.show', ['CONT14ContentsCategory' => $category->id])}}" class="cont14__left__link {{$categoryFirst->id == $category->id ? 'active' : ''}}">{{$category->title}}</button>
                                    </li>
                                @endforeach
                            </ul>
                        </nav>
                    @endif
                </div>
                <div class="cont14__right col">
                    <div id="cont14__right__engBox" class="cont14__right__engBox">
                        <div class="carousel-gallery-cont14 owl-carousel">
                            @foreach ($contents as $content)
                                <div class="cont14__right__engBox__box">
                                    @if ($content->title)
                                        <h4 class="cont14__right__engBox__box__title">{{$content->title}}</h4>
                                    @endif
                                    @if ($content->subtitle)
                                        <h5 class="cont14__right__engBox__box__subtitle">{{$content->subtitle}}o</h5>
                                    @endif
                                    <div class="cont14__right__engBox__box__image">
                                        @if ($content->path_image)
                                            <img src="{{asset('storage/'.$content->path_image)}}" class="h-100 w-100" alt="Imagem">
                                        @else
                                            <iframe width="100%" height="100%" src="{{getUri($content->link)}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                        @endif
                                    </div>
                                    @if ($content->description)
                                        <div class="cont14__right__engBox__box__paragraph">
                                            <p>
                                                {!! $content->description !!}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                                <!-- Fim-cont14__right__box -->
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
