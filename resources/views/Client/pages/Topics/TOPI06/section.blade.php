@if ($topics->count())
    <section id="TOPI06" class="topi06">
        <div class="container-fluid">
            <div class="row topi06__row">
                @foreach ($topics as $topic)
                    <article class="topi06__box col-12 col-sm-6">
                        <div class="position-relative">
                            @if ($topic->path_image_desktop)
                                <img src="{{asset('storage/'.$topic->path_image_desktop)}}" alt="Background" width="100%" height="100%" class="topi06__box__background position-absolute top-0 start-0">
                            @endif
                            <div class="topi06__box__content row">
                                <div class="col-8">
                                    <h2 class="topi06__box__title">{{$topic->title}}</h2>
                                    <div class="topi06__box__paragraph">
                                        <p>{{$topic->description}}</p>
                                    </div>
                                    @if ($topic->link_button)
                                        <a href="{{getUri($topic->link_button)}}" target="{{$topic->target_link_button}}" class="topi06__box__cta">
                                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="25" class="topi06__box__cta__icon" alt="">
                                            {{$topic->title_button}}
                                        </a>
                                    @endif
                                </div>
                                <div class="col-4 topi06__box__image d-flex align-items-center justify-content-center">
                                    @if ($topic->path_image_icon)
                                        <img src="{{asset('storage/'.$topic->path_image_icon)}}" width="63" class="topi06__box__image__img" alt="Ícone">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
                {{-- END .topi06__box --}}
            </div>
        </div>
    </section>
@endif
