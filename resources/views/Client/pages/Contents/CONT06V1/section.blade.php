@if ($contents->count())
    @foreach ($contents as $content)
        <section class="cont06v1">

            @if ($content->title || $content->description)
                <header class="cont06v1__header">
                    @if ($content->title)
                        <h2 class="cont06v1__header__title">
                            {{ $content->title }}
                        </h2>
                    @endif
                    @if ($content->description)
                        <div class="cont06v1__header__paragraph">{!! $content->description !!}</div>
                    @endif
                </header>
            @endif


            @if ($content->link_video)
                <main class="cont06v1__video" {{--BACKEND: INSERIR REQUIRED NO CAMPO DE IMAGEM THUMBNAIL --}}
                    data-src="{{ getUri($content->link_video) }}"
                    style="background-image: url({{ asset('storage/' . $content->path_image) }});">


                    <button class="cont06v1__video__button" title="Play">
                        <img class="cont06v1__video__button__icon" src="{{ asset('storage/uploads/tmp/play.png') }}"
                            alt="Play Vídeo">
                    </button>

                </main>
            @endif


            @if ($content->link_button)
                <a title="{{ $content->title_button }}" href="{{ getUri($content->link_button) }}"
                    target="{{ $content->target_link }}" class="cont06v1__cta">

                    @if ($content->title_button)
                        {{ $content->title_button }}
                    @endif
                </a>
            @endif




        </section>
    @endforeach
@endif
{{-- END #CONT06V1 --}}
