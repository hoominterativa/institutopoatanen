@if ($services->count() || $section)
    <section id="serv11" class="serv11">
        @if ($section)
            <header class="serv11__header">
                @if ($section->title_section)
                    <h2 class="serv11__header__title">{{$section->title_section}}</h2>
                @endif
                @if ($section->subtitle_section)
                    <h3 class="serv11__header__subtitle">{{$section->subtitle_section}}</h3>
                @endif
                @if ($section->description_section)
                    <div class="serv11__header__paragraph">
                        <p>
                            {!! $section->description_section !!}
                        </p>
                    </div>
                @endif
            </header>
        @endif
        @if ($services->count())
            <div class="serv11__services">
                <div class="serv11__services__carousel">
                    <div class="serv11__services__carousel__swiper-wrapper swiper-wrapper">
                        @foreach ($services as $service)
                            <article class="serv11__services__item swiper-slide" data-fancybox data-src='#M{{$service->id}}'>
                                @if ($service->path_image_icon)
                                    <img src="{{asset('storage/'.$service->path_image_icon)}}" loading="lazy" class="serv11__services__item__icon" alt="Ícone do {{$service->title}} ">
                                @endif
                                @if ($service->title)
                                    <h3 class="serv11__services__item__title">{{$service->title}}</h3>
                                @endif
                                @if ($service->description)
                                    <p class="serv11__services__item__paragraph">
                                        {!! $service->description !!}
                                    </p>
                                @endif
                                @include('Client.pages.Services.SERV11.show')
                            </article>
                        @endforeach
                    </div>
                    <div class="serv11__services__carousel__swiper-pagination"></div>
                </div>
            </div>
        @endif
        <a href="{{route('serv11.page')}}" title="página de serviços" class="serv11__cta">CTA</a>
    </section>
@endif
