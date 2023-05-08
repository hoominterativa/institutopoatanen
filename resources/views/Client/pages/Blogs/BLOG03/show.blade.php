@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<main id="root">
    <section id="BLOG01" class="blog01-show container-fluid">
        <div class="container">
            <div class="row justify-content-between">
                <div class="blog01-show__col-start col-12 col-sm-8">
                    <article itemscope itemtype="http://schema.org/Article" class="blog01-show__item">
                        <h1 itemprop="name" class="blog01-show__item__title">Titulo da Notícia completa aqui</h1>
                        <span class="blog01-show__item__published">
                            Data: <span itemprop="datePublished" content="12 de Outubro de 2022" class="blog01-show__item__date">12 de Outubro de 2022</span>
                        </span>
                        <p itemprop="articleSection" class="blog01-show__item__paragraph">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretiu</p>
                        <figure class="blog01-show__item__image">
                            <img itemprop="image" src="{{asset('storage/uploads/tmp/inner-image.jpg')}}" width="100%" alt="titulo do blog" class="blog01-show__item__img"/>
                        </figure>
                        <div itemprop="articleBody" class="ck-content blog01-show__item__description">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus 
                                gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. 
                                In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, 
                                consectetur adipiscing elit. Cras vel tortorLorem ipsum dolor sit amet, consectetur adipiscing elit. 
                                Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi 
                                pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor 
                                sit amet, consectetur adipiscing elit. Cras vel tortorLorem ipsum dolor sit amet, consectetur adipiscing elit. 
                                Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. 
                                In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur 
                                adipiscing elit. Cras vel tortorLorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus 
                                gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus 
                                mattis posuere. Donec tincidunt dignissim faucibus. 
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor
                            </p>
                        </div>
                    </article>
                </div>
                <div class="blog01-show__col-end col-12 col-sm-3">
                    <div class="blog01-show__related">
                        {{-- <a href="" class="blog01-show__related__share">Compartilhar Artigo</a> --}}
                        <h4 class="blog01-show__related__title">Artigos Relacionados</h4>
                            <article class="blog01-show__boxs__item">
                                <div itemscope itemtype="http://schema.org/Article" class="blog01-show__boxs__item__content transition">
                                    <a itemprop="url" href="blogs">
                                        <figure class="blog01-show__boxs__item__image">
                                            <img itemprop="image" src="{{asset('storage/uploads/tmp/inner-image.jpg')}}" class="blog01-show__boxs__item__image__img" width="100%" alt="titulo dos blogs"/>
                                        </figure>
                                        <div class="blog01-show__boxs__item__description">
                                            <span class="blog01-show__boxs__item__date-publish">
                                                Data: <span itemprop="datePublished" content="12 de Outubro de 2022" class="blog01-show__boxs__item__date">12 de Outubro de 2022</span>
                                            </span>
                                            <h3 itemprop="name" class="blog01-show__boxs__item__title">Titulo Topico</h3>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <p itemprop="articleBody" class="blog01-show__boxs__item__paragraph">Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="34" class="blog01-show__boxs__item__icon ms-3" alt="titulo dos blogs"/>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </article>
                        {{-- END .blog01-page__boxs__item --}}
                    </div>
                </div>
            </div>
        </div>
        {{-- END .container --}}
    </section>
    {{-- END .blog01-show --}}
</main>
{{-- END #root --}}
{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
