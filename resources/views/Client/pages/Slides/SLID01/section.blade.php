<section id="slide">
    <div class="slide-carousel-fade">
        @foreach ($slides as $slide)
            <div class="slide-carousel-blade" style="background-image: url({{url('storage/'.$slide->path_image_background)}})">
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="h-100 content-slide d-flex align-items-center flex-nowrap">
                            <div>
                                <h2 class="title">
                                    <span class="subtitle">{{$slide->subtitle}}</span>
                                    {{$slide->title}}
                                </h2>
                                <p>{{$slide->description}}</p>
                                <nav>
                                    @if ($slide->button_link && $slide->button_title)
                                        <a href="{{$slide->button_link}}" class="btn button-wave button-link-slide">{{$slide->button_title}}</a>
                                    @endif
                                    <div class="navigation-slide-fade"></div>
                                </nav>
                            </div>
                        </div>
                        {{-- End .content-slide --}}
                    </div>
                    <div class="col-12 col-lg-6">
                        @if ($slide->path_image_png)
                            <img class="image-png-slide" width="460" src="{{url('storage/'.$slide->path_image_png)}}" alt="">
                        @endif
                    </div>
                </div>
                {{-- End .row --}}
            </div>
        @endforeach
    </div>
</section>
