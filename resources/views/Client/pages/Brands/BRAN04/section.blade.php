<section id="BRAN04" class="bran04">
    <div class="container">
        @if ($section)
            <div class="encompass">
                @if ($section->title || $section->subtitle)
                    <h2>{{ $section->title }}</h2>
                    <h3>{{ $section->subtitle }}</h3>
                    <hr>
                @endif
                <div class="paragraph">
                    @if ($section->description)
                    <p>
                        {!! $section->description !!}
                    </p>
                    @endif
                </div>
            </div>
        @endif
        @if ($brands->count())
            <div class="content">
                @foreach ($brands as $brand)
                    <div class="box">
                        <a href="{{getUri($brand->link?? '#')}}" target="_blank" class="link-full" @if (!$brand->link) style="cursor: default;" @endif></a>
                        <div class="image" style="background-image:url({{ asset('storage/' . $brand->path_image) }});">
                            <div>
                                @if ($brand->path_image_icon)
                                    <img src="{{ asset('storage/' . $brand->path_image_icon) }}" alt="Logo" loading="lazy">
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
