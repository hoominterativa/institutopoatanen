@if ($section)
    <section class="abou04 w-100" id="abou04"
        style="background-image: url({{ asset('storage/' . $section->path_image_desktop_section) }}); background-color: {{ $section->background_color_section }};">
        <main class="abou04__main container">
            @if ($section->path_image_section)
                <img src="{{ asset('storage/' . $section->path_image_section) }}" alt="" class="abou04__image">
            @endif
            <div class="abou04__content d-flex flex-column align-items-start">
                @if ($section->title_section || $section->subtitle_section)
                    <h2 class="abou04__title">{{$section->title_section}}</h2>
                    <h3 class="abou04__subtitle">{{$section->subtitle_section}}</h3>
                    <hr class="abou04__line">
                @endif
                <div class="abou04__desc">
                    @if ($section->description_section)
                        <p>
                            {!! $section->description_section !!}
                        </p>
                    @endif
                </div>
                <a href="{{route('abou04.page')}}" class="abou04__cta">
                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="abou04__cta__icon">
                    CTA
                </a>
            </div>
        </main>
    </section>
@endif
