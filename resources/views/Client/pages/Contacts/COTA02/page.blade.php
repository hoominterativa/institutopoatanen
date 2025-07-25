@extends('Client.Core.client')
@section('content')
    @if ($contact)
        <main id="root" class="cota02">
            <section class="cota02__banner"
                style="background-image: url({{ asset('storage/' . $contact->path_image_banner_desktop) }})">
                @if ($contact->title_banner)
                    <h1 class="cota02__banner__title animation fadeInLeft">{{ $contact->title_banner }}</h1>
                @endif
                @if ($contact->subtitle_banner)
                    <h2 class="cota02__banner__subtitle">{{ $contact->subtitle_banner }}
                    </h2>
                @endif
            </section>

            <section class="cota02__topics">
                @foreach ($topics as $topic)
                    <div class="cota02__topics__item animation fadeInLeft">
                        @if ($topic->path_image_icon)
                            <img src="{{ asset('storage/' . $topic->path_image_icon) }}" class="cota02__topics__item__icon"
                                alt="Ícone do tópico  {{ $topic->title }}">
                        @endif

                        @if ($topic->title)
                            <h2 class="cota02__topics__item__title">
                                {{ $topic->title }}</h2>
                        @endif

                        @if ($topic->description)
                            <div class="cota02__topics__item__paragraph">
                                <p>
                                    {!! $topic->description !!}
                                </p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </section>

            {!! Form::open([
                'route' => 'lead.store',
                'method' => 'post',
                'files' => true,
                'class' => 'send_form_ajax parsley-validate cota02__form animation fadeInLeft',
            ]) !!}

            <header class="cota02__form__header">
                @if ($contact->title_form)
                    <h2 class="cota02__form__header__title animation fadeInLeft">{{ $contact->title_form }}</h2>
                @endif

                {{-- @if ($contact->description_form)
                    <div class="cota02__form__header__paragraph">
                        <p>
                            {!! $contact->description_form !!}
                        </p>
                    </div>
                @endif --}}
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

            <div class="cota02__form__footer">
                <div class="cota02__form__footer__compliance">
                    {!! Form::checkbox('term_accept', 1, null, [
                        'class' => 'cota02__form__footer__compliance__checkbox',
                        'id' => 'term_accept',
                        'required' => true,
                    ]) !!}
                    {!! Form::label('term_accept', 'Aceito os termos descritos na ', ['class' => 'cota02__form__footer__compliance']) !!}
                    <a href="{{ $compliance->link ?? '#' }}" target="_blank"
                        class="cota02__form__footer__compliance__link">Política de Privacidade</a>
                </div>

                <button type="submit" class="cota02__form__footer__cta">
                    <span>
                        {{ $contact->title_button_form }}
                    </span>
                </button>
            </div>
            {!! Form::close() !!}
            @foreach ($sections as $section)
                {!! $section !!}
            @endforeach
        </main>
    @endif
@endsection
