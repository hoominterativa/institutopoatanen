@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    @if ($contact)
        <section id="CONT02" class="cont02-page">
            <div class="container-fluid px-0">
                <header class="cont02-page__header"
                    style="background-image: url({{ asset('storage/' . $contact->path_image_banner_desktop) }}); background-color: {{
                    $contact->background_color_banner }};">
                    <div class="container container-cont02-page__header">
                        @if ($contact->title_banner || $contact->subtitle_banner)
                            <h2 class="cont02-page__header__title d-block">{{ $contact->title_banner }}</h2>
                            {{-- <h3 class="cont02-page__header__subtitle d-block text-uppercase">{{ $contact->subtitle_banner }}</h3> --}}

                        @endif
                    </div>
                    <hr class="cont02-page__header__line mb-0">
                </header>
                <div class="cont02-page__boxForm"
                    style="background-image: url({{ asset('storage/' . $contact->path_image_topic_desktop) }}); background-color: {{ $contact->background_color_topic }};">
                    <div class="container container--boxForm">
                        <div class="row justify-content-center">
                            @foreach ($topics as $topic)
                                <div class="cont02-page__boxForm__item col-sm-4">
                                    <div class="cont02-page__boxForm__item__content">
                                        <div class="cont02-page__boxForm__item__content__image mx-auto">
                                            <img src="{{ asset('storage/' . $topic->path_image_icon) }}" class="w-100 h-100"
                                                alt="Imagem Perfil">
                                        </div>
                                        <div class="cont02-page__boxForm__item__content__description text-center">
                                            @if ($topic->title)
                                                <h2 class="cont02-page__boxForm__item__content__description__title">
                                                    {{ $topic->title }}</h2>
                                            @endif
                                            @if ($topic->description)
                                                <div class="cont02-page__boxForm__item__content__description__paragraph">
                                                    <p>
                                                        {!! $topic->description !!}
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="cont02-page__form"
                    style="background-image: url({{ asset('storage/' . $contact->path_image_form_desktop) }}); background-color: {{ $contact->background_color_form }};">
                    <div class="container">
                        <div class="cont02-page__form__header">
                            @if ($contact->title_form)
                                <h2 class="cont02-page__form__header__title">{{$contact->title_form}}</h2>
                            @endif
                            {{-- <h4 class="cont02-page__form__header__line"></h4> --}}
                            @if ($contact->description_form)
                                <div class="cont02-page__form__header__paragraph">
                                    <p>
                                        {!! $contact->description_form !!}
                                    </p>
                                </div>
                            @endif
                        </div>
                        <div class="cont02-page__form__inputs">
                            <form action=""
                                class="cont02-page__form__inputs__formIput parsley-validate flex-column mx-auto">
                                <input type="hidden" name="target_lead" value="{{ $contact->title_page }}">
                                <input type="hidden" name="target_send" value="{{ base64_encode($contact->email_form) }}">
                                <div class="row">
                                    @foreach ($inputs as $name => $input)
                                        <div
                                            class="cota01-show__form__item__input col-12 {{ $input->type != 'textarea' ? 'col-sm-6' : '' }}">
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
                                <div class="cota01-show__form__footer d-flex align-items-center">
                                    <div class="cota01-show__form__compliance form-check d-flex align-items-center">
                                        {!! Form::checkbox('term_accept', 1, null, [
                                            'class' => 'form-check-input me-1',
                                            'id' => 'term_accept',
                                            'required' => true,
                                        ]) !!}
                                        {!! Form::label('term_accept', 'Aceito os termos descritos na ', ['class' => 'form-check-label']) !!}
                                        <a href="{{ $compliance->link ?? '#' }}" target="_blank"
                                            class="cota01-show__form__compliance__link ms-1">Política de Privacidade</a>
                                    </div>
                                    <button type="submit" class="cota01-show__form__inputs__formIput__input-submit ms-auto">
                                        {{ $contact->title_button_form }}
                                    </button>
                                </div>
                                {!! Form::close() !!}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- Finish Content page Here --}}
        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    @endif
@endsection
