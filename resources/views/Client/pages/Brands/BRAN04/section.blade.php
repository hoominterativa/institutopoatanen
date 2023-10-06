<section id="BRAN04" class="bran04">
    <div class="container container--bran04">
        @if ($section)
            <div class="bran04__encompass text-center">
                @if ($section->title || $section->subtitle)
                    <h2 class="bran04__encompass__title">{{ $section->title }}</h2>
                    <h3 class="bran04__encompass__subtitle">{{ $section->subtitle }}</h3>
                    <hr class="bran04__encompass__line">
                @endif
                <div class="bran04__encompass__paragraph mx-auto">
                    @if ($section->description)
                    <p>
                        {!! $section->description !!}
                    </p>
                    @endif
                </div>
            </div>
        @endif
        @if ($brands->count())
            <div class="bran04__content row mx-auto px-0">
                @foreach ($brands as $brand)
                    <div class="bran04__content__box col-sm-3 position-relative">
                        <a href="{{getUri($brand->link?? '#')}}" target="_blank" class="link-full" @if (!$brand->link) style="cursor: default;" @endif></a>
                        <div class="bran04__content__box__image " style="background-image:url({{ asset('storage/' . $brand->path_image) }});">
                            @if ($brand->path_image_icon)
                                <img src="{{ asset('storage/' . $brand->path_image_icon) }}" alt="Logo" loading="lazy">
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
