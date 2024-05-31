@extends('Client.Core.client')
@section('content')
    <main id="root" class="unit05-page">
        @if ($section)
            <section class="unit05-page__banner" style="background-image: url({{ asset('storage/'. $section->path_image_desktop_banner) }});">
                @if ($section->subtitle_banner)
                    <h2 class="unit05-page__banner__subtitle">{{$section->subtitle_banner}}</h2>
                @endif
                @if ($section->title_banner)
                    <h1 class="unit05-page__banner__title">{{$section->title_banner}}</h1>
                @endif
            </section>
        @endif
        <form class="unit05-page__form">
            <div class="unit05-page__form__input">
                <input type="search" name="buscar" placeholder="Buscar">
            </div>
            <button class="unit05-page__form__submit" type="submit">
                <img src="{{ asset('storage/uploads/tmp/lupa.png') }}" alt="Lupa">
            </button>
        </form>
        @if ($categories->count() || $subcategories->count())
            <section class="unit05-page__menus">
                <menu class="unit05-page__menus__categories">
                    <div class="unit05-page__menus__categories__swiper-wrapper swiper-wrapper">
                        @foreach ($categories as $category)
                            <a title="{{$category->title}}" href="{{ route('unit05.category.page', ['UNIT05UnitsCategory' => $category->slug]) }}"
                                class="unit05-page__menus__categories__item swiper-slide {{ $category->id == $categorySelected->id ? 'active' : '' }}">
                                {{$category->title}}
                            </a>
                        @endforeach
                    </div>
                </menu>
                <menu class="unit05-page__menus__subcategories">
                    <div class="unit05-page__menus__subcategories__swiper-wrapper swiper-wrapper">
                        @foreach ($subcategories as $subcategory)
                            <a {{$subcategory->title}} href="{{route('unit05.subcategory.page',['UNIT05UnitsCategory' => $categorySelected->slug, 'UNIT05UnitsSubcategory' => $subcategory->slug])}}"
                                class="unit05-page__menus__subcategories__item swiper-slide {{ $subcategory->id == $subcategorySelected->id ? 'active' : '' }}">
                                {{$subcategory->title}}
                            </a>
                        @endforeach
                    </div>
                </menu>
            </section>
        @endif
        @if ($units->count())
            <section class="unit05-page__services">
                @foreach ($units as $unit)
                    <article class="unit05-page__services__item" style="position: relative">
                        {{-- FRONTEND ajustar link-full --}}
                        <a title="{{$unit->title}}" href="{{ route('unit05.show', ['UNIT05UnitsCategory' => $unit->category->slug, 'UNIT05UnitsSubcategory' => $unit->subcategory->slug, 'UNIT05Units' => $unit->slug]) }}"
                            class="link-full">
                        </a>
                        @if ($unit->path_image_box)
                            <img class="unit05-page__services__item__bg" src="{{ asset('storage/'. $unit->path_image_box) }}"
                                alt="Imagem de background {{$unit->title}}">
                        @endif
                        @if ($unit->path_image_icon || $unit->title || $unit->subtitle || $unit->description || $unit->links->count())
                            <div class="unit05-page__services__item__information">
                                @if ($unit->path_image_icon)
                                    <img class="unit05-page__services__item__information__logo" src="{{ asset('storage/'. $unit->path_image_icon) }}"
                                    alt="Logo marca do serviço {{$unit->title}}">
                                @endif
                                @if ($unit->subtitle)
                                    <h4 class="unit05-page__services__item__information__subtitle">{{$unit->subtitle}}</h4>
                                @endif
                                @if ($unit->title)
                                    <h3 class="unit05-page__services__item__information__title">{{$unit->title}}</h3>
                                @endif
                                @if ($unit->description)
                                    <div class="unit05-page__services__item__information__paragraph">
                                        <p>
                                            {!! $unit->description !!}
                                        </p>
                                    </div>
                                @endif
                                @if ($unit->links->count())
                                    @foreach ($unit->links as $link)
                                        @if ($link->link)
                                            <a href="{{getUri($link->link)}}" target="{{$link->target_link}}" class="unit05-page__services__item__information__cta">
                                                {{$link->title}}
                                            </a>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        @endif
                    </article>
                @endforeach
            </section>
        @endif
        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
