<section id="CONT12" class="cont12">
    <header class="cont12__header">
        <div class="container cont12__header__container">
            <h2 class="cont12__title">Titulo</h2>
            <h3 class="cont12__subtitle">Subtitulo</h3>
            <hr class="cont12__line">
        </div>
    </header>
    <main class="cont12__main">
        <ul class="cont12__list container">
            @for ($i =0; $i < 4; $i++) <li class="cont12__list__item">
                <div class="cont12__list__item__left">
                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="cont12__list__item__icon">
                    <h4 class="cont12__list__item__title">Titulo do arquivo</h4>
                </div>
                <div class="cont12__list__item__right">
                    <a href="" download="" class="cont12__list__item__cta">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" class="cont12__list__item__cta__icon" alt="">
                        CTA
                    </a>
                    <a href=""  class="cont12__list__item__cta">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" class="cont12__list__item__cta__icon" alt="">
                        CTA
                    </a>
                </div>
                </li>
                @endfor
        </ul>
    </main>
</section>