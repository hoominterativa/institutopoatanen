@if ($topics->count())
    <section id="TOPI04" class="topi04 container-fluid px-0">
        @foreach ($topics as $topic)
            <div class="row">
                <div class="topi04__boxLeft col-md-6 px-0">
                    @if ($topic->path_image)
                        <div class="topi04__image w-100 h-100">
                            <img src="{{ asset('storage/' . $topic->path_image) }}" class="w-100 h-100" alt="">
                        </div>
                    @endif
                </div>
                <div class="topi04__boxRight col-md-6 px-0 d-flex flex-column justify-content-between">
                    <div class="topi04__top">
                        <div class="topi04__description">
                            @if ($topic->title_topic || $topic->title || $topic->subtitle)
                                <h4 class="topi04__destaque">{{ $topic->title_topic }}</h4>
                                <h2 class="topi04__title">{{ $topic->title }}</h2>
                                <h3 class="topi04__subtitle">{{ $topic->subtitle }}</h3>
                                <hr class="topi04__line w-100">
                            @endif
                            <div class="topi04__paragraph">
                                @if ($topic->description)
                                    <p>
                                        {!! $topic->description !!}
                                    </p>
                                @endif
                            </div>
                            <a href="{{ $topic->link_button }}" target="{{ $topic->target_link_button }}"
                                class="topi04__cta transition d-flex justify-content-center align-items-center">
                                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                    class="topi04__cta__icon me-3 transition">
                                @if ($topic->title_button)
                                    {{ $topic->title_button }}
                                @endif
                            </a>
                        </div>
                    </div>
                    <div class="topi04__topics carrosel-topi04-topics owl-carousel">
                        @foreach ($topic->topicSection as $topicSection)
                            <div class="topi04__topics__item w-100">
                                <div class="topi04__topics__item__image w-100 h-100">
                                    @if ($topicSection->path_image_box)
                                        <img src="{{ asset('storage/' . $topicSection->path_image_box) }}"
                                            alt="Imagem" class="w-100 h-100">
                                    @endif
                                </div>
                                <div
                                    class="topi04__topics__item__description d-flex flex-column position-absolute top-0 start-0 w-100 h-100 justify-content-center align-items-center">
                                    @if ($topicSection->path_image_icon)
                                        <img src="{{ asset('storage/' . $topicSection->path_image_icon) }}"
                                            class="topi04__topics__item__icone" alt="Ícone Hoom">
                                    @endif
                                    @if ($topicSection->title)
                                        <h4 class="topi04__topics__item__title mb-0 text-center">
                                            {{ $topicSection->title }}</h4>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            {{-- END .row --}}
        @endforeach
    </section>
    {{-- END #ABOU04 --}}
@endif
