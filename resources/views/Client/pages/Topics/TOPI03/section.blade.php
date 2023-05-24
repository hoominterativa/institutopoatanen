@if ($topics->count())
    <section id="TOPI03" class="container-fluid" style="background-image: url(); background-color: ;">
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
            <div class="container-box row">
                @foreach ($topics as $topic)
                    <article class="box-topic col-sm-4">
                        <div class="content transition">
                            <a href="{{$topic->link ? getUri($topic->link) : 'javascript:void(0)' }}" target="{{$topic->target_link}}" @if (!$topic->link) style="cursor: default;" @endif>
                                <div class="container-info d-flex flex-column justify-content-center align-items-center">
                                    <figure class="image">
                                        @if ($topic->path_image_icon)
                                            <img src="{{asset('storage/' . $topic->path_image_icon)}}" class="icon" width="61" alt="">
                                        @endif
                                    </figure>
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
