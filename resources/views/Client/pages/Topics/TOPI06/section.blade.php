<section id="CONT06" class="cont06">
    <div class="container-fluid">
        <div class="row cont06__row">
            @foreach ($topics as $topic)
                <article class="cont06__box col-12 col-sm-6">
                    <div class="position-relative">
                        <img src="{{asset('storage/'.$topic->path_image)}}" alt="{{$topic->title}}" width="100%" height="100%" class="cont06__box__background position-absolute top-0 start-0">
                        <div class="cont06__box__content row">
                            <div class="col-8">
                                <h2 class="cont06__box__title">{{$topic->title}}</h2>
                                <div class="cont06__box__paragraph">
                                    <p>{{$topic->description}}</p>
                                </div>
                                @if ($topic->link_button)
                                    <!-- <a href="{{getUri($topic->link_button)}}" target="{{$topic->target_link_button}}" class="cont06__box__cta">
                                        <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="25" class="cont06__box__cta__icon" alt="">
                                        {{$topic->title_button}}
                                    </a> -->
                                @endif
                            </div>
                            <div class="col-4 cont06__box__image d-flex align-items-center justify-content-center">
                                <img src="{{asset('storage/'.$topic->path_image_icon)}}" width="63" class="cont06__box__image__img" alt="{{$topic->title}}">
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
            {{-- END .cont06__box --}}
        </div>
    </div>
</section>
