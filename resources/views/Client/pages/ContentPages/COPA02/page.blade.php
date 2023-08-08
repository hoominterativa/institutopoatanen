@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    <main id="root">

        <div id="COPA02" class="copa02-page">
            <section class="copa02-page__assortedBox container-fluid px-0">
                @if ($sectionContent)
                    <header class="copa02-page__assortedBox__header position-relative"
                        style="background-image: url({{ asset('storage/' . $sectionContent->path_image_desktop) }}); background-color: {{ $sectionContent->background_color }};">
                        <div class="copa02-page__assortedBox__header__mask"></div>
                        @if ($sectionContent->title || $sectionContent->subtitle)
                            <div
                                class="container-assortedBox--copa02-page container d-flex flex-column justify-content-center align-items-center">
                                <h3 class="copa02-page__assortedBox__header__encompass flex-column">
                                    <span class="copa02-page__assortedBox__header__title">{{ $sectionContent->title }}</span>
                                    <span
                                        class="copa02-page__assortedBox__header__subtitle">{{ $sectionContent->subtitle }}</span>
                                </h3>
                                <hr class="copa02-page__assortedBox__header__line" />
                            </div>
                        @endif
                    </header>
                @endif
                @if ($contents->count())
                    <div class="copa02-page__assortedBox__content">
                        <div class="row  row--boxStandard flex-column">
                            @foreach ($contents as $content)
                                <div class="copa02-page__assortedBox__boxStandard position-relative px-0"
                                    style="background-image: url({{ asset('storage/' . $content->path_image_desktop) }}); background-color: {{ $content->background_color }};">
                                    <div class="copa02-page__assortedBox__boxStandard__mask"></div>
                                    <div class="container container--boxStandard">
                                        <div class="row row--boxStandard">
                                            @if ($content->path_image_box)
                                                <div class="copa02-page__assortedBox__boxStandard__image col">
                                                    <img src="{{ asset('storage/' . $content->path_image_box) }}"
                                                        loading="lazy" />
                                                </div>
                                            @endif
                                            <div class="copa02-page__assortedBox__boxStandard__description col">
                                                @if ($content->title || $content->subtitle)
                                                    <h4 class="copa02-page__assortedBox__boxStandard__description__title">
                                                        {{ $content->subtitle }}
                                                    </h4>
                                                    <h5
                                                        class="copa02-page__assortedBox__boxStandard__description__subtitle">
                                                        {{ $content->title }}
                                                    </h5>
                                                    <hr class="copa02-page__assortedBox__boxStandard__description__line" />
                                                @endif
                                                <div class="copa02-page__assortedBox__boxStandard__description__paragraph">
                                                    @if ($content->description)
                                                        <p>
                                                            {!! $content->description !!}
                                                        </p>
                                                    @endif
                                                </div>
                                                <div class="copa02-page__assortedBox__boxStandard__description__cta">
                                                    @if ($content->link_button)
                                                        <a href="{{ getUri($content->link_button) }}" arget="{{ $content->target_link_button }}" class="copa02-page__assortedBox__boxStandard__description__cta__link">
                                                            @if ($content->path_image_icon)
                                                                <img src="{{ asset('storage/' . $content->path_image_icon) }}" alt="" class="copa02-page__assortedBox__boxStandard__description__cta__img">
                                                            @endif
                                                            @if ($content->title_button)
                                                                {{ $content->title_button }}
                                                            @endif
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            @endforeach
                        </div>
                        {{-- Finish copa02-page__assortedBox__boxStandard --}}
                    </div>
                @endif
            </section>
        </div>
        @if ($pageSections->count())
            @foreach ($pageSections as $pageSection)
                <section class="copa02-page__emphasis position-relative"
                    style="background-image: url({{ asset('storage/' . $pageSection->path_image_desktop) }}); background-color: {{ $pageSection->background_color }};">
                    <div class="copa02-page__emphasis__mask"></div>
                    <div class="copa02-page__emphasis__header">
                        <div
                            class="container container-emphasis--copa02-page d-flex flex-column justify-content-center align-items-center">
                            @if ($pageSection->title || $pageSection->subtitle)
                                <h3 class="copa02-page__emphasis__container">
                                    <span class="copa02-page__emphasis__header__title">{{ $pageSection->title }}</span>
                                    <span
                                        class="copa02-page__emphasis__headers__subtitle">{{ $pageSection->subtitle }}</span>
                                </h3>
                                <hr class="copa02-page__emphasis__header__line" />
                            @endif
                            @if ($pageSection->description)
                                <div class="copa02-page__emphasis__header__paragraph">
                                    <p>
                                        {!! $pageSection->description !!}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </section>
            @endforeach
        @endif
        @if ($topics->count())
            <section class="copa02-page__boxTopic position-relative" style="background:#ffffff;">
                <div class="copa02-page__boxTopic__mask"></div>
                <div class="container container--copa02-page-boxTopic">
                    @if ($sectionTopic)
                        <header class="copa02-page__boxTopic__header">
                            <div class="d-flex flex-column justify-content-center align-items-center">
                                @if ($sectionTopic->title || $sectionTopic->subtitle)
                                    <h3 class="copa02-page__boxTopic__header__encompass">
                                        <span
                                            class="copa02-page__boxTopic__header__title">{{ $sectionTopic->title }}</span>
                                        <span
                                            class="copa02-page__boxTopic__header__subtitle">{{ $sectionTopic->subtitle }}</span>
                                    </h3>
                                    <hr class="copa02-page__boxTopic__header__line" />
                                @endif
                                @if ($sectionTopic->description)
                                    <div class="copa02-page__boxTopic__header__paragraph">
                                        <p>
                                            {!! $sectionTopic->description !!}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </header>
                    @endif
                    <div class="copa02-page__boxTopic__content carousel-topics-copa02-page owl-carousel">
                        @foreach ($topics as $topic)
                            <div class="copa02-page__boxTopic__item">
                                <div class="copa02-page__boxTopic__item__image">
                                    @if ($topic->path_image_box)
                                        <img src="{{ asset('storage/' . $topic->path_image_box) }}" loading="lazy" />
                                    @endif
                                </div>
                                <div class="copa02-page__boxTopic__item__description">
                                    @if ($topic->title || $topic->subtitle)
                                        <h4 class="copa02-page__boxTopic__item__description__title">
                                            {{ $topic->title }}</h4>
                                        <h5 class="copa02-page__boxTopic__item__description__subtitle">
                                            {{ $topic->subtitle }}</h5>
                                    @endif
                                    @if ($topic->description)
                                        <div class="copa02-page__boxTopic__item__description__paragraph">
                                            <p>
                                                {!! $topic->description !!}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
        @if ($lastSections)
            @foreach ($lastSections as $lastSection)
                <section class="copa02-page__boxContent position-relative"
                    style="background-image: url({{ asset('storage/' . $lastSection->path_image_desktop) }}); background-color: {{ $lastSection->background_color }};">
                    <div class="copa02-page__boxContent__mask"></div>
                    <div class="container container--copa02-page-boxContent">
                        <div class="copa02-page__boxContent__item">
                            <div class="row row--copa02-page-boxContent">
                                @if ($lastSection->path_image_box)
                                    <div class="copa02-page__boxContent__item__image col px-0">
                                        <img src="{{ asset('storage/' . $lastSection->path_image_box) }}" loading="lazy" />
                                    </div>
                                @endif
                                <div class="copa02-page__boxContent__item__description col">
                                    @if ($lastSection->title || $lastSection->subtitle)
                                        <h4 class="copa02-page__boxContent__item__description__title">
                                            {{ $lastSection->subtitle }}</h4>
                                        <h5 class="copa02-page__boxContent__item__description__subtitle">
                                            {{ $lastSection->title }}</h5>
                                        <hr class="copa02-page__boxContent__item__description__line" />
                                    @endif
                                    @if ($lastSection->description)
                                        <div class="copa02-page__boxContent__item__description__paragraph">
                                            <p>
                                                {!! $lastSection->description !!}
                                            </p>
                                        </div>
                                    @endif
                                    @if ($lastSection->link_button)
                                        <div class="copa02-page__boxContent__item__description__cta">
                                            <a href="{{ getUri($lastSection->link_button) }}"target="{{ $lastSection->target_link_button }}" class="copa02-page__boxContent__item__description__cta__link">
                                                @if ($lastSection->path_image_icon)
                                                    <img src="{{ asset('storage/' . $lastSection->path_image_icon) }}" alt="" class="copa02-page__boxContent__item__description__cta__img">
                                                @endif
                                                @if ($lastSection->title_button)
                                                    {{ $lastSection->title_button }}
                                                @endif
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endforeach
        @endif
        </div>

    </main>
    {{-- Finish Content page Here --}}
    @foreach ($sections as $section)
        {!! $section !!}
    @endforeach
@endsection
