@if ($section || $topics->count())

    @if ($section)
        <div>
            @if ($section->title)
                {{ $section->title}}
            @endif
            @if ($section->subitle)
                {{ $section->subtitle}}
            @endif
            @if ($section->text)
                {!! $section->text !!}
            @endif
        </div>
    @endif

    @if ($topics->count())
        <div>
            @foreach ($topics as $topic)
                @if ($topic->path_image_icon)
                    <img src="{{asset('storage/'. $topic->path_image_icon)}}" alt="Imagem do {{$topic->title}}">
                @endif
                @if ($topic->title)
                    {{ $topic->title}}
                @endif
                @if ($topic->description)
                    {!! $topic->description !!}
                @endif
            @endforeach
        </div>
    @endif
@endif
