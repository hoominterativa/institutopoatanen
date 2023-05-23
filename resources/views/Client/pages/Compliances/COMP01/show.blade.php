@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    <main id="root">
        <div id="COMP01" class="comp01-page">
            <section class="container-fluid px-0">
                <header class="comp01-page__header" style="background-image: url({{asset('storage/'.$compliance->path_image_banner)}})">
                    <div class="container d-flex flex-column justify-content-center align-items-center">
                        <h3 class="comp01-page__header__container">
                            <span class="comp01-page__header__title">{{$compliance->title_banner}}</span>
                        </h3>
                    </div>
                </header>

                <div class="container">
                    @foreach ($sections as $section)
                        <div class="comp01-page__content">
                            <div class="">
                                @if ($section->path_image_icon)
                                    <img src="{{asset('storage/'.$section->path_image_icon)}}" width="36" alt="{{$section->title}} {{$section->subtitle}}" class="comp01-page__content__icon">
                                @endif
                                <h2 class="comp01-page__content__container">
                                    <span class="comp01-page__content__subtitle">{{$section->subtitle}}</span>
                                    <span class="comp01-page__content__title">{{$section->title}}</span>
                                </h2>
                            </div>
                            <hr class="comp01-page__content__line">
                            <div class="comp01-page__content__paragraph ck-content">
                                {!!$section->text!!}
                            </div>
                            @if ($section->archives->count())
                                <nav class="comp01-page__archives d-flex align-items-center">
                                    @foreach ($section->archives as $archive)
                                        @if ($archive->path_archive)
                                            <a href="{{asset('storage/'.$archive->path_archive)}}" download="" class="comp01-page__archives__item d-flex align-items-center">
                                        @else
                                            <a href="{{getUri($archive->link)}}" target="{{$archive->link_target}}" class="comp01-page__archives__item d-flex align-items-center">
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
            </section>
            {{-- END .comp01-page__content --}}
        </div>
    </main>
    {{-- END #root --}}
@endsection
