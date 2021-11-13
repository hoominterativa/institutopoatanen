<section id="TOPI01" class="topic container-fluid">
    <div class="container">
        @if ($topicSection)
            @if ($topicSection->active)
                <header class="header-topic">
                    <h2 class="title">{{$topicSection->title}}</h2>
                    <p>{{$topicSection->description}}</p>
                </header>
            @endif
        @endif
        <div class="wrap-box-topic w-100 d-block">
            <div class="carousel-box-topic">
                @foreach ($topics as $topic)
                    <article class="box-topic">
                        <div class="content">
                            <div class="image">
                                <img src="{{url('storage/'.$topic->path_image)}}" alt="{{$topic->title}}">
                            </div>
                            <div class="description">
                                <h2 class="title">{{$topic->title}}</h2>
                                <p>{{$topic->description}}</p>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</section>
