@if ($topics->count() || $section)
    @if ($section)
        <div>
            @if ($section->title)
                <h1>{{$section->title}}</h1>
            @endif
            @if ($section->subtitle)
                <h2>{{$section->subtitle}}</h2>
            @endif
        </div>
    @endif
    @if ($topics->count())
        <div>
            @foreach ($topics as $topic)
                @if ($topic->path_image_desktop)
                    <img src="{{asset('storage/'.$topic->path_image_desktop)}}" alt="Background desktop">
                @endif
                @if ($topic->path_image_mobile)
                <img src="{{asset('storage/'.$topic->path_image_mobile)}}" alt="Background mobile">
                @endif
                @if ($topic->path_image_icon)
                    <img src="{{asset('storage/'.$topic->path_image_icon)}}" alt="Ícone do tópico">
                @endif
                @if ($topic->text)
                    {!! $topic->text !!}
                @endif
                @if ($topic->link_button)
                    <a href="{{getUri($topic->link_button)}}" target="{{$topic->target_link}}" rel="noopener noreferrer">
                        {{$topic->title_button}}
                    </a>
                @endif
            @endforeach
        </div>
    @endif
@endif
