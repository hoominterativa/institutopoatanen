@if ($section)
    <section class="feed06 w-100" id="FEED06"
    style="background-image: url({{ asset('storage/' . $section->path_image_desktop) }}); background-color: {{ $section->background_color }};">
        <div class="container">
            <header class="feed06__header d-flex flex-column align-items-center">
                @if ($section->title)
                <h1 class="feed06__title">{{$section->title}}</h1>
                <hr class="feed06__line">
                @endif
            </header>
            <main class="feed06__main w-100 d-flex flex-column align-items-stretch">
                @if ($feedbacks->count())
                    <div class="feed06__carousel owl-carousel">
                        @foreach ($feedbacks as $feedback)
                            <article class="feed06__item">
                                <header class="feed06__item__header d-flex flex-column align-items-start w-100">
                                    <h3 class="feed06__item__title">{{$feedback->name}}</h3>
                                    <ul class="feed06__item__stars d-flex justify-content-start align-items-center">
                                        @if($feedback->classification >= 1)
                                            @for($i = 0; $i < $feedback->classification; $i++)
                                                <li class="feed06__item__stars__item">
                                                    <img src="{{ asset('storage/uploads/tmp/star-full.png') }}" alt="Estrela cinza">
                                                </li>
                                            @endfor
                                        @endif
                                        @if($feedback->classification < 5)
                                            <li class="feed06__item__stars__item">
                                                <img src="{{ asset('storage/uploads/tmp/star-outline.png') }}" alt="Contorno de estrela">
                                            </li>
                                        @endif
                                    </ul>
                                </header>
                                <main class="feed06__item__text">
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
                @if ($section->link_button)
                    <a href="{{ $section->link_button ? getUri($section->link_button) : 'javascript:void(0)' }}" target="{{ $section->target_link_button }}" class="feed06__cta">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="feed06__cta__icon">
                        @if ($section->title_button)
                            {{ $section->title_button }}
                        @endif
                    </a>
                @endif
            </main>
        </div>
    </section>
@endif
