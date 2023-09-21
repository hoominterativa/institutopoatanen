@if ($section)
    <section id="BRAN01" class="bran01 container-fluid"
        style="background-image: url({{ asset('storage/' . $section->path_image_home_desktop) }}); background-color: {{ $section->background_color_home }};">
        @if ($section->path_image_home_desktop)
            <div class="bran01__mask"></div>
        @endif
        <div class="container container--bran01">
            <div class="row">
                <div class="bran01__encompass px-0 text-center mx-auto w-100">
                    @if ($section->title_home || $section->subtitle_home)
                        <h2 class="bran01__encompass__title">{{ $section->title_home }}</h2>
                        <h3 class="bran01__encompass__subtitle">{{ $section->subtitle_home }}</h3>
                        <hr class="bran01__encompass__line">
                    @endif
                    <div class="bran01__encompass__paragraph mx-auto">
                        <p>
                            {!! $section->description_home !!}
                        </p>
                    </div>
                </div>
                {{-- END .bran01__encompass --}}
                @if ($brands->count())
                    <div class="bran01__content row mx-auto px-0">
                        @foreach ($brands as $brand)
                            <div class="bran01__box col-sm-3">
                                <div class="bran01__box__content position-relative"
                                    style="background-image:url({{ asset('storage/' . $brand->path_image_box) }}); background-size:cover;background-repeat:no-repeat; background-position:center;">
                                    <a href="{{getUri($brand->link?? '#')}}" target="{{ ($brand->link?$brand->target_link : '_self') }}" @if (!$brand->link) style="cursor: default;" @endif class="link-full"></a>
                                    <div class="bran01__box__image">
                                        @if ($brand->path_image_icon)
                                            <img src="{{ asset('storage/' . $brand->path_image_icon) }}" alt="Logo" loading="lazy">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            {{-- END .bran01__box --}}
                        @endforeach
                    </div>
                @endif
                {{-- END .bran01__content --}}
            </div>
            <!-- <a rel="next" href="{{ route('bran01.page') }}"
                class="bran01__cta transition justify-content-center align-items-center">
                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="Icone CTA"
                    class="bran01__cta__icon me-3 transition">
                CTA
            </a> -->
        </div>
        {{-- END .bran01__container --}}
    </section>
    {{-- END .bran01 --}}
@endif
