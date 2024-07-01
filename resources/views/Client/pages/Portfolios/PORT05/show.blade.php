@extends('Client.Core.client')

@section('content')
{{-- BEGIN Page content --}}
    @if ($portfolio->active_banner === 1)
        <section style="background-image: url({{ asset('storage/' . $portfolio->path_image_desktop_banner) }});">
            @if ($portfolio->title_banner)
                <h1>{{ $portfolio->title_banner }}</h1>
            @endif
        </section>
    @endif

    <h1>{{ $portfolio->title }}</h1>
    @if ($portfolio->categories->count())
        <ul>
            @foreach ($portfolio->categories as $category)
                <li>
                    <a href="{{ route('port05.category.page', ['PORT05PortfoliosCategory' => $category->slug]) }}" class="link-full" title="{{ $category->title }}"></a>
                    {{ $category->title }}
                </li>
            @endforeach
        </ul>
    @endif
    @if ($galleries->count())
        <div>
            @if (!$gallery->featured)
                @foreach ($galleries as $gallery)
                    {{-- FRONTEND: Caso tenha $gallery->link_video, a imagem será usada como capa --}}
                    @if ($gallery->link_video)
                        <a href="{{ getUri($gallery->link_video) }}" data-fancybox="gallery">
                            <img src="{{ asset('storage/' . $gallery->path_image) }}" alt="Imagem da galeria">
                        </a>
                    @else
                        <img src="{{ asset('storage/' . $gallery->path_image) }}" data-fancybox="gallery" alt="Imagem da galeria">
                    @endif

                @endforeach
            @else
            @endif
        </div>
    @endif
    @if ($testimonials->count())
        <h2>Depoimentos</h2>
        @foreach ($testimonials as $testimonial)
            <div>
                @if ($testimonial->path_image)
                    <img src="{{asset('storage/' . $testimonial->path_image)}}" alt="Imagem do {{$testimonial->name}}">
                @endif
            </div>
            <div>
                @if ($testimonial->name)
                    <h3>{{$testimonial->name}}</h3>
                @endif
                @if ($testimonial->profession)
                    <h3>{{$testimonial->profession}}</h3>
                @endif
                @if ($testimonial->feedback)
                    {!! $testimonial->feedback !!}
                @endif
            </div>
        @endforeach
    @endif

    @if ($portfolios->count())
        <h2>Relacionados</h2>
        <main>
            <div>
                @foreach ($portfolios as $portfolio)
                    <li>
                        @foreach ($portfolio->categories as $category)
                            <a href="{{ route('port05.show', ['PORT05PortfoliosCategory' => $category->slug, 'PORT05Portfolios' => $portfolio->slug]) }}" class="link-full" title="{{ $category->title }}"></a>
                        @endforeach
                        @if ($portfolio->path_image)
                            <img src="{{ asset('storage/' . $portfolio->path_image) }}" alt="Ícone de {{ $portfolio->title }}" loading="lazy">
                        @endif
                        {{ $portfolio->title }}
                    </li>
                @endforeach
            </div>
        </main>
    @endif

{{-- Finish Content page Here --}}
    @foreach ($sections as $section)
        {!! $section !!}
    @endforeach
@endsection
