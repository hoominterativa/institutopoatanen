@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}

        <section id="cota03" class="cota03">
            <div class="container-fluid px-0">
                <header class="cota03__header d-flex flex-column align-items-center justify-content-center"
                    style="background-image: url({{ asset('storage/uploads/tmp/boxdestaque1.png')}}); background-color: ;">
                    <div class="cota03__header__mask"></div>
                    <div class="container container--cota03-page-header">
                            <h2 class="cota03__header__title d-block">Título</h2>
                            <h3 class="cota03__header__subtitle d-block">Subtitulo</h3>
                        <hr class="cota03__header__line mb-0">
                    </div>
                </header>
                <div class="cota03__boxForm"
                    style="background-image: url({{ asset('storage/uploads/tmp/bg-slide.png') }}); background-color: ;">
                    <div class="container container--boxForm">
                        <div class="row justify-content-center">
                                <div class="cota03__boxForm__item">
                                    <div class="cota03__boxForm__item__content">
                                        <div class="cota03__boxForm__item__content__image mx-auto">
                                            <img src="{{ asset('storage/uploads/tmp/image-pmg.png') }}" class="w-100 h-100"
                                                alt="Imagem Perfil">
                                        </div>
                                        <div class="cota03__boxForm__item__content__description">
                                            <h2 class="cota03__boxForm__item__content__description__title">Título</h2>
                                            <h3 class="cota03__boxForm__item__content__description__subtitle">Subtítulo</h3>
                                            <hr class="cota03__boxForm__item__content__description__line">
                                            <div class="cota03__boxForm__item__content__description__paragraph">
                                                <p>
                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                                                    Cras vel tortor eu purus gravida sollicitudin vel non libero. 
                                                    Vivamus commodo porta velit, vel tempus mi pretium sed. In et
                                                     arcu eget purus mattis posuere. Donec tincidunt dignissim 
                                                     faucibus. 
                                                </p>
                                            </div>
                                           
                                            <a rel="next" href="#"   class="cota03__boxForm__item__content__description__cta">
                                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="cota03__boxForm__item__content__description__cta__icon me-3 transition">
                                                CTA
                                            </a>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="cota03__form"
                    style="background-image: url({{ asset('storage/uploads/tmp/') }}); background-color: ;">
                    <div class="container">
                        <div class="cota03__form__header">
                            <h2 class="cota03__form__header__title">Título</h2>
                            <hr class="cota03__form__header__line"> 
                            <div class="cota03__form__header__paragraph">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu 
                                    purus gravida sollicitudin vel 
                                    non liberolor sit amet, consectetur adipiscing elit. Cras vel tortor
                                </p>
                            </div>
                            
                        </div>
                        <div class="cota03__form__inputs">
                            {!! Form::open(['route' => 'lead.store', 'method' => 'post', 'files' => true, 'class'=>'send_form_ajax cota01-show__form__item parsley-validate d-table w-100']) !!}
                                <input type="hidden" name="target_lead" value="{#">
                                <input type="hidden" name="target_send" value="#">
                                <div class="row">
                                        <div class="cota03__form__inputs__input">
                                            @include('Client.Components.inputs', [
                                                'name' => 'email',
                                                'options' => '',
                                                'placeholder' => 'E-mail',
                                                'type' => 'text',
                                                'required' => 'false',
                                            ])
                                             @include('Client.Components.inputs', [
                                                'name' => 'email',
                                                'options' => '',
                                                'placeholder' => 'E-mail',
                                                'type' => 'text',
                                                'required' => 'false',
                                            ])
                                             @include('Client.Components.inputs', [
                                                'name' => 'email',
                                                'options' => '',
                                                'placeholder' => 'E-mail',
                                                'type' => 'text',
                                                'required' => 'false',
                                            ])
                                             @include('Client.Components.inputs', [
                                                'name' => 'email',
                                                'options' => '',
                                                'placeholder' => 'E-mail',
                                                'type' => 'text',
                                                'required' => 'false',
                                            ])
                                        </div>
                                </div>
                                <div class="cota03__form__footer d-flex align-items-center">
                                    <div class="cota03__form__compliance form-check d-flex align-items-center">
                                        {!! Form::checkbox('term_accept', 1, null, ['class' => 'form-check-input me-1', 'id' => 'term_accept', 'required' => true]) !!}
                                        {!! Form::label('term_accept', 'Aceito os termos descritos na ', ['class' => 'form-check-label']) !!}
                                        <a href="#" target="_blank"
                                            class="cota03__form__compliance__link ms-1">Política de Privacidade</a>
                                    </div>
                                    <button type="submit" class="cota03__form__inputs__formIput__input-submit ms-auto">
                                        <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="transition">
                                        CTA
                                    </button>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- Finish Content page Here --}}
        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
@endsection