@if (isset($section))
    <section class="abou04">
        @if (isset($section->path_image))
            <div class="abou04__image">
                <img src="{{ asset('storage/' . $section->path_image) }}" alt="{{$section->title}}"
                    class="abou04__image__img">
            </div>
        @endif
        @if (isset($section->title) || isset($section->subtitle) || isset($section->description) || isset($section->link_button))
            <header class="abou04__header">
                @if (isset($section->title))                
                    <h2 class="abou04__header__title">{{$section->title}}</h2>
                @endif
                @if (isset($section->subtitle))                
                    <h3 class="abou04__header__subtitle">{{$section->subtitle}}</h3>
                @endif
                @if (isset($section->description))                
                    <div class="abou04__header__paragraph">
                        {{!! $section->description !!}}
                    </div>
                @endif
                @if (isset($section->link_button))                
                    <a href="{{ $section->link_button }}" target="{{ $section->target_link}}" class="abou04__header__cta">{{ $section->title_button}}</a>
                @endif
            </header>
        @endif
    </section>
@endif
