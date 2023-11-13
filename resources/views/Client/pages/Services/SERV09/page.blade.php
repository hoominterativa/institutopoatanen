@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<section id="serv09-page" class="serv09-page sepa">
    <header class="sepa__header">
        
            @if ($section)
                <div class="sepa__header__bg" style="background-image: url({{ asset('storage/' . $section->path_image_desktop) }});  background-color: {{$section->background_color}};">
                    <div class="sepa__header__bg__content">
                        @if ($section->title_banner || $section->subtitle_banner)
                            <h3 class="sepa__header__bg__content__title">{{$section->title_banner}}</h3>
                            <h4 class="sepa__header__bg__content__subtitle">{{$section->subtitle_banner}}</h4>
                            <hr class="sepa__header__bg__content__line">
                        @endif
                    </div>
                </div>
            @endif
        
            @if ($categories->count())
                <nav class="sepa__header__nav">
                    <div class="container container--nav px-0">
                        <ul class="sepa__header__nav__list">
                            @foreach ($categories as $category)
                                <li class="sepa__header__nav__list__category {{isset($category->selected) ? 'active':''}}">
                                    <a href="{{route('serv09.category.page', ['SERV09ServicesCategory' =>$category->slug])}}">
                                        <img src="{{ asset('storage/' . $category->path_image) }}" alt="" class="">
                                        {{$category->title}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </nav>

                <div class="sepa__header__dropdow-mobile">
                    <button class="sepa__header__dropdow-mobile__tab  accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#category" aria-expanded="false" aria-controls="collapseTwo">
                        <img class="sepa__header__dropdow-mobile__tab__left" src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="Ícone">
                        Selecione as categorias
                    </button>
                    <ul id="category" class="sepa__header__dropdow-mobile__description accordion-collapse collapse" data-bs-parent="#category">
                        @foreach ($categories as $category)
                            <li >
                                <a href="{{route('serv09.category.page', ['SERV09ServicesCategory' => $category->slug])}}" >
                                    @if ($category->path_image)
                                        <img src="{{ asset('storage/' . $category->path_image) }}" alt="Icone categoria" class="sepa__header__nav__list__category__icon">
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
        <main class="sepa__main container">
            <div class="sepa__content row">
                @foreach ($services as $service)
                    <article class="serv09__box col-sm-6 d-flex justify-content-between row ">
                        <div class="serv09__box__left col-sm-6">
                            <div class="serv09__box__left__content">
                                @if ($service->title || $service->subtitle)
                                    <h3 class="serv09__box__left__content__title">{{$service->title}}</h3>
                                    <h4 class="serv09__box__left__content__subtitle">{{$service->subtitle}}</h4>
                                @endif
                                @if ($service->price)
                                    <h3 class="serv09__box__left__content__price"><span>R$</span>{{number_format($service->price, 2, ',', '.')}}</h3>
                                @endif

                                <div class="serv09__box__left__content__paragraph">
                                    @if ($service->description)
                                        <p>
                                            {!! $service->description !!}
                                        </p>
                                    @endif
                                </div>
                                @if ($service->topics->count())
                                    <div class="serv09__box__left__content__engBox">
                                        @foreach ($service->topics as $topic)
                                            <div class="serv09__box__left__content__engBox__button">
                                                @if ($topic->path_image)
                                                    <img src="{{ asset('storage/' . $topic->path_image) }}" alt="Ícon" class="serv09__box__left__content__engBox__button__icon">
                                                @endif
                                                @if ($topic->title)
                                                    <h4 class="serv09__box__left__content__engBox__button__title">{{$topic->title}}</h4>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="serv09__box__right col-sm-6">
                            <img src="{{ asset('storage/' . $service->path_image) }}" alt="" class="serv09__box__right__image">
                            <a href="{{route('serv09.page.content', ['SERV09ServicesCategory' => $service->categories->slug, 'SERV09Services' => $service->slug])}}" class="serv09__box__right__btn">
                                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="Ícon" class="serv09__box__right__btn__icon">
                                CTA
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
            {{ $services->links() }}
        </main>
    @endif
</section>
{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
