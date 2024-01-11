@if ($section)
    <section id="ABOU01" class="abou01 container-fluid" style="background-image: url({{ asset('storage/' . $section->path_image_desktop) }});background-color: {{ $section->background_color }}">
        <div class="container">
            @if ($section->title || $section->subtile)
                <h3 class="abou01__container-title">
                    <span class="abou01__title">{{$section->title}}</span>
                    <span class="abou01__subtitle">{{$section->subtitle}}</span>
                </h3>
                <hr class="abou01__line">
            @endif
            @if ($section->description)
                <p class="abou01__paragraph">
                    {!! $section->description !!}
                </p>
            @endif
            @if ($section->link_button)
                <a href="{{getUri($section->link_button)}}" target="{{$section->target_link_button}}" class="abou01__cta transition">
                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="abou01__cta__icon me-3 transition">
                    {{$section->title_button}}
                </a>
            @endif
        </div>
        {{-- END .container --}}
    </section>
    {{-- END #ABOU01 --}}
@endif
