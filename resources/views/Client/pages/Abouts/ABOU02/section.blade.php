<section id="ABOU02" class="abou02 container-fluid" style="background-image: url({{asset('storage/uploads/tmp/bg-section-gray.jpg')}})">
    <div class="row abou02__container ">
        @if ($section)
            <div class="abou02__boxLeft col-md-4 d-flex row align-items-start m-0">
                <div class="abou02__boxLeft__description p-0">
                    @if ($section->title_section || $section->subtitle_section)
                        <h3 class="abou02__boxLeft__subtitle text-center">{{$section->subtitle_section}}</h3>
                        <h2 class="abou02__boxLeft__title mb-0">{{$section->title_section}}</h2>
                        <hr class="abou02__boxLeft__line">
                    @endif
                    <div class="abou02__boxLeft__paragraph">
                        @if ($section->description_section)
                            <p>
                                {!! $section->description_section !!}
                            </p>
                        @endif
                    </div>
                    <a rel="first" href="{{route('abou02.page')}}" class="abou02__boxLeft__cta transition justify-content-center align-items-center">
                        <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="Icone CTA" class="abou02__boxLeft__cta__icon me-3 transition">
                        CTA
                    </a>
                </div>
                {{-- END .abou02__boxLeft__description --}}
            </div>
        @endif
        {{-- END .abou02__boxLeft --}}
        @if ($topics->count())
            <div class="abou02__boxRight col-md-8 p-0">
                <div class="carousel_abou02 owl-carousel">
                    @foreach ($topics as $topic)
                        <article class="abou02__boxRight__item w-100">
                            <a rel="next" href="" data-fancybox="{{$topic->title}}" data-src="#lightbox-abou02-{{$topic->id}}">
                                <div class="abou02__boxRight__content transition w-100 h-100">
                                    <div class="abou02__boxRight__header position-relative w-100 h-100">
                                        <div class="abou02__boxRight__image w-100 h-100">
                                            @if ($topic->path_image_box)
                                                <img src="{{asset('storage/' . $topic->path_image_box)}}" class="w-100 h-100" alt="Titulo Topico">
                                            @endif
                                        </div>
                                        <div class="abou02__boxRight__description text-center flex-column w-100 h-100 position-absolute d-flex justify-content-end align-items-center">
                                            @if ($topic->title_box)
                                                <h3 class="abou02__topic__title">{{$topic->title_box}}</h3>
                                            @endif
                                            @if ($topic->description_box)
                                                <div class="abou02__boxRight__paragraph">
                                                    <p>{!! $topic->description_box !!}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    @include('Client.pages.Abouts.ABOU02.show', [
                                        'topic' => $topic
                                    ])
                                </div>
                            </a>
                        </article>
                    @endforeach
                    {{-- END .abou02__boxRight__item --}}
                </div>
                {{-- END .carousel_abou02 --}}
            </div>
        @endif
        {{-- END .abou02__boxRight --}}
    </div>
    {{-- END .abou02__container --}}
</section>
{{-- END .abou02 --}}
