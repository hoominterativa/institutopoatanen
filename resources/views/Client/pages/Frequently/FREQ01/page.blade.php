@extends('Client.Core.client')
@section('content')
    <main id="root" class="freq01-page">
        @if ($frequentlys->count())
            @if ($section->active === 1)
                @if ($section->title || $section->subtitle)
                    <section class="freq01-page__header"
                        style="background-image: url({{ asset('storage/' . $section->path_image_desktop) }}); /*background-color: {{ $section->background_color }};*/">

                        @if ($section->title)
                            <h1 class="freq01-page__header__title ">{{ $section->title }}</h1>
                        @endif

                        @if ($section->subtitle)
                            <h2 class="freq01-page__header__subtitle ">{{ $section->subtitle }}</h2>
                        @endif

                    </section>
                @endif
            @endif


            <section class="freq01-page__faq">
                @foreach ($frequentlys as $frequently)
                    <details class="freq01-page__faq__item">
                        @if ($frequently->question)
                            <summary class="freq01-page__faq__item__title" aria-level="3" role="heading">
                                {{ $frequently->question }}
                            </summary>
                        @endif

                        @if ($frequently->answer)
                            <div class="freq01-page__faq__item__paragraph details-content">
                                <p>
                                    {!! $frequently->answer !!}
                                </p>
                            </div>
                        @endif
                    </details>
                @endforeach
            </section>

            {!! Form::open(['route' => 'lead.store', 'class' => 'parsley-validate send_form_ajax freq01-page__form']) !!}
            {!! Form::hidden('target_lead', 'Perguntas Frequentes') !!}

            @if ($section->active_form === 1)
                @if ($section->title_form || $section->subtitle_form)
                    <header class="freq01-page__form__header">
                        @if ($section->title_form)
                            <h3 class="freq01-page__form__header__title">{{ $section->title_form }}</h3>
                        @endif
                        @if ($section->subtitle_form)
                            <h4 class="freq01-page__form__header__subtitle">{{ $section->subtitle_form }}</h4>
                        @endif
                    </header>
                @endif
            @endif

            @include('Client.Components.inputs', [
                'type' => 'text',
                'name' => 'column_nome_text',
                'required' => true,
                'placeholder' => 'Nome',
            ])

            @include('Client.Components.inputs', [
                'name' => 'column_e-mail_email',
                'placeholder' => 'E-mail',
                'type' => 'email',
                'required' => true,
            ])

            @include('Client.Components.inputs', [
                'type' => 'phone',
                'name' => 'column_telefone_phone',
                'required' => true,
                'placeholder' => 'Telefone',
            ])

            @include('Client.Components.inputs', [
                'type' => 'text',
                'name' => 'column_empresa_text',
                'required' => false,
                'placeholder' => 'Empresas',
            ])

            @include('Client.Components.inputs', [
                'type' => 'textarea',
                'name' => 'column_mensagem_textarea',
                'required' => true,
                'placeholder' => 'Mensagem',
            ])

            <div class="freq01-page__form__compliance">
                {!! Form::checkbox('term_accept', 1, null, [
                    'class' => 'form-check-input',
                    'id' => 'term_accept',
                    'required' => true,
                ]) !!}
                {!! Form::label('term_accept', 'Aceito os termos descritos na ', ['class' => 'form-check-label']) !!}
                <a href="{{ $compliances->link ?? '#' }}" target="_blank"
                    class="freq01-page__form__compliance__link">Política de Privacidade</a>
            </div>
            <button type="submit" class="freq01-page__form__submit">
                Enviar
            </button>
            {!! Form::close() !!}

            @foreach ($sections as $section)
                {!! $section !!}
            @endforeach
        @endif
    </main>
@endsection
