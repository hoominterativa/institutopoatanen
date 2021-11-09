<section id="slide">
    <div class="navigation-slide"></div>
    <div class="slide-carousel slide-carousel-fade owl-carousel">
        @foreach ($slides as $slide)
            <div class="slide-carousel-blade" style="background-image: url({{url('storage/'.$slide->path_image_background)}})">
                <div class="row h-100">
                    <div class="col-12 col-lg-6">
                        <div class="h-100 content-slide d-flex align-items-center flex-nowrap pe-5">
                            <div>
                                <h2 class="title pb-4 mb-4">
                                    <span class="subtitle">{{$slide->subtitle}}</span>
                                    {{$slide->title}}
                                </h2>
                                <p>{{$slide->description}}</p>
                                <nav>
                                    @if ($slide->button_link && $slide->button_title)
                                        <a href="{{$slide->button_link}}" class="btn btn-wave btn-primary button-link-slide">{{$slide->button_title}}</a>
                                    @endif

                                </nav>
                            </div>
                        </div>
                        {{-- End .content-slide --}}
                    </div>
                    <div class="col-12 col-lg-6 position-relative">
                        @if ($slide->path_image_png)
                            <img class="image-png-slide ms-auto me-auto" src="{{url('storage/'.$slide->path_image_png)}}" alt="">
                        @endif
                    </div>
                </div>
                {{-- End .row --}}
            </div>
        @endforeach
    </div>
</section>
