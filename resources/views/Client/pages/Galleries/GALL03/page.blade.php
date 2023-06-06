@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}

    <section class="gall03-page w-100" id="gall03-page">

        <header class="gall03-page__header w-100 d-flex flex-column align-items-center"
            style="background-image: url({{ asset('storage/uploads/tmp/bg-section-dark-gray.jpg') }})">
            <div class="gall03-page__header__content container">

                <h1 class="gall03-page__header__title text-center">Título Tópico</h1>
                <h3 class="gall03-page__header__subtitle text-center">Subtítulo</h3>
                <hr class="gall03-page__header__line">

            </div>
        </header>

        <main class="gall03-page__main container-fluid">
            <div class="gall03-page__main__content d-flex flex-column align-items-center container">

                <h2 class="gall03-page__main__title">Título</h2>
                <h3 class="gall03-page__main__subtitle">Subtítulo</h3>
                <hr class="gall03-page__main__line">

                <div class="gall03-page__main__list">

                    @for ($i = 0; $i < 5; $i++)
                        <div class="gall03-page__main__list__item">
                            <a href="#lightbox-gall03" data-fancybox class="link-full"></a>

                            <img src="{{ asset('storage/uploads/tmp/bg-slide-dark.png') }}" alt=""
                                class="gall03-page__main__list__item__image">

                            <h4 class="gall03-page__main__list__item__title">
                                Título {{ $i }}
                            </h4>
                        </div>
                    @endfor

                    @include('Client.pages.Galleries.GALL03.show')

                </div>

            </div>
        </main>

    </section>

    {{-- Finish Content page Here --}}
    @foreach ($sections as $section)
        {!! $section !!}
    @endforeach
@endsection
