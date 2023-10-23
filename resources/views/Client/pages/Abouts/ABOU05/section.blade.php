@if ($section)
    <section id="ABOU05" class="abou05 container-fluid"
        style="background-image: url({{ asset('storage/' . $section->path_image_desktop_section) }}); background-color: {{$section->background_color_section}};">
        <div class="container">
            @if ($section->title_section || $section->subtitle_section)
                <h3 class="abou05__container-title">
                    <span class="abou05__title">{{$section->title_section}}</span>
                    <span class="abou05__subtitle">{{$section->subtitle_section}}</span>
                </h3>
                <hr class="abou05__line">
            @endif
            @if ($section->description_section)
                <p class="abou05__paragraph">
                    {!! $section->description_section !!}
                </p>
            @endif
            <a href="{{route('abou05.page')}}" class="abou05__cta transition">
                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="abou05__cta__icon me-3 transition">
                CTA
            </a>
        </div>
        {{-- END .container --}}
    </section>
@endif
{{-- END #ABOU05 --}}
