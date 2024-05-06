@if ($section)
    <section id="SERV06" class="serv06 w-100"
        style="background-image: url({{ asset('storage/' . $section->path_image_desktop_section) }});">
        <div class="container serv06__container">
            @if ($section->path_image_section)
                <img src="{{ asset('storage/' . $section->path_image_section) }}" alt="" class="serv06__image">
            @endif
            <div class="serv06__right d-flex flex-column align-items-start justify-content-start">
                @if ($section->title_section || $section->subtitle_section)
                    <h2 class="serv06__title">{{$section->title_section}}</h2>
                    <h3 class="serv06__subtitle">{{$section->subtitle_section}}</h3>
                    <hr class="serv06__line">
                @endif
                @if ($section->description_section)
                    <div class="serv06__desc">
                        <p>
                            {!! $section->description_section !!}
                        </p>
                    </div>
                    @endif
                <a href="{{route('serv06.page')}}" class="serv06__cta">
                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv06__cta__icon">
                    CTA
                </a>
            </div>
        </div>
    </section>
@endif
