@if ($section || $brands->count() > 0)

    <section id="BRAN04" class="bran04">
        @if ($section)
            @if ($section->title || $section->subtitle || $section->description)
                <div class="bran04__header">
                    @if ($section->title)
                        <h2 class="bran04__header__title">{{ $section->title }}</h2>
                    @endif

                    @if ($section->subtitle)
                        <h3 class="bran04__header__subtitle">{{ $section->subtitle }}</h3>
                    @endif

                    @if ($section->title || $section->subtitle)
                        <hr class="bran04__header__line">
                    @endif

                    @if ($section->description)
                        <div class="bran04__header__paragraph">
                            <p>
                                {!! $section->description !!}
                            </p>
                        </div>
                    @endif

                </div>
            @endif
        @endif

        @if ($brands->count())
            <div class="bran04__content">
                @foreach ($brands as $brand)
                    <div class="bran04__content__item"
                        style="background-image:url({{ asset('storage/' . $brand->path_image) }});">
                        @if ($brand->link)
                            <a title="link para a marca" href="{{ getUri($brand->link) }}"
                                target="{{ $brand->target_link }}" class="link-full"></a>
                        @endif

                        @if ($brand->path_image_icon)
                            <img src="{{ asset('storage/' . $brand->path_image_icon) }}" alt="Logo da marca"
                                loading="lazy">
                        @endif

                    </div>
                @endforeach
            </div>
        @endif

    </section>
@endif
