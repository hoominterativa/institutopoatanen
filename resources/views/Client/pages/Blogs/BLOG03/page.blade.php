@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<section id="BLOG03" class="blog03-page container-fluid px-0">
    <header class="blog03-page__header bg-light" style="background-image: url({{asset('images/image-blog.jpg')}})">
        <div class="container d-flex flex-column justify-content-center h-100">
            <h1 class="blog03-page__header__title">Título página</h1>
        </div>
    </header>
    <div class="container container--pg">
        <div class="blog03-page__navigation">
            <nav class="blog03-page__category blog03-page__category__carousel d-flex">
                <li class="blog03-page__category__item active">
                    <a href="#" >Categoria Artigo</a>
                </li>
                <li class="blog03-page__category__item">
                    <a href="#" >Categoria Artigo</a>
                </li>
                 <li class="blog03-page__category__item">
                    <a href="#" >Categoria Artigo</a>
                </li>
            </nav>
            <form action="" class="blog03-page__search">
                <div class="blog03-page__search__content">
                    <input type="text" name="search" placeholder="Buscar">
                    <img src="{{asset('storage/uploads/tmp/lupa.png')}}" alt="Lupa">
                </div>
            </form>
        </div>
        <div class="blog03-page__boxs row">
                <article class="blog03-page__boxs__item col-sm-6">
                    <div itemscope itemtype="http://schema.org/Article" class="blog03-page__boxs__item__content transition">
                        <a itemprop="url" href="{{route('blog03.show')}}" class="link-full"></a>
                        <figure class="blog03-page__boxs__item__image">
                            <img itemprop="image" src="{{asset('storage/uploads/tmp/inner-image.jpg')}}" class="blog03-page__boxs__item__image__img" width="100%" alt="Título Blog"/>
                        </figure>
                        <div class="blog03-page__boxs__item__description">
                            <div class="blog03-page__boxs__item__buttons">
                                <h3 itemprop="name" class="blog03-page__boxs__item__title">Lorem ipsum dolor sit amet, consect etur adipiscing elit</h3>
                                <div class="blog03-page__boxs__item__cta">
                                    <a href="{{route('blog03.show')}}"><img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" class="blog03-page__boxs__item__cta__icon" alt="title"/> CTA</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                {{-- END .blog03-page__boxs__item --}}
                <article class="blog03-page__boxs__item col-sm-6">
                    <div itemscope itemtype="http://schema.org/Article" class="blog03-page__boxs__item__content transition">
                        <a itemprop="url" href="{{route('blog03.show')}}" class="link-full"></a>
                        <figure class="blog03-page__boxs__item__image">
                            <img itemprop="image" src="{{asset('storage/uploads/tmp/inner-image.jpg')}}" class="blog03-page__boxs__item__image__img" width="100%" alt="Título Blog"/>
                        </figure>
                        <div class="blog03-page__boxs__item__description">
                            <h3 itemprop="name" class="blog03-page__boxs__item__title">Lorem ipsum dolor sit amet, consect etur adipiscing elit</h3>
                            <div class="blog03-page__boxs__item__cta">
                                <a href="{{route('blog03.show')}}"><img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" class="blog03-page__boxs__item__cta__icon" alt="title"/> CTA</a>
                            </div>
                        </div>
                    </div>
                </article>
                {{-- END .blog03-page__boxs__item --}}
        </div>
        {{-- END .blog03-page__boxs --}}
        <nav aria-label="..." class="blog03-page__pagination">
            <ul class="pagination pagination-sm">
                <li class="page-item active" aria-current="page">
                <span class="page-link">1</span>
                </li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
            </ul>
        </nav>
    </div>
    {{-- END .container --}}
</section>
</main>
{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
