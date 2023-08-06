@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}

<div class="serv07-show-banner">    
    <header class="serv07-show-banner__header"style="background-image: url({{ asset('storage/uploads/tmp/bannercopa02.png') }}); background-color: #00000070;">
        <div class="container d-flex flex-column align-items-center">
            <h1 class="serv07-show-banner__title">Titulo do banner</h1>
        </div>
    </header>
</div>


<section class="serv07-show">
        <main>
            <div class="serv07-show__contentTitle">
                <div class="serv07-show__contentTitle__container container">
                    <div class="serv07-show__contentTitle__wrap">
                        <div class="row">
                            <div class="col-12 col-md-6"></div>
                            <div class="col-12 col-md-6 serv07-show__contentTitle__sideRight">
                                <h1 class="serv07-show__contentTitle__title">Titulo do produto</h1>
                                <h3 class="serv07-show__contentTitle__subtitle">Titulo Sub</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="serv07-show__info">
                <div class="serv07-show__info__container container">
                    <div class="row">
                        <div class="col-12 col-md-6 serv07-show__info__gallery">
                            <div id="receiveGallery">
                                <div class="serv07-show__info__gallery__wrap">
                                    <img src="{{ asset('storage/uploads/tmp/thumbnail.png') }}" width="100%" class="serv07-show__info__gallery__imgMain" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 serv07-show__info__description">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibusbero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. bero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibusbero. Vivamus commodo porta velit, vel tempus mLorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibusbero. Vivamus commodo porta velit, vel tempus m.
                            <a href="#" target="_blank" class="serv07-show__info__description__cta">
                                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" width="31px" class="me-2" alt="">
                                CTA
                            </a>
                        </div>
                    </div>
                    <div class="serv07-show__info__gallery__carousel" style="margin-top: 78px;">
                        <img src="{{ asset('storage/uploads/tmp/thumbnail.png') }}" class="serv07-show__info__gallery__thumbnail" alt="">
                        <img src="{{ asset('storage/uploads/tmp/thumbnail.png') }}" class="serv07-show__info__gallery__thumbnail" alt="">
                        <img src="{{ asset('storage/uploads/tmp/thumbnail.png') }}" class="serv07-show__info__gallery__thumbnail" alt="">
                        <img src="{{ asset('storage/uploads/tmp/thumbnail.png') }}" class="serv07-show__info__gallery__thumbnail" alt="">
                    </div>
                </div>
            </div>
        </main>
    </section>





<!-- TEAM01 -->
<div class="serv07-show-section__content__product container">
    <header class="header-topic">
        <h3 class="container-title">
            <span class="title">Título</span>
        </h3>
        <hr class="line">
    </header>
    <div class="row serv07-show-section__content--row carousel-serv07-show-section-product">
        <article class="serv07-show-section__content__product__item col-md-3">
            <div class="serv07-show-section__content__product__item__image">
                <img src="{{ asset('storage/uploads/tmp/bg-boxitem.png') }}" class="w-100 h-100" alt="Titulo Topico">
            </div>
            <div class="serv07-show-section__content__product__item__description d-flex  flex-column justify-content-end mx-0 w-100 text-center">
                <div class="serv07-show-section__content__product__item__description__encompass">
                    <div class="flex-column serv07-show-section__content__product__item__description__encompass__txt">
                        <h2 class="serv07-show-section__content__product__item__description__encompass__txt__title mx-0 px-0">Titulo Topico</h2>
                    </div>
                </div>
                <div class="serv07-show-section__content__product__item__description_paragraph text-start px-0 ">
                    <p>
                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deleniti, facere.
                    </p>
                </div>
                <div class="serv07-show-section__content__product__item__description__buttons">
                    <a rel="next" href="#" data-fancybox= "#" data-src="#"  class="serv07-show-section__content__product__item__description__buttons__cta transition d-flex justify-content-center align-items-center mx-auto">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv07-show-section__content__product__item__description__buttons__cta__icon me-3 transition">
                        CTA
                    </a>
                </div>
            </div>
        </article>
        <article class="serv07-show-section__content__product__item col-md-3">
            <div class="serv07-show-section__content__product__item__image">
                <img src="{{ asset('storage/uploads/tmp/bg-boxitem.png') }}" class="w-100 h-100" alt="Titulo Topico">
            </div>
            <div class="serv07-show-section__content__product__item__description d-flex  flex-column justify-content-end mx-0 w-100 text-center">
                <div class="serv07-show-section__content__product__item__description__encompass">
                    <div class="flex-column serv07-show-section__content__product__item__description__encompass__txt">
                        <h2 class="serv07-show-section__content__product__item__description__encompass__txt__title mx-0 px-0">Titulo Topico</h2>
                    </div>
                </div>
                <div class="serv07-show-section__content__product__item__description_paragraph text-start px-0 ">
                    <p>
                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deleniti, facere.
                    </p>
                </div>
                <div class="serv07-show-section__content__product__item__description__buttons">
                    <a rel="next" href="#" data-fancybox= "#" data-src="#"  class="serv07-show-section__content__product__item__description__buttons__cta transition d-flex justify-content-center align-items-center mx-auto">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv07-show-section__content__product__item__description__buttons__cta__icon me-3 transition">
                        CTA
                    </a>
                </div>
            </div>
        </article>
        <article class="serv07-show-section__content__product__item col-md-3">
            <div class="serv07-show-section__content__product__item__image">
                <img src="{{ asset('storage/uploads/tmp/bg-boxitem.png') }}" class="w-100 h-100" alt="Titulo Topico">
            </div>
            <div class="serv07-show-section__content__product__item__description d-flex  flex-column justify-content-end mx-0 w-100 text-center">
                <div class="serv07-show-section__content__product__item__description__encompass">
                    <div class="flex-column serv07-show-section__content__product__item__description__encompass__txt">
                        <h2 class="serv07-show-section__content__product__item__description__encompass__txt__title mx-0 px-0">Titulo Topico</h2>
                    </div>
                </div>
                <div class="serv07-show-section__content__product__item__description_paragraph text-start px-0 ">
                    <p>
                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deleniti, facere.
                    </p>
                </div>
                <div class="serv07-show-section__content__product__item__description__buttons">
                    <a rel="next" href="#" data-fancybox= "#" data-src="#"  class="serv07-show-section__content__product__item__description__buttons__cta transition d-flex justify-content-center align-items-center mx-auto">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv07-show-section__content__product__item__description__buttons__cta__icon me-3 transition">
                        CTA
                    </a>
                </div>
            </div>
        </article>
        <article class="serv07-show-section__content__product__item col-md-3">
            <div class="serv07-show-section__content__product__item__image">
                <img src="{{ asset('storage/uploads/tmp/bg-boxitem.png') }}" class="w-100 h-100" alt="Titulo Topico">
            </div>
            <div class="serv07-show-section__content__product__item__description d-flex  flex-column justify-content-end mx-0 w-100 text-center">
                <div class="serv07-show-section__content__product__item__description__encompass">
                    <div class="flex-column serv07-show-section__content__product__item__description__encompass__txt">
                        <h2 class="serv07-show-section__content__product__item__description__encompass__txt__title mx-0 px-0">Titulo Topico</h2>
                    </div>
                </div>
                <div class="serv07-show-section__content__product__item__description_paragraph text-start px-0 ">
                    <p>
                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deleniti, facere.
                    </p>
                </div>
                <div class="serv07-show-section__content__product__item__description__buttons">
                    <a rel="next" href="#" data-fancybox= "#" data-src="#"  class="serv07-show-section__content__product__item__description__buttons__cta transition d-flex justify-content-center align-items-center mx-auto">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv07-show-section__content__product__item__description__buttons__cta__icon me-3 transition">
                        CTA
                    </a>
                </div>
            </div>
        </article>
        <article class="serv07-show-section__content__product__item col-md-3">
            <div class="serv07-show-section__content__product__item__image">
                <img src="{{ asset('storage/uploads/tmp/bg-boxitem.png') }}" class="w-100 h-100" alt="Titulo Topico">
            </div>
            <div class="serv07-show-section__content__product__item__description d-flex  flex-column justify-content-end mx-0 w-100 text-center">
                <div class="serv07-show-section__content__product__item__description__encompass">
                    <div class="flex-column serv07-show-section__content__product__item__description__encompass__txt">
                        <h2 class="serv07-show-section__content__product__item__description__encompass__txt__title mx-0 px-0">Titulo Topico</h2>
                    </div>
                </div>
                <div class="serv07-show-section__content__product__item__description_paragraph text-start px-0 ">
                    <p>
                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deleniti, facere.
                    </p>
                </div>
                <div class="serv07-show-section__content__product__item__description__buttons">
                    <a rel="next" href="#" data-fancybox= "#" data-src="#"  class="serv07-show-section__content__product__item__description__buttons__cta transition d-flex justify-content-center align-items-center mx-auto">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv07-show-section__content__product__item__description__buttons__cta__icon me-3 transition">
                        CTA
                    </a>
                </div>
            </div>
        </article>
        <article class="serv07-show-section__content__product__item col-md-3">
            <div class="serv07-show-section__content__product__item__image">
                <img src="{{ asset('storage/uploads/tmp/bg-boxitem.png') }}" class="w-100 h-100" alt="Titulo Topico">
            </div>
            <div class="serv07-show-section__content__product__item__description d-flex  flex-column justify-content-end mx-0 w-100 text-center">
                <div class="serv07-show-section__content__product__item__description__encompass">
                    <div class="flex-column serv07-show-section__content__product__item__description__encompass__txt">
                        <h2 class="serv07-show-section__content__product__item__description__encompass__txt__title mx-0 px-0">Titulo Topico</h2>
                    </div>
                </div>
                <div class="serv07-show-section__content__product__item__description_paragraph text-start px-0 ">
                    <p>
                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deleniti, facere.
                    </p>
                </div>
                <div class="serv07-show-section__content__product__item__description__buttons">
                    <a rel="next" href="#" data-fancybox= "#" data-src="#"  class="serv07-show-section__content__product__item__description__buttons__cta transition d-flex justify-content-center align-items-center mx-auto">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv07-show-section__content__product__item__description__buttons__cta__icon me-3 transition">
                        CTA
                    </a>
                </div>
            </div>
        </article>
        <article class="serv07-show-section__content__product__item col-md-3">
            <div class="serv07-show-section__content__product__item__image">
                <img src="{{ asset('storage/uploads/tmp/bg-boxitem.png') }}" class="w-100 h-100" alt="Titulo Topico">
            </div>
            <div class="serv07-show-section__content__product__item__description d-flex  flex-column justify-content-end mx-0 w-100 text-center">
                <div class="serv07-show-section__content__product__item__description__encompass">
                    <div class="flex-column serv07-show-section__content__product__item__description__encompass__txt">
                        <h2 class="serv07-show-section__content__product__item__description__encompass__txt__title mx-0 px-0">Titulo Topico</h2>
                    </div>
                </div>
                <div class="serv07-show-section__content__product__item__description_paragraph text-start px-0 ">
                    <p>
                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deleniti, facere.
                    </p>
                </div>
                <div class="serv07-show-section__content__product__item__description__buttons">
                    <a rel="next" href="#" data-fancybox= "#" data-src="#"  class="serv07-show-section__content__product__item__description__buttons__cta transition d-flex justify-content-center align-items-center mx-auto">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv07-show-section__content__product__item__description__buttons__cta__icon me-3 transition">
                        CTA
                    </a>
                </div>
            </div>
        </article>
        <article class="serv07-show-section__content__product__item col-md-3">
            <div class="serv07-show-section__content__product__item__image">
                <img src="{{ asset('storage/uploads/tmp/bg-boxitem.png') }}" class="w-100 h-100" alt="Titulo Topico">
            </div>
            <div class="serv07-show-section__content__product__item__description d-flex  flex-column justify-content-end mx-0 w-100 text-center">
                <div class="serv07-show-section__content__product__item__description__encompass">
                    <div class="flex-column serv07-show-section__content__product__item__description__encompass__txt">
                        <h2 class="serv07-show-section__content__product__item__description__encompass__txt__title mx-0 px-0">Titulo Topico</h2>
                    </div>
                </div>
                <div class="serv07-show-section__content__product__item__description_paragraph text-start px-0 ">
                    <p>
                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deleniti, facere.
                    </p>
                </div>
                <div class="serv07-show-section__content__product__item__description__buttons">
                    <a rel="next" href="#" data-fancybox= "#" data-src="#"  class="serv07-show-section__content__product__item__description__buttons__cta transition d-flex justify-content-center align-items-center mx-auto">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv07-show-section__content__product__item__description__buttons__cta__icon me-3 transition">
                        CTA
                    </a>
                </div>
            </div>
        </article>
    </div>
    <a href="#" class="serv07-show-section__content__cta">
        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv07-show-section__content__cta__icon">
        CTA
    </a>
</div>


{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
