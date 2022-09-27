<section id="SLID01" class="container-fluid p-0" data-slide-height="auto">
    <div class="SLID01 owl-carousel">
        @foreach ($slides as $slide)
            <div class="container-slide">
                @if ($slide->title_button=='' && $slide->link_button)
                    <a href="{{$slide->link_button}}" target="{{$slide->target_link_button}}" class="link-full"></a>
                @endif
                @if ($slide->path_image_desktop)
                    <img src="{{asset('storage/'.$slide->path_image_desktop)}}" data-image-mobile="{{asset('storage/'.$slide->path_image_mobile)}}" class="img-background-slide" alt="image Background {{$slide->title}} {{$slide->subtitle}}">
                @endif
                <div class="content-slide container ms-auto me-auto row align-items-center {{$slide->position_content}}">
                    <div class="content-description col-12 col-sm-9">
                        @if ($slide->title || $slide->subtitle)
                            <h2>
                                <span class="title">{{$slide->title}}</span>
                                <span class="subtitle">{{$slide->subtitle}}</span>
                            </h2>
                        @endif
                        @if ($slide->description)
                            <p class="description">{{$slide->description}}</p>
                        @endif
                        @if ($slide->title_button && $slide->link_button)
                            <a href="{{$slide->link_button}}" target="{{$slide->target_link_button}}" class="btn-cta-slide py-1 px-3 transition">{{$slide->title_button}}</a>
                        @endif
                    </div>
                    <div class="img-floating-png col-sm-6">
                        @if ($slide->path_image_png)
                            <img src="{{asset('storage/'.$slide->path_image_png)}}" alt="image Destaque {{$slide->title}} {{$slide->subtitle}}">
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{-- END owl-carousel --}}
    <div id="dotsSlideCustom"></div>
</section>
