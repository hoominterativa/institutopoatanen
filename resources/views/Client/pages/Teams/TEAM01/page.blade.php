@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<section class="container-fluid px-0 team01-page">
    <header class="team01-page__header w-100 d-flex justify-content-center align-items-center" style="background-image: url();background-color:">
        <div class="team01-page__header__mask"></div>
        <div class="d-flex container--team01-page__header">
            <h4 class="team01-page__header__title">Título do Banner</h4>
        </div>
    </header>
    {{-- Finish team01-page__header --}}
    <div class="team01-page__content container">
        <div class="team01-page__content__text text-center">
            <h4 class="team01-page__content__text__title">Título do Banner</h4>
            <h5 class="team01-page__content__text__subtitle">Subtítulo do Banner</h5>
            <hr class="team01-page__content__text__line">
        </div>

        <ul class="team01-page__content__category  container-fluid d-flex flex-row justify-content-center align-items-center px-0 flex-wrap">
            <li class="col-md-2 team01-page__content__category_li">
                <a class="w-100 d-flex justify-content-center align-items-center" href="#">
                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="team01-page__content__category__li__img">
                    Categoria
                </a>
            </li>
        </ul>
        <div class="team01-page__content__dropdown-mobile">
              <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item">
                  <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        Categoria
                    </button>
                  </h2>
                  <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <ul>
                            <li><a href="#">Categoria</a></li>
                        </ul>
                    </div>
                  </div>
                </div>

              </div>
        </div>
        {{-- Finish team01-page__content__category --}}
        <div class="team01-page__content__product container">
            <div class="row team01-page__content--row">
                <article class="team01-page__content__product__item col-md-3">
                    <div class="team01-page__content__product__item__image">
                        <img src="{{asset('storage/uploads/tmp/gall01_image1.png')}}" class="w-100 h-100" alt="Titulo Topico">
                    </div>
                    <div class="team01-page__content__product__item__description d-flex  flex-column justify-content-end mx-0 w-100 text-center">
                        <div class="team01-page__content__product__item__description__encompass">
                            <div class="team01-page__content__product__item__description__encompass__icon">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" />
                            </div>
                            <div class="flex-column team01-page__content__product__item__description__encompass__txt">
                                <h2 class="team01-page__content__product__item__description__encompass__txt__title mx-0 px-0">sdasdasdasd</h2>
                                <h2 class="team01-page__content__product__item__description__encompass__txt__subtitle mx-0 px-0">sdasdasdasd</h2>
                            </div>

                        </div>
                        <div class="team01-page__content__product__item__description_paragraph text-start px-0 ">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            </p>
                        </div>
                        <div class="team01-page__content__product__item__description__buttons">
                            <a rel="next" href="javascript-void(0);" data-fancybox data-src="#lightbox-team01-page-1"  class="team01-page__content__product__item__description__buttons__cta transition d-flex justify-content-center align-items-center mx-auto">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="team01-page__content__product__item__description__buttons__cta__icon me-3 transition">
                                CTA
                            </a>
                        </div>
                    </div>
                    @include('Client.pages.teams.TEAM01.show')
                </article>
                {{-- Finish team01-page__content__product__item --}}
                <article class="team01-page__content__product__item col-md-3">
                    <div class="team01-page__content__product__item__image">
                        <img src="{{asset('storage/uploads/tmp/gall01_image1.png')}}" class="w-100 h-100" alt="Titulo Topico">
                    </div>
                    <div class="team01-page__content__product__item__description d-flex  flex-column justify-content-end mx-0 w-100 text-center">
                        <div class="team01-page__content__product__item__description__encompass">
                            <div class="team01-page__content__product__item__description__encompass__icon">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" />
                            </div>
                            <div class="flex-column team01-page__content__product__item__description__encompass__txt">
                                <h2 class="team01-page__content__product__item__description__encompass__txt__title mx-0 px-0">sdasdasdasd</h2>
                                <h2 class="team01-page__content__product__item__description__encompass__txt__subtitle mx-0 px-0">sdasdasdasd</h2>
                            </div>

                        </div>
                        <div class="team01-page__content__product__item__description_paragraph text-start px-0 ">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            </p>
                        </div>
                        <div class="team01-page__content__product__item__description__buttons">
                            <a rel="next" href="javascript-void(0);" data-fancybox data-src="#lightbox-team01-page-1"  class="team01-page__content__product__item__description__buttons__cta transition d-flex justify-content-center align-items-center mx-auto">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="team01-page__content__product__item__description__buttons__cta__icon me-3 transition">
                                CTA
                            </a>
                        </div>
                    </div>
                    @include('Client.pages.teams.TEAM01.show')
                </article>
                {{-- Finish team01-page__content__product__item --}}
                <article class="team01-page__content__product__item col-md-3">
                    <div class="team01-page__content__product__item__image">
                        <img src="{{asset('storage/uploads/tmp/gall01_image1.png')}}" class="w-100 h-100" alt="Titulo Topico">
                    </div>
                    <div class="team01-page__content__product__item__description d-flex  flex-column justify-content-end mx-0 w-100 text-center">
                        <div class="team01-page__content__product__item__description__encompass">
                            <div class="team01-page__content__product__item__description__encompass__icon">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" />
                            </div>
                            <div class="flex-column team01-page__content__product__item__description__encompass__txt">
                                <h2 class="team01-page__content__product__item__description__encompass__txt__title mx-0 px-0">sdasdasdasd</h2>
                                <h2 class="team01-page__content__product__item__description__encompass__txt__subtitle mx-0 px-0">sdasdasdasd</h2>
                            </div>

                        </div>
                        <div class="team01-page__content__product__item__description_paragraph text-start px-0 ">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            </p>
                        </div>
                        <div class="team01-page__content__product__item__description__buttons">
                            <a rel="next" href="javascript-void(0);" data-fancybox data-src="#lightbox-team01-page-1"  class="team01-page__content__product__item__description__buttons__cta transition d-flex justify-content-center align-items-center mx-auto">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="team01-page__content__product__item__description__buttons__cta__icon me-3 transition">
                                CTA
                            </a>
                        </div>
                    </div>
                    @include('Client.pages.teams.TEAM01.show')
                </article>
                {{-- Finish team01-page__content__product__item --}}
                <article class="team01-page__content__product__item col-md-3">
                    <div class="team01-page__content__product__item__image">
                        <img src="{{asset('storage/uploads/tmp/gall01_image1.png')}}" class="w-100 h-100" alt="Titulo Topico">
                    </div>
                    <div class="team01-page__content__product__item__description d-flex  flex-column justify-content-end mx-0 w-100 text-center">
                        <div class="team01-page__content__product__item__description__encompass">
                            <div class="team01-page__content__product__item__description__encompass__icon">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" />
                            </div>
                            <div class="flex-column team01-page__content__product__item__description__encompass__txt">
                                <h2 class="team01-page__content__product__item__description__encompass__txt__title mx-0 px-0">sdasdasdasd</h2>
                                <h2 class="team01-page__content__product__item__description__encompass__txt__subtitle mx-0 px-0">sdasdasdasd</h2>
                            </div>

                        </div>
                        <div class="team01-page__content__product__item__description_paragraph text-start px-0 ">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            </p>
                        </div>
                        <div class="team01-page__content__product__item__description__buttons">
                            <a rel="next" href="javascript-void(0);" data-fancybox data-src="#lightbox-team01-page-1"  class="team01-page__content__product__item__description__buttons__cta transition d-flex justify-content-center align-items-center mx-auto">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="team01-page__content__product__item__description__buttons__cta__icon me-3 transition">
                                CTA
                            </a>
                        </div>
                    </div>
                    @include('Client.pages.teams.TEAM01.show')
                </article>
                {{-- Finish team01-page__content__product__item --}}
                <article class="team01-page__content__product__item col-md-3">
                    <div class="team01-page__content__product__item__image">
                        <img src="{{asset('storage/uploads/tmp/gall01_image1.png')}}" class="w-100 h-100" alt="Titulo Topico">
                    </div>
                    <div class="team01-page__content__product__item__description d-flex  flex-column justify-content-end mx-0 w-100 text-center">
                        <div class="team01-page__content__product__item__description__encompass">
                            <div class="team01-page__content__product__item__description__encompass__icon">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" />
                            </div>
                            <div class="flex-column team01-page__content__product__item__description__encompass__txt">
                                <h2 class="team01-page__content__product__item__description__encompass__txt__title mx-0 px-0">sdasdasdasd</h2>
                                <h2 class="team01-page__content__product__item__description__encompass__txt__subtitle mx-0 px-0">sdasdasdasd</h2>
                            </div>

                        </div>
                        <div class="team01-page__content__product__item__description_paragraph text-start px-0 ">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            </p>
                        </div>
                        <div class="team01-page__content__product__item__description__buttons">
                            <a rel="next" href="javascript-void(0);" data-fancybox data-src="#lightbox-team01-page-1"  class="team01-page__content__product__item__description__buttons__cta transition d-flex justify-content-center align-items-center mx-auto">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="team01-page__content__product__item__description__buttons__cta__icon me-3 transition">
                                CTA
                            </a>
                        </div>
                    </div>
                    @include('Client.pages.teams.TEAM01.show')
                </article>
                {{-- Finish team01-page__content__product__item --}}
                <article class="team01-page__content__product__item col-md-3">
                    <div class="team01-page__content__product__item__image">
                        <img src="{{asset('storage/uploads/tmp/gall01_image1.png')}}" class="w-100 h-100" alt="Titulo Topico">
                    </div>
                    <div class="team01-page__content__product__item__description d-flex  flex-column justify-content-end mx-0 w-100 text-center">
                        <div class="team01-page__content__product__item__description__encompass">
                            <div class="team01-page__content__product__item__description__encompass__icon">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" />
                            </div>
                            <div class="flex-column team01-page__content__product__item__description__encompass__txt">
                                <h2 class="team01-page__content__product__item__description__encompass__txt__title mx-0 px-0">sdasdasdasd</h2>
                                <h2 class="team01-page__content__product__item__description__encompass__txt__subtitle mx-0 px-0">sdasdasdasd</h2>
                            </div>

                        </div>
                        <div class="team01-page__content__product__item__description_paragraph text-start px-0 ">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            </p>
                        </div>
                        <div class="team01-page__content__product__item__description__buttons">
                            <a rel="next" href="javascript-void(0);" data-fancybox data-src="#lightbox-team01-page-1"  class="team01-page__content__product__item__description__buttons__cta transition d-flex justify-content-center align-items-center mx-auto">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="team01-page__content__product__item__description__buttons__cta__icon me-3 transition">
                                CTA
                            </a>
                        </div>
                    </div>
                    @include('Client.pages.teams.TEAM01.show')
                </article>
                {{-- Finish team01-page__content__product__item --}}
            </div>
            {{-- Finish row team01-page__content--row --}}
        </div>
        {{-- Finish team01-page__content__product --}}

    </div>
</section>
{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
