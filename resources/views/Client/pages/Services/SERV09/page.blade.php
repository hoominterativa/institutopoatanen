@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<section id="serv09-page" class="serv09-page sepa">
    <header class="sepa__header">
        <div class="container-fluid px-0">
            @if ($section)
                <div class="sepa__header__bg" style="background-image: url({{ asset('storage/' . $section->path_image_desktop) }});  background-color: {{$section->background_color}};">
                    <div class="sepa__header__content">
                        @if ($section->title_banner || $section->subtitle_banner)
                            <h3 class="sepa__header__title">{{$section->title_banner}}</h3>
                            <h4 class="sepa__header__subtitle">{{$section->subtitle_banner}}</h4>
                            <hr class="sepa__header__hr">
                        @endif
                    </div>
                </div>
            @endif
        </div>
        <div class="">
            <div class="">
                @if ($categories->count())
                    <div class="">
                        <ul class="">
                            @foreach ($categories as $category)
                                <li class="serv09-categories__list__item {{isset($category->selected) ? 'active':''}}">
                                    <a href="{{route('serv09.category.page', ['SERV09ServicesCategory' =>$category->slug])}}">
                                        <img src="{{ asset('storage/' . $category->path_image) }}" alt="" class="">
                                        {{$category->title}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </header>
    @if ($services->count())
        <main class="">
            <div class="">
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
                                <a href="{{route('serv09.page.content', ['SERV09ServicesCategory' => $service->categories->slug, 'SERV09Services' => $service->slug])}}">
                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="">
                                    CTA
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
                <ul class="">
                    <li class="">
                        {{ $services->links() }}
                    </li>
                </ul>
            </div>
        </main>
    @endif
</section>
{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
