@extends('Client.Core.client')
@section('content')
    <main id="root">
        <section id="BLOG01" class="blog01-show container-fluid">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="blog01-show__col-start col-12 col-sm-8">
                        <article class="blog01-show__item">
                            <h1 class="blog01-show__item__title">Titulo da Notícia completa aqui</h1>
                            <span class="blog01-show__item__published">
                                Data: <span class="blog01-show__item__date">12 de Outubro de 2022</span>
                            </span>
                            <p class="blog01-show__item__paragraph">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretiu
                            </p>
                            <figure class="blog01-show__item__image">
                                <img src="{{asset('storage/uploads/tmp/inner-image.jpg')}}" width="100%" alt="Titulo da Notícia completa aqui" class="blog01-show__item__img">
                            </figure>
                            <div class="blog01-show__item__description">
                                <b>Lorem ipsum dolor sit</b> <i>Lorem ipsum dolor</i> <strong>Lorem ipsum dolor sit amet</strong>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero.
                                Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere.
                                Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                Cras vel tortorLorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero.
                                Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus.
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortorLorem ipsum dolor sit amet, consectetur adipiscing elit.
                                Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed.
                                In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                Cras vel tortorLorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero.
                                Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere.
                                Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor
                                <ul>
                                    <li>Lorem ipsum dolor sit amet</li>
                                    <li>Lorem ipsum dolor sit amet</li>
                                    <li>Lorem ipsum dolor sit amet</li>
                                    <li>Lorem ipsum dolor sit amet</li>
                                    <li>Lorem ipsum dolor sit amet</li>
                                    <li>Lorem ipsum dolor sit amet</li>
                                    <li>Lorem ipsum dolor sit amet</li>
                                    <li>Lorem ipsum dolor sit amet</li>
                                    <li>Lorem ipsum dolor sit amet</li>
                                    <li>Lorem ipsum dolor sit amet</li>
                                    <li>Lorem ipsum dolor sit amet</li>
                                </ul>
                                <ol>
                                    <li>Lorem ipsum dolor sit amet</li>
                                    <li>Lorem ipsum dolor sit amet</li>
                                    <li>Lorem ipsum dolor sit amet</li>
                                    <li>Lorem ipsum dolor sit amet</li>
                                    <li>Lorem ipsum dolor sit amet</li>
                                    <li>Lorem ipsum dolor sit amet</li>
                                    <li>Lorem ipsum dolor sit amet</li>
                                    <li>Lorem ipsum dolor sit amet</li>
                                    <li>Lorem ipsum dolor sit amet</li>
                                    <li>Lorem ipsum dolor sit amet</li>
                                    <li>Lorem ipsum dolor sit amet</li>
                                </ol>
                            </div>

                        </article>
                    </div>
                    <div class="blog01-show__col-end col-12 col-sm-3">
                        <div class="blog01-show__related">
                            {{-- <a href="" class="blog01-show__related__share">Compartilhar Artigo</a> --}}
                            <h4 class="blog01-show__related__title">Artigos Relacionados</h4>
                            <article class="blog01-show__boxs__item">
                                <div itemscope itemtype="http://schema.org/Article" class="blog01-show__boxs__item__content transition">
                                    <a itemprop="url" href="{{route('blog01.show',['BLOG01Blogs' => 1])}}">
                                        <figure class="blog01-show__boxs__item__image">
                                            <img itemprop="image" src="{{asset('storage/uploads/tmp/image-box.jpg')}}" class="blog01-show__boxs__item__image__img" width="100%" alt="Titulo Topico"/>
                                        </figure>
                                        <div class="blog01-show__boxs__item__description">
                                            <span class="blog01-show__boxs__item__date-publish">
                                                Data: <span itemprop="datePublished" class="blog01-show__boxs__item__date">12 de Outubro de 2022</span>
                                            </span>
                                            <h3 itemprop="name" class="blog01-show__boxs__item__title">Titulo Topico</h3>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <p itemprop="articleBody" class="blog01-show__boxs__item__paragraph">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="34" class="blog01-show__boxs__item__icon ms-3" alt="Titulo Topico"/>
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
@endsection
