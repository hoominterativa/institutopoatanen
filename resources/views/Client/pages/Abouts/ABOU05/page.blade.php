@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<main id="root">
    <div id="abou05-page" class="abou05-page">
        <section class="container-fluid px-0">
            <header class="abou05-page__header" style="background-image: url('{{asset('storage/uploads/tmp/bg-banner-inner.jpg')}}');">
                <div class="container container--abou05-header d-flex flex-column justify-content-center align-items-center">
                    <h3 class="abou05-page__header__container d-flex flex-column justify-content-center align-items-center">
                        <span class="abou05-page__header__title">Titulo do banner</span>
                        <span class="abou05-page__header__subtitle">SUBTITULO</span>
                    </h3>
                    <hr class="abou05-page__header__line">
                </div>
            </header>

            <div class="container">
                <div class="abou05-page__content  d-flex flex-column justify-content-center align-items-center">
                    <h2 class="abou05-page__content__encompass d-flex flex-column justify-content-center align-items-center">
                        <span class="abou05-page__content__title">Titulo</span>
                        <span class="abou05-page__content__subtitle">Subtitulo</span>
                    </h2>
                    <hr class="abou05-page__content__line">
                    <div class="abou05-page__content__paragraph">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin 
                            vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. 
                            Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor 
                            eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et 
                            arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur 
                            adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, 
                            vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. 
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida
                        </p>
                    </div>
                </div>
            </div>
        </section>
        {{-- END .abou05-page__content --}}
        <section class="abou05-page__section container-fluid px-0">
            <div class="abou05-page__section__encompass">
                <h4 class="abou05-page__section__encompass__title">Titulo</h4>
                <h5 class="abou05-page__section__encompass__subtitle">Subtitulo</h5>
            </div>
            <div class="container container--abou05-page__section">
                <div class="row abou05-page__section__row align-items-center">
                    <div class="abou05-page__section__box">
                        <div class="abou05-page__section__box__image col-12 col-md-5 m-0">
                            <img class="w-100 h-100" src=""  width="430" alt="Titulo">
                        </div>
                        <div class="col-12 col-md-7 abou05-page__section__box__description">
                                <h2 class="abou05-page__section__box__description__encompass d-block">
                                    <span class="abou05-page__section__box__description__encompass__title d-block">Titulo</span>
                                    <span class="abou05-page__section__box__description__encompass__subtitle d-block">Subtitulo</span>
                                    <hr class="abou05-page__section__box__description__encompass__line">
                                </h2>
                                <div class="abou05-page__section__box__description__paragraph">
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus 
                                        gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. 
                                        In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. 
                                    </p>
                                </div>
                                <a href="#lightbox-abou05-5" data-fancybox class="abou05-page__section__box__description__cta transition justify-content-center align-items-center ms-auto">
                                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="Icone CTA" class="abou05-page__section__cta__icon me-3 transition">
                                    CTA
                                </a> 
                        </div>
                        @include('Client.pages.Abouts.ABOU05.show');
                    </div>
                </div>
            </div>
        </section>
        {{-- END .abou05-page__section --}}

    </div>
    {{-- END .abou05-page --}}
</main>
{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
