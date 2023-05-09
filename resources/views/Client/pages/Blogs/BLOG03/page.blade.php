@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<section id="BLOG03" class="blog03-page container-fluid px-0">
    @if ($banner)
        <header class="blog03-page__header bg-light" style="background-image: url({{ asset('storage/' . $banner->path_image_desktop) }}); background-color: {{ $banner->background_color }};">
            <div class="blog03-page__header__mask"></div>
            <div class="container container--header d-flex flex-column justify-content-center h-100">
                @if ($banner->title)
                    <h1 class="blog03-page__header__title">{{$banner->title}}</h1>
                @endif
            </div>
        </header>
    @endif
    <div class="container container--pg">
        <div class="blog03-page__navigation">
            @if ($categories->count())
                <nav class="blog03-page__category blog03-page__category__carousel d-flex">
                    @foreach ($categories as $category)
                        <li class="blog03-page__category__item {{isset($category->selected) ? 'blog03-pagecategoryitem--active':''}}">
                            <a href="{{route('blog03.category.page', ['BLOG03BlogsCategory' => $category->slug])}}" >{{$category->title}}</a>
                        </li>
                    @endforeach
                </nav>
            @endif
            <form action="{{route('blog03.page')}}" method="GET" class="blog03-page__search">
                <div class="blog03-page__search__content">
                    <input type="text" name="buscar" placeholder="Buscar">
                    <img src="{{asset('storage/uploads/tmp/lupa.png')}}" alt="Lupa">
                </div>
            </form>
        </div>
        @if ($blogs->count())
            <div class="blog03-page__boxs row">
                @foreach ($blogs as $blog)
                    <article class="blog03-page__boxs__item col-sm-6">
                        <div itemscope itemtype="http://schema.org/Article" class="blog03-page__boxs__item__content transition">
                            <a itemprop="url" href="{{route('blog03.show.content', ['BLOG03BlogsCategory' => $blog->category->slug, 'BLOG03Blogs' => $blog->slug])}}" class="link-full"></a>
                            <figure class="blog03-page__boxs__item__image">
                                <img itemprop="image" src="{{asset('storage/' . $blog->path_image)}}" class="blog03-page__boxs__item__image__img" width="100%" alt="{{$blog->title}}"/>
                            </figure>
                            <div class="blog03-page__boxs__item__description">
                                <div class="blog03-page__boxs__item__buttons">
                                    @if ($blog->title)
                                        <h3 itemprop="name" class="blog03-page__boxs__item__title">{!! $blog->title !!}</h3>
                                    @endif
                                    <div class="blog03-page__boxs__item__cta">
                                        <a href="{{route('blog03.show.content', ['BLOG03BlogsCategory' => $blog->category->slug, 'BLOG03Blogs' => $blog->slug])}}"><img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" class="blog03-page__boxs__item__cta__icon" alt="title"/> CTA</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
                {{-- END .blog03-page__boxs__item --}}
            </div>
        @endif
        {{-- END .blog03-page__boxs --}}
        <nav aria-label="..." class="blog03-page__pagination">
            {{-- <ul class="pagination pagination-sm">
                <li class="page-item active" aria-current="page">
                <span class="page-link">1</span>
                </li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
            </ul> --}}
            {{ $blogs->links() }}
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
