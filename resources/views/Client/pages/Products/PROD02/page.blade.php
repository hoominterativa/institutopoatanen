@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<section class="container-fluid px-0 prod02__page">
    <header class="prod02__page__header w-100 d-flex justify-content-center align-items-end" style="background:#ccc;">
        <div class="d-flex">
            <h4 class="prod02__page__header__title">Titulo do banner</h4>
        </div>
    </header>
    <div class="prod02__page__content container">
        <ul class="prod02__page__content__category  container-fluid d-flex flex-row justify-content-center align-items-center px-0 flex-wrap">
            <li class="col-md-2 prod02__page__content__category_li"><a class="w-100 d-flex justify-content-center align-items-center" href="#"><img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="prod02__page__content__category__li__img">Serviços</a></li>
            <li class="col-md-2"><a class="w-100 d-flex justify-content-center align-items-center" href="#"><img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="">Serviços</a></li>
            <li class="col-md-2"><a class="w-100 d-flex justify-content-center align-items-center" href="#"><img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="">Serviços</a></li>
            <li class="col-md-2"><a class="w-100 d-flex justify-content-center align-items-center" href="#"><img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="">Serviços</a></li>
            <li class="col-md-2"><a class="w-100 d-flex justify-content-center align-items-center" href="#"><img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="">Serviços</a></li>
            <li class="col-md-2"><a class="w-100 d-flex justify-content-center align-items-center" href="#"><img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="">Serviços</a></li>
            <li class="col-md-2"><a class="w-100 d-flex justify-content-center align-items-center" href="#"><img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="">Serviços</a></li>
            <li class="col-md-2"><a class="w-100 d-flex justify-content-center align-items-center" href="#"><img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="">Serviços</a></li>
        </ul>
        <div class="prod02__page__content__product container">
            <div class="row prod02__page__content--row">
                <article class="prod02__page__content__product__item col-md-3 ">
                    <div class="prod02__page__content__product__item__image w-100 h-100">
                        <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" class="w-100 h-100" alt="Titulo Topico">
                    </div>
                    <div class="prod02__page__content__product__item__description d-flex  flex-column justify-content-end mx-0 w-100 h-100 text-center">
                        <h2 class="prod02__page__content__product__item__description__title mx-0 px-0">Titulo Topico</h2>
                        <div class="prod02__page__content__product__item__description_paragraph mx-0 px-0 ">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                            </p>
                        </div>
                        <a rel="next" href="javascript-void(0);" data-fancybox="" data-src="#lightbox-prod02-1" class="prod02__page__content__product__item__cta transition d-flex justify-content-center align-items-center mx-auto">
                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="prod02__page__content__product__item__cta__icon me-3 transition">
                            CTA
                        </a>
                    </div>
                    @include('Client.pages.Products.PROD02.show')
                </article>
                <article class="prod02__page__content__product__item col-md-3 ">
                    <div class="prod02__page__content__product__item__image w-100 h-100">
                        <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" class="w-100 h-100" alt="Titulo Topico">
                    </div>
                    <div class="prod02__page__content__product__item__description d-flex  flex-column justify-content-end mx-0 w-100 h-100 text-center">
                        <h2 class="prod02__page__content__product__item__description__title mx-0 px-0">Titulo Topico</h2>
                        <div class="prod02__page__content__product__item__description_paragraph mx-0 px-0 ">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                            </p>
                        </div>
                        <a rel="next" href="javascript-void(0);" data-fancybox="" data-src="#lightbox-prod02-1" class="prod02__page__content__product__item__cta transition d-flex justify-content-center align-items-center mx-auto">
                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="prod02__page__content__product__item__cta__icon me-3 transition">
                            CTA
                        </a>
                    </div>
                </article>
                <article class="prod02__page__content__product__item col-md-3 ">
                    <div class="prod02__page__content__product__item__image w-100 h-100">
                        <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" class="w-100 h-100" alt="Titulo Topico">
                    </div>
                    <div class="prod02__page__content__product__item__description d-flex  flex-column justify-content-end mx-0 w-100 h-100 text-center">
                        <h2 class="prod02__page__content__product__item__description__title mx-0 px-0">Titulo Topico</h2>
                        <div class="prod02__page__content__product__item__description_paragraph mx-0 px-0 ">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                            </p>
                        </div>
                        <a rel="next" href="javascript-void(0);" data-fancybox="" data-src="#lightbox-prod02-1" class="prod02__page__content__product__item__cta transition d-flex justify-content-center align-items-center mx-auto">
                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="prod02__page__content__product__item__cta__icon me-3 transition">
                            CTA
                        </a>
                    </div>
                </article>
                <article class="prod02__page__content__product__item col-md-3 ">
                    <div class="prod02__page__content__product__item__image w-100 h-100">
                        <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" class="w-100 h-100" alt="Titulo Topico">
                    </div>
                    <div class="prod02__page__content__product__item__description d-flex  flex-column justify-content-end mx-0 w-100 h-100 text-center">
                        <h2 class="prod02__page__content__product__item__description__title mx-0 px-0">Titulo Topico</h2>
                        <div class="prod02__page__content__product__item__description_paragraph mx-0 px-0 ">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                            </p>
                        </div>
                        <a rel="next" href="javascript-void(0);" data-fancybox="" data-src="#lightbox-prod02-1" class="prod02__page__content__product__item__cta transition d-flex justify-content-center align-items-center mx-auto">
                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="prod02__page__content__product__item__cta__icon me-3 transition">
                            CTA
                        </a>
                    </div>
                </article>
                <article class="prod02__page__content__product__item col-md-3 ">
                    <div class="prod02__page__content__product__item__image w-100 h-100">
                        <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" class="w-100 h-100" alt="Titulo Topico">
                    </div>
                    <div class="prod02__page__content__product__item__description d-flex  flex-column justify-content-end mx-0 w-100 h-100 text-center">
                        <h2 class="prod02__page__content__product__item__description__title mx-0 px-0">Titulo Topico</h2>
                        <div class="prod02__page__content__product__item__description_paragraph mx-0 px-0 ">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                            </p>
                        </div>
                        <a rel="next" href="javascript-void(0);" data-fancybox="" data-src="#lightbox-prod02-1" class="prod02__page__content__product__item__cta transition d-flex justify-content-center align-items-center mx-auto">
                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="prod02__page__content__product__item__cta__icon me-3 transition">
                            CTA
                        </a>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>
{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
