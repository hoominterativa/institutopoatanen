@if ($section)
    <section id="SERV06" class="serv06 w-100"
        style="background-image: url({{ asset('storage/' . $section->path_image_desktop) }}); background-color: {{$section->background_color}};">
        <div class="container serv06__container">
            @if ($section->path_image)
                <img src="{{ asset('storage/' . $section->path_image) }}" alt="" class="serv06__image">
            @endif
            <div class="serv06__right d-flex flex-column align-items-start justify-content-start">
                @if ($section->title || $section->subtitle)
                    <h2 class="serv06__title">{{$section->title}}</h2>
                    <h3 class="serv06__subtitle">{{$section->subtitle}}</h3>
                    <hr class="serv06__line">
                @endif
                <div class="serv06__desc">
                    @if ($section->description)
                        <p>
                            {!! $section->description !!}
                        </p>
                    @endif
                </div>
                <a href="{{route('serv06.page')}}" class="serv06__cta">
                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv06__cta__icon">
                    CTA
                </a>
            </div>
        </div>
    </section>
@endif
