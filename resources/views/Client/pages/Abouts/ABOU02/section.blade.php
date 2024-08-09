<section id="ABOU02" class="abou02"
    style="background-image: url({{ asset('storage/uploads/tmp/bg-section-gray.jpg') }})">

    @if ($section)
        @if ($section->title_section || $section->subtitle_section || $section->description_section)
            <header class="abou02__header">
                @if ($section->subtitle_section)
                    <h3 class="abou02__header__subtitle">{{ $section->subtitle_section }}</h3>
                @endif

                @if ($section->title_section)
                    <h2 class="abou02__header__title">{{ $section->title_section }}</h2>
                @endif

                @if ($section->description_section)
                    <div class="abou02__header__paragraph">
                        <p>
                            {!! $section->description_section !!}
                        </p>
                    </div>
                @endif
                <a href="{{ route('abou02.page') }}" class="abou02__header__cta">
                    CTA
                </a>
            </header>
        @endif

    @endif

    @if ($topics->count())
        <div class="abou02__topics">
            <div class="abou02__topics__swiper-wrapper swiper-wrapper">
                @foreach ($topics as $topic)
                    <article class="abou02__topics__item swiper-slide" data-fancybox
                        data-src="#lightbox-abou02-{{ $topic->id }}">

                        @if ($topic->path_image_box)
                            <img src="{{ asset('storage/' . $topic->path_image_box) }}"
                                class="abou02__topics__item__image" alt="Imagem do tópico {{ $topic->title_box }}"
                                loading="lazy">
                        @endif

                        @if ($topic->title_box)
                            <h3 class="abou02__topics__item__title">{{ $topic->title_box }}</h3>
                        @endif

                        @if ($topic->description_box)
                            <div class="abou02__topics__item__paragraph">
                                <p>{!! $topic->description_box !!}</p>
                            </div>
                        @endif

                        @include('Client.pages.Abouts.ABOU02.show', [
                            'topic' => $topic,
                        ])


                    </article>
                @endforeach

            </div>

        </div>
    @endif


</section>
