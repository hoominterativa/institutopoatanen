@extends('Client.Core.client')
@section('content')
    <main class="root">
        <section id="SERV01" class="serv01-page">
            @if ($section)
                <header class="serv01-page__header" {{$section->path_image_banner<>'' ? 'style=background-image:url('.asset('storage/'.$section->path_image_banner).');background-size:cover;background-position:center':''}}>
                    <h3 class="serv01-page__header__container">
                        <span class="serv01-page__header__title">{{$section->title_banner}}</span>
                    </h3>
                    <hr class="serv01-page__header__line">
                    <p class="serv01-page__header__paragraph">{{$section->description_banner}}</p>
                </header>
                {{-- END .serv01-page__header --}}
            @endif
            <div class="container">
                <div class="serv01-page__container-box row">
                    @foreach ($services as $service)
                        <article class="serv01-page__container-box__item col-12 col-sm-4 col-lg-3">
                            <div class="content transition">
                                @if ($service->path_image)
                                    <img src="{{asset('storage/'.$service->path_image)}}" width="100%" height="100%" class="position-absolute top-0 start-0" alt="{{$service->title}}">
                                @endif
                                <a href="{{route('serv01.show', ['SERV01Services' => $service->slug])}}">
                                    <div class="serv01-page__container-box__info d-flex flex-column justify-content-center align-items-center">
                                        <figure class="serv01-page__container-box__image">
                                            <img src="{{asset('storage/'.$service->path_image_icon)}}" class="icon" width="50px" alt="">
                                        </figure>
                                        <div class="serv01-page__container-box__description">
                                            <h3 class="serv01-page__container-box__title">{{$service->title}}</h3>
                                            <p class="serv01-page__container-box__paragraph mx-auto">{{$service->description}}</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{route('serv01.show', ['SERV01Services' => $service->slug])}}" class="serv01-page__container-box__link d-flex align-items-center justify-content-center">
                                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="25px" class="me-3 serv01-page__container-box__link__icon">
                                    CTA
                                </a>
                            </div>
                        </article>
                    @endforeach
                    {{-- END .box-service --}}
                </div>
                {{-- END .serv01-page__container-box --}}
            </div>
            {{-- END .container --}}
        </section>
        {{-- END #SERV01 --}}
    </main>
    {{-- END #ROOT --}}

    @foreach ($sections as $section)
        {!!$section!!}
    @endforeach
@endsection
