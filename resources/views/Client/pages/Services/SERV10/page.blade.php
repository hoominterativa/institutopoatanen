@extends('Client.Core.client')
@section('content')
    <main id="root" class="serv10-page">
        @if ($section)
            @if ($section->title_banner || $section->description_banner)
                <section class="serv10-page__banner">
                    @if ($section->title_banner)
                        <h1 class="serv10-page__banner__title">{{ $section->title_banner }}</h1>
                    @endif

                    @if ($section->description_banner)
                        <div class="serv10-page__banner__paragraph">
                            <p>
                                {!! $section->description_banner !!}
                            </p>
                        </div>
                    @endif
                </section>
            @endif
        @endif

        <section class="serv10-page__main">
            @if ($categories->count())
                <aside class="serv10-page__main__categories">
                    <ul class="serv10-page__main__categories__carousel">
                        <div class="serv10-page__main__categories__carousel__swiper-wrapper swiper-wrapper">
                            @foreach ($categories as $category)
                                <li
                                    class="serv10-page__main__categories__item swiper-slide {{ isset($category->selected) ? 'active' : '' }}">
                                    <a title="{{ $category->title }}" class="link-full"
                                        href="{{ route('serv10.category.page', ['SERV10ServicesCategory' => $category->slug]) }}"></a>
                                    {{ $category->title }}
                                </li>
                            @endforeach
                        </div>
                    </ul>
                </aside>
            @endif

            @if ($services->count())
                <main class="serv10-page__main__services">
                    @foreach ($services as $service)
                        <div class="serv10-page__main__services__item">
                            <a href="{{ route('serv10.show', ['SERV10ServicesCategory' => $service->categories->slug, 'SERV10Services' => $service->slug]) }}"
                                class="link-full">
                            </a>

                            @if ($service->path_image_box)
                                <img
                                class="serv10-page__main__services__item__bg"
                                src="{{ asset('storage/' . $service->path_image_box) }}" alt="imagem de background do {{ $service->title_box }}">
                            @endif


                            @if ($service->path_image_icon_box)
                                <img
                                class="serv10-page__main__services__item__icon"
                                src="{{ asset('storage/' . $service->path_image_icon_box) }}" alt="ícone">
                            @endif

                            @if ($service->title_box)
                                <h4 class="serv10-page__main__services__item__title">
                                    {{ $service->title_box }}</h4>
                            @endif

                            @if ($service->description_box)
                                <div class="serv10-page__main__services__item__paragraph">
                                    <p>
                                        {!! $service->description_box !!}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </main>
            @endif

        </section>



        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
