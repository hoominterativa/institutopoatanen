@if ($topics->count())
    <section id="TOPI05" class="topi05 container-fluid px-0" style="background-color: #fff;">
        <div class="container container--pd px-0">
            <div class="row">
                @foreach ($topics as $topic)
                    <article class="topi05__box col-sm-4">
                        <a href="{{ $topic->link ? getUri($topic->link) : 'javascript:void(0)' }}" target="{{ $topic->link ? $topic->target_link : '' }}" @if (!$topic->link) style="cursor: default;" @endif>
                            @if ($topic->path_image)
                                <figure class="topi05__box__image w-100">
                                    <img src="{{ asset('storage/' . $topic->path_image) }}" class="w-100 h-100" alt="">
                                </figure>
                            @endif
                            @if ($topic->title || $topic->description)
                                <div class="topi05__box__description text-center">
                                    <h2 class="topi05__box__description__title">{{ $topic->title }}</h2>
                                    <div class="topi05__box__description__paragraph">
                                        <p>
                                            {!! $topic->description !!}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </a>
                    </article>
                    {{-- END topi05__box --}}
                @endforeach
            </div>
            {{-- END row --}}
        </div>
        {{-- END container --}}
    </section>
    {{-- END #TOPI05 --}}
@endif
