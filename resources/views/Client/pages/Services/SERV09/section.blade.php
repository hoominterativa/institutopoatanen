<section id="SERV09" class="serv09">
    <div class="container">
        <header class="">
            @if ($section->title || $section->subtitle)
                <h3 class="">{{ $section->subtitle }}</h3>
                <h2 class="">{{ $section->title }}</h2>
                <hr class="">
            @endif
            @if ($section->description)
                <div class="">
                    {!! $section->description !!}
                </div>
            @endif
            @if ($categories->count())
                <div class="">
                    <ul class="">
                        @foreach ($categories as $category)
                            <li class="" >
                                <a href="{{route('serv09.category.page', ['SERV09ServicesCategory' => $category->slug])}}">
                                    @if ($category->path_image)
                                        <img src="{{ asset('storage/' . $category->path_image) }}" alt="Icone categoria" class="">
                                    @endif
                                    {{$category->title}}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </header>
        @if ($services->count())
            <main class="">
                <div class="">
                    @foreach ($services as $service)
                        <article class="">
                            <div class="">
                                <div class="">
                                    <div class="">
                                        @if ($service->title || $service->subtitle)
                                            <h3 class="">{{$service->title}}</h3>
                                            <h4 class="">{{$service->subtitle}}</h4>
                                        @endif
                                        @if ($service->price)
                                            <h3 class=""><span>R$</span>{{number_format($service->price, 2, ',', '.')}}</h3>
                                        @endif
                                    </div>
                                    <div class="">
                                        @if ($service->description)
                                            <p class="">
                                                {!! $service->description !!}
                                            </p>
                                        @endif
                                    </div>
                                    @if ($service->topics->count())
                                        <div>
                                            @foreach ($service->topics as $topic)
                                                <div>
                                                    @if ($topic->path_image)
                                                        <img src="{{ asset('storage/' . $topic->path_image) }}" alt="" class="">
                                                    @endif
                                                    @if ($topic->title)
                                                        <h4>{{$topic->title}}</h4>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <img src="{{ asset('storage/' . $service->path_image) }}" alt="" class="">
                                <a href="{{route('serv09.page.content', ['SERV09ServicesCategory' => $category->slug, 'SERV09Services' => $service->slug])}}">
                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="">
                                    CTA
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
                <a  href="{{route('serv09.category.page', ['SERV09ServicesCategory' => $categoryFirst->slug])}}" class="">
                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="">
                    Ver mais
                </a>
            </main>
        @endif
    </div>
</section>
