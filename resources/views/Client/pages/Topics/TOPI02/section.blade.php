@if ($topics->count())
    @if ($section)
        <section id="TOPI02" class="container-fluid" style="background-image: url({{asset('storage/'.$section->path_image_background)}}); background-color: {{$section->background_color}};">
            <div class="container">
                @if ($section->title || $section->subtitle || $section->description)
                    <header class="header-topic">
                        <h3 class="container-title">
                            @if ($section->title)
                                <span class="title">{{$section->title}}</span>
                            @endif
                            @if ($section->subtitle)
                                <span class="subtitle">{{$section->subtitle}}</span>
                            @endif
                        </h3>
                        @if ($section->description)
                            <hr class="line">
                            <p class="paragraph">{{$section->description}}</p>
                        @endif
                    </header>
                @endif
                <div class="container-box row carousel-topi02">
                    @foreach ($topics as $topic)
                        <article class="box-topic col">
                            <div class="content transition">
                                <a href="{{$topic->link?getUri($topic->link):'javascript:void(0)'}}" target="{{$topic->target_link}}">
                                    @if ($topic->path_image)
                                        <img src="{{asset('storage/'.$topic->path_image)}}" width="100%" height="100%" class="position-absolute top-0 start-0" alt="">
                                    @endif
                                    <div class="container-info d-flex flex-column justify-content-center align-items-center">
                                        <figure class="image">
                                            <img src="{{asset('storage/'.$topic->path_image_icon)}}" class="icon" width="61" alt="">
                                        </figure>
                                        <div class="description">
                                            <h3 class="title">{{$topic->title}}</h3>
                                            <p class="paragraph">{{$topic->description}}</p>
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
@endif
