@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<div id="ABOU02" class="abou02-page">
    <section class="container-fluid px-0">
        <header class="abou02-page__header" style="background-image: url({{asset('storage/uploads/tmp/bg-banner-inner.jpg')}})">
            <h2 class="container container--abou02-header d-block text-center">
                <span class="abou02-page__header__title d-block">Titulo do banner</span>
                <span class="abou02-page__header__subtitle d-block text-uppercase">SUBTITULO</span>
                <hr class="abou02-page__header__line mb-0">
            </h2>
        </header>
        <div class="container container--abou02-page">
            <div class="abou02-page__content text-center">
                <h2 class="abou02-page__content__container d-block text-center">
                    <span class="abou02-page__content__subtitle d-block">Subtitulo</span>
                    <span class="abou02-page__content__title mb-0 d-block">Titulo</span>
                </h2>
                {{-- END .abou02-page__content__container --}}
                <hr class="abou02-page__content__line">
                <div class="abou02-page__content__paragraph">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt d
                    </p>
                </div>
                {{-- END .abou02-page__content__paragraph --}}
            </div>
        </div>
    </section>
    {{-- END .abou02-page__content --}}
    <section class="abou02-page__topic container-fluid px-0" style="background-image: url({{asset('storage/uploads/tmp/bg-section-dark-gray.jpg')}})">
        <div class="container container--abou02-page__topic">
            <h2 class="abou02-page__topic__encompass d-block text-center">
                <span class="abou02-page__topic__encompass__title d-block">Titulo</span>
                <span class="abou02-page__topic__encompass__subtitle mb-0 d-block">Subtitulo</span>
                <hr class="abou02-page__topic__encompass__line">
            </h2>
            {{-- END .abou02-page__topic__encompass --}}
            <div class="abou02-page__topic__content">
                <div class="carousel-abou02-topic owl-carousel">
                    <article class="abou02-page__topic__item w-100">
                        <a rel="next" href="javascript-void(0);" data-fancybox="" data-src="#lightbox-abou02-1">
                            <div class="abou02-page__topic__item_content transition w-100 h-100">
                                <div class="abou02-page__topic__header position-relative w-100 h-100">
                                    <div class="abou02-page__topic__image w-100 h-100">
                                        <img src="{{asset('storage/uploads/tmp//image-box.jpg')}}" class="w-100 h-100" alt="">
                                    </div>
                                    <div class="abou02-page__topic__description text-center flex-column w-100 h-100 position-absolute d-flex justify-content-end align-items-center">
                                        <h3 class="abou02-page__topic__title">Titulo Topico</h3>
                                        <div class="abou02-page__topic__paragraph">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                                        </div>

                                    </div>
                                </div>
                                @include('Client.pages.Abouts.ABOU02.show')
                            </div>
                        </a>
                    </article>
                    {{-- END .abou02-page__topic__item --}}
                </div>
            </div>
            {{-- END .abou02-page__topic__content --}}
        </div>
    </section>
    {{-- END .abou02-page__topic --}}
    <section class="abou02-page__section container-fluid px-0">
        <div class="container container--abou02-page__section">
            <div class="row abou02-page__section__row align-items-center">
                <div class="abou02-page__section__image col-12 col-md-5 m-0">
                    <img class="w-100 h-100" src="{{asset('storage/uploads/tmp/png-slide.png')}}"  width="430" alt="Titulo">
                </div>
                <div class="col-12 col-md-7 abou02-page__section__description">
                    <h2 class="abou02-page__section__encompass_title d-block">
                        <span class="abou02-page__section__title d-block">Titulo</span>
                        <span class="abou02-page__section__subtitle d-block">Subtitulo</span>
                    </h2>
                    <hr class="abou02-page__section__line">
                    <div class="abou02-page__section__paragraph">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus.
                        </p>
                    </div>
                    <a rel="next" href="#" class="abou02-page__section__cta transition justify-content-center align-items-center ms-auto">
                        <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="abou02-page__section__cta__icon me-3 transition">
                        CTA
                    </a>
                </div>
            </div>
        </div>
    </section>
    {{-- END .abou02-page__section --}}
</div>
{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
