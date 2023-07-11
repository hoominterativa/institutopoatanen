@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    <main id="root">
        <section id="BLOG01" class="blog01-page container-fluid px-0">
            @if ($banner)
                <header class="blog01-page__header bg-light"
                style="background-image: url({{ asset('storage/' . $banner->path_image_desktop) }}); background-color: {{$banner->background_color}} !important;">
                    <div class="container d-flex flex-column justify-content-center h-100">
                        @if ($banner->title)
                            <h1 class="blog01-page__header__title">{{ $banner->title }}</h1>
                        @endif
                        <nav
                            class="blog01-page__header__category blog01-page__header__category__carousel d-flex justify-content-center">
                            @foreach ($categories as $category)
                                <a href="{{ route('blog01.category.page', ['BLOG01BlogsCategory' => $category->slug]) }}"
                                    class="blog01-page__header__category__item {{ isset($category->selected) ? 'blog01-page__header__category__item--active' : '' }}">{{ $category->title }}</a>
                            @endforeach
                        </nav>
                    </div>
                </header>
            @endif

            <div class="container">
                <div class="blog01-page__boxs row">
                    <div
                        class="blog01-page__boxs__featured blog01-page__boxs__featured__carousel col-12 {{ $blogsFeatured->count() <= 0 ? 'p-5' : '' }}">
                        @foreach ($blogsFeatured as $blogFeatured)
                            <article class="blog01-page__boxs__featured__item">
                                <div itemscope itemtype="http://schema.org/Article"
                                    class="blog01-page__boxs__featured__item__content transition row align-items-center">
                                    <figure class="blog01-page__boxs__featured__item__image col-12 col-sm-6">
                                        <a itemprop="url"
                                            href="{{ route('blog01.show.content', ['BLOG01BlogsCategory' => $blogFeatured->category->slug, 'BLOG01Blogs' => $blogFeatured->slug]) }}">
                                            <img itemprop="image" src="{{ asset('storage/' . $blogFeatured->path_image) }}"
                                                class="blog01-page__boxs__featured__item__image__img" width="100%"
                                                alt="{{ $blogFeatured->title }}" />
                                        </a>
                                    </figure>
                                    <div class="blog01-page__boxs__featured__item__description col-12 col-sm-6">
                                        <span
                                            class="blog01-page__boxs__featured__item__category">{{ $blogFeatured->category->title }}</span>
                                        <a itemprop="url"
                                            href="{{ route('blog01.show.content', ['BLOG01BlogsCategory' => $blogFeatured->category->slug, 'BLOG01Blogs' => $blogFeatured->slug]) }}">
                                            <h2 itemprop="name" class="blog01-page__boxs__featured__item__title">
                                                {{ $blogFeatured->title }}</h2>
                                        </a>
                                        <span class="blog01-page__boxs__featured__item__date-publish">
                                            Data: <span itemprop="datePublished" content="{{ $blogFeatured->publishing }}"
                                                class="blog01-page__boxs__featured__item__date">{{ Carbon\Carbon::parse($blogFeatured->publishing)->formatLocalized('%d de %B de %Y') }}</span>
                                        </span>
                                        <p itemprop="articleBody" class="blog01-page__boxs__featured__item__paragraph">
                                            {{ $blogFeatured->description }}</p>
                                        <a itemprop="url"
                                            href="{{ route('blog01.show.content', ['BLOG01BlogsCategory' => $blogFeatured->category->slug, 'BLOG01Blogs' => $blogFeatured->slug]) }}"
                                            class="blog01-page__boxs__featured__item__cta d-flex align-items-center justify-content-center ms-auto">
                                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" width="25"
                                                class="blog01-page__boxs__featured__item__cta__icon me-3"
                                                alt="{{ $blogFeatured->title }}" />
                                            CTA
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                        {{-- END .blog01-page__boxs__featured__item --}}
                    </div>
                    {{-- END .blog01-page__boxs__featured --}}
                    @foreach ($blogs as $blog)
                        <article class="blog01-page__boxs__item col-12 col-sm-3">
                            <div itemscope itemtype="http://schema.org/Article"
                                class="blog01-page__boxs__item__content transition">
                                <a itemprop="url"
                                    href="{{ route('blog01.show.content', ['BLOG01BlogsCategory' => $blog->category->slug, 'BLOG01Blogs' => $blog->slug]) }}">
                                    <figure class="blog01-page__boxs__item__image">
                                        <img itemprop="image" src="{{ asset('storage/' . $blog->path_image_thumbnail) }}"
                                            class="blog01-page__boxs__item__image__img" width="100%"
                                            alt="{{ $blog->title }}" />
                                    </figure>
                                    <div class="blog01-page__boxs__item__description">
                                        <span class="blog01-page__boxs__item__date-publish">
                                            Data: <span itemprop="datePublished" content="{{ $blog->publishing }}"
                                                class="blog01-page__boxs__item__date">{{ Carbon\Carbon::parse($blog->publishing)->formatLocalized('%d de %B de %Y') }}</span>
                                        </span>
                                        <h3 itemprop="name" class="blog01-page__boxs__item__title">{{ $blog->title }}</h3>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <p itemprop="articleBody" class="blog01-page__boxs__item__paragraph">
                                                {{ $blog->description }}</p>
                                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" width="34"
                                                class="blog01-page__boxs__item__icon ms-3" alt="{{ $blog->title }}" />
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </article>
                    @endforeach
                    {{-- END .blog01-page__boxs__item --}}

                    <div class="blog01-page__pagination">
                        {{ $blogs->links() }}
                    </div>
                </div>
                {{-- END .blog01-page__boxs --}}
            </div>
            {{-- END .container --}}
        </section>
    </main>
    {{-- Finish Content page Here --}}
    @foreach ($sections as $section)
        {!! $section !!}
    @endforeach
@endsection
