@if ($section || $categories->count())
    <section id="serv12" class="serv12">
        @if ($section)
            <header class="serv12__header">
                @if ($section->title)
                    <h2 class="serv12__header__title">{{$section->title}}</h2>
                @endif
                @if ($section->subtitle)
                    <h3 class="serv12__header__subtitle">{{$section->subtitle}}</h3>
                @endif
                @if ($section->description)
                    <div class="serv12__header__paragraph">
                        {!! $section->description !!}
                    </div>
                @endif
            </header>
        @endif
        @if ($categories->count())
            <aside class="serv12__categories">
                <menu class="serv12__categories__swiper-wrapper swiper-wrapper">
                    @for ($i = 1; $i < 5; $i++)
                        <li class="serv12__categories__item swiper-slide active">
                            <a href="#" class="link-full" title="categoria{{$i}}"></a>
                            categoria {{$i}}
                        </li>
                    @endfor
                </menu>
            </aside>
        @endif
        <div class="serv12__services">
            <div class="serv12__services__carousel">
                <div class="serv12__services__carousel__swiper-wrapper swiper-wrapper">
                    @for ($j = 0; $j < 5; $j++)
                        <article class="serv12__services__item swiper-slide">
                            <a href="{{route('serv12.page')}}" class="link-full"></a>
                            <img src="{{asset('storage/uploads/tmp/icon-black.svg')}}" loading="lazy" class="serv12__services__item__icon" alt="Ícone do {{$j}} ">
                            <h3 class="serv12__services__item__title">Serviço</h3>
                            <p class="serv12__services__item__paragraph">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            </p>
                        </article>
                    @endfor
                </div>
                <div class="serv12__services__carousel__swiper-pagination"></div>
            </div>
            <a href="{{route('serv12.page')}}" title="página de serviços" class="serv12__cta">CTA</a>
        </div>
    </section>
@endif
