@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    <section class="unit03-page w-100" style="background-image: url({{ asset('storage/uploads/tmp/bg-banner-inner.jpg') }})">
        <header class="unit03-page__banner">
            <div class="unit03-page__banner__content container d-flex flex-column align-items-center justify-content-center">
                <h1 class="unit03-page__banner__title text-center">Título da Página</h1>
                <h2 class="unit03-page__banner__subtitle text-center">Subtítulo</h2>
                <hr class="unit03-page__banner__line">
            </div>
        </header>

        <main class="unit03-page__main w-100 d-flex flex-column">

            <ul class="unit03-page__categories w-100">
                <li class="unit03-page__categories__item">
                    <a href="">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                            class="unit03-page__categories__item__icon">
                        Categoria
                    </a>
                </li>
                <li class="unit03-page__categories__item">
                    <a href="">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                            class="unit03-page__categories__item__icon">
                        Categoria
                    </a>
                </li>
                <li class="unit03-page__categories__item">
                    <a href="">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                            class="unit03-page__categories__item__icon">
                        Categoria
                    </a>
                </li>
            </ul>

        </main>

    </section>
    {{-- Finish Content page Here --}}
    @foreach ($sections as $section)
        {!! $section !!}
    @endforeach
@endsection
