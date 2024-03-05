@extends('Client.Core.client')
@section('content')
    <main id="root">
        {{-- BEGIN Page content --}}
        <section class="serv02-page">
            @if ($banner)
                <header class="serv02-page__header">
                    @if ($banner->title_banner)
                        <h1 class="serv02-page__title">{{$banner->title_banner}}</h1>
                    @endif
                    @if ($banner->description_banner)
                        <div class="serv02-page__paragraph">
                            <p>
                                {!! $banner->description_banner !!}
                            </p>
                        </div>
                    @endif
                </header>
            @endif
            @if ($services->count())
                <main class="serv02-page__main">
                    @foreach ($services as $service)
                        <div class="serv02-page__item">
                            @if ($service->path_image_box)
                                <img src="{{ asset('storage/' . $service->path_image_box) }}" alt="{{$service->title_box}}" class="serv02-page__item__bg">
                            @endif
                            <div class="serv02-page__item__information">
                                @if ($service->path_image_icon_box)
                                    <img src="{{ asset('storage/'.$service->path_image_icon_box) }}" alt="Ícone" class="serv02-page__item__information__icon">
                                @endif
                                @if ($service->title_box)
                                    <h4 class="serv02-page__item__information__title">{{$service->title_box}}</h4>
                                @endif
                                @if ($service->description_box)
                                    <p class="serv02-page__item__information__description">
                                        {!! $service->description_box !!}
                                    </p>
                                @endif
                            </div>
                            <a href="{{route('serv02.show', ['SERV02Services' => $service->slug])}}" class="serv02-page__item__cta">
                                CTA
                            </a>
                        </div>
                    @endforeach
                </main>
            @endif
        </section>
        {{-- Finish Content page Here --}}
        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
