@if ($section)
    <section id="BRAN01" class="bran01 container-fluid"
        style="background-image: url({{ asset('storage/' . $section->path_image_home_desktop) }}); background-color: {{ $section->background_color_home }};">
        <div class="container container--bran01">
            <div class="row">
                <div class="bran01__encompass px-0 text-center mx-auto w-100">
                    <h2 class="bran01__encompass__title">{{ $section->title_home }}</h2>
                    <h3 class="bran01__encompass__subtitle">{{ $section->subtitle_home }}</h3>
                    <hr class="bran01__encompass__line">
                    <div class="bran01__encompass__paragraph mx-auto">
                        <p>
                            {!! $section->description_home !!}
                        </p>
                    </div>
                </div>
                {{-- END .bran01__encompass --}}
                <div class="bran01__content row mx-auto px-0">
                    @foreach ($brands as $brand)
                        @if ($brand->featured)
                            <div class="bran01__box col-sm-3">
                                <div class="bran01__box__content position-relative"
                                    style="background-image:url({{ asset('storage/' . $brand->path_image_box) }}); background-size:cover;background-repeat:no-repeat; background-position:center;">
                                    <a href="{{ $brand->link }}" target="{{ $brand->target_link }}"
                                        class="link-full"></a>
                                    <div class="bran01__box__image">
                                        <img src="{{ asset('storage/' . $brand->path_image_icon) }}" alt="Logo"
                                            loading="lazy">
                                    </div>
                                </div>
                            </div>
                        @endif
                        {{-- END .bran01__box --}}
                    @endforeach
                </div>
                {{-- END .bran01__content --}}
            </div>
        </div>
        {{-- END .bran01__container --}}
    </section>
    {{-- END .bran01 --}}
@endif
