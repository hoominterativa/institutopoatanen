@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
    @if ($banner)
        <section style="background-image: url({{ asset('storage/' . $banner->path_image_desktop_banner) }});">
            @if ($banner->title_banner)
                <h1>{{ $banner->title_banner }}</h1>
            @endif
        </section>
    @endif
    @if ($categories->count())
        <aside>
            <menu>
                @foreach ($categories as $category)
                    <li class="{{ isset($category->selected) ? 'active' : '' }}">
                        <a href="{{ route('port05.category.page', ['PORT05PortfoliosCategory' => $category->slug]) }}"
                            class="link-full" title="{{ $category->title }}"></a>
                        {{ $category->title }}
                    </li>
                @endforeach
            </menu>
        </aside>
    @endif
    @if ($portfolios->count())
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
    {!!$section!!}
@endforeach
@endsection
