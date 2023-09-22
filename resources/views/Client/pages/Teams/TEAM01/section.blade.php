<section id="TEAM01" class="team01 container-fluid px-0">
    <div class="container container--edit">
        @if ($section)
            <header class="team01__navigation">
                <div class="team01__navigation__content d-flex justify-content-between w-100">
                    <div class="team01__navigation__content__encompass">
                        @if ($section->title || $section->subtitle)
                            <h1 class="team01__navigation__content__encompass__title">{{$section->title}}</h1>
                            <h2 class="team01__navigation__content__encompass__subtitle mb-0">{{$section->subtitle}}</h2>
                            <hr class="team01__navigation__content__encompass__line">
                        @endif
                        <div class="team01__navigation__content__encompass__paragraph">
                            @if ($section->description)
                                <p>
                                    {!! $section->description !!}
                                </p>
                            @endif
                        </div>
                    </div>
                    {{-- Finish team01__navigation__content__encompass --}}
                </div>
                {{-- Finish team01__navigation__content --}}
            </header>
        @endif
        {{-- Finish team01__navigation --}}
        @if ($teams->count())
            <div class="team01__content__product">
                <div class="carousel-team01 owl-carousel">
                    @foreach ($teams as $team)
                        <article class="team01__content__product__item w-100">
                            <div class="team01__content__product__item__image">
                                @if ($team->path_image_box)
                                    <img src="{{asset('storage/' . $team->path_image_box)}}" class="w-100 h-100" alt="Titulo Topico">
                                @endif
                            </div>
                            <div class="team01__content__product__item__description d-flex  flex-column justify-content-end mx-0 w-100 h-100 text-center">
                                <div class="team01__content__product__item__description__encompass">
                                    <div class="team01__content__product__item__description__encompass__icon">
                                        @if ($team->path_image_icon)
                                            <img src="{{asset('storage/' . $team->path_image_icon)}}" alt="" />
                                        @endif
                                    </div>
                                    <div class="flex-column team01__content__product__item__description__encompass__txt">
                                        @if ($team->title || $team->subtitle)
                                            <h2 class="team01__content__product__item__description__encompass__txt__title mx-0 px-0">{{$team->title}}</h2>
                                            <h2 class="team01__content__product__item__description__encompass__txt__subtitle mx-0 px-0">{{$team->subtitle}}</h2>
                                        @endif
                                    </div>
                                </div>
                                <div class="team01__content__product__item__description_paragraph text-start px-0 ">
                                    @if ($team->description)
                                        <p>
                                            {!! $team->description !!}
                                        </p>
                                    @endif
                                </div>
                                <div class="team01__content__product__item__description__buttons">
                                    <a rel="next" href="#" data-fancybox= "{{$team->slug}}" data-src="#lightbox-team01-{{$team->slug}}"  class="team01__content__product__item__description__buttons__cta transition d-flex justify-content-center align-items-center mx-auto">
                                        <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="team01__content__product__item__description__buttons__cta__icon me-3 transition">
                                        @if ($team->title_button)
                                            {{$team->title_button}}
                                        @endif
                                    </a>
                                </div>
                            </div>
                            @include('Client.Pages.teams.TEAM01.show', [
                                'team' => $team
                            ])
                        </article>
                    @endforeach
                    {{-- Finish team01__content__product__item --}}
                </div>
                {{-- Finish carousel-team01 --}}
                <a rel="next" href="{{route('team01.page')}}" class="team01__content__product__cta transition d-flex">
                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="team01__content__product__cta__icon me-3 transition">
                    CTA
                </a>
            </div>
        @endif
        {{-- Finish team01__content__product --}}
    </div>
    {{-- Finish container --}}
</section>
{{-- Finish team01 --}}
