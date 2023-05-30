@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<section class="container-fluid px-0 team01-page">
    @if ($banner)
        <header class="team01-page__header w-100 d-flex justify-content-center align-items-center"
        style="background-image: url({{asset('storage/'.$banner->path_image_desktop)}});background-color: {{$banner->background_color}}">
            <div class="team01-page__header__mask"></div>
            <div class="d-flex container--team01-page__header">
                @if ($banner->title)
                    <h4 class="team01-page__header__title">{{$banner->title}}</h4>
                @endif
            </div>
        </header>
    @endif
    {{-- Finish team01-page__header --}}
    <div class="team01-page__content container">
        @if ($sectionTeam)
            <div class="team01-page__content__text text-center">
                @if ($sectionTeam->title || $sectionTeam->subtitle)
                    <h4 class="team01-page__content__text__title">{{$sectionTeam->title}}</h4>
                    <h5 class="team01-page__content__text__subtitle">{{$sectionTeam->subtitle}}</h5>
                    <hr class="team01-page__content__text__line">
                @endif
            </div>
        @endif
        @if ($categories->count())
            <ul class="team01-page__content__category  container-fluid d-flex flex-row justify-content-center align-items-center px-0 flex-wrap">
                @foreach ($categories as $category)
                    <li class="col-md-2 team01-page__content__category_li {{isset($category->selected) ? 'active':''}}">
                        <a class="w-100 d-flex justify-content-center align-items-center" href="{{route('team01.category.page', ['TEAM01TeamsCategory' => $category->slug])}}">
                            @if ($category->path_image_icon)
                                <img src="{{asset('storage/' . $category->path_image_icon)}}" alt="" class="team01-page__content__category__li__img">
                            @endif
                            @if ($category->title)
                                {{ $category->title }}
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>

            <div class="team01-page__content__dropdown-mobile">
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                Categoria
                            </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <ul>
                                    @foreach ($categories as $category)
                                        <li>
                                            <a href="{{route('team01.category.page', ['TEAM01TeamsCategory' => $category->slug])}}">
                                                @if ($category->title)
                                                    {{ $category->title }}
                                                @endif
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         @endif
        {{-- Finish team01-page__content__category --}}
        @if ($teams->count())
            <div class="team01-page__content__product container">
                <div class="row team01-page__content--row">
                    @foreach ($teams as $team)
                        <article class="team01-page__content__product__item col-md-3">
                            <div class="team01-page__content__product__item__image">
                                @if ($team->path_image_box)
                                    <img src="{{asset('storage/' . $team->path_image_box)}}" class="w-100 h-100" alt="Titulo Topico">
                                @endif
                            </div>
                            <div class="team01-page__content__product__item__description d-flex  flex-column justify-content-end mx-0 w-100 text-center">
                                <div class="team01-page__content__product__item__description__encompass">
                                    <div class="team01-page__content__product__item__description__encompass__icon">
                                        @if ($team->path_image_icon)
                                            <img src="{{asset('storage/' . $team->path_image_icon)}}" alt="" />
                                        @endif
                                    </div>
                                    <div class="flex-column team01-page__content__product__item__description__encompass__txt">
                                        @if ($team->title || $team->subtitle)
                                            <h2 class="team01-page__content__product__item__description__encompass__txt__title mx-0 px-0">{{$team->title}}</h2>
                                            <h2 class="team01-page__content__product__item__description__encompass__txt__subtitle mx-0 px-0">{{$team->subtitle}}</h2>
                                        @endif
                                    </div>
                                </div>
                                <div class="team01-page__content__product__item__description_paragraph text-start px-0 ">
                                    @if ($team->description)
                                        <p>
                                            {!! $team->description !!}
                                        </p>
                                    @endif
                                </div>
                                <div class="team01-page__content__product__item__description__buttons">
                                    <a rel="next" href="#" data-fancybox= "{{$team->slug}}" data-src="#lightbox-team01-{{$team->slug}}"  class="team01-page__content__product__item__description__buttons__cta transition d-flex justify-content-center align-items-center mx-auto">
                                        <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="team01-page__content__product__item__description__buttons__cta__icon me-3 transition">
                                        CTA
                                    </a>
                                </div>
                            </div>
                            @include('Client.pages.teams.TEAM01.show', [
                                'team' => $team
                            ])
                        </article>
                    @endforeach
                </div>
                {{-- Finish row team01-page__content--row --}}
            </div>
        @endif
        {{-- Finish team01-page__content__product --}}
    </div>
</section>
{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
