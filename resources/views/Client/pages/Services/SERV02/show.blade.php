@extends('Client.Core.client')
@section('content')
    <main id="root">
        {{-- BEGIN Page content --}}

        <section class="serv02-show">
            <header class="serv02-show__header"
                style="background-image: url({{ asset('storage/' . $service->path_image_desktop_banner) }});  background-color: {{ $service->background_color_banner }};">
                <h1 class="serv02-show__header__title">{{$service->title_banner}}</h1>

                <nav class="serv02-show__header__categories">

                    <ul class="serv02-show__header__categories__carousel owl-carousel">

                        @for ($i = 0; $i < 5; $i++)
                            <li class="serv02-show__header__categories__item">
                                <a href="#" class="link-full"></a>

                                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="icone"
                                    class="serv02-show__header__categories__item__icon">

                                Serviços
                            </li>
                        @endfor

                    </ul>
                </nav>
            </header>

            <main class="serv02-show__main">

                <section class="serv02-show__core"
                    style="background-image: url({{ asset('storage/uploads/tmp/box-branco.png') }})">

                    <header class="serv02-show__core__header">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="ícone"
                            class="serv02-show__core__header__icon">

                        <h3 class="serv02-show__core__header__subtitle">Subtitulo</h3>

                        <h2 class="serv02-show__core__header__title">Titulo</h2>

                        <hr class="serv02-show__core__header__line">
                    </header>

                    <main class="serv02-show__core__paragraph">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida
                            sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu
                            eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet,
                            consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero.
                            Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere.
                            Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel
                            tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus.
                            Lorem ipsum dolor sit amet, consectet</p>
                    </main>
                </section>

                <section class="serv02-show__topics">

                    <header class="serv02-show__topics__header">

                        <h2 class="serv02-show__topics__header__title">Titulo</h2>

                        <h3 class="serv02-show__topics__header__subtitle">Subtitulo</h3>

                        <hr class="serv02-show__topics__header__line">

                        <div class="serv02-show__topics__header__paragraph">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida
                                sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et
                                arcu
                                eget purus mattis posuere. Donec tincidunt dignissim faucibus.
                            </p>
                        </div>

                    </header>

                    <main class="serv02-show__topics__main">
                        <div class="serv02-show__topics__carousel owl-carousel">

                            @for ($i = 0; $i < 5; $i++)
                                <div class="serv02-show__topics__item">
                                    <img src="{{ asset('storage/uploads/tmp/retangle.png') }}" alt=""
                                        class="serv02-show__topics__item__bg">

                                    <div class="serv02-show__topics__item__information">

                                        <div class="serv02-show__topics__item__information__hold-ttl">

                                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                                class="serv02-show__topics__item__information__icon">

                                            <h4 class="serv02-show__topics__item__information__title">Título do tópico</h4>

                                        </div>

                                        <div class="serv02-show__topics__item__information__description">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu
                                                purus
                                                gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus
                                                mi
                                                pretium sed. In et arcu eget
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            @endfor

                        </div>
                    </main>

                </section>

            </main>
        </section>

        {{-- Finish Content page Here --}}
        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
