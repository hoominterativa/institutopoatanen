<section id="serv10" class="serv10">
    <div class="container container--edit px-0">
        @if ($section)
            <div class="serv10__header">
                @if ($section->title_section || $section->subtitle_section)
                    <h2 class="serv10__header__title">{{$section->title_section}}</h2>
                    <h3 class="serv10__header__subtitle">{{$section->subtitle_section}}</h3>
                    <hr class="serv10__header__line">
                @endif
                @if ($section->description_section)
                    <div class="serv10__header__paragraph">
                        <p>
                            {!! $section->description_section !!}
                        </p>
                    </div>
                @endif
            </div>
        @endif
        {{-- END serv10__header --}}
        @if ($services->count())
            <div class="serv10__main carousel-serv10 owl-carousel">
                @foreach ($services as $service)
                    <div class="serv10__main__box">
                        <div class="serv10__main__box__content">
                            @if ($service->path_image_box)
                                <div class="serv10__main__box__bg">
                                    <img src="{{asset('storage/'.$service->path_image_box)}}" alt="Bg">
                                </div>
                            @endif
                            <div class="serv10__main__box__description">
                                @if ($service->path_image_icon_box)
                                    <div class="serv10__main__box__description__icon">
                                        <img src="{{asset('storage/'.$service->path_image_icon_box)}}" alt="ícone">
                                    </div>
                                @endif
                                @if ($service->title_box)
                                    <h4 class="serv10__main__box__description__title">{{$service->title_box}}</h4>
                                @endif
                                @if ($service->description_box)
                                    <div class="serv10__main__box__description__paragraph">
                                        <p>
                                            {!! $service->description_box !!}
                                        </p>
                                    </div>
                                @endif
                                <a href="{{route('serv10.show',['SERV10ServicesCategory' => $service->categories->slug, 'SERV10Services' => $service->slug])}}" class="serv10__main__box__description__btn">
                                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="ícone Button">
                                    CTA
                                </a>
                            </div>
                        </div>
                    </div>
                    {{-- END serv10__main__box --}}
                @endforeach
            </div>
        @endif
        {{-- END carousel-serv10 --}}
    </div>
</section>
{{-- END serv10 --}}
