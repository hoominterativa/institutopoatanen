<section id="CONT13" class="cont13"
    style="background-image: url({{ asset('storage/' . $section->path_image_desktop) }}); background-color: {{ $section->background_color }};">
    <div class="cont13__mask"></div>
    <div class="container container--cont13">
        @if ($section->active)
            <header class="cont13__header text-center">
                @if ($section->title || $section->subtitle)
                    <h2 class="cont13__header__title">{{$section->title}}</h2>
                    <h3 class="cont13__header__subtitle">{{$section->subtitle}}</h3>
                    <hr class="cont13__header__line">
                @endif
            </header>
        @endif
        <main class="cont13__main row">
            <div class="cont13__main__left col-sm-7">
                @if ($contents->count())
                    <div class="carousel-cont13 owl-carousel cont13__main__left__content">
                        @foreach ($contents as $content)
                            <div class="cont13__main__left__content__box position-relative">
                                <a href="#lightbox-cont13-{{$content->id}}" data-fancybox class="link-full"></a>
                                <img src="{{asset('storage/'  . $content->path_image)}}" alt="Bloco">
                                @include('Client.pages.Contents.CONT13.show',[
                                    'content' => $content
                                ])
                            </div>
                        @endforeach
                        {{-- fim-cont13__main__left__box --}}
                    </div>
                @endif
                @if ($topics->count())
                    <div class="cont13__main__left__rede">
                        @if ($section->title_topic)
                            <h4 class="cont13__main__left__rede__title">{{$section->title_topic}}</h4>
                        @endif
                        <div class="cont13__main__left__rede__links">
                            @foreach ($topics as $topic)
                                <a href="{{getUri($topic->link ?? "#")}}" target="{{$topic->link ? $topic->target_link : null}}" @if (!$topic->link) style="cursor: default;" @endif>
                                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="Ícone">
                                </a>
                            @endforeach
                            {{-- fim-cont13__main__left__rede__links__link --}}
                        </div>
                    </div>
                    @if ($section->description_topic)
                        <div class="cont13__main__left__paragraph mx-auto text-center">
                            <p>
                                {!! $section->description_topic !!}
                            </p>
                        </div>
                    @endif
                @endif
            </div>
            <div class="cont13__main__right col-sm-5 px-0">
                @if ($section->path_image)
                    <div class="cont13__main__right__image">
                        <img src="{{asset('storage/' . $section->path_image)}}" alt="Imagem flutuante">
                    </div>
                @endif
            </div>
        </main>
    </div>
</section>
