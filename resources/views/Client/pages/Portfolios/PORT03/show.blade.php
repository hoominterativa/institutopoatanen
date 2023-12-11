
<section id="lightbox-port03-{{$portfolio->id}}" class="posh-show posh">
    <div class="container container--posh">
        <header class="posh__header text-center">
            <h2 class="posh__header__title">{{$portfolio->title}}</h2>
            <h3 class="posh__header__subtitle">{!! $portfolio->text !!}</h3>
        </header>
        <div class="posh__content carousel-posh">
            <div class="posh__box box-slide">
                <div class="posh__box__engImage">
                    <div class="posh__box__engImage__content">
                        <div class="posh__box__engImage__content__flow image-container">
                            <div class="posh__box__engImage__content__flow__images">
                                @if ($portfolio->path_image_before)
                                    <img src="{{asset('storage/' . $portfolio->path_image_before)}}" alt="Image antes" class="posh__box__engImage__content__flow__images__img image1">
                                @endif
                                @if ($portfolio->path_image_after)
                                    <img src="{{asset('storage/' . $portfolio->path_image_after)}}" alt="Image depois" class="posh__box__engImage__content__flow__images__img image2">
                                @endif
                            </div>
                        </div>
                        <div class="posh__box__engImage__content__divider divider">
                            <span class="before-text">Antes</span>
                            <span class="after-text">Depois</span>
                        </div>
                    </div>
                </div>
                <div class="posh__box__description">
                    @if ($portfolio->link_button || $portfolio->title_button)
                        <a href="{{getUri($portfolio->link_button)}}" target="{{$portfolio->target_link_button}}" class="posh__box__description__btn transition d-flex justify-content-center align-items-center">
                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="icon" class="posh__box__description__btn__icon me-3 transition">
                            {{$portfolio->title_button}}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
{{-- #PORT02 --}}

