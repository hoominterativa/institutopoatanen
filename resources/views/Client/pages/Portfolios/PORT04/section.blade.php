<section id="PORT04" class="port04">
    @if ($section)
        <header>
            @if ($section->title_section || $section->subtitle_section)
                <h3>{{$section->subtitle_section}}</h3>
                <h2>{{$section->title_section}}</h2>
                <hr>
            @endif
            @if ($section->description_section)
                <p>
                    {!! $section->description_section !!}
                </p>
            @endif
        </header>
        @if ($portfolios->count())
            @foreach ($portfolios as $portfolio)
                <article>
                    <img src="{{ asset('storage/' . $portfolio->path_image) }}" alt="Imagem do portfólio">
                    <a href="{{ route('port04.page.content', ['PORT04PortfoliosCategory' => $portfolio->category->slug, 'PORT04Portfolios' => $portfolio->slug] ) }}" class="link-full"></a>
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
                </article>
            @endforeach
            <a href="{{ route('port04.page') }}">
                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" class="me-2" alt="">
                CTA
            </a>
        @endif
    @endif
</section>
