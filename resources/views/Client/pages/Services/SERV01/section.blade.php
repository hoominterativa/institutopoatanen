@if ($section)
    <section id="SERV01" class="serv01 container-fluid">
        <div class="container">
            <header class="serv01__header">
                @if ($section->title_section || $section->subtitle_section)
                    <h3 class="serv01__header__container">
                        @if ($section->title_section)
                            <span class="serv01__header__title">{{$section->title_section}}</span>
                        @endif
                        @if ($section->subtitle_section)
                            <span class="serv01__header__subtitle">{{$section->subtitle_section}}</span>
                        @endif
                    </h3>
                    <hr class="serv01__header__line">
                @endif
                <p class="serv01__header__paragraph">{{$section->description_section}}</p>
            </header>
            <div class="serv01__container-box carousel-serv01 row">
                @foreach ($services as $service)
                    <article class="serv01__container-box__item col-12 mb-5">
                        <div class="content transition">
                            @if ($service->path_image)
                                <img src="{{asset('storage/'.$service->path_image)}}" width="100%" height="100%" class="position-absolute top-0 start-0" alt="{{$service->title}}">
                            @endif
                            <a href="{{route('serv01.show', ['SERV01Services' => $service->slug])}}">
                                <div class="serv01__container-box__info d-flex flex-column justify-content-center align-items-center">
                                    <figure class="serv01__container-box__image">
                                        <img src="{{asset('storage/'.$service->path_image_icon)}}" class="icon" width="50px" alt="">
                                    </figure>
                                    <div class="serv01__container-box__description">
                                        <h3 class="serv01__container-box__title">{{$service->title}}</h3>
                                        <p class="serv01__container-box__paragraph mx-auto">{{$service->description}}</p>
                                    </div>
                                </div>
                            </a>
                            <a href="{{route('serv01.show', ['SERV01Services' => $service->slug])}}" class="serv01__container-box__link d-flex align-items-center justify-content-center">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="25px" class="me-3 serv01__container-box__link__icon">
                                CTA
                            </a>
                        </div>
                    </article>
                @endforeach
                {{-- END .box-service --}}
            </div>
            {{-- END .serv01__container-box --}}
        </div>
    </section>
    {{-- END #SERV01 --}}
@endif
