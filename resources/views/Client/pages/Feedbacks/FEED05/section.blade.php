<section class="feed05 w-100" id="FEED05">
    <div class="container">
        @if ($section)
            <header class="feed05__header d-flex flex-column align-items-center">
                @if ($section->title)
                    <h1 class="feed05__title">{{$section->title}}</h1>
                    <hr class="feed05__line">
                @endif
            </header>
        @endif
        <main class="feed05__main w-100 d-flex flex-column align-items-center">
            @if ($feedbacks->count())
                <div class="feed05__carousel owl-carousel">
                    @foreach ($feedbacks as $feedback)
                        <article class="feed05__item">
                            <header class="feed05__item__header d-flex flex-column align-items-center w-100">
                                @if ($feedback->path_image)
                                    <img src="{{ asset('storage/' . $feedback->path_image) }}" alt="" class="feed05__item__avatar">
                                @endif
                                @if ($feedback->name)
                                    <h3 class="feed05__item__title">{{$feedback->name}}</h3>
                                @endif
                                <ul class="feed05__item__stars d-flex justify-content-center align-items-center">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <li class="feed05__item__stars__item">
                                            @if ($i <= $feedback->classification)
                                                <img src="{{ asset('storage/uploads/tmp/star-full.png') }}" alt="Estrela cinza">
                                            @else
                                                <img src="{{ asset('storage/uploads/tmp/star-outline.png') }}" alt="Contorno de estrela">
                                            @endif
                                        </li>
                                    @endfor
                                </ul>
                            </header>
                            <main class="feed05__item__text">
                                @if ($feedback->testimony)
                                    <p>
                                        {!! $feedback->testimony !!}
                                    </p>
                                @endif
                            </main>
                        </article>
                    @endforeach
                </div>
            @endif
        </main>
    </div>
</section>
