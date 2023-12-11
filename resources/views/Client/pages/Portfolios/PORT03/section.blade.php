<section id="PORT03" class="port03">
    <div class="container container--port03">
        @if ($section)
            <header class="port03__header text-center">
                @if ($section->title_section || $section->subtitle_section)
                    <h2 class="port03__header__title">{{$section->title_section}}</h2>
                    <h3 class="port03__header__subtitle">{{$section->subtitle_section}}</h3>
                    <hr class="port03__header__line"/>
                @endif
            </header>
        @endif
        @if ($portfolios->count())
            <div class="port03__content carousel-port03 owl-carousel">
                @foreach ($portfolios as $portfolio)
                    <div class="port03__box box-slide position-relative">
                        <div class="port03__box__engImage">
                            <div class="port03__box__engImage__content">
                                <div class="port03__box__engImage__content__flow image-container">
                                    <div class="port03__box__engImage__content__flow__images">
                                        @if ($portfolio->path_image_before)
                                            <img src="{{asset('storage/' . $portfolio->path_image_before)}}" alt="Image 1" class="port03__box__engImage__content__flow__images__img image1"/>
                                        @endif
                                        @if ($portfolio->path_image_after)
                                            <img src="{{asset('storage/' . $portfolio->path_image_after)}}" alt="Image 2" class="port03__box__engImage__content__flow__images__img image2"/>
                                        @endif
                                    </div>
                                </div>
                                <div class="port03__box__engImage__content__divider divider">
                                    <span class="before-text">Antes</span>
                                    <span class="after-text">Depois</span>
                                </div>
                            </div>
                        </div>
                        <div class="port03__box__description">
                            <div class="port03__box__description__left">
                                @if ($portfolio->title)
                                    <h4 class="port03__box__description__left__title">{{$portfolio->title}}</h4>
                                @endif
                                @if ($portfolio->description)
                                    <h5 class="port03__box__description__left__subtitle">{!! $portfolio->description !!}</h5>
                                @endif
                            </div>
                            {{-- @if ($portfolio->link_button || $portfolio->title_button)
                                <a href="{{getUri($portfolio->link_button)}}" target="{{$portfolio->target_link_button}}" class="port03__box__description__btn transition d-flex justify-content-center align-items-center">
                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="icon" class="port03__box__description__btn__icon me-3 transition">
                                    {{$portfolio->title_button}}
                                </a>
                            @endif --}}
                            
                            <a href="#lightbox-port03-{{$portfolio->id}}" data-fancybox="" class="port03__box__description__btn transition d-flex justify-content-center align-items-center">
                                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="icon" class="port03__box__description__btn__icon me-3 transition">
                                Ver mais
                            </a>
                            @include('Client.pages.Portfolios.PORT03.show',[
                                'portfolio' => $portfolio
                            ])
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
{{-- #PORT02 --}}
