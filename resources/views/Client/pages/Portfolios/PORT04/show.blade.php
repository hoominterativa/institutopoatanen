@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<section class="port04-show">
    <header class="">
        <div class="">
            @if ($portfolio->active_banner)
                <div class="" style="background-image: url({{ asset('storage/' . $portfolio->path_image_desktop_banner) }});  background-color: {{$portfolio->background_color_banner}};">
                    @if ($portfolio->title_banner || $portfolio->subtitle_banner)
                        <div class="">
                            <h3 class="">{{$portfolio->title_banner}}</h3>
                            <h4 class="">{{$portfolio->subtitle_banner}}</h4>
                            <hr class="">
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </header>

    <main>
        @if ($portfolio->active_content)
            <div>
                @if ($portfolio->path_image_content)
                    <div class="">
                        <img src="{{ asset('storage/' . $portfolio->path_image_content) }}" alt="Imagem" class="">
                    </div>
                @endif
                <div class="">
                    @if ($portfolio->title_content || $portfolio->subtitle_content)
                        <h4 class="">{{$portfolio->subtitle_content}}</h4>
                        <h3 class="">{{$portfolio->title_content}}</h3>
                        <hr class="">
                    @endif
                    @if ($portfolio->text_content)
                        <p>
                            {!! $portfolio->text_content !!}
                        </p>
                    @endif
                </div>
            </div>
        @endif
        @if ($additionalTopics->count())
            <div>
                @foreach ($additionalTopics as $additionalTopic)
                    @if ($additionalTopic->path_image_icon)
                        <div class="">
                            <img src="{{ asset('storage/' . $additionalTopic->path_image_icon) }}" alt="Imagem" class="">
                        </div>
                    @endif
                    @if ($additionalTopic->title)
                        <h4>{{$additionalTopic->title}}</h4>
                    @endif
                    @if ($additionalTopic->text)
                        <p>
                            {!! $additionalTopic->text !!}
                        </p>
                    @endif
                @endforeach
            </div>
        @endif
        @if ($topics->count())
            <div>
                @foreach ($topics as $topic)
                    @if ($topic->path_image_icon)
                        <div class="">
                            <img src="{{ asset('storage/' . $topic->path_image_icon) }}" alt="Imagem" class="">
                        </div>
                    @endif
                    @if ($topic->title)
                        <h4>{{$topic->title}}</h4>
                    @endif
                    @if ($topic->description)
                        <p>
                            {!! $topic->description !!}
                        </p>
                    @endif
                @endforeach
            </div>
        @endif
        @if ($galleries->count())
            <div>
                @foreach ($galleries as $gallery)
                    @if ($gallery->path_image)
                        <div class="">
                            <img src="{{ asset('storage/' . $gallery->path_image) }}" alt="Imagem" class="">
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </main>

    @if ($relationships->count())
        <section>
            @if ($portfolio->active_section)
                <header>
                    <div class="">
                        @if ($portfolio->title_section || $portfolio->subtitle_section)
                            <h4 class="">{{$portfolio->subtitle_section}}</h4>
                            <h3 class="">{{$portfolio->title_section}}</h3>
                            <hr class="">
                        @endif
                        @if ($portfolio->description_section)
                            <p>
                                {!! $portfolio->description_section !!}
                            </p>
                        @endif
                    </div>
                </header>
            @endif
            <article>
                <div class="">
                    @foreach ($relationships as $relationship)
                        <article>
                            <a href="{{ route('port04.page.content', ['PORT04PortfoliosCategory' => $relationship->category->slug, 'PORT04Portfolios' => $relationship->slug] ) }}">
                                <img src="{{ asset('storage/' . $relationship->path_image) }}" alt="Imagem do portfólio">
                                <div>
                                    @if ($relationship->title)
                                        <h4>{{$relationship->title}}</h4>
                                    @endif
                                    @if ($relationship->description)
                                        <p>
                                            {!! $relationship->description !!}
                                        </p>
                                    @endif
                                </div>
                                <img src="{{ asset('storage/' . $relationship->path_image_icon) }}" alt="Ícone do portfólio">
                            </a>
                        </article>
                    @endforeach
                </div>
            </article>
        </section>
    @endif

</section>
{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
