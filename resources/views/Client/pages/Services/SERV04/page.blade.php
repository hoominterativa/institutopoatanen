@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    <main id="root" class="serv04-page">
        @if ($section)
            <section class="serv04-page__banner"
                style="background-image: url({{ asset('storage/' . $section->path_image_banner_desktop) }});">

                @if ($section->title_banner)
                    <h1 class="serv04-page__banner__title">{{ $section->title_banner }}</h1>
                @endif

                @if ($section->description_banner)
                    <div class="serv04-page__banner__paragraph">
                        <p>
                            {!! $section->description_banner !!}
                        </p>
                    </div>
                @endif
            </section>
            @if ($categories->count())
                <aside class="serv04-page__categories">
                    <menu class="serv04-page__categories__swiper-wrapper swiper-wrapper">
                        @foreach ($categories as $categoryGet)
                            <li
                                class="serv04-page__categories__item swiper-slide {{ $categoryGet->id == $category->id ? 'active' : '' }}">
                                <a href="{{ route('serv04.category.page', ['SERV04ServicesCategory' => $categoryGet->slug]) }}"
                                    class="link-full"></a>
                                {{ $categoryGet->title }}
                            </li>
                        @endforeach

                    </menu>
                </aside>
            @endif
        @endif

        <section class="serv04-page__category-information">
            @if ($category->path_image)
                <img class="serv04-page__category-information__image" src="{{ asset('storage/' . $category->path_image) }}"
                    alt="Image Categoria" loading="lazy">
            @endif

            <div class="serv04-page__category-information__description">
                @if ($category->title)
                    <h2 class="serv04-page__category-information__description__title">{{ $category->title }}</h2>
                @endif

                @if ($category->description)
                    <div class="serv04-page__category-information__description__paragraph">
                        <p>
                            {!! $category->description !!}
                        </p>
                    </div>
                @endif
            </div>
        </section>

        @if ($services->count())
            <section class="serv04-page__services-section">
                <aside class="serv04-page__services-section__carousel">
                    <menu class="serv04-page__services-section__carousel__swiper-wrapper swiper-wrapper">
                        @foreach ($services as $serviceGet)
                            <li class="serv04-page__services-section__carousel__item swiper-slide {{ $serviceGet->id == $service->id ? 'active' : '' }}"
                                style="background-image:url({{ asset('storage/' . $serviceGet->path_image_box) }});">
                                <a href="{{ route('serv04.show', ['SERV04ServicesCategory' => $category->slug, 'SERV04Services' => $serviceGet->slug]) }}"
                                    class="link-full"></a>
                                @if ($serviceGet->path_image_icon)
                                    <img class="serv04-page__services-section__carousel__item__icon"
                                        src="{{ asset('storage/' . $serviceGet->path_image_icon) }}"
                                        alt="Ícone do serviço {{ $serviceGet->title }}" loading="lazy">
                                @endif
                                {{ $serviceGet->title }}

                            </li>
                        @endforeach
                    </menu>
                </aside>

                <div class="serv04-page__services-section__information">

                    @if ($service->path_image)
                        <img class="serv04-page__services-section__information__image"
                            src="{{ asset('storage/' . $service->path_image) }}"
                            alt="Imagem que se relaciona com o serviço {{ $service->title }}" loading="lazy">
                    @endif

                    @if ($service->title || $service->subtitle || $service->text)
                        <div class="serv04-page__services-section__information__description">
                            @if ($service->title || $service->subtitle)
                                <h2 class="serv04-page__services-section__information__description__title">
                                    {{ $service->title }}
                                </h2>
                                <h2 class="serv04-page__services-section__information__description__subtitle">
                                    {{ $service->subtitle }}</h2>
                            @endif

                            @if ($service->text)
                                <div class="serv04-page__services-section__information__description__paragraph">
                                    <p>
                                        {!! $service->text !!}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endif

                </div>
                @if ($topics)
                    <div class="serv04-page__services-section__accordion">
                        @foreach ($topics as $topic)
                            <details class="serv04-page__services-section__accordion__item">
                                @if ($topic->title)
                                    <summary class="serv04-page__services-section__accordion__item__title" aria-level="3"
                                        role="heading">
                                        {{ $topic->title }}
                                    </summary>
                                @endif
                                @if ($topic->text)
                                    <div class="serv04-page__services-section__accordion__item__paragraph details-content">
                                        {!! $topic->text !!}
                                    </div>
                                @endif
                            </details>
                        @endforeach
                    </div>
                @endif
            </section>
        @endif



        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
