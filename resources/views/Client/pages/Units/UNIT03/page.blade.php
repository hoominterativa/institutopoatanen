@extends('Client.Core.client')
@section('content')
    <main id="root" class="unit03-page ">
        @if ($banner)
            <section class="unit03-page__banner"
                style="background-image: url({{ asset('storage/' . $banner->path_image_desktop) }}); background-color: {{ $banner->background_color }}">
                @if ($banner->title)
                    <h1 class="unit03-page__banner__title">{{ $banner->title }}</h1>
                @endif
                @if ($banner->subtitle)
                    <h2 class="unit03-page__banner__subtitle">{{ $banner->subtitle }}</h2>
                @endif
            </section>
        @endif

        @if ($categories->count())
            <aside class="unit03-page__categories">
                <div class="unit03-page__categories__carousel">

                    <menu class="unit03-page__categories__carousel__swiper-wrapper swiper-wrapper">

                        @foreach ($categories as $category)
                            <a
                                class="unit03-page__categories__carousel__item swiper-slide {{ isset($category->selected) ? 'active' : '' }}"href="{{ route('unit03.category.page', ['UNIT03UnitsCategory' => $category->slug]) }}">

                                @if ($category->path_image_icon)
                                    <img src="{{ asset('storage/' . $category->path_image_icon) }}"
                                        alt="Ícone da categoria {{ $category->title }}"
                                        class="unit03-page__categories__carousel__item__icon">
                                @endif

                                @if ($category->title)
                                    {{ $category->title }}
                                @endif
                            </a>
                        @endforeach

                    </menu>

                </div>
            </aside>
        @endif

        @if ($units->count())
            <section class="unit03-page__list">

                @foreach ($units as $unit)
                    <article class="unit03-page__list__item">

                        <a href="{{ route('unit03.page.content', ['UNIT03UnitsCategory' => $unit->category->slug, 'UNIT03Units' => $unit->slug]) }}"
                            class="link-full"></a>

                        <div class="unit03-page__list__item__top">
                            @if ($unit->path_image)
                                <img src="{{ asset('storage/' . $unit->path_image) }}" alt="Thumbnail"
                                    class="unit03-page__list__item__top__bg">
                            @endif
                            @if ($unit->title)
                                <h2 class="unit03-page__list__item__top__title">{{ $unit->title }}</h2>
                            @endif
                        </div>

                        <div class="unit03-page__list__item__bottom">
                            @if ($unit->path_image_icon)
                                <img src="{{ asset('storage/' . $unit->path_image_icon) }}" alt="Logo unidade"
                                    class="unit03-page__list__item__bottom__icon">
                            @endif
                        </div>
                    </article>
                @endforeach
            </section>
        @endif

        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
