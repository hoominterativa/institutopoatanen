@foreach ($contents as $content)
    <section id="CONT03" class="cont03 container-fluid" style="background-image: url({{asset('storage/'.$content->path_image_background)}})">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg-4">
                    <article class="cont03__content">
                        <h2 class="cont03__content__hypertext">
                            <span class="cont03__content__title">{{$content->title}}</span>
                            <span class="cont03__content__subtitle">{{$content->subtitle}}</span>
                        </h2>
                        <hr class="cont03__content__line">
                        <p class="cont03__content__paragraph">{{$content->description}}</p>
                        @if ($content->link)
                            <a href="{{getUri($content->link)}}" target="{{$content->target_link}}" class="cont03__content__cta d-flex justify-content-center align-items-center transition">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" class="cont03__content__cta__icon transition me-3" width="25" alt="">
                                CTA
                            </a>
                        @endif
                    </article>
                </div>
                <div class="col-12 col-lg-4">
                    <figure class="cont03__figure__center">
                        <img src="{{asset('storage/'.$content->path_image_center)}}" width="100%" alt="">
                    </figure>
                </div>
                <div class="col-12 col-lg-4">
                    <figure class="cont03__figure__right">
                        <img src="{{asset('storage/'.$content->path_image_right)}}" width="100%" alt="">
                    </figure>
                </div>
            </div>
        </div>
    </section>
@endforeach
