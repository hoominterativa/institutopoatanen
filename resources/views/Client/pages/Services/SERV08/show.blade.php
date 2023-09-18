<div id="lightbox-serv08" class="lightbox-serv08 row">
    <div class="row px-0 mx-0 lightbox-serv08__content">
        <div class="lightbox-serv08__content__left">
            <article class="lightbox-serv08__content__left__article" style="background-image: url({{ asset('images/gray.png') }}); background-color: #ffffff;">
                <div class="lightbox-serv08__promotion">
                    <h4 class="lightbox-serv08__promotion__titulo">Promoção</h4>
                </div>
                <div class="lightbox-serv08__content w-100 d-flex flex-column align-items-stretch">
                    <div class="lightbox-serv08__top w-100 d-flex align-items-center justify-content-between">
                        <div class="lightbox-serv08__top__left d-flex flex-column align-items-start justify-content-start ">
                            <h3 class="lightbox-serv08__top__title">Titulo Topico</h3>
                            <h4 class="lightbox-serv08__top__subtitle">subtítulo</h4>
                            <hr class="lightbox-serv08__top__line">
                        </div>
                        <div class="lightbox-serv08__top__center d-flex flex-column align-items-start justify-content-start ">
                            <h3 class="lightbox-serv08__top__center__title">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Tenetur veritatis qui error odi.</h3>
                            <ul class="lightbox-serv08__top__center__list">
                                @for ($i = 0; $i < 7; $i++) <li class="lightbox-serv08__top__center__list__item"><span><img src="{{ asset('images/cta.png') }}" alt="Icone check"></span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo veritatis.</li>
                                    @endfor
                            </ul>
                        </div>
                    </div>
                    <div class="lightbox-serv08__top__right d-flex flex-column align-items-end justify-content-start ">
                        <h4 class="lightbox-serv08__top__right__subtitle">subtítulo</h4>
                        <h3 class="lightbox-serv08__top__right__title"><span>R$</span> 00,00</h3>
                    </div>
                </div>
            </article>
        </div>
        <div class="lightbox-serv08__content__right">
            <h2 class="lightbox-serv08__content__right__titulo">Form Completo</h2>
            <div class="lightbox-serv08__content__right__descricao">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu p</p>
            </div>
            <form action="" class="lightbox-serv08__content__right__form">
                <div class="input__item input__item--text">
                    <input type='text' id='nome' name='nome' placeholder="Nome:" required>
                </div>
                <div class="input__item input__item--email">
                    <input type="email" id="email" name="email" placeholder="Email:" value="">
                </div>
                <div class="input__item input__item--phone">
                    <input type="tel" id="telefone" name="Telefoe" placeholder="Telefone:" value="">
                </div>
                <div class="input__item input__item--text">
                    <input type="text" id="cidade_origem" name="cidade_origem" placeholder="Cidade de Origem" value="">
                </div>
            </form>
            <div class="input__item input__item--checkbox">
                <div style=" width: 100%;" class="d-flex align-items-center">
                    <div style=" width: 100%; margin-bottom: 0!important;" class="col-12 col-lg-6 mb-3 form-check d-flex align-items-center">
                        <h4 style=" width: 100%;" class="lightbox-serv08__content__right__form__check__titulo">Aceito os termos descritos na Política de Privacidade</h4>
                    </div>
                </div>
                <input style=" width: 16px;" type="checkbox" name="" value="">
            </div>
            <a rel="next" class="lightbox-serv08__cta" href="">
                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="serv08-box__cta__icon">
                CTA
            </a>
        </div>
    </div>
</div>