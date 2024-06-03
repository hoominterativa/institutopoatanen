@extends('Client.Core.client')
@section('content')
    <main id="root" class="unit05-show">
        <header class="unit05-show__header">
            <img src="{{ asset('images/bg-colorido.svg') }}" alt="" class="unit05-show__header__bg">
            @if ($unit->path_image || $unit->path_image_icon)
                <div class="unit05-show__header__images">
                    @if ($unit->path_image)
                        <img class="unit05-show__header__images__item" src="{{ asset('storage/'. $unit->path_image) }}"
                            alt="Image descritiva da unidade {{$unit->title}}">
                    @endif
                    @if ($unit->path_image_icon)
                        <img class="unit05-show__header__images__logo" src="{{ asset('storage/'. $unit->path_image_icon) }}"
                        alt="Logomarca da unidade {{$unit->title}}">
                    @endif
                </div>
            @endif
            @if ($unit->title || $unit->text || $unit->subtitle || $links->count())
                <section class="unit05-show__header__information">
                    @if ($unit->subtitle)
                        <h3 class="unit05-show__header__information__subtitle">{{$unit->subtitle}}</h3>
                    @endif
                    @if ($unit->title)
                        <h2 class="unit05-show__header__information__title">{{$unit->title}}</h2>
                    @endif
                    @if ($unit->text)
                        <div class="unit05-show__header__information__paragraph">
                            <p>{!! $unit->text !!}</p>
                        </div>
                    @endif
                    @if ($links->count())
                        <menu class="unit05-show__header__information__menu">
                            @foreach ($links as $link)
                                <a class="unit05-show__header__information__menu__item" title="{{$link->title}}"
                                    href="{{getUri($link->link)}}" target="{{$link->target_link}}">{{$link->title}}</a>
                            @endforeach
                        </menu>
                    @endif
                </section>
            @endif
        </header>
        @if ($contents->count())
            @foreach ($contents as $content)
                <section class="unit05-show__content">
                    <div class="unit05-show__content__information">
                        @if ($content->subtitle)
                            <h3 class="unit05-show__content__information__subtitle">{{$content->subtitle}}</h3>
                        @endif
                        @if ($content->title)
                            <h2 class="unit05-show__content__information__title">{{$content->title}}</h2>
                        @endif
                        @if ($content->text)
                            <div class="unit05-show__content__information__paragraph">
                                <p>
                                    {!! $content->text !!}
                                </p>
                            </div>
                        @endif
                    </div>
                    @if ($content->path_image)
                        <img src="{{ asset('storage/' . $content->path_image) }}" loading='lazy'
                            alt="Banner da seção {{$content->title}}" class="unit05-show__content__image">
                    @endif
                </section>
            @endforeach
        @endif
        @if ($relatedUnits->count())
            <section class="unit05-show__related">
                <header class="unit05-show__related__header">
                    <h2 class="unit05-show__related__header__title">{{$unit->category->title}}</h2>
                    <h3 class="unit05-show__related__header__subtitle">{{$unit->subcategory->title}}</h3>
                </header>
                <div class="unit05-show__related__carousel">
                    <div class="unit05-show__related__carousel__swiper-wrapper swiper-wrapper">
                        @foreach ($relatedUnits as $relatedUnit)
                            <article class="unit05-show__related__carousel__item swiper-slide" style="position: relative">
                                {{-- FRONTEND ajustar link-full --}}
                                <a title="{{$relatedUnit->title}}" href="{{ route('unit05.show', ['UNIT05UnitsCategory' => $relatedUnit->category->slug, 'UNIT05UnitsSubcategory' => $relatedUnit->subcategory->slug, 'UNIT05Units' => $relatedUnit->slug]) }}"
                                    class="link-full">
                                </a>
                                @if ($relatedUnit->path_image_box)
                                    <img class="unit05-show__related__carousel__item__bg" src="{{ asset('storage/'. $relatedUnit->path_image_box) }}"
                                    alt="Imagem de background {{$relatedUnit->title}}">
                                @endif
                                <div class="unit05-show__related__carousel__item__information">
                                    @if ($relatedUnit->path_image_icon)
                                        <img class="unit05-show__related__carousel__item__information__logo"
                                            src="{{ asset('storage/'. $relatedUnit->path_image_icon) }}" alt="Logo marca da unidade {{$relatedUnit->title}}">
                                    @endif
                                    @if ($relatedUnit->subtitle)
                                        <h4 class="unit05-show__related__carousel__item__information__subtitle">{{$relatedUnit->subtitle}}</h4>
                                    @endif
                                    @if ($relatedUnit->title)
                                        <h3 class="unit05-show__related__carousel__item__information__title">{{$relatedUnit->title}}</h3>
                                    @endif
                                    @if ($relatedUnit->description)
                                        <div class="unit05-show__related__carousel__item__information__paragraph">
                                            <p>
                                                {!! $relatedUnit->description !!}
                                            </p>
                                        </div>
                                    @endif
                                    @if ($relatedUnit->links->count())
                                        @foreach ($relatedUnit->links as $relatedLink)
                                            <a href="{{getUri($relatedLink->link)}}" target="{{$relatedLink->target_link}}"
                                                class="unit05-show__related__carousel__item__information__cta">
                                                {{$relatedLink->title}}
                                            </a>
                                        @endforeach
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="unit05-show__related__carousel__nav">
                        <div class="unit05-show__related__carousel__nav__swiper-button-prev swiper-button-prev"></div>
                        <div class="unit05-show__related__carousel__nav__swiper-button-next swiper-button-next"></div>
                    </div>
                </div>
            </section>
        @endif

        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
