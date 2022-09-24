@foreach ($slides as $slide)

@endforeach
<section id="SLID01" class="container-fluid" data-slide-height="auto">
    @if ($slide->title_button=='' && $slide->link_button)
        <a href="{{$slide->link_button}}" target="{{$slide->target_link_button}}" class="link-full"></a>
    @endif
    <img src="{{asset('storage/'.$slide->path_image_desktop)}}" data-image-mobile="{{asset('storage/'.$slide->path_image_mobile)}}" class="img-background-slide" alt="image Background {{$slide->title}} {{$slide->subtitle}}">
    <div class="content-slide container ms-auto me-auto row align-items-center {{$slide->position_content}}">
        <div class="content-description col-12 col-sm-9">
            <h2>
                <span class="title">{{$slide->title}}</span>
                <span class="subtitle">{{$slide->subtitle}}</span>
            </h2>
            <p class="description">{{$slide->description}}</p>
            @if ($slide->title_button && $slide->link_button)
                <a href="{{$slide->link_button}}" target="{{$slide->target_link_button}}" class="btn-cta-slide py-1 px-3 transition">{{$slide->title_button}}</a>
            @endif
        </div>
        <div class="img-floating-png col-sm-6">
            <img src="{{asset('storage/'.$slide->path_image_png)}}" alt="image Destaque {{$slide->title}} {{$slide->subtitle}}">
        </div>
    </div>
</section>
