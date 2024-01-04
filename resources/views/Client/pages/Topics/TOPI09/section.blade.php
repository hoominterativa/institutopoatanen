@if ($topics->count())
    <section id="TOPI09" class="topi09 container-fluid px-0" style="background-color:;">
        <div class="container container--pd">
            <div class=" row--carrossel owl-carousel topi09__carousel">
                @foreach ($topics as $topic)
                    <article class="topi09__box">
                        <div class="topi09__content transition">
                            <div class="topi09__image">
                                @if ($topic->path_image_icon)
                                    <img src="{{ asset('storage/' . $topic->path_image_icon) }}" class="icon" width="53.74" alt="Ícone">
                                @endif
                            </div>
                            <div class="topi09__description">
                                @if ($topic->title)
                                    <h3 class="topi09__title">{{ $topic->title }}</h3>
                                @endif
                                <div class="topi09__paragraph">
                                    @if ($topic->description)
                                        <p>{!! $topic->description !!}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
                {{-- Fim box --}}
            </div>
            {{-- Fim row --}}
        </div>
        {{-- Fim container --}}
    </section>
@endif
{{-- Fim section topi09 --}}
