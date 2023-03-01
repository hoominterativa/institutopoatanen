@if ($blogs->count())
    <section id="BLOG01" class="blog01 container-fluid">
        <div class="container">
            @if ($section)
                @if ($section->title??false || $section->subtitle??false || $section->description??false)
                    <header class="blog01__header">
                        <h3 class="blog01__header__hypertext">
                            @if ($section->title??false)
                                <span class="blog01__header__title">{{$section->title}}</span>
                            @endif
                            @if ($section->subtitle??false)
                                <span class="blog01__header__subtitle">{{$section->subtitle}}</span>
                            @endif
                        </h3>
                        @if ($section->description??false)
                            <hr class="blog01__header__line">
                            <p class="blog01__header__paragraph">{{$section->description}}</p>
                        @endif
                    </header>
                @endif
            @endif
            <div class="blog01__boxs row blog01__boxs__carousel">
                @foreach ($blogs as $blog)
                    <article class="blog01__boxs__item col-12 col-sm-3">
                        <div itemscope itemtype="http://schema.org/Article" class="blog01__boxs__item__content transition">
                            <a itemprop="url" href="{{route('blog01.show.content', ['BLOG01BlogsCategory' => $blog->category->slug, 'BLOG01Blogs' => $blog->slug])}}">
                                <figure class="blog01__boxs__item__image">
                                    <img itemprop="image" src="{{asset('storage/'.$blog->path_image_thumbnail)}}" class="blog01__boxs__item__image__img" width="100%" alt="{{$blog->title}}"/>
                                </figure>
                                <div class="blog01__boxs__item__description d-flex align-items-center justify-content-between">
                                    <h2 itemprop="name" class="blog01__boxs__item__title">{{$blog->title}}</h2>
                                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="34" class="blog01__boxs__item__icon" alt="{{$blog->title}}"/>
                                </div>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endif
