@if ($services->count())
    <section id="SERV02" class="serv02">
        @if ($section)
            <header class="serv02__header">
                @if ($section->title_section || $section->subtitle_section)
                    <h2 class="serv02__title">{{$section->title_section}}</h2>
                    <h3 class="serv02__subtitle">{{$section->subtitle_section}}</h3>
                    <hr class="serv02__line">
                @endif
                @if ($section->description_section)
                    <div class="serv02__paragraph">
                        <p>
                            {!! $section->description_section !!}
                        </p>
                    </div>
                @endif
            </header>
        @endif
        <main class="serv02__main">
            <div class="serv02__carousel owl-carousel">
                @foreach ($services as $service)
                    <div class="serv02__item">
                        @if ($service->path_image_box)
                            <img src="{{ asset('storage/'.$service->path_image_box) }}" alt="Imagem do box {{$service->title_box}}" class="serv02__item__bg">
                        @endif
                        <div class="serv02__item__information">
                            @if ($service->path_image_icon_box)
                                <img src="{{ asset('storage/'.$service->path_image_icon_box) }}" alt="Ícone do box {{$service->title_box}}" class="serv02__item__information__icon">
                            @endif
                            @if ($service->title_box)
                                <h4 class="serv02__item__information__title">{{$service->title_box}}</h4>
                            @endif
                            @if ($service->description_box)
                                <p class="serv02__item__information__description">
                                    {!! $service->description_box !!}
                                </p>
                            @endif
                        </div>
                        <a href="{{route('serv02.show',['SERV02Services' => $service->slug])}}" class="serv02__item__cta">
                            CTA
                        </a>
                    </div>
                @endforeach
            </div>
        </main>
    </section>
@endif
