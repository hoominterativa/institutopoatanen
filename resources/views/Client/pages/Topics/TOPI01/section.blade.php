<section id="TOPI01" class="topic container-fluid">
    <div class="container py-5">
        @if ($topicSection)
            @if ($topicSection->active)
                <header class="header-topic">
                    <h2 class="title">{{$topicSection->title}}</h2>
                    <p class="ms-auto me-auto mb-0">{{$topicSection->description}}</p>
                </header>
            @endif
        @endif
        <div class="wrap-box-topic w-100 d-block py-4">
            <div class="carousel-box-topic owl-carousel">
                @foreach ($topics as $topic)
                    <article class="box-topic p-1">
                        <div class="content">
                            <div class="image">
                                <img src="{{url('storage/'.$topic->path_image)}}" alt="{{$topic->title}}">
                            </div>
                            <div class="description">
                                <h2 class="title">{{$topic->title}}</h2>
                                <p class="mb-0">{{$topic->description}}</p>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</section>
