@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<main id="root">
    <section id="BLOG01" class="blog01-show container-fluid">
        <div class="container">
            <div class="row justify-content-between">
                <div class="blog01-show__col-start col-12 col-sm-8">
                    <article itemscope itemtype="http://schema.org/Article" class="blog01-show__item">
                        <h1 itemprop="name" class="blog01-show__item__title">{{$blog->title}}</h1>
                        <span class="blog01-show__item__published">
                            Publicado em: <span itemprop="datePublished" content="{{$blog->publishing}}" class="blog01-show__item__date">{{ Carbon\Carbon::parse($blog->publishing)->format('d/m/Y')}}</span>
                        </span>
                        <p itemprop="articleSection" class="blog01-show__item__paragraph">{!! $blog->description !!} </p>
                        <figure class="blog01-show__item__image">
                            <img itemprop="image" src="{{asset('storage/' .$blog->path_image)}}" width="100%" alt="{{$blog->title}}" class="blog01-show__item__img"/>
                        </figure>
                        <div itemprop="articleBody" class="ck-content blog01-show__item__description">
                            <p>
                                {!!$blog->text!!}
                            </p>
                        </div>
                    </article>
                </div>
                <div class="blog01-show__col-end col-12 col-sm-3">
                    <div class="blog01-show__related">
                        {{-- <a href="" class="blog01-show__related__share">Compartilhar Artigo</a> --}}
                        <h4 class="blog01-show__related__title">Artigos Relacionados</h4>
                        @foreach ($blogsRelated as $blogRelated)
                            <article class="blog01-show__boxs__item">
                                <div itemscope itemtype="http://schema.org/Article" class="blog01-show__boxs__item__content transition">
                                    <a itemprop="url" href="{{route('blog03.show.content', ['BLOG03BlogsCategory' => $blogRelated->category->slug, 'BLOG03Blogs' => $blogRelated->slug])}}">
                                        <figure class="blog01-show__boxs__item__image">
                                            <img itemprop="image" src="{{asset('storage/' . $blogRelated->path_image)}}" class="blog01-show__boxs__item__image__img" width="100%" alt="{{$blogRelated->title}}"/>
                                        </figure>
                                        <div class="blog01-show__boxs__item__description">
                                            <span class="blog01-show__boxs__item__date-publish">
                                                Publicado em: <span itemprop="datePublished" content="{{$blog->publishing}}" class="blog01-show__item__date">{{ Carbon\Carbon::parse($blog->publishing)->format('d/m/Y')}}</span>
                                            </span>
                                            <h3 itemprop="name" class="blog01-show__boxs__item__title">{{$blogRelated->title}}</h3>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <p itemprop="articleBody" class="blog01-show__boxs__item__paragraph">{!! $blog->description !!}</p>
                                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="34" class="blog01-show__boxs__item__icon ms-3" alt="titulo dos blogs"/>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </article>
                        @endforeach
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
