@if ($topics->count())
    <section id="TOPI02" class="container-fluid">
        <div class="container">
            @if ($section)
                <header class="header-topic">
                    @if ($section->title || $section->subtitle)
                        <h3 class="container-title">
                            <span class="title">{{$section->title}}</span>
                            <span class="subtitle">{{$section->subtitle}}</span>
                            <hr class="line">
                        </h3>
                    @endif
                    @if ($section->description)
                        <p class="paragraph">{!! $section->description !!}</p>
                    @endif
                </header>
            @endif
            <div class="container-box row carousel-topi02">
                @foreach ($topics as $topic)
                    <article class="box-topic col">
                        <div class="content transition">
                            <a href="{{$topic->link ? getUri($topic->link) : '#'}}" target="{{$topic->link ? $topic->target_link : ''}}" @if (!$topic->link) style="cursor: default;" @endif>
                                @if ($topic->path_image)
                                    <img src="{{asset('storage/'.$topic->path_image)}}" width="100%" height="100%" class="position-absolute top-0 start-0" alt="">
                                @endif
                                <div class="container-info d-flex flex-column justify-content-center align-items-center">
                                    @if ($topic->path_image_icon)
                                        <figure class="image">
                                            <img src="{{asset('storage/'.$topic->path_image_icon)}}" class="icon" width="61" alt="">
                                        </figure>
                                    @endif
                                    <div class="description">
                                        @if ($topic->title)
                                            <h3 class="title">{{$topic->title}}</h3>
                                        @endif
                                        @if ($topic->description)
                                            <p class="paragraph">{!! $topic->description !!}</p>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                    </article>
                @endforeach
                {{-- END .box-topic --}}
            </div>
        </div>
    </section>
@endif
