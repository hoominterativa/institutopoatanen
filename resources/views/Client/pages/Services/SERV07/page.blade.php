@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}

<!-- SERV06 -->
<header class="serv07-page__header"style="background-image: url(#); background-color: #00000070;">
    <div class="container d-flex flex-column align-items-center">
        <h1 class="serv07-page__title">Title</h1>
        <h3 class="serv07-page__subtitle">Subtitle</h3>
        <hr class="serv07-page__line">
    </div>
</header>
<div class="serv07-categories">
    <ul class="serv07-categories__list w-100">
        <li class="serv07-categories__list__item">
            <a href="#">
                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv07-categories__list__item__icon">
                Categoria
            </a>
            <a href="#">
                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv07-categories__list__item__icon">
                Categoria II
            </a>
            <a href="#">
                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv07-categories__list__item__icon">
                Categoria III
            </a>
            <a href="#">
                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv07-categories__list__item__icon">
                Categoria IV
            </a>
        </li>
    </ul>
    <div class="serv07-categories__dropdown-mobile">
        <div class="accordion accordion-flush" id="accordionFlushExample">
            <div class="accordion-item">
                <h2 class="accordion-header serv07-categories__dropdown-mobile__item">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv07-categories__dropdown-mobile__item__icon">
                    </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <ul>
                            <li class="serv07-categories__dropdown-mobile__item">
                                <a href="#">
                                    <img src="#" alt="" class="serv07-categories__dropdown-mobile__item__icon">
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="serv07-topo container">
    <div class="__description">
        <h2 class="serv07-topo__description d-block">
            <span class="serv07-topo__description__title d-block">title</span>
            <span class="serv07-topo__description__subtitle d-block">subtitle</span>
            <hr class="serv07-topo__description__line">
        </h2>
        <div class="serv07-topo__description__paragraph">
            <p>
                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Repudiandae, modi?
            </p>
        </div>
    </div>
    <div class="__cta">
        <a href="#" class="serv07-topo__cta">
            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv07-topo__cta__icon">
            CTA
        </a>
    </div>
</div>


<!-- ABOU02 -->
<section class="serv07-page__section container-fluid px-0">
    <div class="container container--serv07-page__section">
        <div class="row serv07-page__section__row align-items-center">
            <div class="serv07-page__section__image col-12 col-md-5 m-0">
                <img class="w-100 h-100" src="{{ asset('storage/uploads/tmp/image-pmg.png') }}"  width="430" alt="Titulo">
            </div>
            <div class="col-12 col-md-7 serv07-page__section__description">
                    <h2 class="serv07-page__section__encompass_title d-block">
                        <span class="serv07-page__section__title d-block">title</span>
                        <span class="serv07-page__section__subtitle d-block">subtitle</span>
                        <hr class="serv07-page__section__line">
                    </h2>
                    <div class="serv07-page__section__paragraph">
                        <p>
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Repudiandae, modi?
                        </p>
                    </div>
    
                <a href="#" target="#" class="serv07-page__section__cta transition justify-content-center align-items-center ms-auto">
                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="Icone CTA" class="serv07-page__section__cta__icon me-3 transition">
                    Btn
                </a>
            </div>
        </div>

        <div class="row serv07-page__section__row align-items-center">
            <div class="serv07-page__section__image col-12 col-md-5 m-0">
                <img class="w-100 h-100" src="{{ asset('storage/uploads/tmp/image-pmg.png') }}"  width="430" alt="Titulo">
            </div>
            <div class="col-12 col-md-7 serv07-page__section__description">
                    <h2 class="serv07-page__section__encompass_title d-block">
                        <span class="serv07-page__section__title d-block">title</span>
                        <span class="serv07-page__section__subtitle d-block">subtitle</span>
                        <hr class="serv07-page__section__line">
                    </h2>
                    <div class="serv07-page__section__paragraph">
                        <p>
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Repudiandae, modi?
                        </p>
                    </div>
    
                <a href="#" target="#" class="serv07-page__section__cta transition justify-content-center align-items-center ms-auto">
                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="Icone CTA" class="serv07-page__section__cta__icon me-3 transition">
                    Btn
                </a>
            </div>
        </div>
    </div>
</section>


<!-- TOPI02 -->
<section id="SERV07" class="container-fluid" style="background-image: url(#); background-color: #0000007a">
    <div class="container">
        <header class="header-topic">
            <h3 class="container-title">
                <span class="title">title</span>
                <span class="subtitle">subtitle</span>
            </h3>
            <hr class="line">
            <p class="paragraph">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla, voluptate!</p>
        </header>
        <div class="container-box row carousel-serv07">
            <article class="box-topic col">
                <div class="content transition">
                    <a href="#" target="">
                        <img src="#" width="100%" height="100%" class="position-absolute top-0 start-0" alt="">
                        <div class="container-info d-flex flex-column justify-content-center align-items-center">
                            <figure class="image">
                                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" class="icon" width="61" alt="">
                            </figure>
                            <div class="description">
                                <h3 class="title">title</h3>
                                <p class="paragraph">Lorem ipsum dolor sit amet consectetur adipisicing elit. Officiis, aspernatur.</p>
                            </div>
                        </div>
                    </a>
                </div>
            </article>
            <article class="box-topic col">
                <div class="content transition">
                    <a href="#" target="">
                        <img src="#" width="100%" height="100%" class="position-absolute top-0 start-0" alt="">
                        <div class="container-info d-flex flex-column justify-content-center align-items-center">
                            <figure class="image">
                                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" class="icon" width="61" alt="">
                            </figure>
                            <div class="description">
                                <h3 class="title">title</h3>
                                <p class="paragraph">Lorem ipsum dolor sit amet consectetur adipisicing elit. Officiis, aspernatur.</p>
                            </div>
                        </div>
                    </a>
                </div>
            </article>
            <article class="box-topic col">
                <div class="content transition">
                    <a href="#" target="">
                        <img src="#" width="100%" height="100%" class="position-absolute top-0 start-0" alt="">
                        <div class="container-info d-flex flex-column justify-content-center align-items-center">
                            <figure class="image">
                                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" class="icon" width="61" alt="">
                            </figure>
                            <div class="description">
                                <h3 class="title">title</h3>
                                <p class="paragraph">Lorem ipsum dolor sit amet consectetur adipisicing elit. Officiis, aspernatur.</p>
                            </div>
                        </div>
                    </a>
                </div>
            </article>
            <article class="box-topic col">
                <div class="content transition">
                    <a href="#" target="">
                        <img src="#" width="100%" height="100%" class="position-absolute top-0 start-0" alt="">
                        <div class="container-info d-flex flex-column justify-content-center align-items-center">
                            <figure class="image">
                                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" class="icon" width="61" alt="">
                            </figure>
                            <div class="description">
                                <h3 class="title">title</h3>
                                <p class="paragraph">Lorem ipsum dolor sit amet consectetur adipisicing elit. Officiis, aspernatur.</p>
                            </div>
                        </div>
                    </a>
                </div>
            </article>
            <article class="box-topic col">
                <div class="content transition">
                    <a href="#" target="">
                        <img src="#" width="100%" height="100%" class="position-absolute top-0 start-0" alt="">
                        <div class="container-info d-flex flex-column justify-content-center align-items-center">
                            <figure class="image">
                                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" class="icon" width="61" alt="">
                            </figure>
                            <div class="description">
                                <h3 class="title">title</h3>
                                <p class="paragraph">Lorem ipsum dolor sit amet consectetur adipisicing elit. Officiis, aspernatur.</p>
                            </div>
                        </div>
                    </a>
                </div>
            </article>
        </div>
    </div>
</section>

<!-- TEAM01 -->
<div class="serv07-page__content__product container">
    <header class="header-topic">
        <h3 class="container-title">
            <span class="title">title</span>
            <span class="subtitle">subtitle</span>
        </h3>
        <hr class="line">
        <p class="paragraph">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla, voluptate!</p>
    </header>
    <div class="row serv07-page__content--row carousel-serv07-product">
        <article class="serv07-page__content__product__item col-md-3">
            <div class="serv07-page__content__product__item__image">
                <img src="##" class="w-100 h-100" alt="Titulo Topico">
            </div>
            <div class="serv07-page__content__product__item__description d-flex  flex-column justify-content-end mx-0 w-100 text-center">
                <div class="serv07-page__content__product__item__description__encompass">
                    <div class="flex-column serv07-page__content__product__item__description__encompass__txt">
                        <h2 class="serv07-page__content__product__item__description__encompass__txt__title mx-0 px-0">title</h2>
                    </div>
                </div>
                <div class="serv07-page__content__product__item__description_paragraph text-start px-0 ">
                    <p>
                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deleniti, facere.
                    </p>
                </div>
                <div class="serv07-page__content__product__item__description__buttons">
                    <a rel="next" href="#" data-fancybox= "#" data-src="#"  class="serv07-page__content__product__item__description__buttons__cta transition d-flex justify-content-center align-items-center mx-auto">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv07-page__content__product__item__description__buttons__cta__icon me-3 transition">
                        CTA
                    </a>
                </div>
            </div>
        </article>
        <article class="serv07-page__content__product__item col-md-3">
            <div class="serv07-page__content__product__item__image">
                <img src="##" class="w-100 h-100" alt="Titulo Topico">
            </div>
            <div class="serv07-page__content__product__item__description d-flex  flex-column justify-content-end mx-0 w-100 text-center">
                <div class="serv07-page__content__product__item__description__encompass">
                    <div class="flex-column serv07-page__content__product__item__description__encompass__txt">
                        <h2 class="serv07-page__content__product__item__description__encompass__txt__title mx-0 px-0">title</h2>
                    </div>
                </div>
                <div class="serv07-page__content__product__item__description_paragraph text-start px-0 ">
                    <p>
                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deleniti, facere.
                    </p>
                </div>
                <div class="serv07-page__content__product__item__description__buttons">
                    <a rel="next" href="#" data-fancybox= "#" data-src="#"  class="serv07-page__content__product__item__description__buttons__cta transition d-flex justify-content-center align-items-center mx-auto">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv07-page__content__product__item__description__buttons__cta__icon me-3 transition">
                        CTA
                    </a>
                </div>
            </div>
        </article>
        <article class="serv07-page__content__product__item col-md-3">
            <div class="serv07-page__content__product__item__image">
                <img src="##" class="w-100 h-100" alt="Titulo Topico">
            </div>
            <div class="serv07-page__content__product__item__description d-flex  flex-column justify-content-end mx-0 w-100 text-center">
                <div class="serv07-page__content__product__item__description__encompass">
                    <div class="flex-column serv07-page__content__product__item__description__encompass__txt">
                        <h2 class="serv07-page__content__product__item__description__encompass__txt__title mx-0 px-0">title</h2>
                    </div>
                </div>
                <div class="serv07-page__content__product__item__description_paragraph text-start px-0 ">
                    <p>
                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deleniti, facere.
                    </p>
                </div>
                <div class="serv07-page__content__product__item__description__buttons">
                    <a rel="next" href="#" data-fancybox= "#" data-src="#"  class="serv07-page__content__product__item__description__buttons__cta transition d-flex justify-content-center align-items-center mx-auto">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv07-page__content__product__item__description__buttons__cta__icon me-3 transition">
                        CTA
                    </a>
                </div>
            </div>
        </article>
        <article class="serv07-page__content__product__item col-md-3">
            <div class="serv07-page__content__product__item__image">
                <img src="##" class="w-100 h-100" alt="Titulo Topico">
            </div>
            <div class="serv07-page__content__product__item__description d-flex  flex-column justify-content-end mx-0 w-100 text-center">
                <div class="serv07-page__content__product__item__description__encompass">
                    <div class="flex-column serv07-page__content__product__item__description__encompass__txt">
                        <h2 class="serv07-page__content__product__item__description__encompass__txt__title mx-0 px-0">title</h2>
                    </div>
                </div>
                <div class="serv07-page__content__product__item__description_paragraph text-start px-0 ">
                    <p>
                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deleniti, facere.
                    </p>
                </div>
                <div class="serv07-page__content__product__item__description__buttons">
                    <a rel="next" href="#" data-fancybox= "#" data-src="#"  class="serv07-page__content__product__item__description__buttons__cta transition d-flex justify-content-center align-items-center mx-auto">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv07-page__content__product__item__description__buttons__cta__icon me-3 transition">
                        CTA
                    </a>
                </div>
            </div>
        </article>
        <article class="serv07-page__content__product__item col-md-3">
            <div class="serv07-page__content__product__item__image">
                <img src="##" class="w-100 h-100" alt="Titulo Topico">
            </div>
            <div class="serv07-page__content__product__item__description d-flex  flex-column justify-content-end mx-0 w-100 text-center">
                <div class="serv07-page__content__product__item__description__encompass">
                    <div class="flex-column serv07-page__content__product__item__description__encompass__txt">
                        <h2 class="serv07-page__content__product__item__description__encompass__txt__title mx-0 px-0">title</h2>
                    </div>
                </div>
                <div class="serv07-page__content__product__item__description_paragraph text-start px-0 ">
                    <p>
                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deleniti, facere.
                    </p>
                </div>
                <div class="serv07-page__content__product__item__description__buttons">
                    <a rel="next" href="#" data-fancybox= "#" data-src="#"  class="serv07-page__content__product__item__description__buttons__cta transition d-flex justify-content-center align-items-center mx-auto">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv07-page__content__product__item__description__buttons__cta__icon me-3 transition">
                        CTA
                    </a>
                </div>
            </div>
        </article>
        <article class="serv07-page__content__product__item col-md-3">
            <div class="serv07-page__content__product__item__image">
                <img src="##" class="w-100 h-100" alt="Titulo Topico">
            </div>
            <div class="serv07-page__content__product__item__description d-flex  flex-column justify-content-end mx-0 w-100 text-center">
                <div class="serv07-page__content__product__item__description__encompass">
                    <div class="flex-column serv07-page__content__product__item__description__encompass__txt">
                        <h2 class="serv07-page__content__product__item__description__encompass__txt__title mx-0 px-0">title</h2>
                    </div>
                </div>
                <div class="serv07-page__content__product__item__description_paragraph text-start px-0 ">
                    <p>
                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deleniti, facere.
                    </p>
                </div>
                <div class="serv07-page__content__product__item__description__buttons">
                    <a rel="next" href="#" data-fancybox= "#" data-src="#"  class="serv07-page__content__product__item__description__buttons__cta transition d-flex justify-content-center align-items-center mx-auto">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv07-page__content__product__item__description__buttons__cta__icon me-3 transition">
                        CTA
                    </a>
                </div>
            </div>
        </article>
        <article class="serv07-page__content__product__item col-md-3">
            <div class="serv07-page__content__product__item__image">
                <img src="##" class="w-100 h-100" alt="Titulo Topico">
            </div>
            <div class="serv07-page__content__product__item__description d-flex  flex-column justify-content-end mx-0 w-100 text-center">
                <div class="serv07-page__content__product__item__description__encompass">
                    <div class="flex-column serv07-page__content__product__item__description__encompass__txt">
                        <h2 class="serv07-page__content__product__item__description__encompass__txt__title mx-0 px-0">title</h2>
                    </div>
                </div>
                <div class="serv07-page__content__product__item__description_paragraph text-start px-0 ">
                    <p>
                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deleniti, facere.
                    </p>
                </div>
                <div class="serv07-page__content__product__item__description__buttons">
                    <a rel="next" href="#" data-fancybox= "#" data-src="#"  class="serv07-page__content__product__item__description__buttons__cta transition d-flex justify-content-center align-items-center mx-auto">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv07-page__content__product__item__description__buttons__cta__icon me-3 transition">
                        CTA
                    </a>
                </div>
            </div>
        </article>
        <article class="serv07-page__content__product__item col-md-3">
            <div class="serv07-page__content__product__item__image">
                <img src="##" class="w-100 h-100" alt="Titulo Topico">
            </div>
            <div class="serv07-page__content__product__item__description d-flex  flex-column justify-content-end mx-0 w-100 text-center">
                <div class="serv07-page__content__product__item__description__encompass">
                    <div class="flex-column serv07-page__content__product__item__description__encompass__txt">
                        <h2 class="serv07-page__content__product__item__description__encompass__txt__title mx-0 px-0">title</h2>
                    </div>
                </div>
                <div class="serv07-page__content__product__item__description_paragraph text-start px-0 ">
                    <p>
                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deleniti, facere.
                    </p>
                </div>
                <div class="serv07-page__content__product__item__description__buttons">
                    <a rel="next" href="#" data-fancybox= "#" data-src="#"  class="serv07-page__content__product__item__description__buttons__cta transition d-flex justify-content-center align-items-center mx-auto">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv07-page__content__product__item__description__buttons__cta__icon me-3 transition">
                        CTA
                    </a>
                </div>
            </div>
        </article>
    </div>
</div>


{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
