@extends('Client.Core.client')
@section('content')
<style>
    .blog03 {
        background-color: #FFFF;
        position: relative;
        padding-left: 0;
        padding-right: 0;
        padding-bottom: 5px;
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
    .blog03__main .swiper-pagination-bullets .swiper-pagination-bullet {
        background-color: #1A2069;
        opacity: 0.5;
    }
    .blog03__main .swiper-pagination-bullets .swiper-pagination-bullet-active {
        opacity: 1;
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
                            <h1 class="copa02-page__assortedBox__banner__title animation fadeInLeft">{{ $section->title_banner }}</h1>
                        @endif
                    </section>
                @endif
            </section>
        </div>
        @if ($section->active_content == 1)
            <section class="copa02-page__emphasis">
                <div class="copa02-page__emphasis__header">
                        @if ($section->title_content)
                            <h3 class="copa02-page__emphasis__header__title animation fadeInLeft">{{ $section->title_content }}</h3>
                        @endif
                        @if ($section->description_content)
                            <div class="copa02-page__emphasis__header__paragraph animation fadeInRight">
                                {!! $section->description_content !!}
                            </div>
                        @endif
                </div>
            </section>
        @endif

        @if ($contentPages->count())
            <div class="copa02-page__assortedBox__content">
                @foreach ($contentPages as $contentPage)
                    <div class="copa02-page__assortedBox__boxStandard"
                        style="background-image: url({{ asset('storage/' . $contentPage->path_image_desktop) }});">
                        @if ($contentPage->path_image_box)
                            <div class="copa02-page__assortedBox__boxStandard__image animation fadeInUp">
                                <img src="{{ asset('storage/' . $contentPage->path_image_box) }}"
                                    loading="lazy" />
                            </div>
                        @endif
                        <div class="copa02-page__assortedBox__boxStandard__description">
                            @if ($contentPage->title)
                                <h4 class="copa02-page__assortedBox__boxStandard__description__title animation fadeInUp">
                                    {{ $contentPage->title }}
                                </h4>
                            @endif
                            <div class="copa02-page__assortedBox__boxStandard__description__paragraph animation fadeInUp">
                                @if ($contentPage->description)
                                    {!! $contentPage->description !!}
                                @endif
                            </div>

                            {{-- <div class="copa02-page__assortedBox__boxStandard__description__cta">
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
                            </div> --}}
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if ($section->active_last_section == 1)
            <section class="copa02-page__boxContent">
                <div class="copa02-page__boxContent__item"> 
                    @if ($section->path_image_box_last_section)
                        <img src="{{ asset('storage/' . $section->path_image_box_last_section) }}" loading="lazy" />
                    @endif
                    <div class="copa02-page__boxContent__item__description">
                        @if ($section->title_last_section)
                            <h4 class="copa02-page__boxContent__item__description__title animation fadeInLeft">
                                {{ $section->title_last_section }}
                            </h4>
                        @endif

                        <div class="copa02-page__boxContent__item__description__center">
                            @if ($section->description_last_section)
                                <div class="copa02-page__boxContent__item__description__paragraph animation fadeInLeft">
                                    {!! $section->description_last_section !!}
                                </div>
                            @endif
                            @if ($section->link_button_last_section)
                                <a href="{{ getUri($section->link_button_last_section) }}"target="{{ $section->target_link_button_last_section }}" class="copa02-page__boxContent__item__description__cta animation fadeInRight">
                                    @if ($section->title_button_last_section)
                                        <span>
                                            {{ $section->title_button_last_section }}
                                        </span>
                                    @endif
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        @endif

        {{-- @if ($topics->count())
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
        @endif --}}
        
        </div>

    </main>
    {{-- Finish Content page Here --}}
    @foreach ($sections as $section)
        {!! $section !!}
    @endforeach
@endsection