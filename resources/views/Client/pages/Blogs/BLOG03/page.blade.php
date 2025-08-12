@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    <main id="root" class="blog03-page">
        @if ($section)
            @if ($section->title_banner)
                <section class="blog03-page__banner"
                    style="background-image: url({{ asset('storage/' . $section->path_image_desktop_banner) }}); ">
                    <h1 class="blog03-page__banner__title animation fadeInLeft">{{ $section->title_banner }}</h1>
                </section>
            @endif
        @endif

        {{-- <aside class="blog03-page__navigation">
            @if ($categories->count())
                <menu class="blog03-page__navigation__categories">
                    @foreach ($categories as $category)
                        <a href="{{ route('blog03.category.page', ['BLOG03BlogsCategory' => $category->slug]) }}"
                            class="blog03-page__navigation__categories__item {{ isset($category->selected) ? 'active' : '' }} swiper-slide">
                            {{ $category->title }}
                        </a>
                    @endforeach
                </menu>
            @endif


            <form action="{{ route('blog03.page') }}" method="GET" class="blog03-page__navigation__form">
                <input type="search" name="buscar" placeholder="Buscar">
                <button class="blog03-page__navigation__form__submit" type="submit">
                    <img class="blog03-page__navigation__form__submit__icon"
                        src="{{ asset('storage/uploads/tmp/lupa.png') }}" alt="Lupa">
                </button>

            </form>
        </aside> --}}

        @if ($blogs->count())
            <div class="blog03-page__main">
                @foreach ($blogs as $blog)
                    <article class="blog03-page__main__item animation fadeInLeft" itemscope itemtype="http://schema.org/Article">
                        {{-- <a title="{!! $blog->title !!}"
                            href="{{ route('blog03.show.content', ['BLOG03BlogsCategory' => $blog->category->slug, 'BLOG03Blogs' => $blog->slug]) }}"
                            class="link-full"></a> --}}

                        @if ($blog->path_image_box)
                            <figure class="blog03-page__main__item__image">
                                <img itemprop="image" src="{{ asset('storage/' . $blog->path_image_box) }}"
                                    class="blog03-page__main__item__image__img" alt="Imagem de {{ $blog->title }}" />
                            </figure>
                        @endif

                        @if ($blog->title || $blog->description)
                            <div class="blog03-page__main__item__information">
                                @if ($blog->title)
                                    <h3 class="blog03-page__main__item__information__title">
                                        {!! $blog->title !!}</h3>
                                @endif

                                {{-- @if ($blog->description)
                                    <p class="blog03-page__main__item__information__paragraph">
                                        {!! $blog->description !!}
                                    </p>
                                @endif --}}

                                <a href="{{ route('blog03.show.content', ['BLOG03BlogsCategory' => $blog->category->slug, 'BLOG03Blogs' => $blog->slug]) }}" class="blog03-page__main__item__information__cta">
                                    <span>
                                        
                                    </span>
                                </a>
                            </div>
                        @endif
                    </article>
                @endforeach
            </div>
        @endif
        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach

    </main>

@endsection
