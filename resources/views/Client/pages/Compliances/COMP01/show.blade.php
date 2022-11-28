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
                    <div class="comp01-page__content">
                        <div class="">
                            <img src="{{asset('storage/'.$compliance->path_image_icon)}}" width="36" alt="{{$compliance->title}} {{$compliance->subtitle}}" class="comp01-page__content__icon">
                            <h2 class="comp01-page__content__container">
                                <span class="comp01-page__content__subtitle">{{$compliance->subtitle}}</span>
                                <span class="comp01-page__content__title">{{$compliance->title}}</span>
                            </h2>
                        </div>
                        <hr class="comp01-page__content__line">
                        <div class="comp01-page__content__paragraph ck-content">
                            {!!$compliance->text!!}
                        </div>
                        @if ($archives->count())
                            <nav class="comp01-page__archives d-flex align-items-center">
                                @foreach ($archives as $archive)
                                    <a href="{{asset('storage/'.$archive->path_archive)}}" class="comp01-page__archives__item d-flex align-items-center">
                                        <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="36" alt="{{$archive->title}}" class="comp01__archives__item__icon">
                                        <span class="ms-3">{{$archive->title}}</span>
                                    </a>
                                @endforeach
                            </nav>
                        @endif
                    </div>
                </div>
            </section>
            {{-- END .comp01-page__content --}}
        </div>
    </main>
    {{-- END #root --}}
@endsection
