@if ($categories->count() || $portfolios->count() || $section)
    @if ($section)
        <div>
            @if ($section->title_section)
                <h1>{{ $section->title_section }}</h1>
            @endif
            @if ($section->subtitle_section)
                <h2>{{ $section->subtitle_section }}</h2>
            @endif
        </div>
    @endif

    @if ($categories->count())
        <aside>
            <menu>
                @foreach ($categories as $category)
                    <li>
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
                            <a href="{{ route('port05.show', ['PORT05PortfoliosCategory' => $category->slug, 'PORT05Portfolios' => $portfolio->slug]) }}"
                                class="link-full" title="{{ $portfolio->title }}"></a>
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


    <a href="{{ route('port05.page') }}" class="serv09__main__cta">
        CTA
    </a>

@endif
