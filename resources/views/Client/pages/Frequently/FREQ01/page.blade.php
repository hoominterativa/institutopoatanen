<main class="freq01-page">
    @if ($frequentlys->count())
        <section class="freq01-page__faq">
            <h3 class="freq01-page__faq__title">Perguntas frequentes</h3>
            @foreach ($frequentlys as $frequently)
                <details class="freq01-page__faq__item">
                    @if ($frequently->question)
                        <summary class="freq01-page__faq__item__title" aria-level="3" role="heading">
                            {{ $frequently->question }}
                        </summary>
                    @endif

                    @if ($frequently->answer)
                        <div class="freq01-page__faq__item__paragraph details-content">
                            <p>
                                {!! $frequently->answer !!}
                            </p>
                        </div>
                    @endif
                </details>
            @endforeach
        </section>
    @endif
</main>

