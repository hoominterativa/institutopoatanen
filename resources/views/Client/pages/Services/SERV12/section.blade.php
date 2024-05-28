    <section id="serv12" class="serv12">
        <header class="serv12__header">
            <h2 class="serv12__header__title">Titulo</h2>
            <h3 class="serv12__header__subtitle">Subtitulo</h3>
            <div class="serv12__header__paragraph">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                    Cras vel tortor eu purus gravida sollicitudin vel non libero. 
                    Vivamus commodo porta velit, vel tempus mi pretium sed. 
                    In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. 
                </p>
            </div>
        </header>
        <aside class="serv12__categories">
            <menu class="serv12__categories__swiper-wrapper swiper-wrapper">
                <li class="serv12__categories__item active swiper-slide">
                    <a href="#" class="link-full" title="categoria"></a>
                    categoria
                </li>
                @for ($i = 1; $i < 5; $i++)
                    <li class="serv12__categories__item swiper-slide">
                        <a href="#" class="link-full" title="categoria{{$i}}"></a>
                        categoria {{$i}}
                    </li>
                @endfor
            </menu>
        </aside>
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
