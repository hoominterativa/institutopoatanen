@if ($contents)
    @foreach ($contents as $content)
        <section id="CONT03" class="cont03 container-fluid"
            style="background-image: url({{ asset('storage/' . $content->path_image_background_desktop)}}); background-color:{{$content->background_color}};">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12 col-lg-4">
                        <article class="cont03__content">
                            @if ($content->title || $content->subtitle)
                                <h2 class="cont03__content__hypertext">
                                    <span class="cont03__content__title">{{$content->title}}</span>
                                    <span class="cont03__content__subtitle">{{$content->subtitle}}</span>
                                    <hr class="cont03__content__line">
                                </h2>
                            @endif
                            @if ($content->description)
                                <div class="cont03__content__paragraph">
                                    {!! $content->description !!}
                                </div>
                            @endif
                            @if ($content->link_button)
                                <a href="{{getUri($content->link_button)}}" target="{{$content->target_link_button}}" class="cont03__content__cta d-flex justify-content-center align-items-center transition">
                                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" class="cont03__content__cta__icon transition me-3" width="25" alt="Ícone">
                                    @if ($content->title_button)
                                        {{$content->title_button}}
                                    @endif
                                </a>
                            @endif
                        </article>
                    </div>
                    @if ($content->path_image_center)
                        <div class="col-12 col-lg-4">
                            <figure class="cont03__figure__center">
                                <img src="{{asset('storage/'. $content->path_image_center)}}" width="100%" alt="Imagem central">
                            </figure>
                        </div>
                    @endif
                    @if ($content->path_image_right)
                        <div class="col-12 col-lg-4">
                            <figure class="cont03__figure__right">
                                <img src="{{asset('storage/'. $content->path_image_right)}}" width="100%" alt="Imagem direita">
                            </figure>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endforeach
@endif
