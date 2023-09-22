@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}

        <section id="cota03" class="cota03">
            <div class="container-fluid px-0">
                <header class="cota03__header d-flex flex-column align-items-center justify-content-center"
                    style="background-image: url({{ asset('storage/' . $contact->path_image_banner_desktop) }}); background-color: {{ $contact->background_color_banner }};">
                    @if ($contact->path_image_banner_desktop)
                    <div class="cota03__header__mask"></div>
                    @endif
                    <div class="container container--cota03-page-header">
                        @if ($contact->title_banner || $contact->subtitle_banner)
                            <h2 class="cota03__header__title d-block">{{$contact->title_banner}}</h2>
                            <h3 class="cota03__header__subtitle d-block">{{$contact->subtitle_banner}}</h3>
                        @endif
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
                                            @if ($contact->path_image_content)
                                                <img src="{{ asset('storage/' . $contact->path_image_content) }}" class="w-100 h-100" alt="Imagem Perfil">
                                            @endif
                                        </div>
                                        <div class="cota03__boxForm__item__content__description">
                                            @if ($contact->title_content || $contact->subtitle_content)
                                                <h2 class="cota03__boxForm__item__content__description__title">{{$contact->title_content}}</h2>
                                                <h3 class="cota03__boxForm__item__content__description__subtitle">{{$contact->subtitle_content}}</h3>
                                                <hr class="cota03__boxForm__item__content__description__line">
                                            @endif
                                            <div class="cota03__boxForm__item__content__description__paragraph">
                                                @if ($contact->description_content)
                                                    <p>
                                                        {!! $contact->description_content !!}
                                                    </p>
                                                @endif
                                            </div>
                                            @if ($contact->link_button_content)
                                                <a rel="next" href="{{getUri($contact->link_button_content)}}"  target="{{ $contact->target_link_button_content }}" class="cota03__boxForm__item__content__description__cta">
                                                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="cota03__boxForm__item__content__description__cta__icon me-3 transition">
                                                    @if ($contact->title_button_content)
                                                        {{$contact->title_button_content}}
                                                    @endif
                                                </a>
                                            @endif
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
                            @if ($contact->title_form)
                                <h2 class="cota03__form__header__title">{{$contact->title_form}}</h2>
                                <hr class="cota03__form__header__line">
                            @endif
                            <div class="cota03__form__header__paragraph">
                                @if ($contact->description_form)
                                    <p>
                                        {!! $contact->description_form !!}
                                    </p>
                                @endif
                            </div>

                        </div>
                        <div class="cota03__form__inputs">
                            {!! Form::open(['route' => 'lead.store', 'method' => 'post', 'files' => true, 'class'=>'send_form_ajax cota01-show__form__item parsley-validate d-table w-100']) !!}
                            <input type="hidden" name="target_lead" value="{{ $contact->title_page }}">
                            <input type="hidden" name="target_send" value="{{ base64_encode($contact->email_form) }}">
                                <div class="row">
                                    @foreach ($inputs as $name => $input)
                                        <div class="cota03__form__inputs__input col-12 {{ $input->type != 'textarea' ? 'col-sm-6' : '' }}">
                                            @include('Client.Components.inputs', [
                                                'name' => $name,
                                                'options' => $input->option,
                                                'placeholder' => $input->placeholder,
                                                'type' => $input->type,
                                                'required' => isset($input->required) ? $input->required : false,
                                            ])
                                        </div>
                                    @endforeach
                                </div>
                                <div class="cota03__form__footer d-flex align-items-center">
                                    <div class="cota03__form__compliance form-check d-flex align-items-center">
                                        {!! Form::checkbox('term_accept', 1, null, ['class' => 'form-check-input me-1', 'id' => 'term_accept', 'required' => true]) !!}
                                        {!! Form::label('term_accept', 'Aceito os termos descritos na ', ['class' => 'form-check-label']) !!}
                                        <a href="{{ getUri($compliance->link ?? '#') }}" target="_blank" class="cota03__form__compliance__link ms-1">Política de Privacidade</a>
                                    </div>
                                    <button type="submit" class="cota03__form__inputs__formIput__input-submit ms-auto">
                                        <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="transition">
                                        {{ $contact->title_button_form }}
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
