@if ($contents)
    @foreach ($contents as $content)
        <section id="CONT03" class="cont03">
            {{-- FRONTEND: REVISAR A ESTRUTURA DO HTML - ARTICLE DEVERIA ENVOLVER TAMBEM A IMAGEM OU SO A PARTE DO TEXTO? --}}
            <div class="cont03__information">
                @if ($content->title || $content->subtitle || $content->description)
                    @if ($content->title)
                        <h2 class="cont03__information__title">{{ $content->title }}</h2>
                    @endif

                    @if ($content->subtitle)
                        <h3 class="cont03__information__subtitle">{{ $content->subtitle }}</h3>
                    @endif

                    @if ($content->title || $content->subtitle)
                        <hr class="cont03__information__line">
                    @endif
                @endif

                @if ($content->description)
                    <div class="cont03__information__paragraph">
                        {!! $content->description !!}
                    </div>
                @endif

                @if ($content->link_button)
                    <a href="{{ getUri($content->link_button) }}" target="{{ $content->target_link_button }}"
                        class="cont03__information__cta">

                        @if ($content->title_button)
                            {{ $content->title_button }}
                        @endif
                    </a>
                @endif
            </div>

            @if ($content->path_image_center)
                <div class="cont03__image">
                    <img src="{{ asset('storage/' . $content->path_image_center) }}" class="cont03__image"
                        alt="Imagem da ">
                </div>
            @endif

            @if ($content->path_image_right)
                <div class="cont03__image">
                    <img src="{{ asset('storage/' . $content->path_image_right) }}" class="" alt="Imagem direita">
                </div>
            @endif

        </section>
    @endforeach
@endif
