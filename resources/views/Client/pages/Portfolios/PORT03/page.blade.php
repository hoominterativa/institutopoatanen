@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<section class="port03-page popa">
    @if (isset($section->active_banner))
        <header class="popa__banner container-fluid px-0">
            <div class="popa__banner__container">
                <div class="popa__banner__image"
                style="background-image: url({{ asset('storage/' . $section->path_image_desktop_banner) }});  background-color: {{$section->background_color_banner}} ;">
                    <div class="container popa__banner__header text-center">
                        @if ($section->title_banner)
                            <h4 class="popa__banner__header__title">{{$section->title_banner}}</h4>
                            <hr class="popa__banner__header__line">
                        @endif
                    </div>
                </div>
            </div>
        </header>
    @endif
    <main class="popa__portfolio">
        @if (isset($section->active_content))
            <div class="popa__portfolio__header">
                <div class="container">
                    <div class="popa__portfolio__header__top">
                        <div class="popa__portfolio__header__top__left">
                            @if ($section->path_image_icon_content)
                                <img src="{{ asset('storage/' . $section->path_image_icon_content) }}" alt="Ícone da categoria" class="popa__portfolio__header__top__left__icon">
                            @endif
                        </div>
                        <div class="popa__portfolio__header__top__right">
                            @if ($section->title_content || $section->subtitle_content)
                                <h2 class="popa__portfolio__header__top__right__title">{{$section->title_content}}</h2>
                                <h1 class="popa__portfolio__header__top__right__subtitle">{{$section->subtitle_content}}</h1>
                            @endif
                        </div>
                    </div>
                    <div class="popa__portfolio__header__bottom">
                        <hr class="popa__portfolio__header__bottom__line">
                        <div class="popa__portfolio__header__bottom__description">
                            @if ($section->description_content)
                                <p>
                                    {!! $section->description_content !!}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
            <nav class="popa__portfolio__categories">
                <div class="container">
                    <ul class="popa__portfolio__categories__list w-100  mb-0 px-0">
                        <div class="popa__portfolio__categories__carousel">
                                @for ($i = 0; $i <= 16; $i++)
                                <li
                                    class="popa__portfolio__categories__list__item">
                                    <a class=" d-flex w-100 h-100 justify-content-between align-items-center" href="#">
                                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="Ícone da categoria"
                                                class="popa__portfolio__categories__list__item__icon">
                                            Categoria
                                    </a>
                                </li>
                                @endfor
                        </div>
                    </ul>

                    <div class="popa__portfolio__categories__dropdown-mobile">
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div class="accordion-item">
                                <h2
                                    class="accordion-header popa__portfolio__categories__dropdown-mobile__item">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                        aria-expanded="false" aria-controls="flush-collapseOne">
                                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}"
                                            alt=""
                                            class="popa__portfolio__categories__dropdown-mobile__item__icon">
                                        Categorias
                                    </button>
                                </h2>
                                <div id="flush-collapseOne" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <ul>

                                                <li
                                                    class="popa__portfolio__categories__dropdown-mobile__item">
                                                    <a class=" d-flex w-100 h-100 justify-content-start align-items-center"
                                                        href="#">
                                                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}"
                                                                alt="Ícone da categoria"
                                                                class="popa__portfolio__categories__dropdown-mobile__item__icon">
                                                            Categoria
                                                    </a>
                                                </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            <div class="popa__portfolio__content container px-0">
                <div class="row">
                @for ($i = 0; $i <= 16; $i++)
                <article class="popa__portfolio__content__item col-sm-4 position-relative">
                    <a class="link-full" href="#"></a>
                    <div class="popa__portfolio__content__item__encompass">
                        <div class="popa__portfolio__content__item__images mx-auto">
                            <div class="carousel-box-image owl-carousel">
                                <div class="popa__portfolio__content__item__images__image">
                                    {{-- <span class="before-text">Antes</span> --}}
                                    <img src="{{ asset('storage/uploads/tmp/gall01_image1.png') }}" alt="Imagem">
                                </div>
                                {{-- fim popa__portfolio__content__item__images__image --}}
                                <div class="popa__portfolio__content__item__images__image">
                                    {{-- <span class="after-text">Depois</span> --}}
                                    <img src="{{ asset('storage/uploads/tmp/gall01_image1.png') }}" alt="Imagem">
                                </div>
                                {{-- fim popa__portfolio__content__item__images__image --}}
                            </div>
                        </div>
                        <div class="popa__portfolio__content__item__description">
                            <h4 class="popa__portfolio__content__item__description__title">Título</h4>
                            <div class="popa__portfolio__content__item__description__paragraph">
                                <p>Descrição</p>
                            </div>
                        </div>
                    </div>
                </article>
                {{-- fim popa__portfolio__content__item --}}
                @endfor
                </div>
            </div>
    </main>
</section>
{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
