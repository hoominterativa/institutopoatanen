@extends('Client.Core.client')
@section('content')
    @if ($contentPage)
        <main id="root">
            <section class="copa03__banner"
                style="background-image: url({{ asset('storage/'.$contentPage->path_image_banner_desktop) }}); background-color: {{$contentPage->background_color_banner}};">
                @if ($categories->count())
                    <div class="copa03__banner__categories quedinha">
                        <button class="copa03__banner__categories__btn quedinha__btn">Categorias</button>
                        <ul class="copa03__banner__categories__content quedinha__content">
                            @foreach ($categories as $category)
                                <li class="copa03__banner__categories__content__item">
                                    <a href="{{route('copa03.category.page', ['COPA03ContentPages' => $contentPage->slug, 'COPA03ContentPagesCategory' => $category->slug])}}" class="copa03__banner__categories__content__item__link">
                                        {{ $category->title }} </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </section>
            @if ($subcategoryTopics->count())
                <section class="copa03__topics">
                    @if ($contentPage->title_topic_section || $contentPage->subtitle_topic_section)
                        <header class="copa03__topics__header">
                            <h1 class="copa03__topics__header__title">{{$contentPage->title_topic_section}}</h1>
                            <h2 class="copa03__topics__header__subtitle">{{$contentPage->subtitle_topic_section}}</h2>
                            <hr class="copa03__topics__header__line">
                        </header>
                    @endif
                    <nav class="copa03__topics__subcategories">
                        <ul class="copa03__topics__subcategories__swiper-wrapper swiper-wrapper">
                            @foreach ($subcategoryTopics as $subcategoryTopic)
                                <li class="copa03__topics__subcategories__item swiper-slide">
                                    <a href="{{route('copa03.subcategory-topic.page', ['COPA03ContentPages' => $contentPage->slug, 'COPA03ContentPagesCategory' => $subcategoryTopic->category->slug , 'COPA03ContentPagesSubCategoryT' => $subcategoryTopic->slug])}}" class="link-full"></a>
                                    @if ($subcategoryTopic)
                                        <img src="{{ asset('storage/'.$subcategoryTopic->path_image_icon) }}" alt="Ícone do tópico {{$subcategoryTopic->title}}" loading="lazy" class="copa03__topics__subcategories__item__icon">
                                    @endif
                                    {{$subcategoryTopic->title}}
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                    <main class="copa03__topics__main">
                        <div class="copa03__topics__main__swiper-wrapper swiper-wrapper">
                            @foreach ($subcategoryTopic->topics as $topic)
                                <article class="copa03__topics__main__item swiper-slide">
                                    @if ($topic->path_image)
                                        <img src="{{ asset('storage/'.$topic->path_image) }}" alt="Imagem de fundo do tópico {{$topic->title}}" loading="lazy" class="copa03__topics__main__item__bg">
                                    @endif
                                    @if ($topic->path_image_icon)
                                        <img src="{{ asset('storage/'.$topic->path_image_icon) }}" alt="Ícone do tópico {{$topic->title}}" loading="lazy" class="copa03__topics__main__item__icon">
                                    @endif
                                    @if ($topic->title)
                                        <h3 class="copa03__topics__main__item__title">{{$topic->title}}</h3>
                                    @endif
                                    @if ($topic->description)
                                        <div class="copa03__topics__main__item__paragraph">
                                            <p>{!! $topic->description !!}</p>
                                        </div>
                                    @endif
                                    @if ($topic->path_archive || $topic->link_button)
                                        <a href="{{ $topic->path_archive ? $topic->path_archive : getUri($topic->link_button) }}" {{ $topic->path_archive ? 'download' : 'target="_blank"' }} class="copa03__topics__main__item__cta">
                                            @if ($topic->title_button)
                                                {{$topic->title_button}}
                                            @endif
                                        </a>
                                    @endif
                                </article>
                            @endforeach
                        </div>
                        <div class="copa03__topics__main__nav">
                            <div class="copa03__topics__main__nav__swiper-button-prev swiper-button-prev"></div>
                            <div class="copa03__topics__main__nav__swiper-button-next swiper-button-next"></div>
                        </div>
                    </main>
                </section>
            @endif
            @if ($subcategoryVideos->count())
                <section class="copa03__videos">
                    @if ($contentPage->title_video_section || $contentPage->subtitle_video_section)
                        <header class="copa03__videos__header">
                            <h2 class="copa03__videos__header__title">{{$contentPage->title_video_section}}</h2>
                            <h3 class="copa03__videos__header__subtitle">{{$contentPage->subtitle_video_section}}</h3>
                            <hr class="copa03__videos__header__line">
                        </header>
                    @endif
                    <nav class="copa03__videos__subcategories">
                        <ul class="copa03__videos__subcategories__swiper-wrapper swiper-wrapper">
                            @foreach ($subcategoryVideos as $subcategoryVideo)
                                <li class="copa03__videos__subcategories__item swiper-slide">
                                    <a href="{{route('copa03.subcategory-video.page', ['COPA03ContentPages' => $contentPage->slug,'COPA03ContentPagesCategory' => $subcategoryVideo->category->slug, 'COPA03ContentPagesSubCategoryV' => $subcategoryVideo->slug])}}" class="link-full"></a>
                                    @if ($subcategoryVideo->path_image_icon)
                                        <img src="{{ asset('storage/'.$subcategoryVideo->path_image_icon) }}" alt="Ícone da subcategoria {{$subcategoryVideo->title}}" loading="lazy" class="copa03__videos__subcategories__item__icon">
                                    @endif
                                    {{$subcategoryVideo->title}}
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                    <main class="copa03__videos__main">
                        @foreach ($subcategoryVideo->videos as $video)
                            @if ($video->path_archive || $video->link)
                                <article class="copa03__videos__main__item" data-fancybox data-src="{{$video->path_archive ? $video->path_archive : getUri($video->link)}}">
                                    @if ($video->path_image)
                                        <img src="{{ asset('storage/'.$video->path_image) }}" alt="Thumbnail do {{$video->title}}" loading="lazy" class="copa03__videos__main__item__bg">
                                    @endif
                                    @if ($video->title)
                                        <h3 class="copa03__videos__main__item__title">{{$video->title}}</h3>
                                    @endif
                                </article>
                            @endif
                        @endforeach
                    </main>
                </section>
            @endif
            @foreach ($sections as $section)
                {!! $section !!}
            @endforeach
        </main>
    @endif
@endsection
