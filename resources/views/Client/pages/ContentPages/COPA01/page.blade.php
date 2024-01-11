@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    <main id="root">
        <div id="COPA01" class="copa01-page">
            <section class="container-fluid px-0">
                @if ($section->active_banner == 1)
                    <header class="copa01-page__header"
                    style="background-image: url({{asset('storage/'.$section->path_image_desktop)}}); background-color: {{$section->background_color}};">
                        <div class="container d-flex flex-column justify-content-center align-items-center">
                            <h3 class="copa01-page__header__container">
                                <span class="copa01-page__header__title">{{$section->title}}</span>
                            </h3>
                        </div>
                    </header>
                @endif
                <div class="container">
                    @foreach ($contentPages as $contentPage)
                        <div class="copa01-page__content">
                            <div class="">
                                @if ($contentPage->path_image)
                                    <img src="{{asset('storage/'.$contentPage->path_image)}}" width="36" alt="Ícone" class="copa01-page__content__icon">
                                @endif
                                <h2 class="copa01-page__content__container">
                                    <span class="copa01-page__content__subtitle">{{$contentPage->subtitle}}</span>
                                    <span class="copa01-page__content__title">{{$contentPage->title}}</span>
                                    <hr class="copa01-page__content__line">
                                </h2>
                            </div>
                            <div class="copa01-page__content__paragraph ck-content">
                                {!!$contentPage->text!!}
                            </div>
                            @if ($contentPage->archives->count())
                                <nav class="copa01-page__archives d-flex align-items-center">
                                    @foreach ($contentPage->archives as $archive)
                                        @if ($archive->path_archive)
                                            <a href="{{asset('storage/'.$archive->path_archive)}}" download="" class="copa01-page__archives__item d-flex align-items-center">
                                        @else
                                            <a href="{{getUri($archive->link)}}" target="{{$archive->link_target}}" class="copa01-page__archives__item d-flex align-items-center">
                                        @endif
                                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="36" alt="{{$archive->title}}" class="comp01__archives__item__icon">
                                            <span class="ms-3">{{$archive->title}}</span>
                                        </a>
                                    @endforeach
                                </nav>
                            @endif
                        </div>
                    @endforeach
                </div>
                {{-- Área nova --}}
                @if ($topics->count())
                    <div>
                        @if ($section->active_section == 1)
                            <div>
                                <h2 class="">
                                    <span class="">{{$section->title_section}}</span>
                                    <span class="">{{$section->subtitle_section}}</span>
                                    <hr class="">
                                </h2>
                                <div class="">
                                    {!!$section->description_section!!}
                                </div>
                            </div>
                        @endif
                        <div>
                            @foreach ($topics as $topic)
                                @if ($topic->path_image)
                                        <img src="{{asset('storage/'.$topic->path_image)}}"  alt="Imagem background do box" class="">
                                    @endif
                                <h4>{{$topic->title}}</h4>
                                <p>{!! $topic->description !!}</p>
                                @if ($topic->path_image_icon)
                                    <img src="{{asset('storage/'.$topic->path_image_icon)}}" width="36" alt="Ícone" class="">
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
                {{-- Fim área nova --}}
            </section>
            {{-- END .copa01-page__content --}}
        </div>
    </main>
    {{-- END #root --}}
    @foreach ($sections as $section)
        {!!$section!!}
    @endforeach
@endsection
