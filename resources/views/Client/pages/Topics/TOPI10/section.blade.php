@if ($topics->count())
    <section id="TOPI10" class="container-fluid" style="background-image: url(); background-color: ;">
        <div class="container">
            @if ($section)
                <header class="header-topic">
                    <h3 class="container-title">
                        @if ($section->title || $section->subtitle)
                            <span class="title">{{$section->title}}</span>
                            <span class="subtitle">{{$section->subtitle}}</span>
                            <hr class="line">
                        @endif
                    </h3>
                    @if ($section->description)
                        <p class="paragraph">{!! $section->description !!}</p>
                    @endif
                </header>
            @endif
            <div class="container-box row">
                @foreach ($topics as $topic)
                    <article class="box-topic col-sm-4">
                        <div class="content transition">
                            @if ($topic->path_image_box)
                                <img src="{{ asset('storage/' . $topic->path_image_box) }}" width="100%" height="100%" class="position-absolute top-0 start-0" alt="">
                            @endif
                            <div class="container-info d-flex flex-column justify-content-center align-items-center">
                                <figure class="image">
                                    @if ($topic->path_image_icon)
                                        <img src="{{ asset('storage/' . $topic->path_image_icon) }}" class="icon" width="61" alt="">
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
                        </div>
                    </article>
                @endforeach
                {{-- END .box-topic --}}
            </div>
        </div>
    </section>
@endif
