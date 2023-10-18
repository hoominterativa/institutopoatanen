@if ($section)
    <section id="ABOU01" class="abou01 container-fluid" style="background-image: url({{ asset('storage/' . $section->path_image_section_desktop) }});background-color: {{ $section->background_color_section }}">
        <div class="container">
            @if ($section->title_section || $section->subtile_section)
                <h3 class="abou01__container-title">
                    <span class="abou01__title">{{$section->title_section}}</span>
                    <span class="abou01__subtitle">{{$section->subtitle_section}}</span>
                </h3>
                <hr class="abou01__line">
            @endif
            @if ($section->description_section)
                <p class="abou01__paragraph">
                    {!! $section->description_section !!}
                </p>
            @endif
            <a href="{{route('abou01.page')}}" class="abou01__cta transition">
                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="abou01__cta__icon me-3 transition">
                CTA
            </a>
        </div>
        {{-- END .container --}}
    </section>
    {{-- END #ABOU01 --}}
@endif
