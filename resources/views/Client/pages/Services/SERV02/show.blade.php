@extends('Client.Core.client')
@section('content')
    <main id="root">
        {{-- BEGIN Page content --}}
        <section class="serv02-show">
            <header class="serv02-show__header"
                style="background-image: url({{ asset('storage/' . $service->path_image_desktop_banner) }});  background-color: {{ $service->background_color_banner }};">
                <h1 class="serv02-show__header__title">{{$service->title_banner}}</h1>
                @if ($servicesNotIn->count())
                    <nav class="serv02-show__header__categories">
                        <ul class="serv02-show__header__categories__carousel owl-carousel">
                            @foreach ($servicesNotIn as $serviceNotIn)
                                <li class="serv02-show__header__categories__item">
                                    <a href="{{route('serv02.show',['SERV02Services' => $serviceNotIn->slug])}}" class="link-full"></a>
                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="icone" class="serv02-show__header__categories__item__icon">
                                    {{$serviceNotIn->title}}
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                @endif
            </header>
            <main class="serv02-show__main">
                <section class="serv02-show__core">
                    @if ($service->title || $service->subtitle)
                        <header class="serv02-show__core__header">
                            <h3 class="serv02-show__core__header__subtitle">{{$service->subtitle}}</h3>
                            <h2 class="serv02-show__core__header__title">{{$service->title}}</h2>
                            <hr class="serv02-show__core__header__line">
                        </header>
                    @endif
                    @if ($service->text)
                        <main class="serv02-show__core__paragraph">
                            <p>
                                {!! $service->text !!}
                            </p>
                        </main>
                    @endif
                </section>
                @if ($topics->count())
                    <section class="serv02-show__topics">
                        @if ($service->active_section == 1)
                            <header class="serv02-show__topics__header">
                                @if ($service->title_section || $service->subtitle_section)
                                    <h2 class="serv02-show__topics__header__title">{{$service->title_section}}</h2>
                                    <h3 class="serv02-show__topics__header__subtitle">{{$service->subtitle_section}}</h3>
                                    <hr class="serv02-show__topics__header__line">
                                @endif
                                @if ($service->description_section)
                                    <div class="serv02-show__topics__header__paragraph">
                                        <p>
                                            {!! $service->description_section !!}
                                        </p>
                                    </div>
                                @endif
                            </header>
                        @endif
                        <main class="serv02-show__topics__main">
                            <div class="serv02-show__topics__carousel owl-carousel">
                                @foreach ($topics as $topic)
                                    <div class="serv02-show__topics__item">
                                        @if ($topic->path_image)
                                            <img src="{{ asset('storage/'.$topic->path_image) }}" alt="{{$topic->title}}" class="serv02-show__topics__item__bg">
                                        @endif
                                        <div class="serv02-show__topics__item__information">
                                            <div class="serv02-show__topics__item__information__hold-ttl">
                                                @if ($topic->path_image_icon)
                                                    <img src="{{ asset('storage/'.$topic->path_image_icon) }}" alt="Ícone" class="serv02-show__topics__item__information__icon">
                                                @endif
                                                @if ($topic->title)
                                                    <h4 class="serv02-show__topics__item__information__title">{{$topic->title}}</h4>
                                                @endif
                                            </div>
                                            @if ($topic->description)
                                                <div class="serv02-show__topics__item__information__description">
                                                    <p>
                                                        {!! $topic->description !!}
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </main>
                    </section>
                @endif
            </main>
        </section>
        {{-- Finish Content page Here --}}
        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
