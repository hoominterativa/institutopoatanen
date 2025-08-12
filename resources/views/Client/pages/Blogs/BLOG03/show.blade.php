@extends('Client.Core.client')
@section('content')
    <main id="root">
        <section id="root" class="blog03-show">
            <section class="blog03-show__banner">
                <h2 class="blog03-show__banner__title animation fadeInLeft">{!! $blog->title !!}</h2>
                @if ($blog->path_image)
                    <img itemprop="image" src="{{ asset('storage/' . $blog->path_image) }}" alt="{{ $blog->title }}"
                        class="blog03-show__article__image animation fadeInUp" />
                @endif
            </section>

            <article itemscope itemtype="http://schema.org/Article" class="blog03-show__article">
                <img class="blog03-show__article__firula" src="{{ asset('images/blog03-firula.png') }}" alt="Firula">



                {{-- <h1 iitemprop="headline" class="blog03-show__article__title animation fadeInLeft">{!! $blog->title !!}</h1> --}}

                {{-- <p class="blog03-show__article__time">
                    Publicado em: <time class="blog03-show__article__time"
                        datetime="{{ dateFormat($blog->publishing, 'd', 'M', 'Y', '') }}" itemprop="datePublished"
                        class="blog03-show__item__date">{{ dateFormat($blog->publishing, 'd', 'M', 'Y', '') }}</time>
                </p> --}}

                {{-- <p itemprop="description" class="blog03-show__article__description">
                    {!! $blog->description !!}
                </p> --}}

                <div itemprop="articleBody" class="blog03-show__article__body ck-content animation fadeInLeft">
                    <p>
                        {!! $blog->text !!}
                    </p>
                </div>

                <button class="blog03-show__article__share animation fadeInRight">
                    <span>
                        Enviar
                    </span>
                </button>
                <dialog class="blog03-show__article__modal">
                    <header class="blog03-show__article__modal__header">
                        <h3 class="blog03-show__article__modal__header__title">Compartilhar</h3>
                        <button class="blog03-show__article__modal__header__close" aria-label="Cancelar">
                            <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24"
                                viewBox="0 0 24 24" width="24" focusable="false"
                                style="pointer-events: none; display: inherit; width: 100%; height: 100%;">
                                <path
                                    d="m12.71 12 8.15 8.15-.71.71L12 12.71l-8.15 8.15-.71-.71L11.29 12 3.15 3.85l.71-.71L12 11.29l8.15-8.15.71.71L12.71 12z">
                                </path>
                            </svg>
                        </button>
                    </header>
                    <div class="blog03-show__article__modal__main">
                        <menu class="blog03-show__article__modal__main__socials">
                            <div class="blog03-show__article__modal__main__socials__swiper-wrapper swiper-wrapper">
                                <a class="blog03-show__article__modal__main__socials__item swiper-slide"
                                    title="Compartilhar no Whatsapp" id="whatsapp" target="_blank">
                                    <figure class="blog03-show__article__modal__main__socials__item__figure">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60" focusable="false"
                                            style="pointer-events: none; display: inherit;">
                                            <g fill="none" fill-rule="evenodd">
                                                <circle cx="30" cy="30" r="30" fill="#25D366"></circle>
                                                <path
                                                    d="M39.7746 19.3513C37.0512 16.5467 33.42 15 29.5578 15C21.6022 15 15.1155 21.6629 15.1155 29.8725C15.1155 32.4901 15.7758 35.0567 17.0467 37.3003L15 45L22.6585 42.9263C24.7712 44.1161 27.148 44.728 29.5578 44.728C37.5134 44.728 44 38.0652 44 29.8555C44 25.8952 42.498 22.1558 39.7746 19.3513ZM29.5578 42.2295C27.3956 42.2295 25.2829 41.6346 23.4508 40.5127L23.0051 40.2408L18.4661 41.4646L19.671 36.9093L19.3904 36.4334C18.1855 34.4618 17.5583 32.1841 17.5583 29.8555C17.5583 23.0397 22.9556 17.4986 29.5743 17.4986C32.7763 17.4986 35.7968 18.7904 38.0581 21.119C40.3193 23.4476 41.5737 26.5581 41.5737 29.8555C41.5572 36.6884 36.1764 42.2295 29.5578 42.2295ZM36.1434 32.966C35.7803 32.779 34.0142 31.8782 33.6841 31.7592C33.354 31.6402 33.1064 31.5722 32.8754 31.9462C32.6278 32.3201 31.9511 33.153 31.7365 33.4079C31.5219 33.6629 31.3238 33.6799 30.9607 33.4929C30.5976 33.306 29.4422 32.915 28.0558 31.6572C26.9829 30.6714 26.2567 29.4476 26.0421 29.0907C25.8275 28.7167 26.0256 28.5127 26.2072 28.3258C26.3722 28.1558 26.5703 27.8839 26.7518 27.6799C26.9334 27.4589 26.9994 27.3059 27.115 27.068C27.2305 26.813 27.181 26.6091 27.082 26.4221C26.9994 26.2351 26.2732 24.3994 25.9761 23.6686C25.679 22.9377 25.3819 23.0397 25.1673 23.0227C24.9528 23.0057 24.7217 23.0057 24.4741 23.0057C24.2265 23.0057 23.8469 23.0907 23.5168 23.4646C23.1867 23.8385 22.2459 24.7394 22.2459 26.5581C22.2459 28.3938 23.5333 30.1445 23.7149 30.3994C23.8964 30.6544 26.2567 34.3938 29.8714 36.0085C30.7297 36.3994 31.4064 36.6204 31.9345 36.7904C32.7928 37.0793 33.5851 37.0283 34.2123 36.9433C34.9055 36.8414 36.3415 36.0425 36.6551 35.1756C36.9522 34.3088 36.9522 33.5609 36.8697 33.4079C36.7541 33.255 36.5065 33.153 36.1434 32.966Z"
                                                    fill="white"></path>
                                            </g>
                                        </svg>
                                        <figcaption class="blog03-show__article__modal__main__socials__item__figure__title">
                                            Whatsapp
                                        </figcaption>
                                    </figure>
                                </a>
                                <a class="blog03-show__article__modal__main__socials__item swiper-slide"
                                    title="Compartilhar no Facebook" id="facebook" target="_blank">
                                    <figure class="blog03-show__article__modal__main__socials__item__figure">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60" focusable="false"
                                            style="pointer-events: none; display: inherit;">
                                            <g fill="none" fill-rule="evenodd">
                                                <path
                                                    d="M28.4863253 59.9692983c-6.6364044-.569063-11.5630204-2.3269561-16.3219736-5.8239327C4.44376366 48.4721168 3e-7 39.6467924 3e-7 29.9869344c0-14.8753747 10.506778-27.18854591 25.2744118-29.61975392 6.0281072-.9924119 12.7038532.04926445 18.2879399 2.85362966C57.1386273 10.0389054 63.3436516 25.7618627 58.2050229 40.3239688 54.677067 50.3216743 45.4153135 57.9417536 34.81395 59.5689067c-2.0856252.3201125-5.0651487.5086456-6.3276247.4003916z"
                                                    fill="#3B5998" fill-rule="nonzero"></path>
                                                <path
                                                    d="M25.7305108 45h5.4583577V30.0073333h4.0947673l.8098295-4.6846666h-4.9045968V21.928c0-1.0943333.7076019-2.2433333 1.7188899-2.2433333h2.7874519V15h-3.4161354v.021c-5.3451414.194-6.4433395 3.2896667-6.5385744 6.5413333h-.0099897v3.7603334H23v4.6846666h2.7305108V45z"
                                                    fill="#FFF"></path>
                                            </g>
                                        </svg>
                                        <figcaption class="blog03-show__article__modal__main__socials__item__figure__title">
                                            Facebook
                                        </figcaption>
                                    </figure>
                                </a>
                                <a class="blog03-show__article__modal__main__socials__item swiper-slide" id="x"
                                    title="Compartilhar no X" target="_blank">
                                    <figure class="blog03-show__article__modal__main__socials__item__figure">
                                        <svg width="192" height="192" viewBox="0 0 192 192" fill="none"
                                            xmlns="http://www.w3.org/2000/svg" focusable="false"
                                            style="pointer-events: none; display: inherit;">
                                            <rect width="192" height="192" rx="96" fill="black"></rect>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M42 47H76L100 78.5L127 47H144L107.5 88.5L150 145H117L91 111L61 145H44L83 100.5L42 47ZM62 57H71.5L130.5 135H121.5L62 57Z"
                                                fill="white"></path>
                                        </svg>
                                        <figcaption class="blog03-show__article__modal__main__socials__item__figure__title">
                                            X
                                        </figcaption>
                                    </figure>
                                </a>
                                <a class="blog03-show__article__modal__main__socials__item swiper-slide" id="email"
                                    title="Compartilhar via email" target="_blank">
                                    <figure class="blog03-show__article__modal__main__socials__item__figure">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60" focusable="false"
                                            style="pointer-events: none; display: inherit;">
                                            <g fill-rule="nonzero" fill="none">
                                                <path
                                                    d="M28.4863253 59.9692983c-6.6364044-.569063-11.5630204-2.3269561-16.3219736-5.8239327C4.44376366 48.4721168 3e-7 39.6467924 3e-7 29.9869344c0-14.8753747 10.506778-27.18854591 25.2744118-29.61975392 6.0281072-.9924119 12.7038532.04926445 18.2879399 2.85362966C57.1386273 10.0389054 63.3436516 25.7618627 58.2050229 40.3239688 54.677067 50.3216743 45.4153135 57.9417536 34.81395 59.5689067c-2.0856252.3201125-5.0651487.5086456-6.3276247.4003916z"
                                                    fill="#888"></path>
                                                <path
                                                    d="M40.531502 19.160814h-22c-1.74 0-2.986 1.2375-3 3v16c0 1.7625 1.26 3 3 3h22c1.74 0 3-1.2375 3-3v-16c0-1.7625-1.26-3-3-3zm0 6l-11 7-11-7v-3l11 7 11-7v3z"
                                                    fill="#FFF"></path>
                                            </g>
                                        </svg>
                                        <figcaption class="blog03-show__article__modal__main__socials__item__figure__title">
                                            Email
                                        </figcaption>
                                    </figure>
                                </a>
                            </div>
                        </menu>

                        <div class="blog03-show__article__modal__main__copy">
                            <p class="blog03-show__article__modal__main__copy__link"></p>
                            <button class="blog03-show__article__modal__main__copy__button">Copiar</button>
                        </div>
                    </div>
                </dialog>
            </article>

            <section id="blog03-show__galeria" class="blog03-show__galeria">
                {{-- @dd($blog->galleriesActive) --}}
                @foreach ($blog->galleriesActive as $gallery)
                {{-- @dd($gallery) --}}

                @if(!$gallery->link_url)
                    <a href="{{ asset('storage/' . $gallery->path_image) }}" class="blog03-show__galeria__item"
                        data-fancybox>
                        <img class="blog03-show__galeria__item animation fadeInUp" alt="Imagem da galeria" loading="lazy"
                            src="{{ asset('storage/' . $gallery->path_image) }}" />
                    </a>
                @else
                    <!-- Vídeo como imagem de capa com botão Play -->
                    <a href="{{ $gallery->link_url }}"
                        class="blog03-show__galeria__item blog03-show__galeria__video animation fadeInUp" data-fancybox>
                        <img src="{{ asset('storage/' . $gallery->path_image) }}" alt="Capa do vídeo" loading="lazy" />
                        <span>
                            <img src="{{ asset('images/play.png') }}" alt="Firula">
                        </span> <!-- Ícone de play -->
                    </a>
                @endif
                @endforeach

                {{-- <a href="{{ asset('images/blog03-galeria.png') }}" class="blog03-show__galeria__item" data-fancybox>
                    <img class="blog03-show__galeria__item animation fadeInUp" alt="Imagem da galeria" loading="lazy"
                        src="{{ asset('images/blog03-galeria-tres.png') }}" />
                </a> --}}

                <!-- Imagem -->

                {{-- <a href="{{ asset('images/blog03-galeria.png') }}" class="blog03-show__galeria__item" data-fancybox>
                    <img class="blog03-show__galeria__item animation fadeInUp" alt="Imagem da galeria" loading="lazy"
                        src="{{ asset('images/blog03-galeria-quatro.png') }}" />
                </a> --}}

                <!-- Imagem -->

                {{-- <a href="{{ asset('images/blog03-galeria.png') }}" class="blog03-show__galeria__item" data-fancybox>
                    <img class="blog03-show__galeria__item animation fadeInUp" alt="Imagem da galeria" loading="lazy"
                        src="{{ asset('images/blog03-galeria-cinco.png') }}" />
                </a> --}}

                {{-- <a href="{{ asset('videos/demo.mp4') }}"
                    class="blog03-show__galeria__item blog03-show__galeria__video animation fadeInUp" data-fancybox>
                    <img src="{{ asset('images/blog03-galeria-seis.png') }}" alt="Capa do vídeo" loading="lazy" />
                    <span>
                        <img src="{{ asset('images/play.png') }}" alt="Firula">
                    </span> <!-- Ícone de play -->
                </a> --}}
            </section>



            @if ($blogsRelated->count() > 0)
                <section class="blog03-show__related">
                    <h3 class="blog03-show__related__title animation fadeInLeft">Outros <span>projetos</span></h3>
                    <div class="blog03-show__related__carousel">
                        <div class="blog03-show__related__carousel__swiper-wrapper swiper-wrapper">
                            @foreach ($blogsRelated as $blogRelated)
                                <article itemscope itemtype="http://schema.org/Article"
                                    class="blog03-show__related__carousel__item swiper-slide animation fadeInLeft">
                                    {{-- <a class="link-full" title="{{ $blogRelated->title }}"
                                        href="{{ route('blog03.show.content', ['BLOG03BlogsCategory' => $blogRelated->category->slug, 'BLOG03Blogs' => $blogRelated->slug]) }}"></a> --}}

                                    <figure class="blog03-show__related__carousel__item__image">
                                        <img src="{{ asset('storage/' . $blogRelated->path_image_box) }}"
                                            class="blog03-show__related__carousel__item__image__img"
                                            alt="{{ $blogRelated->title }}" />
                                    </figure>

                                    <div class="blog03-show__related__carousel__item__information">
                                        <h4 class="blog03-show__related__carousel__item__information__title">
                                            {!! $blogRelated->title !!}</h4>

                                        {{-- <p class="blog03-show__related__carousel__item__information__paragraph">
                                            {!! $blogRelated->description !!}</p> --}}

                                        <a href="{{ route('blog03.show.content', ['BLOG03BlogsCategory' => $blogRelated->category->slug, 'BLOG03Blogs' => $blogRelated->slug]) }}"
                                            class="blog03-show__related__carousel__item__information__cta">
                                            <span>

                                            </span>
                                        </a>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                        <div class="blog03-show__related__carousel-pagination swiper-pagination"></div>
                    </div>

                </section>
            @endif
        </section>

        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection

@section('tagSeo')
    <title>{{ $blog->title }}</title>
    <meta name="title" content="{{ $blog->title }}">
    <meta name="description" content="{{ $blog->description }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $blog->title }}">
    <meta property="og:description" content="{{ $blog->description }}">
    <meta property="og:image" content="{{ asset('storage/' . $blog->path_image_thumbnail) }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $blog->title }}">
    <meta property="twitter:description" content="{{ substr($blog->description, 0, 130) }}">
    <meta property="twitter:image" content="{{ asset('storage/' . $blog->path_image_thumbnail) }}">
@endsection
