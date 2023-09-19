<div id="lightbox-serv08-{{$service->id}}" class="lightbox-serv08 row">
    <div class="row px-0 mx-0 lightbox-serv08__content">
        <div class="lightbox-serv08__content__left">
            <article class="lightbox-serv08__content__left__article" style="background-image: url({{ asset('images/gray.png') }}); background-color: #ffffff;">
                <div class="lightbox-serv08__promotion">
                    <h4 class="lightbox-serv08__promotion__titulo">Promoção</h4>
                </div>
                <div class="lightbox-serv08__content w-100 d-flex flex-column align-items-stretch">
                    <div class="lightbox-serv08__top w-100 d-flex align-items-center justify-content-between">
                        <div class="lightbox-serv08__top__left d-flex flex-column align-items-start justify-content-start ">
                            <h3 class="lightbox-serv08__top__title">{{$service->title}}</h3>
                            <h4 class="lightbox-serv08__top__subtitle">{{$service->subtitle}}</h4>
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
                        <h4 class="lightbox-serv08__top__right__subtitle">{{$service->title_price}}</h4>
                        <h3 class="lightbox-serv08__top__right__title"><span>R$</span> {{$service->price}}</h3>
                    </div>
                </div>
            </article>
        </div>
        @if ($contact)
            <div class="lightbox-serv08__content__right">
                <h2 class="lightbox-serv08__content__right__titulo">{{$contact->title}}</h2>
                <div class="lightbox-serv08__content__right__descricao">
                    <p>
                        {!! $contact->description !!}
                    </p>
                </div>
                {!! Form::open([
                    'route' => 'lead.store',
                    'method' => 'post',
                    'files' => true,
                    'class' => 'send_form_ajax sche01-form__form d-flex w-100 flex-column align-items-stretch form-contact parsley-validate align-items-center',
                ]) !!}
                <div class="sche01-form__form__inputs d-flex flex-column w-100 align-items-stretch">
                    <input type="hidden" name="target_lead" value="{{$contact->title}}">
                    <input type="hidden" name="target_send" value="{{ base64_encode($contact->email) }}">

                    @foreach ($inputs as $name => $input)
                        @include('Client.Components.inputs', [
                            'name' => $name,
                            'options' => $input->option,
                            'placeholder' => $input->placeholder,
                            'required' => isset($input->required) ? $input->required : false,
                            'type' => $input->type,
                            'class' => 'col-md-8',
                        ])
                    @endforeach
                    <label for="" class="sche01-form__form__checkbox-label">
                        {!! Form::checkbox('term_accept', 1, null, [
                            'class' => 'form-check-input me-1',
                            'id' => 'term_accept',
                            'required' => true,
                        ]) !!}
                        {!! Form::label('term_accept', 'Aceito os termos descritos na ', ['class' => 'form-check-label']) !!}
                        <a href="{{ getUri($compliance->link ?? '#') }}" target="_blank" class="">Aceito os termos descritos na Política de Privacidade</a>
                    </label>
                </div>
                <button type="submit" class="lightbox-serv08__cta">
                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" class="serv08-box__cta__icon" alt="Ícone">
                    @if ($contact->title_button)
                        {{ $contact->title_button }}
                    @endif
                </button>
                {!! Form::close() !!}
            </div>
        @endif
    </div>
</div>
