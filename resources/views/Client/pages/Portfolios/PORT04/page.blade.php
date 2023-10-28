@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}

<section class="port04-page">
    <header class="">
        <div class="">
            @if ($section->active_banner)
                <div class="" style="background-image: url({{ asset('storage/' . $section->path_image_desktop_banner) }});  background-color: {{$section->background_color_banner}};">
                    @if ($section->title_banner || $section->subtitle_banner)
                        <div class="">
                            <h3 class="">{{$section->title_banner}}</h3>
                            <h4 class="">{{$section->subtitle_banner}}</h4>
                            <hr class="">
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </header>
    <main class="">
        <div class="">
            <div class="">
                <div class="">
                    @if ($section->active_content)
                        @if ($section->subtitle_content || $section->title_content)
                            <h1 class="">{{$section->subtitle_content}}</h1>
                            <h2 class="">{{$section->title_content}}</h2>
                            <hr class="">
                        @endif
                        @if ($section->text_content)
                            <div class="">
                                <p>
                                    {!! $section->text_content !!}
                                </p>
                            </div>
                        @endif
                    @endif
                    @if ($categories->count())
                        <div class="">
                            <ul class="">
                                @foreach ($categories as $category)
                                    <li class=" {{isset($category->selected) ? 'active':''}}">
                                        <a href="{{route('port04.category.page', ['PORT04PortfoliosCategory' =>$category->slug])}}">
                                            @if ($category->path_image_icon)
                                                <img src="{{ asset('storage/' . $category->path_image_icon) }}" alt="Ícone da categoria" class="">
                                            @endif
                                            {{$category->title}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
            @if ($portfolios->count())
                <div class="">
                    @foreach ($portfolios as $portfolio)
                        <article>
                            <a href="{{ route('port04.page.content', ['PORT04PortfoliosCategory' => $portfolio->category->slug, 'PORT04Portfolios' => $portfolio->slug] ) }}">
                                <img src="{{ asset('storage/' . $portfolio->path_image) }}" alt="Imagem do portfólio">
                                <div>
                                    @if ($portfolio->title)
                                        <h4>{{$portfolio->title}}</h4>
                                    @endif
                                    @if ($portfolio->description)
                                        <p>
                                            {!! $portfolio->description !!}
                                        </p>
                                    @endif
                                </div>
                                <img src="{{ asset('storage/' . $portfolio->path_image_icon) }}" alt="Ícone do portfólio">
                            </a>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </main>
</section>

{{-- Finish Content page Here --}}
@foreach ($sections as $section)
{!!$section!!}
@endforeach
@endsection
