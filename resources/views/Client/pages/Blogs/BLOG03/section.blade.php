@if ($blogs->count())
    <section id="BLOG03" class="blog03 container-fluid">
        <div class="container">
            @if ($section)
                <header class="blog03__header">
                    @if ($section->title || $section->subtitle)
                        <h3 class="blog03__header__hypertext">
                            <span class="blog03__header__title">{{$section->title}}</span>
                            <span class="blog03__header__subtitle">{{$section->subtitle}}</span>
                            <hr class="blog03__header__line">
                        </h3>
                    @endif
                    @if ($section->description)
                        <p class="blog03__header__paragraph">{!! $section->description !!}</p>
                    @endif
                </header>
            @endif
            <div class="blog03__boxs row blog03__boxs__carousel owl-carousel">
                @foreach ($blogs as $blog)
                    <article class="blog03__boxs__item">
                        <a itemprop="url" href="{{route('blog03.show.content', ['BLOG03BlogsCategory' => $blog->category->slug, 'BLOG03Blogs' => $blog->slug])}}" class="link-full"></a>
                        <div class="blog03__boxs__item__content d-flex justify-content-between row transition">
                            <figure class="blog03__boxs__item__image px-0">
                                @if ($blog->path_image)
                                    <img itemprop="image" src="{{asset('storage/' . $blog->path_image)}}" class="blog03__boxs__item__image__img" width="100%" alt="image"/>
                                @endif
                            </figure>
                            <div class="blog03__boxs__item__description col">
                                @if ($blog->title)
                                    <h2 itemprop="name" class="blog03__boxs__item__title"><img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="34" class="blog03__boxs__item__title__icon" alt="title"/> {{$blog->title}}</h2>
                                @endif
                                <div class="blog03__boxs__item__paragraph">
                                    @if ($blog->description)
                                        <p>
                                            {!! $blog->description !!}
                                        </p>
                                    @endif
                                </div>
                                <div class="blog03__boxs__item__cta">
                                    <a href="{{route('blog03.show.content', ['BLOG03BlogsCategory' => $blog->category->slug, 'BLOG03Blogs' => $blog->slug])}}"><img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" class="blog03__boxs__item__cta__icon" alt="title"/> CTA</a>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
                {{-- Fim-blog03__boxs__item --}}
            </div>
            <div class="blog03__cta">
                <a href="{{route('blog03.category.page', ['BLOG03BlogsCategory' => $category->slug])}}"><img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" class="blog03__cta__icon" alt="title"/> Ver todos</a>
            </div>
        </div>
    </section>
@endif
