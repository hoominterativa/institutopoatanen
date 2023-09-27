@if ($sections)
    <section id="TOPI102" class="topi102 container-fluid px-0"
        style="background-image: url({{ asset('storage/' . $sections->path_image_desktop) }});">
        <div class="container container--pd">
            <div class="row mx-auto">
                <div class="topi102__text px-0 d-flex justify-content-between">
                    @if ($sections->title || $sections->subtitle)
                        <div class="topi102__encompass">
                            <h3 class="topi102__encompass__title">{{ $sections->title }}</h3>
                            <h4 class="topi102__encompass__subtitle">{{ $sections->subtitle }}</h4>
                        </div>
                    @endif
                    @if ($featuredtopics->count())
                        <nav class="topi102__navigation">
                            <ul class="mb-0">
                                @foreach ($featuredtopics as $featuredtopic)
                                    <li>
                                        <h4 class="title">{{ $featuredtopic->quantity }}</h4>
                                        <span>{{ $featuredtopic->title }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </nav>
                    @endif
                </div>
                {{-- END topi102__category__area --}}
                @if ($topics->count())
                    <div class="topi102__content px-0 w-100 flex-column carousel-topi102 owl-carousel">
                        @foreach ($topics as $topic)
                            <article data-fancybox data-src="#lightbox-topi102-{{ $topic->id }}"
                                class="topi102__content__box w-100">
                                <figure class="topi102__content__box__image w-100 h-100  mb-0">
                                    @if ($topic->path_image_box)
                                        <img src="{{ asset('storage/' . $topic->path_image_box) }}" class="w-100 h-100" alt="{{$topic->title}}">
                                    @endif
                                </figure>
                                <div class="topi102__content__box__description text-center w-100">
                                    <h2 class="topi102__content__box__description__title">{{ $topic->title }}</h2>
                                    <div class="topi102__content__box__description__paragraph">
                                        <p>
                                            {!! $topic->description !!}
                                        </p>
                                    </div>
                                </div>
                                @include('Client.pages.Topics.TOPI102.show', ['topic' => $topic]);
                            </article>
                            {{-- END topi102__content__box --}}
                        @endforeach
                    </div>
                    {{-- END topi102__content --}}
                @endif
            </div>
            {{-- END row --}}
        </div>
        {{-- END container --}}
    </section>
    {{-- END #topi102 --}}
@endif
