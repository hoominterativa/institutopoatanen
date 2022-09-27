<section id="CONT01" class="container-fluid">
    <div class="container py-4">
        <div class="row align-items-center">
            <div class="description col-12 col-sm-8">
                <h3 class="title">{{$content->title}}</h3>
                <h2 class="subtitle">{{$content->subtitle}}</h2>
            </div>
            <div class="image col-12 col-sm-4">
                @if ($content->link)
                    @switch($content->target_link)
                        @case('_blank')
                        @case('_self')
                            <a href="{{$content->link}}" target="{{$content->target_link}}">
                        @break
                        @case('_lightbox')
                            <a href="{{$content->link}}" data-fancybox="">
                        @break
                    @endswitch
                @endif

                    @if ($content->path_image)
                        <img src="{{asset('storage/'.$content->path_image)}}" width="100%" height="100%" alt="{{$content->subtitle}}">
                    @endif

                @if ($content->link)
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>
