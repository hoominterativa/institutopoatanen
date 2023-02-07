@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
    <main id="root">
        <div id="WOWI01" class="wowi01-show">
            @if ($workWith->path_image_banner || $workWith->title_banner)
                <section class="container-fluid px-0">
                    <header class="wowi01-show__header" style="background-image: url({{asset('storage/'.$workWith->path_image_banner)}})">
                        <div class="container d-flex flex-column justify-content-center align-items-center">
                            <h3 class="wowi01-show__header__container">
                                <span class="wowi01-show__header__title">{{$workWith->title_banner}}</span>
                            </h3>
                        </div>
                    </header>
                </section>
            @endif

            <section class="wowi01-show__content__wrapper">
                <div class="container">
                    <div class="wowi01-show__content">
                        <div class="">
                            @if ($workWith->path_image_icon)
                                <img src="{{asset('storage/'.$workWith->path_image_icon)}}" width="36" alt="{{$workWith->title}} {{$workWith->subtitle}}" class="wowi01-show__content__icon">
                            @endif
                            <h2 class="wowi01-show__content__container">
                                <span class="wowi01-show__content__subtitle">{{$workWith->title}}</span>
                                <span class="wowi01-show__content__title">{{$workWith->subtitle}}</span>
                            </h2>
                        </div>
                        <hr class="wowi01-show__content__line">
                        <div class="wowi01-show__content__paragraph ck-content">{!!$workWith->text!!}</div>
                    </div>
                    {{-- END .wowi01-show__content --}}
                </div>
                {{-- END .container --}}
            </section>
            {{-- END .wowi01-show__content__wrapper --}}

            @if ($topicSection)
                <section class="wowi01-show__container-box__wrapper">
                    <div class="container">
                        <header class="wowi01-show__container-box__header">
                            <h3 class="wowi01-show__container-box__header__container">
                                <span class="wowi01-show__container-box__header__title">{{$topicSection->title}}</span>
                                <span class="wowi01-show__container-box__header__subtitle">{{$workWith->subtitle}}</span>
                            </h3>
                            <hr class="wowi01-show__container-box__header__line">
                            <p class="wowi01-show__container-box__header__paragraph">{{$topicSection->description}}</p>
                        </header>
                        <div class="wowi01-show__container-box wowi01-show__container-box__carousel row">
                            @foreach ($topics as $topic)
                                <article class="wowi01-show__container-box__item col-12 col-sm-4 col-lg-3 mb-5">
                                    <div class="content transition">
                                        <a href="{{$topic->link??'javascript:void(0)'}}" {{$topic->link?'target='.$topic->link_target:''}}>
                                            @if ($topic->path_image_thumbnail)
                                                <img src="{{asset('storage/'.$topic->path_image_thumbnail)}}" width="100%" height="100%" class="wowi01-show__container-box__image d-block" alt="{{$topic->title}}">
                                            @endif
                                            <div class="wowi01-show__container-box__info">
                                                <figure class="wowi01-show__container-box__icon">
                                                    @if ($topic->path_image_icon)
                                                        <img src="{{asset('storage/'.$topic->path_image_icon)}}" class="icon" width="60px" alt="{{$topic->title}}">
                                                    @endif
                                                </figure>
                                                <div class="wowi01-show__container-box__description">
                                                    <h3 class="wowi01-show__container-box__title">{{$topic->title}}</h3>
                                                    <p class="wowi01-show__container-box__paragraph mx-auto">{{$topic->description}}</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </article>
                            @endforeach
                            {{-- END .wowi01-show__container-box__item --}}
                        </div>
                        {{-- END .wowi01-show__container-box --}}
                    </div>
                </section>
                {{-- END .wowi01-show__container-box__wrapper --}}
            @endif

            <section class="wowi01-show__content-section container-fluid">
                <div class="container wowi01-show__content-section__container">
                    @if ($workWith->path_image_content || $workWith->title_content || $workWith->subtitle_content || $workWith->description_content)
                        <div class="wowi01-show__content-section__info row">
                            @if ($workWith->path_image_content)
                                <div class="wowi01-show__content-section__info__image col-12 col-lg-6">
                                    <img src="{{asset('storage/'.$workWith->path_image_content)}}" width="429" class="wowi01-show__content-section__info__image__item" alt="Título Subtitulo">
                                </div>
                            @endif
                            <div class="wowi01-show__content-section__info__description col-12 {{$workWith->path_image_content?'col-lg-6':''}}">
                                <h3 class="wowi01-show__content-section__info__container">
                                    <span class="wowi01-show__content-section__info__title">{{$workWith->title_content}}</span>
                                    <span class="wowi01-show__content-section__info__subtitle">{{$workWith->subtitle_content}}</span>
                                </h3>
                                <hr class="wowi01-show__content-section__info__line">
                                <p class="wowi01-show__content-section__info__paragraph">{{$workWith->description_content}}</p>
                                @if ($workWith->link_content)
                                    <a href="{{$workWith->link_content}}" target="{{$workWith->link_target_content}}" class="wowi01-show__content-section__info__cta float-end d-flex align-items-center justify-content-center">
                                        <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="25px" class="me-3 wowi01-show__content-section__info__cta__icon">
                                        CTA
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </section>
        </div>
        {{-- END #WOWI01 --}}

        @if ($workWiths->count())
            <section id="WOWI01" class="wowi01 container-fluid">
                <div class="container">
                    @if ($section)
                        @if ($section->title || $section->subtitle || $section->description)
                            <header class="wowi01__header">
                                <h3 class="wowi01__header__container">
                                    <span class="wowi01__header__title">{{$section->title}}</span>
                                    <span class="wowi01__header__subtitle">{{$section->subtitle}}</span>
                                </h3>
                                <hr class="wowi01__header__line">
                                <p class="wowi01__header__paragraph">{{$section->description}}</p>
                            </header>
                        @endif
                    @endif
                    <div class="wowi01__container-box carousel-wowi01 row">
                        @foreach ($workWiths as $workWith)
                            <article class="wowi01__container-box__item col-12 col-sm-4 col-lg-3 mb-5">
                                <div class="content transition">
                                    <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" width="100%" height="100%" class="position-absolute top-0 start-0" alt="{{$workWith->title}}">
                                    <a href="{{route('wowi01.show', ['WOWI01WorkWith' => $workWith->slug])}}">
                                        <div class="wowi01__container-box__info d-flex flex-column justify-content-center align-items-center">
                                            @if ($workWith->path_image_icon)
                                                <figure class="wowi01__container-box__image">
                                                    <img src="{{asset('storage/'.$workWith->path_image_icon)}}" class="icon" width="60px" alt="{{$workWith->title}}">
                                                </figure>
                                            @endif
                                            <div class="wowi01__container-box__description">
                                                <h3 class="wowi01__container-box__title">{{$workWith->title}}</h3>
                                                <p class="wowi01__container-box__paragraph mx-auto">{{$workWith->description}}</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="{{route('wowi01.show', ['WOWI01WorkWith' => $workWith->slug])}}" class="wowi01__container-box__link d-flex align-items-center justify-content-center">
                                        <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="25px" class="me-3 wowi01__container-box__link__icon">
                                        CTA
                                    </a>
                                </div>
                            </article>
                            {{-- END .wowi01__container-box__item --}}
                        @endforeach
                    </div>
                    {{-- END .wowi01__container-box --}}
                </div>
            </section>
            {{-- END #WOWI01 --}}
        @endif

    </main>
    {{-- END #root --}}

    {{-- Finish Content page Here --}}
    @foreach ($sections as $section)
        {!!$section!!}
    @endforeach
@endsection
