@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    <main id="root" class="bran02-page">
        @if ($content->path_image || $content->title_banner || $content->subtitle_banner)
            <section class="bran02-page__banner"
                style="background-image: url({{ asset('storage/' . $content->path_image) }})">
                @if ($content->title_banner)
                    <h1 class="bran02-page__banner__title">{{ $content->title_banner }}</h1>
                @endif
                @if ($content->subtitle_banner)
                    <h2 class="bran02-page__banner__subtitle">{{ $content->subtitle_banner }}</h2>
                @endif
            </section>
        @endif
        <header class="bran02-page__header">
            @if ($content->title_home)
                <h2 class="bran02-page__header__title">{{ $content->title_page }}</h2>
            @endif
            @if ($content->subtitle_page)
                <h3 class="bran02-page__header__subtitle">{{ $content->subtitle_page }}</h3>
            @endif
            @if ($content->description)
                <div class="bran02-page__header__description">
                    <p>
                        {!! $content->description !!}
                    </p>
                </div>
            @endif
        </header>
        <aside class="bran02-page__categories">
            <menu class="bran02-page__categories__swiper-wrapper swiper-wrapper">
                @foreach ($bran02categories as $category)
                    <a href="{{ route('bran02.show', $category->slug) }}"
                        class="bran02-page__categories__item swiper-slide {{ $category->id == $show ? 'active' : '' }}"> {{ $category->category }} </a>
                @endforeach
            </menu>
        </aside>
        
        <div class="bran02-page__products">
            
            @foreach ($bran02marcas as $marcas)
                <a class="bran02-page__products__item" href="{{ $marcas->button_link }}"
                    target="{{ $marcas->target_link }}">
                    
                    <img class="bran02-page__products__item__image" src="{{ asset('storage/' . $marcas->path_image) }}"
                        alt="Imagem referente a seção {{-- TITLE --}}">
                </a>
            @endforeach
            
        </div>
        <div class="bran02-page__pagination">
            {{ $bran02marcas->links() }}
        </div>
        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
    {{-- Finish Content page Here --}}
@endsection
