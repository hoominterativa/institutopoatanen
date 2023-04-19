@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<div id="FREQ01" class="freq01-page container-fluid px-0">
    <section class="freq01-page__faq">
        <header class="freq01-page__faq__header"
            style="background-image: url({{asset('storage/uploads/tmp/bg-banner-inner.jpg')}}); background-color:;">
                <div class="freq01-pag__faq__header__mask"></div>
                <div class="container container--freq01-page">
                    <h2 class=" d-block text-center">
                        <span class="freq01-page__faq__header__title d-block">Título da Página</span>
                        <span class="freq01-page__faq__header__subtitle d-block">Subtitulo</span>
                    </h2>
                    <hr class="freq01-page__faq__header__line mb-0">
                </div>
        </header>
        <div class="freq01-page__faq__content">
            <div class="container">
                <div class="accordion freq01-page__faq__content__box" id="accordionExample">
                    <div class="accordion-item freq01-page__faq__content__box__item">
                        <h2 class="accordion-header freq01-page__faq__content__box__item__title">
                            <button class="freq01-page__faq__content__box__item__title__button accordion-button collapsed d-flex align-items-center justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseTwo">
                                Pergunta
                                <svg class="freq01-page__faq__content__box__item__title__arrow" width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="19" cy="19" r="19" transform="matrix(1.19249e-08 -1 -1 -1.19249e-08 38 38)" fill="#404040"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.8076 22.2759L9.17262 20.6409L19.0001 10.8134L28.8276 20.6409L27.1926 22.2759L19.0001 14.0834L10.8076 22.2759Z" fill="#F6F3F0"/>
                                </svg>
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse freq01-page__faq__content__box__item__text" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                               <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero.
                                    Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus.
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero.
                                    Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere.
                                    Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                    Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, v
                                    el tempus mi pretium sed. In et arcu eget
                                    purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consect
                               </p>
                            </div>
                        </div>
                    </div>
                    {{-- END .freq01-page__box --}}
                    <div class="accordion-item freq01-page__faq__content__box__item">
                        <h2 class="accordion-header freq01-page__faq__content__box__item__title">
                            <button class="freq01-page__faq__content__box__item__title__button accordion-button collapsed d-flex align-items-center justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Pergunta
                                <svg class="freq01-page__faq__content__box__item__title__arrow" width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="19" cy="19" r="19" transform="matrix(1.19249e-08 -1 -1 -1.19249e-08 38 38)" fill="#404040"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.8076 22.2759L9.17262 20.6409L19.0001 10.8134L28.8276 20.6409L27.1926 22.2759L19.0001 14.0834L10.8076 22.2759Z" fill="#F6F3F0"/>
                                </svg>
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse freq01-page__faq__content__box__item__text" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                               <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero.
                                    Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus.
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero.
                                    Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere.
                                    Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                    Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, v
                                    el tempus mi pretium sed. In et arcu eget
                                    purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consect
                               </p>
                            </div>
                        </div>
                    </div>
                    {{-- END .freq01-page__box --}}
                </div>
                {{-- END .freq01-page__faq__content__box --}}
            </div>
            {{-- END .container --}}
        </div>
        {{-- END .freq01-page__faq__content --}}
    </section>
    <section class="freq01-page__form">
        <header class="freq01-page__form__header">
            <h3 class="freq01-page__form__header__title">Título</h3>
            <h4 class="freq01-page__form__header__subtitle">Subtítulo</h4>
            <hr class="freq01-page__form__header__line">
        </header>
        <div class="container">
            <div class="freq01-page__form__item">
                {!! Form::open(['route' => 'lead.store', 'class' => 'parsley-validate send_form_ajax']) !!}
                    {!! Form::hidden('target_lead', 'Perguntas Frequentes') !!}
                    @include('Client.Components.inputs', [
                        'type' => 'text',
                        'name' => 'column_nome_text',
                        'required'=> true,
                        'placeholder' => 'Nome'
                    ])
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            @include('Client.Components.inputs', [
                                'name' => 'column_e-mail_email',
                                'placeholder' => 'E-mail',
                                'type' => 'email',
                                'required'=> true,
                            ])
                        </div>
                        <div class="col-12 col-sm-6">
                            @include('Client.Components.inputs', [
                                'type' => 'phone',
                                'name' => 'column_telefone_phone',
                                'required'=> true,
                                'placeholder' => 'Telefone'
                            ])
                        </div>
                    </div>
                    @include('Client.Components.inputs', [
                        'type' => 'text',
                        'name' => 'column_empresa_text',
                        'required'=> false,
                        'placeholder' => 'Empresas'
                    ])
                    @include('Client.Components.inputs', [
                        'type' => 'textarea',
                        'name' => 'column_mensagem_textarea',
                        'required'=> true,
                        'placeholder' => 'Mensagem'
                    ])
                    <div class="cota01-show__form__compliance form-check d-flex align-items-center">
                        {!! Form::checkbox('term_accept', 1, null, [
                            'class' => 'form-check-input me-1',
                            'id' => 'term_accept',
                            'required' => true,
                        ]) !!}
                        {!! Form::label('term_accept', 'Aceito os termos descritos na ', ['class' => 'form-check-label']) !!}
                        <a href="{ { $compliance->link ?? '#' } }" target="_blank"
                            class="cota01-show__form__compliance__link ms-1">Política de Privacidade</a>
                    </div>
                    <button type="submit" class="freq01-page__form__submit ms-auto ms-auto mt-2 d-flex align-items-center">
                        <img class="freq01-page__form__submit__icon" src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="">
                        Enviar
                    </button>
                {!! Form::close() !!}
            </div>
        </div>
    </section>
</div>

{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
