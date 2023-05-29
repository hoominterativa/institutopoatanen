@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<section class="container-fluid px-0 prod02__page">
    <header class="prod02__page__header w-100 d-flex justify-content-center align-items-end" style="background-image: url();background-color:">
        <div class="prod02__page__header__mask"></div>
        <div class="d-flex container--prod02__page__header">
            <h4 class="prod02__page__header__title">Título do Banner</h4>
        </div>
    </header>
    {{-- Finish prod02__page__header --}}
    <div class="prod02__page__content container">
    
        <ul class="prod02__page__content__category  container-fluid d-flex flex-row justify-content-center align-items-center px-0 flex-wrap">
                <li class="col-md-2 prod02__page__content__category_li">
                    <a class="w-100 d-flex justify-content-center align-items-center" href="#">
                        <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="prod02__page__content__category__li__img">
                        Categoria
                    </a>
                </li>
        </ul>
        {{-- Finish prod02__page__content__category --}}
            <div class="prod02__page__content__product container">
                <div class="row prod02__page__content--row">
                    <article class="team01__page__content__product__item col-md-3 ">
                        <div class="team01__page__content__product__item__image">
                            <img src="{{asset('storage/uploads/tmp/gall01_image1.png')}}" class="w-100 h-100" alt="Titulo Topico">
                        </div>
                        <div class="team01__page__content__product__item__description d-flex  flex-column justify-content-end mx-0 w-100 h-100 text-center">
                            <div class="team01__page__content__product__item__description__encompass">
                                <div class="team01__page__content__product__item__description__encompass__icon">
                                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" />
                                </div>
                                <h2 class="team01__page__content__product__item__description__encompass__title mx-0 px-0">sdasdasdasd</h2>
                                <h2 class="team01__page__content__product__item__description__encompass__subtitle mx-0 px-0">sdasdasdasd</h2>
                            </div>
                            <div class="team01__page__content__product__item__description_paragraph mx-0 px-0 ">
                                <p>
                                    asdasdasdadasd
                                </p>
                            </div>
                            <div class="team01__page__content__product__item__description__buttons">
                                <a rel="next" href="javascript-void(0);" data-fancybox data-src="#lightbox-team01-1"  class="team01__page__content__product__item__description__buttons__cta transition d-flex justify-content-center align-items-center mx-auto">
                                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="team01__page__content__product__item__description__buttons__cta__icon me-3 transition">
                                    CTA
                                </a>
                            </div>
                        </div>
                        @include('Client.pages.teams.TEAM01.show')
                    </article>
                    {{-- Finish prod02__page__content__product__item --}}
                </div>
                {{-- Finish row prod02__page__content--row --}}
            </div>
            {{-- Finish prod02__page__content__product --}}
    </div>
</section>
{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
