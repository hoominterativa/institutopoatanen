@if ($slides->count())
    <section id="SLID01" class="slid01">
        <div class="slid01__swiper-wrapper swiper-wrapper">
            @foreach ($slides as $slide)
                <div class="slid01__item swiper-slide">
                    @if ($slide->path_image_desktop || $slide->path_image_mobile)
                        <picture class="slid01__item__background">
                            @if ($slide->path_image_mobile)
                                <source media="(max-width:991.98px )" srcset="{{ asset('storage/' . $slide->path_image_mobile) }}">
                            @endif
                            @if ($slide->path_image_desktop)
                                <img src="{{ asset('storage/' . $slide->path_image_desktop) }}" class="slid01__item__background__img"
                                    alt="Image de Background {{ $slide->title }} {{ $slide->subtitle }}">
                            @endif
                        </picture>
                    @endif
                    @if ($slide->title || $slide->subtitle || $slide->description || $slide->link_button)
                        <header class="slid01__item__header">
                            @if ($slide->title)
                                <h1 class="slid01__item__header__title">{!! $slide->title !!}</h1>
                            @endif
                            @if ($slide->subtitle)
                                <h2 class="slid01__item__header__subtitle">{!! $slide->subtitle !!}</h2>
                            @endif
                            {{-- @if ($slide->description)
                                <p class="slid01__item__header__description">{{ $slide->description }}</p>
                            @endif --}}
                            @if ($slide->link_button)
                                <a href="{{ getUri($slide->link_button) }}" target="{{ $slide->target_link_button }}" class="slid01__item__header__cta">
                                    @if ($slide->title_button)
                                        <span>
                                            {{ $slide->title_button }}
                                        </span>
                                    @endif
                                </a>
                            @endif
                        </header>
                    @endif
                    @if ($slide->path_image)
                        <img class="slid01__item__image" src="{{ asset('storage/' . $slide->path_image) }}"
                            alt="image Destaque {{ $slide->title }} {{ $slide->subtitle }}">
                    @endif
                </div>
            @endforeach
        </div>
    </section>
@endif
