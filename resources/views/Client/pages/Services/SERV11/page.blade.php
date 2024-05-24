@extends('Client.Core.client')
@section('content')
    <main id="root" class="serv11-page">
        {{-- BACKEND: Inserir bg de fundo --}}
        <section class="serv11-page__banner" style="background-image: url({{ asset('images/banner.png') }});">
            <h1 class="serv11-page__banner__title">Título da seção</h1>
            <h2 class="serv11-page__banner__subtitle">Subtitulo da seção</h2>
        </section>
        @for ($j = 0; $j < 4; $j++)
            <div class="serv11-page__section-service">
                <header class="serv11-page__section-service__header">
                    <h4 class="serv11-page__section-service__header__subtitle">Subtitulo</h4>
                    <h3 class="serv11-page__section-service__header__title">Titulo Pagina</h3>
                </header>

                <div class="serv11-page__section-service__list">
                    @for ($i = 0; $i < 15; $i++)
                    <article class="serv11-page__section-service__list__item" data-fancybox data-src='#M{{$i}}'>
                        <img src="{{asset('images/icon.svg')}}" loading="lazy" class="serv11-page__section-service__list__item__icon" alt="Ícone do item ">
                        <h3 class="serv11-page__section-service__list__item__title">Titulo Topico</h3>
                        <p class="serv11-page__section-service__list__item__paragraph">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>


                        @include('Client.pages.Services.SERV11.show')
                    </article>
                @endfor
                </div>
            </div>
        @endfor
        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
