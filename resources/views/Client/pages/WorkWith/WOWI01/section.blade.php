@if ($workWiths->count())
    @if ($section)
        <section id="WOWI01" class="wowi01 container-fluid">
            <div class="container">
                @if ($section->title || $section->subtitle || $section->description)
                    <header class="wowi01__header">
                        <h3 class="wowi01__header__container">
                            <span class="wowi01__header__title">{{$section->title}}</span>
                            <span class="wowi01__header__subtitle">{{$section->subtitle}}</span>
                        </h3>
                        <hr class="wowi01__header__line">
                        <p class="wowi01__header__paragraph">{{$section->description}}</p>
                    </header>
                @endif
                <div class="wowi01__container-box carousel-wowi01 row">
                    @foreach ($workWiths as $workWith)
                        <article class="wowi01__container-box__item col-12 col-sm-4 col-lg-3 mb-5">
                            <div class="content transition">
                                <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" width="100%" height="100%" class="position-absolute top-0 start-0" alt="{{$workWith->title}}">
                                <a href="{{route('wowi01.show', ['WOWI01WorkWith' => $workWith->slug])}}">
                                    <div class="wowi01__container-box__info d-flex flex-column justify-content-center align-items-center">
                                        @if ($workWith->path_image_icon)
                                            <figure class="wowi01__container-box__image">
                                                <img src="{{asset('storage/'.$workWith->path_image_icon)}}" class="icon" width="60px" alt="{{$workWith->title}}">
                                            </figure>
                                        @endif
                                        <div class="wowi01__container-box__description">
                                            <h3 class="wowi01__container-box__title">{{$workWith->title}}</h3>
                                            <p class="wowi01__container-box__paragraph mx-auto">{{$workWith->description}}</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{route('wowi01.show', ['WOWI01WorkWith' => $workWith->slug])}}" class="wowi01__container-box__link d-flex align-items-center justify-content-center">
                                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="25px" class="me-3 wowi01__container-box__link__icon">
                                    CTA
                                </a>
                            </div>
                        </article>
                        {{-- END .wowi01__container-box__item --}}
                    @endforeach
                </div>
                {{-- END .wowi01__container-box --}}
            </div>
        </section>
        {{-- END #WOWI01 --}}
    @endif
@endif
