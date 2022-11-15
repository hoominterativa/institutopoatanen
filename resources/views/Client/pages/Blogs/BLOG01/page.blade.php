@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<main id="root">
    <section id="BLOG01" class="blog01-page container-fluid">
        <header class="blog01-page__header row flex-column justify-content-center" style="background-image: url({{asset('storage/uploads/tmp/bg-banner-inner.jpg')}})">
            <h1 class="blog01-page__header__title col-12">Título Página</h1>
            <nav class="blog01-page__header__category blog01-page__header__category__carousel col-12 d-flex justify-content-center">
                <a href="#" class="blog01-page__header__category__item blog01-page__header__category__item--active">Categoria Artigo</a>
                <a href="#" class="blog01-page__header__category__item">Categoria Artigo</a>
                <a href="#" class="blog01-page__header__category__item">Categoria Artigo</a>
                <a href="#" class="blog01-page__header__category__item">Categoria Artigo</a>
            </nav>
        </header>
        <div class="container">
            <div class="blog01-page__boxs row">
                <div class="blog01-page__boxs__featured blog01-page__boxs__featured__carousel col-12">
                    <article class="blog01-page__boxs__featured__item">
                        <div itemscope itemtype="http://schema.org/Article" class="blog01-page__boxs__featured__item__content transition row align-items-center">
                            <figure class="blog01-page__boxs__featured__item__image col-12 col-sm-6">
                                <a itemprop="url" href="{{route('blog01.show', ['BLOG01Blogs' => 1])}}">
                                    <img itemprop="image" src="{{asset('storage/uploads/tmp/inner-image.jpg')}}" class="blog01-page__boxs__featured__item__image__img" width="100%" alt="Titulo da Notícia"/>
                                </a>
                            </figure>
                            <div class="blog01-page__boxs__featured__item__description col-12 col-sm-6">
                                <span class="blog01-page__boxs__featured__item__category">Categoria do Artigo</span>
                                <a itemprop="url" href="{{route('blog01.show', ['BLOG01Blogs' => 1])}}">
                                    <h2 itemprop="name" class="blog01-page__boxs__featured__item__title">Titulo da Notícia</h2>
                                </a>
                                <span class="blog01-page__boxs__featured__item__date-publish">
                                    Data: <span itemprop="datePublished" content="2022-10-12" class="blog01-page__boxs__featured__item__date">12 de Outubro de 2022</span>
                                </span>
                                <p itemprop="articleBody" class="blog01-page__boxs__featured__item__paragraph">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero.
                                    Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere.
                                    Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor
                                </p>
                                <a itemprop="url" href="{{route('blog01.show', ['BLOG01Blogs' => 1])}}" class="blog01-page__boxs__featured__item__cta d-flex align-items-center justify-content-center ms-auto">
                                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="25" class="blog01-page__boxs__featured__item__cta__icon me-3" alt="Titulo da Notícia"/>
                                    CTA
                                </a>
                            </div>
                        </div>
                    </article>
                    {{-- END .blog01-page__boxs__featured__item --}}

                    <article class="blog01-page__boxs__featured__item">
                        <div itemscope itemtype="http://schema.org/Article" class="blog01-page__boxs__featured__item__content transition row align-items-center">
                            <figure class="blog01-page__boxs__featured__item__image col-12 col-sm-6">
                                <a itemprop="url" href="{{route('blog01.show', ['BLOG01Blogs' => 1])}}">
                                    <img itemprop="image" src="{{asset('storage/uploads/tmp/inner-image.jpg')}}" class="blog01-page__boxs__featured__item__image__img" width="100%" alt="Titulo da Notícia"/>
                                </a>
                            </figure>
                            <div class="blog01-page__boxs__featured__item__description col-12 col-sm-6">
                                <span class="blog01-page__boxs__featured__item__category">Categoria do Artigo</span>
                                <a itemprop="url" href="{{route('blog01.show', ['BLOG01Blogs' => 1])}}">
                                    <h2 itemprop="name" class="blog01-page__boxs__featured__item__title">Titulo da Notícia</h2>
                                </a>
                                <span class="blog01-page__boxs__featured__item__date-publish">
                                    Data: <span itemprop="datePublished" content="2022-10-12" class="blog01-page__boxs__featured__item__date">12 de Outubro de 2022</span>
                                </span>
                                <p itemprop="articleBody" class="blog01-page__boxs__featured__item__paragraph">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero.
                                    Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere.
                                    Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor
                                </p>
                                <a itemprop="url" href="{{route('blog01.show', ['BLOG01Blogs' => 1])}}" class="blog01-page__boxs__featured__item__cta d-flex align-items-center justify-content-center ms-auto">
                                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="25" class="blog01-page__boxs__featured__item__cta__icon me-3" alt="Titulo da Notícia"/>
                                    CTA
                                </a>
                            </div>
                        </div>
                    </article>
                    {{-- END .blog01-page__boxs__featured__item --}}
                </div>
                {{-- END .blog01-page__boxs__featured --}}

                <article class="blog01-page__boxs__item col-12 col-sm-3">
                    <div itemscope itemtype="http://schema.org/Article" class="blog01-page__boxs__item__content transition">
                        <a itemprop="url" href="{{route('blog01.show',['BLOG01Blogs' => 1])}}">
                            <figure class="blog01-page__boxs__item__image">
                                <img itemprop="image" src="{{asset('storage/uploads/tmp/image-box.jpg')}}" class="blog01-page__boxs__item__image__img" width="100%" alt="Titulo Topico"/>
                            </figure>
                            <div class="blog01-page__boxs__item__description">
                                <span class="blog01-page__boxs__item__date-publish">
                                    Data: <span itemprop="datePublished" class="blog01-page__boxs__item__date">12 de Outubro de 2022</span>
                                </span>
                                <h3 itemprop="name" class="blog01-page__boxs__item__title">Titulo Topico</h3>
                                <div class="d-flex align-items-center justify-content-between">
                                    <p itemprop="articleBody" class="blog01-page__boxs__item__paragraph">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="34" class="blog01-page__boxs__item__icon ms-3" alt="Titulo Topico"/>
                                </div>
                            </div>
                        </a>
                    </div>
                </article>
                {{-- END .blog01-page__boxs__item --}}
                <article class="blog01-page__boxs__item col-12 col-sm-3">
                    <div itemscope itemtype="http://schema.org/Article" class="blog01-page__boxs__item__content transition">
                        <a itemprop="url" href="{{route('blog01.show',['BLOG01Blogs' => 1])}}">
                            <figure class="blog01-page__boxs__item__image">
                                <img itemprop="image" src="{{asset('storage/uploads/tmp/image-box.jpg')}}" class="blog01-page__boxs__item__image__img" width="100%" alt="Titulo Topico"/>
                            </figure>
                            <div class="blog01-page__boxs__item__description">
                                <span class="blog01-page__boxs__item__date-publish">
                                    Data: <span itemprop="datePublished" class="blog01-page__boxs__item__date">12 de Outubro de 2022</span>
                                </span>
                                <h3 itemprop="name" class="blog01-page__boxs__item__title">Titulo Topico</h3>
                                <div class="d-flex align-items-center justify-content-between">
                                    <p itemprop="articleBody" class="blog01-page__boxs__item__paragraph">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="34" class="blog01-page__boxs__item__icon ms-3" alt="Titulo Topico"/>
                                </div>
                            </div>
                        </a>
                    </div>
                </article>
                {{-- END .blog01-page__boxs__item --}}
                <article class="blog01-page__boxs__item col-12 col-sm-3">
                    <div itemscope itemtype="http://schema.org/Article" class="blog01-page__boxs__item__content transition">
                        <a itemprop="url" href="{{route('blog01.show',['BLOG01Blogs' => 1])}}">
                            <figure class="blog01-page__boxs__item__image">
                                <img itemprop="image" src="{{asset('storage/uploads/tmp/image-box.jpg')}}" class="blog01-page__boxs__item__image__img" width="100%" alt="Titulo Topico"/>
                            </figure>
                            <div class="blog01-page__boxs__item__description">
                                <span class="blog01-page__boxs__item__date-publish">
                                    Data: <span itemprop="datePublished" class="blog01-page__boxs__item__date">12 de Outubro de 2022</span>
                                </span>
                                <h3 itemprop="name" class="blog01-page__boxs__item__title">Titulo Topico</h3>
                                <div class="d-flex align-items-center justify-content-between">
                                    <p itemprop="articleBody" class="blog01-page__boxs__item__paragraph">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="34" class="blog01-page__boxs__item__icon ms-3" alt="Titulo Topico"/>
                                </div>
                            </div>
                        </a>
                    </div>
                </article>
                {{-- END .blog01-page__boxs__item --}}
                <article class="blog01-page__boxs__item col-12 col-sm-3">
                    <div itemscope itemtype="http://schema.org/Article" class="blog01-page__boxs__item__content transition">
                        <a itemprop="url" href="{{route('blog01.show',['BLOG01Blogs' => 1])}}">
                            <figure class="blog01-page__boxs__item__image">
                                <img itemprop="image" src="{{asset('storage/uploads/tmp/image-box.jpg')}}" class="blog01-page__boxs__item__image__img" width="100%" alt="Titulo Topico"/>
                            </figure>
                            <div class="blog01-page__boxs__item__description">
                                <span class="blog01-page__boxs__item__date-publish">
                                    Data: <span itemprop="datePublished" class="blog01-page__boxs__item__date">12 de Outubro de 2022</span>
                                </span>
                                <h3 itemprop="name" class="blog01-page__boxs__item__title">Titulo Topico</h3>
                                <div class="d-flex align-items-center justify-content-between">
                                    <p itemprop="articleBody" class="blog01-page__boxs__item__paragraph">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="34" class="blog01-page__boxs__item__icon ms-3" alt="Titulo Topico"/>
                                </div>
                            </div>
                        </a>
                    </div>
                </article>
                {{-- END .blog01-page__boxs__item --}}
                <article class="blog01-page__boxs__item col-12 col-sm-3">
                    <div itemscope itemtype="http://schema.org/Article" class="blog01-page__boxs__item__content transition">
                        <a itemprop="url" href="{{route('blog01.show',['BLOG01Blogs' => 1])}}">
                            <figure class="blog01-page__boxs__item__image">
                                <img itemprop="image" src="{{asset('storage/uploads/tmp/image-box.jpg')}}" class="blog01-page__boxs__item__image__img" width="100%" alt="Titulo Topico"/>
                            </figure>
                            <div class="blog01-page__boxs__item__description">
                                <span class="blog01-page__boxs__item__date-publish">
                                    Data: <span itemprop="datePublished" class="blog01-page__boxs__item__date">12 de Outubro de 2022</span>
                                </span>
                                <h3 itemprop="name" class="blog01-page__boxs__item__title">Titulo Topico</h3>
                                <div class="d-flex align-items-center justify-content-between">
                                    <p itemprop="articleBody" class="blog01-page__boxs__item__paragraph">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="34" class="blog01-page__boxs__item__icon ms-3" alt="Titulo Topico"/>
                                </div>
                            </div>
                        </a>
                    </div>
                </article>
                {{-- END .blog01-page__boxs__item --}}
                <article class="blog01-page__boxs__item col-12 col-sm-3">
                    <div itemscope itemtype="http://schema.org/Article" class="blog01-page__boxs__item__content transition">
                        <a itemprop="url" href="{{route('blog01.show',['BLOG01Blogs' => 1])}}">
                            <figure class="blog01-page__boxs__item__image">
                                <img itemprop="image" src="{{asset('storage/uploads/tmp/image-box.jpg')}}" class="blog01-page__boxs__item__image__img" width="100%" alt="Titulo Topico"/>
                            </figure>
                            <div class="blog01-page__boxs__item__description">
                                <span class="blog01-page__boxs__item__date-publish">
                                    Data: <span itemprop="datePublished" class="blog01-page__boxs__item__date">12 de Outubro de 2022</span>
                                </span>
                                <h3 itemprop="name" class="blog01-page__boxs__item__title">Titulo Topico</h3>
                                <div class="d-flex align-items-center justify-content-between">
                                    <p itemprop="articleBody" class="blog01-page__boxs__item__paragraph">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="34" class="blog01-page__boxs__item__icon ms-3" alt="Titulo Topico"/>
                                </div>
                            </div>
                        </a>
                    </div>
                </article>
                {{-- END .blog01-page__boxs__item --}}
                <article class="blog01-page__boxs__item col-12 col-sm-3">
                    <div itemscope itemtype="http://schema.org/Article" class="blog01-page__boxs__item__content transition">
                        <a itemprop="url" href="{{route('blog01.show',['BLOG01Blogs' => 1])}}">
                            <figure class="blog01-page__boxs__item__image">
                                <img itemprop="image" src="{{asset('storage/uploads/tmp/image-box.jpg')}}" class="blog01-page__boxs__item__image__img" width="100%" alt="Titulo Topico"/>
                            </figure>
                            <div class="blog01-page__boxs__item__description">
                                <span class="blog01-page__boxs__item__date-publish">
                                    Data: <span itemprop="datePublished" class="blog01-page__boxs__item__date">12 de Outubro de 2022</span>
                                </span>
                                <h3 itemprop="name" class="blog01-page__boxs__item__title">Titulo Topico</h3>
                                <div class="d-flex align-items-center justify-content-between">
                                    <p itemprop="articleBody" class="blog01-page__boxs__item__paragraph">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="34" class="blog01-page__boxs__item__icon ms-3" alt="Titulo Topico"/>
                                </div>
                            </div>
                        </a>
                    </div>
                </article>
                {{-- END .blog01-page__boxs__item --}}
                <article class="blog01-page__boxs__item col-12 col-sm-3">
                    <div itemscope itemtype="http://schema.org/Article" class="blog01-page__boxs__item__content transition">
                        <a itemprop="url" href="{{route('blog01.show',['BLOG01Blogs' => 1])}}">
                            <figure class="blog01-page__boxs__item__image">
                                <img itemprop="image" src="{{asset('storage/uploads/tmp/image-box.jpg')}}" class="blog01-page__boxs__item__image__img" width="100%" alt="Titulo Topico"/>
                            </figure>
                            <div class="blog01-page__boxs__item__description">
                                <span class="blog01-page__boxs__item__date-publish">
                                    Data: <span itemprop="datePublished" class="blog01-page__boxs__item__date">12 de Outubro de 2022</span>
                                </span>
                                <h3 itemprop="name" class="blog01-page__boxs__item__title">Titulo Topico</h3>
                                <div class="d-flex align-items-center justify-content-between">
                                    <p itemprop="articleBody" class="blog01-page__boxs__item__paragraph">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="34" class="blog01-page__boxs__item__icon ms-3" alt="Titulo Topico"/>
                                </div>
                            </div>
                        </a>
                    </div>
                </article>
                {{-- END .blog01-page__boxs__item --}}


                <div class="blog01-page__pagination">
                    <nav class="float-end">
                        <ul class="pagination">
                          <li class="page-item">
                            <a class="page-link" href="#" aria-label="Anterior">
                              <span aria-hidden="true">&laquo;</span>
                            </a>
                          </li>
                          <li class="page-item"><a class="page-link" href="#">1</a></li>
                          <li class="page-item"><a class="page-link" href="#">2</a></li>
                          <li class="page-item"><a class="page-link" href="#">3</a></li>
                          <li class="page-item">
                            <a class="page-link" href="#" aria-label="Próximo">
                              <span aria-hidden="true">&raquo;</span>
                            </a>
                          </li>
                        </ul>
                      </nav>
                </div>
            </div>
            {{-- END .blog01-page__boxs --}}


        </div>
        {{-- END .container --}}
    </section>
</main>
{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
