@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<section id="BLOG03" class="blog03-page container-fluid px-0">
    <header class="blog03-page__header bg-light" style="background-image: url({{asset('images/image-blog.jpg')}})">
        <div class="container d-flex flex-column justify-content-center h-100">
            <h1 class="blog03-page__header__title">Título página</h1>
        </div>
    </header>
    <div class="container">
        <div class="blog03-page__navigation">
            <nav class="blog03-page__category blog03-page__category__carousel d-flex justify-content-center">
                <li>
                    <a href="#" class="blog03-page__category__item">Categoria Artigo</a>
                </li>
            </nav>
            <form action="" class="blog03-page__search">
                <label for="">
                    <input type="search" name="search" placeholder="Pesquisar">
                </label>
            </form>
        </div>
        <div class="blog03-page__boxs row">
            <div class="blog03-page__boxs__featured blog03-page__boxs__featured__carousel col-12">
                <article class="blog03-page__boxs__item col-12 col-sm-3">
                    <div itemscope itemtype="http://schema.org/Article" class="blog03-page__boxs__item__content transition">
                        <a itemprop="url" href="#">
                            <figure class="blog03-page__boxs__item__image">
                                <img itemprop="image" src="{{asset('storage/uploads/tmp/inner-image.jpg')}}" class="blog03-page__boxs__item__image__img" width="100%" alt="Título Blog"/>
                            </figure>
                            <div class="blog03-page__boxs__item__description">
                                <h3 itemprop="name" class="blog03-page__boxs__item__title">Lorem ipsum dolor sit amet, consect etur adipiscing elit</h3>
                                <div class="blog03-page__boxs__item__cta">
                                    <a href="#"><img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" class="blog03-page__boxs__item__cta__icon" alt="title"/> CTA</a>
                                </div>
                            </div>
                        </a>
                    </div>
                </article>
                {{-- END .blog03-page__boxs__item --}}
            </div>

            <div class="blog03-page__pagination">
                <li>
                    <a href="#"></a>
                </li>
            </div>
        </div>
        {{-- END .blog03-page__boxs --}}
    </div>
    {{-- END .container --}}
</section>
</main>
{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
