@extends('Client.Core.client')
@section('content')
    @if ($contact)
        <main id="root">
            @if ($contact->active_banner === 1)
                <section class="cota05-page__banner"
                    style="background-image: url({{ asset('storage/' . $contact->path_image_desktop_banner) }}); background-color: {{ $contact->background_color_banner }};">
                    @if ($contact->title_banner)
                        <h1 class="cota05-page__banner__title">{{ $contact->title_banner }}</h1>
                    @endif
                    @if ($contact->subtitle_banner)
                        <h2 class="cota05-page__banner__subtitle">{{ $contact->subtitle_banner }}</h2>
                    @endif
                </section>
            @endif
            {!! Form::open([
                'method' => 'post',
                'route' => 'cota05.lead.store',
                'files' => true,
                'class' => 'cota05-page__form send_form_ajax parsley-validate',
            ]) !!}

            <header class="cota05-page__form__header">
                @if ($contact->active_form)
                    <div class="cota05-page__form__header__information">
                        <h2 class="cota05-page__form__header__information__title">
                            @if ($contact->path_image_icon_form)
                                <img src="{{ asset('storage/' . $contact->path_image_icon_form) }}"
                                    class="cota05-page__form__header__information__title__icon"
                                    alt="Ícone de {{ $contact->title_form }}" loading="lazy">
                            @endif
                            @if ($contact->title_form)
                                {{ $contact->title_form }}
                            @endif
                        </h2>
                        @if ($contact->description_form)
                            <div class="cota05-page__form__header__information__paragraph">
                                <p>{!! $contact->description_form !!}</p>
                            </div>
                        @endif
                    </div>
                @endif

                <ul class="cota05-page__form__header__icons">
                    <li class="cota05-page__form__header__icons__item">
                        <img loading="lazy" src="{{ asset('images/cota05-icon03.png') }}" alt="icone de ruim"
                            class="cota05-page__form__header__icons__item__icon">
                    </li>
                    <li class="cota05-page__form__header__icons__item">
                        <img loading="lazy" src="{{ asset('images/cota05-icon02.png') }}" alt="ícone de mais ou menos"
                            class="cota05-page__form__header__icons__item__icon">
                    </li>
                    <li class="cota05-page__form__header__icons__item">
                        <img loading="lazy" src="{{ asset('images/cota05-icon01.png') }}" alt="ícone de bom"
                            class="cota05-page__form__header__icons__item__icon">
                    </li>
                </ul>
            </header>

            <input type="hidden" name="target_lead" value="{{ $contact->title_page }}">
            <input type="hidden" name="target_send" value="{{ base64_encode($contact->email_form) }}">
            <input type="hidden" name="contact_id" value="{{ $contact->id }}">

            @foreach ($assessments as $name => $input)
                @include('Client.Components.inputs', [
                    'name' => $name,
                    'options' => $input->option,
                    'placeholder' => $input->placeholder,
                    'type' => $input->type,
                    'required' => isset($input->required) ? $input->required : false,
                ])
            @endforeach

            <div class="cota05-page__form__inputs-group">
                @foreach ($inputs as $name => $input)
                    @include('Client.Components.inputs', [
                        'name' => $name,
                        'options' => $input->option,
                        'placeholder' => $input->placeholder,
                        'type' => $input->type,
                        'required' => isset($input->required) ? $input->required : false,
                    ])
                @endforeach
            </div>

            <footer class="cota05-page__form__footer">
                <div class="cota05-page__form__footer__compliance">
                    {!! Form::checkbox('term_accept', 1, null, [
                        'class' => 'form-check-input me-1',
                        'id' => 'term_accept',
                        'required' => true,
                    ]) !!}
                    {!! Form::label('term_accept', 'Aceito os termos descritos na ', ['class' => 'form-check-label']) !!}
                    <a href="{{ $compliance->link ?? '#' }}" target="_blank"
                        class="cota03__form__compliance__link ms-1">Política de Privacidade</a>
                </div>

                <button type="submit" class="cota05-page__form__footer__cta">
                    {{ $contact->title_button_form }}
                </button>
            </footer>

            {!! Form::close() !!}
            @foreach ($sections as $section)
                {!! $section !!}
            @endforeach
        </main>
    @endif
@endsection
