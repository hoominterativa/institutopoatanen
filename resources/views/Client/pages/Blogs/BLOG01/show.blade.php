@extends('Client.Core.client')
@section('content')
    <main id="root">
        <section id="BLOG01" class="blog01-show container-fluid">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="blog01-show__col-start col-12 col-sm-8">
                        <article itemscope itemtype="http://schema.org/Article" class="blog01-show__item">
                            <h1 itemprop="name" class="blog01-show__item__title">{{$blog->title}}</h1>
                            <span class="blog01-show__item__published">
                                Data: <span itemprop="datePublished" content="{{$blog->publishing}}" class="blog01-show__item__date">{{ dateFormat($blog->publishing, 'd', 'M', 'Y', '') }}</span>
                            </span>
                            <p itemprop="articleSection" class="blog01-show__item__paragraph">{{$blog->description}}</p>
                            @if ($blog->path_image)
                                <figure class="blog01-show__item__image">
                                    <img itemprop="image" src="{{asset('storage/'.$blog->path_image)}}" width="100%" alt="{{$blog->title}}" class="blog01-show__item__img"/>
                                </figure>
                            @endif
                            <div itemprop="articleBody" class="ck-content blog01-show__item__description">
                                {!!$blog->text!!}
                            </div>
                            <div class="d-flex justify-content-end align-items-end">
                                <a href="" class="blog01-show__item__share" id="shareButton">Compartilhar Artigo</a>
                            </div>
                        </article>
                    </div>
                    <div class="blog01-show__col-end col-12 col-sm-3">
                        <div class="blog01-show__related">
                            <h4 class="blog01-show__related__title">Artigos Relacionados</h4>
                            @foreach ($blogsRelated as $blogRelated)
                                <article class="blog01-show__boxs__item">
                                    <div itemscope itemtype="http://schema.org/Article" class="blog01-show__boxs__item__content transition">
                                        <a itemprop="url" href="{{route('blog01.show.content', ['BLOG01BlogsCategory' => $blogRelated->category->slug, 'BLOG01Blogs' => $blogRelated->slug])}}">
                                            <figure class="blog01-show__boxs__item__image">
                                                <img itemprop="image" src="{{asset('storage/'.$blogRelated->path_image_thumbnail)}}" class="blog01-show__boxs__item__image__img" width="100%" alt="{{$blogRelated->title}}"/>
                                            </figure>
                                            <div class="blog01-show__boxs__item__description">
                                                <span class="blog01-show__boxs__item__date-publish">
                                                    Data: <span itemprop="datePublished" content="{{$blogRelated->publishing}}" class="blog01-show__boxs__item__date">{{ dateFormat($blogRelated->publishing, 'd', 'M', 'Y', '') }}</span>
                                                </span>
                                                <h3 itemprop="name" class="blog01-show__boxs__item__title">{{$blogRelated->title}}</h3>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <p itemprop="articleBody" class="blog01-show__boxs__item__paragraph">{!! $blogRelated->description !!}</p>
                                                    @if ($blogRelated->path_image_icon)
                                                        <img src="{{asset('storage/' . $blogRelated->path_image_icon)}}" width="34" class="blog01-show__boxs__item__icon ms-3" alt="{{$blogRelated->title}}"/>
                                                    @endif
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
    @foreach ($sections as $section)
        {!!$section!!}
    @endforeach
@endsection

@section('tagSeo')
    <title>{{$blog->title}}</title>
    <meta name="title" content="{{$blog->title}}">
    <meta name="description" content="{{ $blog->description }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{url()->current()}}">
    <meta property="og:title" content="{{$blog->title}}">
    <meta property="og:description" content="{{$blog->description}}">
    <meta property="og:image" content="{{asset('storage/'.$blog->path_image_thumbnail)}}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{url()->current()}}">
    <meta property="twitter:title" content="{{$blog->title}}">
    <meta property="twitter:description" content="{{substr($blog->description, 0 , 130)}}">
    <meta property="twitter:image" content="{{asset('storage/'.$blog->path_image_thumbnail)}}">
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const shareButton = document.getElementById("shareButton");

        shareButton.addEventListener("click", function() {
            // Verifique se a API do Web Share está disponível no navegador
            if (navigator.share) {
                // Dados para compartilhar
                const title = "{{$blog->title}}" ; // Incorporar o título do artigo
                const description = "{{$blog->description}}"; // Incorporar o a descrição do artigo
                const url = "{{url()->current() }}"  // Incorporar a URL do artigo

                const shareData = {
                    title: title,
                    text: description,
                    url: url
                };

                // Chame a API do Web Share para abrir a janela de compartilhamento
                navigator.share(shareData)
                    .then(() => {
                        console.log('Artigo compartilhado com sucesso!');
                    })
                    .catch((error) => {
                        console.error('Erro ao compartilhar o artigo:', error);
                    });
            } else {
                alert('Este navegador não suporta compartilhamento direto. Você pode copiar o link e compartilhá-lo manualmente.');
            }
        });
    });
</script>
