@extends('Client.Core.client')
@section('content')
    <main id="root">
        {{-- BEGIN Page content --}}

        <section class="serv02-page">
            <header class="serv02-page__header">

                <h1 class="serv02-page__title">Título Página</h1>

                <div class="serv02-page__paragraph">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida
                        sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget
                        purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur
                        adipiscing elit. Cras vel tortor</p>
                </div>
            </header>

            <main class="serv02-page__main">

                @for ($i = 0; $i < 8; $i++)
                    <div class="serv02-page__item">

                        <img src="{{ asset('storage/uploads/tmp/bg-boxitem.png') }}" alt="Imagem de fundo [ttl do topic]"
                            class="serv02-page__item__bg">

                        <div class="serv02-page__item__information">

                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}"
                                alt="Imagem de fundo [ttl do topic]" class="serv02-page__item__information__icon">

                            <h4 class="serv02-page__item__information__title">Título do tópico</h4>

                            <p class="serv02-page__item__information__description">Lorem ipsum dolor sit amet, consectetur
                                adipiscing elit. </p>

                        </div>

                        <a href="#" class="serv02-page__item__cta">

                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}"
                                alt="Imagem de fundo [ttl do topic]" class="serv02-page__item__cta__icon">

                            CTA

                        </a>

                    </div>
                @endfor

            </main>
        </section>

        {{-- Finish Content page Here --}}
        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
