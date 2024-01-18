@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<section id="serv10-page" class="serv10-page">
    @if ($section)
        <div class="serv10-page__banner">
            <div class="container container--edit px-0">
                @if ($section->title_banner)
                    <h4 class="serv10-page__banner__title">{{$section->title_banner}}</h4>
                @endif
                @if ($section->description_banner)
                    <div class="serv10-page__banner__paragraph">
                        <p>
                            {!! $section->description_banner !!}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    @endif
    {{-- END serv10-page__banner --}}
    <div class="serv10-page__main container px-0">
        @if ($categories)
            <div class="serv10-page__main__navigation">
                <nav>
                    <ul>
                        @foreach ($categories as $category)
                            <li class="serv10-page__main__navigation__title {{isset($category->selected) ? 'active':''}}">
                                <a href="{{route('serv10.category.page', ['SERV10ServicesCategory' => $category->slug])}}">{{$category->title}}</a>
                            </li>
                        @endforeach
                    </ul>
                </nav>
                <div class="serv10-page__main__navigation__dropdown-mobile">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header serv10-page__main__navigation__dropdown-mobile__item">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseOne" aria-expanded="false"
                                    aria-controls="flush-collapseOne">
                                    Categorias
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <ul>
                                        @foreach ($categories as $category)
                                            <li class="serv10-page__main__navigation__dropdown-mobile__item">
                                                <a href="{{route('serv10.category.page', ['SERV10ServicesCategory' => $category->slug])}}">
                                                    {{$category->title}}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        {{-- END serv10-page__main__titleDest --}}
        @if ($services->count())
            <div class="serv10-page__main__engBox row">
                @foreach ($services as $service)
                    <div class="serv10-page__main__engBox__box col-sm-3">
                        <div class="serv10-page__main__engBox__box__content">
                            @if ($service->path_image_box)
                                <div class="serv10-page__main__engBox__box__bg">
                                    <img src="{{asset('storage/'.$service->path_image_box)}}" alt="Bg">
                                </div>
                            @endif
                            <div class="serv10-page__main__engBox__box__description">
                                @if ($service->path_image_icon_box)
                                    <div class="serv10-page__main__engBox__box__description__icon">
                                        <img src="{{asset('storage/'.$service->path_image_icon_box)}}" alt="ícone">
                                    </div>
                                @endif
                                @if ($service->title_box)
                                    <h4 class="serv10-page__main__engBox__box__description__title">{{$service->title_box}}</h4>
                                @endif
                                @if ($service->description_box)
                                    <div class="serv10-page__main__engBox__box__description__paragraph">
                                        <p>
                                            {!! $service->description_box !!}
                                        </p>
                                    </div>
                                @endif
                                <a href="{{route('serv10.show', ['SERV10ServicesCategory' => $service->categories->slug, 'SERV10Services' => $service->slug])}}" class="serv10-page__main__engBox__box__description__btn">
                                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="ícone Button">
                                    CTA
                                </a>
                            </div>
                        </div>
                    </div>
                {{-- END serv10-page__main__engBox__box --}}
                @endforeach
            </div>
        @endif
        {{-- END serv10-page__main__engBox --}}
    </div>
    {{-- END serv10-page__main --}}
</section>
{{-- END serv10-page --}}
{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
