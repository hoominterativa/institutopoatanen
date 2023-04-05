@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<main id="root">
    <div id="COPA02" class="copa02-page">
        <section class="copa02-page__assortedBox container-fluid px-0">
            <header class="copa02-page__assortedBox__header position-relative" style="background-image: url({{asset('storage/uploads/tmp/bannercopa02.png')}})">
                <div class="copa02-page__assortedBox__header__mask"></div>
                <div class="container-assortedBox--copa02-page container d-flex flex-column justify-content-center align-items-center">
                    <h3 class="copa02-page__assortedBox__header__encompass flex-column">
                        <span class="copa02-page__assortedBox__header__title">Título da Página</span>
                        <span class="copa02-page__assortedBox__header__subtitle">Subtítulo</span>
                    </h3>
                    <hr class="copa02-page__assortedBox__header__line" />
                </div>
            </header>
            <div class="copa02-page__assortedBox__content">
                <div class="row  row--boxStandard flex-column">
                    <div class="copa02-page__assortedBox__boxStandard position-relative px-0" style="background-image: url({{asset('storage/uploads/tmp/box-branco.png')}})">

                        <div class="copa02-page__assortedBox__boxStandard__mask"></div>
                        <div class="container container--boxStandard">
                            <div class="row row--boxStandard">
                                <div class="copa02-page__assortedBox__boxStandard__image col">
                                    <img src="{{asset('storage/uploads/tmp/gall01_image1.png')}}" loading="lazy" />
                                </div>
                                <div class="copa02-page__assortedBox__boxStandard__description col">
                                    <h4 class="copa02-page__assortedBox__boxStandard__description__title">Subtitulo</h4>
                                    <h5 class="copa02-page__assortedBox__boxStandard__description__subtitle">Titulo</h5>
                                    <hr class="copa02-page__assortedBox__boxStandard__description__line" />
                                    <div 
                                    class="copa02-page__assortedBox__boxStandard__description__paragraph">
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec 
                                        </p>
                                    </div>
                                    <div class="copa02-page__assortedBox__boxStandard__description__cta">
                                        <a href="#" class="copa02-page__assortedBox__boxStandard__description__cta__link">
                                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="copa02-page__assortedBox__boxStandard__description__cta__img">
                                            CTA
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Finish copa02-page__assortedBox__boxStandard --}}
                    <div class="copa02-page__assortedBox__boxStandard position-relative px-0" style="background-image: url({{asset('storage/uploads/tmp/box2copa02.png')}})">

                        <div class="copa02-page__assortedBox__boxStandard__mask"></div>
                        <div class="container container--boxStandard">
                            <div class="row row--boxStandard">
                                <div class="copa02-page__assortedBox__boxStandard__image col">
                                    <img src="{{asset('storage/uploads/tmp/gall01_image1.png')}}" loading="lazy" />
                                </div>
                                <div class="copa02-page__assortedBox__boxStandard__description col">
                                    <h4 class="copa02-page__assortedBox__boxStandard__description__title">Subtitulo</h4>
                                    <h5 class="copa02-page__assortedBox__boxStandard__description__subtitle">Titulo</h5>
                                    <hr class="copa02-page__assortedBox__boxStandard__description__line" />
                                    <div 
                                    class="copa02-page__assortedBox__boxStandard__description__paragraph">
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec 
                                        </p>
                                    </div>
                                    <div class="copa02-page__assortedBox__boxStandard__description__cta">
                                        <a href="#" class="copa02-page__assortedBox__boxStandard__description__cta__link">
                                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="copa02-page__assortedBox__boxStandard__description__cta__img">
                                            CTA
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Finish copa02-page__assortedBox__boxStandard --}}
                </div>
            </div>
        </section>
        <section class="copa02-page__emphasis position-relative" style="background-image: url({{asset('storage/uploads/tmp/boxdestaque1.png')}})">
            <div class="copa02-page__emphasis__mask"></div>
            <div class="copa02-page__emphasis__header">
                <div class="container container-emphasis--copa02-page d-flex flex-column justify-content-center align-items-center">
                    <h3 class="copa02-page__emphasis__container">
                        <span class="copa02-page__emphasis__header__title">Titulo</span>
                        <span class="copa02-page__emphasis__headers__subtitle">Subtitulo</span>
                    </h3>
                    <hr class="copa02-page__emphasis__header__line" />
                    <div class="copa02-page__emphasis__header__paragraph">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. 
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <section class="copa02-page__boxTopic position-relative" style="background-image: url({{asset('storage/uploads/tmp/secaobox.png')}})">
            <div class="copa02-page__boxTopic__mask"></div>
            <div class="container container--copa02-page-boxTopic">
                <header class="copa02-page__boxTopic__header">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <h3 class="copa02-page__boxTopic__header__encompass">
                            <span class="copa02-page__boxTopic__header__title">Titulo</span>
                            <span class="copa02-page__boxTopic__header__subtitle">Subtitulo</span>
                        </h3>
                        <hr class="copa02-page__boxTopic__header__line" />
                        <div class="copa02-page__boxTopic__header__paragraph">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. 
                            </p>
                        </div>
                        
                    </div>
                </header>
                <div class="copa02-page__boxTopic__content carousel-topics-copa02-page owl-carousel">
                     <div class="copa02-page__boxTopic__item">
                        <div class="copa02-page__boxTopic__item__image">
                            <img src="{{asset('storage/uploads/tmp/gall01_image1.png')}}" loading="lazy" />
                        </div>
                        <div class="copa02-page__boxTopic__item__description">
                            <h4 class="copa02-page__boxTopic__item__description__title">Subtitulo</h4>
                            <h5 class="copa02-page__boxTopic__item__description__subtitle">Titulo</h5>
                            <div class="copa02-page__boxTopic__item__description__paragraph">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit
                                </p>
                            </div>
                        </div>
                     </div>
                </div>
            </div>
        </section>
        <section class="copa02-page__boxContent position-relative" style="background-image: url({{asset('storage/uploads/tmp/destaquebx.png')}})">
            <div class="copa02-page__boxContent__mask"></div>
            <div class="container container--copa02-page-boxContent">
                <div class="copa02-page__boxContent__item">
                    <div class="row row--copa02-page-boxContent">
                        <div class="copa02-page__boxContent__item__image col px-0">
                            <img src="{{asset('storage/uploads/tmp/gall01_image1.png')}}" loading="lazy" />
                        </div>
                        <div class="copa02-page__boxContent__item__description col">
                            <h4 class="copa02-page__boxContent__item__description__title">Subtitulo</h4>
                            <h5 class="copa02-page__boxContent__item__description__subtitle">Titulo</h5>
                            <hr class="copa02-page__boxContent__item__description__line" />
                            <div class="copa02-page__boxContent__item__description__paragraph">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec 
                                </p>
                            </div>
                            <div class="copa02-page__boxContent__item__description__cta">
                                <a href="#" class="copa02-page__boxContent__item__description__cta__link">
                                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="copa02-page__boxContent__item__description__cta__img">
                                    CTA
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>
{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
