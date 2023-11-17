@if ($content)
    <section id="CONT08" class="cont08" style="background-image: url({{ asset('storage/' . $content->path_image_desktop) }}); background-color: {{ $content->background_color }};">
        @if ($content->path_image)
            <img src="{{asset('storage/' . $content->path_image)}}" alt="Imagem">
        @endif
        @if ($content->title || $content->subtitle)
            <h2 class="">{{ $content->title }}</h2>
            <h3 class="">{{ $content->subtitle }}</h3>
            <hr class="">
        @endif
        @if ($content->text)
            <div class="">
                {!! $content->text !!}
            </div>
        @endif
        @if ($topics->count())
            @foreach ($topics as $topic)
                @if ($topic->path_image)
                    <img src="{{asset('storage/' . $topic->path_image)}}" alt="Ícone">
                @endif
                @if ($topic->description)
                    <div class="">
                        {!! $topic->description !!}
                    </div>
                @endif
            @endforeach
        @endif
        @if ($content->link_button)
            <a  href="{{getUri($content->link_button)}}" target="{{$content->target_link_button}}" class="">
                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="Ícone" class="">
                {{$content->title_button}}
            </a>
        @endif
    </section>
@endif
