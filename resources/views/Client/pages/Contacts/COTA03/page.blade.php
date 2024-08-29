@extends('Client.Core.client')
@section('content')

    <main id="root" class="cota03">

        <section class="cota03__banner"
            style="background-image: url({{ asset('storage/' . $contact->path_image_banner_desktop) }}); background-color: {{ $contact->background_color_banner }};">

            @if ($contact->title_banner || $contact->subtitle_banner)
                <h1 class="cota03__banner__title ">{{ $contact->title_banner }}</h1>
                <h2 class="cota03__banner__subtitle ">{{ $contact->subtitle_banner }}</h2>
            @endif

        </section>

        <div class="cota03__content">
            <div class="cota03__content__image">
                @if ($contact->path_image_content)
                    <img src="{{ asset('storage/' . $contact->path_image_content) }}" class="cota03__content__image__img"
                        alt="Imagem da seção {{ $contact->title_content }}">
                @endif
            </div>

            <header class="cota03__content__header">
                @if ($contact->title_content)
                    <h2 class="cota03__content__header__title">
                        {{ $contact->title_content }}</h2>
                @endif
                @if ($contact->subtitle_content)
                    <h3 class="cota03__content__header__subtitle">
                        {{ $contact->subtitle_content }}</h3>
                @endif

                @if ($contact->description_content)
                    <div class="cota03__content__header__paragraph">
                        {!! $contact->description_content !!}
                    </div>
                @endif

                @if ($contact->link_button_content)
                    <a rel="next" href="{{ getUri($contact->link_button_content) }}"
                        target="{{ $contact->target_link_button_content }}" class="cota03__content__header__cta">
                        @if ($contact->title_button_content)
                            {{ $contact->title_button_content }}
                        @endif
                    </a>
                @endif
            </header>

        </div>

        {!! Form::open([
            'route' => 'lead.store',
            'method' => 'post',
            'files' => true,
            'class' => 'send_form_ajax parsley-validate cota03__form',
        ]) !!}

        <header class="cota03__form__header">
            @if ($contact->title_form)
                <h2 class="cota03__form__header__title">{{ $contact->title_form }}</h2>
            @endif
            <div class="cota03__form__header__paragraph">
                @if ($contact->description_form)
                    <p>
                        {!! $contact->description_form !!}
                    </p>
                @endif
            </div>

        </header>

        <input type="hidden" name="target_lead" value="{{ $contact->title_page }}">
        <input type="hidden" name="target_send" value="{{ base64_encode($contact->email_form) }}">

        @foreach ($inputs as $name => $input)
            @include('Client.Components.inputs', [
                'name' => $name,
                'options' => $input->option,
                'placeholder' => $input->placeholder,
                'type' => $input->type,
                'required' => isset($input->required) ? $input->required : false,
            ])
        @endforeach

        <footer class="cota03__form__footer">
            <div class="cota03__form__footer__compliance">
                {!! Form::checkbox('term_accept', 1, null, [
                    'class' => 'cota03__form__footer__compliance__checkbox',
                    'id' => 'term_accept',
                    'required' => true,
                ]) !!}

                {!! Form::label('term_accept', 'Aceito os termos descritos na ', [
                    'class' => 'cota03__form__footer__compliance',
                ]) !!}
                <a href="{{ $compliance->link ?? '#' }}" target="_blank"
                    class="cota03__form__footer__compliance__link ms-1">Política de Privacidade</a>
            </div>

            <button type="submit" class="cota03__form__footer__cta">
                {{ $contact->title_button_form }}
            </button>
        </footer>

        {!! Form::close() !!}

        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
