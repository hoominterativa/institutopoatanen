@extends('Client.Core.client')
@section('content')
<style>
    .cont05 {
        background-color: #FFF;
    }
    .cont05__header__title {
        color: #2E368E;
    }
    .cont05__main p {
        color: #242424;
    }
    .cont05__main__cta {
        background-color: #1A2069;
        border: 1px solid #1A2069;
        color: #FFFF;
    }
    .cont05__main__cta:hover {
        background-color: transparent;
        border: 1px solid #1A2069;
        color: #1A2069;
    }
    .blog03 {
        background-color: #FFFF;
        position: relative;
        padding-left: 0;
        padding-right: 0;
        padding-bottom: 0;
    }
    .blog03:before {
        content: '';
        position: absolute;
        width: 100%;
        height: 560px;
        background-color: #95D059;
        top: 0;
        left: 0;
    }
    .blog03__header {
        padding-left: 5vw;
        padding-right: 5vw;
    }
    .blog03__main {
        padding-left: 5vw;
        margin-right: 5vw;
    }
    .blog03__cta {
        margin-right: 5vw;
    }
</style>
    {{-- BEGIN Page content --}}
    <main id="root">
        <div id="COPA02" class="copa02-page">
            <section class="copa02-page__assortedBox">
                @if ($section->active_banner == 1)
                    <section class="copa02-page__assortedBox__banner"
                        style="background-image: url({{ asset('storage/' . $section->path_image_desktop_banner) }}); background-color: {{ $section->background_color_banner }};">
                        @if ($section->title_banner)
                            <h1 class="copa02-page__assortedBox__banner__title">{{ $section->title_banner }}</h1>
                        @endif
                    </section>
                @endif
                @if ($contentPages->count())
                    <div class="copa02-page__assortedBox__content">
                        <div class="row  row--boxStandard flex-column">
                            @foreach ($contentPages as $contentPage)
                                <div class="copa02-page__assortedBox__boxStandard position-relative px-0"
                                    style="background-image: url({{ asset('storage/' . $contentPage->path_image_desktop) }}); background-color: {{ $contentPage->background_color }};">
                                    <div class="copa02-page__assortedBox__boxStandard__mask"></div>
                                    <div class="container container--boxStandard">
                                        <div class="row row--boxStandard">
                                            @if ($contentPage->path_image_box)
                                                <div class="copa02-page__assortedBox__boxStandard__image col">
                                                    <img src="{{ asset('storage/' . $contentPage->path_image_box) }}"
                                                        loading="lazy" />
                                                </div>
                                            @endif
                                            <div class="copa02-page__assortedBox__boxStandard__description col">
                                                @if ($contentPage->title || $contentPage->subtitle)
                                                    <h4 class="copa02-page__assortedBox__boxStandard__description__title">
                                                        {{ $contentPage->subtitle }}
                                                    </h4>
                                                    <h5
                                                        class="copa02-page__assortedBox__boxStandard__description__subtitle">
                                                        {{ $contentPage->title }}
                                                    </h5>
                                                    <hr class="copa02-page__assortedBox__boxStandard__description__line" />
                                                @endif
                                                <div class="copa02-page__assortedBox__boxStandard__description__paragraph">
                                                    @if ($contentPage->description)
                                                        <p>
                                                            {!! $contentPage->description !!}
                                                        </p>
                                                    @endif
                                                </div>
                                                <div class="copa02-page__assortedBox__boxStandard__description__cta">
                                                    @if ($contentPage->link_button)
                                                        <a href="{{ getUri($contentPage->link_button) }}" target="{{ $contentPage->target_link_button }}" class="copa02-page__assortedBox__boxStandard__description__cta__link">
                                                            @if ($contentPage->path_image_icon)
                                                                <img src="{{ asset('storage/' . $contentPage->path_image_icon) }}" alt="" class="copa02-page__assortedBox__boxStandard__description__cta__img">
                                                            @endif
                                                            @if ($contentPage->title_button)
                                                                {{ $contentPage->title_button }}
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
        @if ($section->active_content == 1)
            <section class="copa02-page__emphasis position-relative"
                style="background-image: url({{ asset('storage/' . $section->path_image_desktop_content) }}); background-color: {{ $section->background_color_content }};">
                <div class="copa02-page__emphasis__mask"></div>
                <div class="copa02-page__emphasis__header">
                    <div class="container container-emphasis--copa02-page d-flex flex-column justify-content-center align-items-center">
                        @if ($section->title_content || $section->subtitle_content)
                            <h3 class="copa02-page__emphasis__container">
                                <span class="copa02-page__emphasis__header__title">{{ $section->title_content }}</span>
                                <span class="copa02-page__emphasis__headers__subtitle">{{ $section->subtitle_content }}</span>
                            </h3>
                            <hr class="copa02-page__emphasis__header__line"/>
                        @endif
                        @if ($section->description_content)
                            <div class="copa02-page__emphasis__header__paragraph">
                                <p>
                                    {!! $section->description_content !!}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        @endif
        @if ($topics->count())
            <section class="copa02-page__boxTopic position-relative" style="background:#ffffff;">
                <div class="copa02-page__boxTopic__mask"></div>
                <div class="container container--copa02-page-boxTopic">
                    @if ($section->active_section_topic == 1)
                        <header class="copa02-page__boxTopic__header">
                            <div class="d-flex flex-column justify-content-center align-items-center">
                                @if ($section->title_section_topic || $section->subtitle_section_topic)
                                    <h3 class="copa02-page__boxTopic__header__encompass">
                                        <span class="copa02-page__boxTopic__header__title">{{ $section->title_section_topic }}</span>
                                        <span class="copa02-page__boxTopic__header__subtitle">{{ $section->subtitle_section_topic }}</span>
                                    </h3>
                                    <hr class="copa02-page__boxTopic__header__line" />
                                @endif
                                @if ($section->description_section_topic)
                                    <div class="copa02-page__boxTopic__header__paragraph">
                                        <p>
                                            {!! $section->description_section_topic !!}
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
        @if ($section->active_last_section == 1)
            <section class="copa02-page__boxContent position-relative"
                style="background-image: url({{ asset('storage/' . $section->path_image_desktop_last_section) }}); background-color: {{ $section->background_color_last_section }};">
                <div class="copa02-page__boxContent__mask"></div>
                <div class="container container--copa02-page-boxContent">
                    <div class="copa02-page__boxContent__item">
                        <div class="row row--copa02-page-boxContent">
                            @if ($section->path_image_box_last_section)
                                <div class="copa02-page__boxContent__item__image col px-0">
                                    <img src="{{ asset('storage/' . $section->path_image_box_last_section) }}" loading="lazy" />
                                </div>
                            @endif
                            <div class="copa02-page__boxContent__item__description col">
                                @if ($section->title_last_section || $section->subtitle_last_section)
                                    <h4 class="copa02-page__boxContent__item__description__title">
                                        {{ $section->title_last_section }}</h4>
                                    <h5 class="copa02-page__boxContent__item__description__subtitle">
                                        {{ $section->subtitle_last_section }}</h5>
                                    <hr class="copa02-page__boxContent__item__description__line" />
                                @endif
                                @if ($section->description_last_section)
                                    <div class="copa02-page__boxContent__item__description__paragraph">
                                        <p>
                                            {!! $section->description_last_section !!}
                                        </p>
                                    </div>
                                @endif
                                @if ($section->link_button_last_section)
                                    <div class="copa02-page__boxContent__item__description__cta">
                                        <a href="{{ getUri($section->link_button_last_section) }}"target="{{ $section->target_link_button_last_section }}" class="copa02-page__boxContent__item__description__cta__link">
                                            @if ($section->path_image_icon_last_section)
                                                <img src="{{ asset('storage/' . $section->path_image_icon_last_section) }}" alt="" class="copa02-page__boxContent__item__description__cta__img">
                                            @endif
                                            @if ($section->title_button_last_section)
                                                {{ $section->title_button_last_section }}
                                            @endif
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
        </div>

    </main>
    {{-- Finish Content page Here --}}
    @foreach ($sections as $section)
        {!! $section !!}
    @endforeach
@endsection