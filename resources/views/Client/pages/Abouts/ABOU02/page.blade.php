@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<div id="ABOU02" class="abou02-page">
    <section class="container-fluid px-0">
        <header class="abou02-page__header" style="background-image: url({{asset('storage/uploads/tmp/bg-banner-inner.jpg')}})">
            <div class="container container--abou02-header d-flex flex-column justify-content-center align-items-center">
                <h3 class="abou02-page__header__title">Titulo do banner</h3>
                <h4 class="abou02-page__header__subtitle mb-0">SUBTITULO</h4>
                <hr class="abou02-page__header__line mb-0">
            </div>
        </header>
        <div class="container container--abou02-page">
            <div class="abou02-page__content text-center">
                <div class="abou02-page__content__container">
                    <h3 class="abou02-page__content__subtitle">Subtitulo</h3>
                    <h2 class="abou02-page__content__title mb-0">Titulo</h2>
                </div>
                <hr class="abou02-page__content__line">
                <p class="abou02-page__content__paragraph">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt d
                </p>
            </div>
        </div>
    </section>
    {{-- END .abou02-page__content --}}
    <section class="abou02-page__topic container-fluid" style="background-image: url({{asset('storage/uploads/tmp/bg-section-dark-gray.jpg')}})">
        <div class="container container--abou02-page__topic">
            <div class="abou02-page__topic__container text-center">
                <h2 class="abou02-page__topic__title">Titulo</h2>
                <h3 class="abou02-page__topic__subtitle">Subtitulo</h3>
                <hr class="abou02-page__topic__line">
            </div>
            <div class="carousel-abou02-topic owl-carousel">
                    <article class="abou02-page__topic__item ">
                            <a href="javascript-void(0);" data-fancybox="" data-src="#lightbox-abou02-1">
                            <div class="abou02-page__topic__content transition w-100 h-100">
                                <div class="abou02-page__topic__item__header position-relative w-100 h-100">
                                    <div class="abou02-page__topic__item__image w-100 h-100">
                                        <img src="{{asset('storage/uploads/tmp/port01_path_image_box.png')}}" class="img-fluid w-100 h-100" alt="">
                                    </div>
                                    <div class="abou02-page__topic__item__description text-center flex-column w-100 h-100 position-absolute d-flex justify-content-end align-items-center">
                                        <h3 class="abou02-page__topic__item__title">Titulo Topico</h3>
                                        <p class="abou02-page__topic__item__paragraph">Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                                    </div>
                                </div>
                                @include('Client.pages.Abouts.ABOU02.show')
                            </div>
                        </a>
                    </article>
            </div>
        </div>
    </section>
    {{-- END .abou02-page__topic --}}
    <section class="abou02-page__section container-fluid px-0">
        <div class="container">
            <div class="row abou02-page__section__row align-items-center">
                <div class="abou02-page__section__image col-12 col-lg-5">
                    <img src="" class="abou02-page__section__image__item" width="430" alt="Titulo">
                </div>
                <div class="col-12 col-lg-7">
                    <h2 class="abou02-page__section__container">
                        <span class="abou02-page__section__title">Titulo</span>
                        <span class="abou02-page__section__subtitle">Subtitulo</span>
                    </h2>
                    <hr class="abou02-page__section__line">
                    <p class="abou02-page__section__paragraph">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. 
                    </p>
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
