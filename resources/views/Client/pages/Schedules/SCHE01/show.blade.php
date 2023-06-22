@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    <div class="sche01-show">
        @if ($bannerShow)
            <section class="sche01-show__banner w-100"
                style="background-image: url({{ asset('storage/' . $bannerShow->path_image_desktop) }}); background-color: {{ $bannerShow->background_color }};">
                <header
                    class="sche01-show__banner__content container d-flex flex-column align-items-center justify-content-center">
                    @if ($bannerShow->title || $bannerShow->subtitle)
                        <h1 class="sche01-show__banner__title text-center">{{ $bannerShow->title }}</h1>
                        <h2 class="sche01-show__banner__subtitle text-center">{{ $bannerShow->subtitle }}</h2>
                        <hr class="sche01-show__banner__line">
                    @endif
                </header>
            </section>
        @endif
        <section class="sche01-show__cont">
            <div class="sche01-show__cont__body container">
                <article class="sche01-show__content d-flex flex-column">
                    <header class="sche01-show__content__header w-100 d-flex flex-row">
                        <div
                            class="sche01-show__content__date d-flex flex-column align-items-center justify-content-center">
                            <span
                                class="sche01-show__content__day">{{ Carbon\Carbon::parse($schedule->event_date)->formatLocalized('%d') }}</span>
                            <span
                                class="sche01-show__content__month">{{ Carbon\Carbon::parse($schedule->event_date)->formatLocalized('%B') }}</span>
                            <span
                                class="sche01-show__content__year">{{ Carbon\Carbon::parse($schedule->event_date)->formatLocalized('%Y') }}</span>
                        </div>
                        <div class="sche01-show__content__right d-flex flex-column align-items-start justify-content-start">
                            @if ($schedule->title)
                                <h2 class="sche01-show__content__title">{{ $schedule->title }}</h2>
                            @endif
                            <hr class="sche01-show__content__line">
                            <ul class="sche01-show__content__header__topics">
                                <li class="sche01-show__content__header__topics__item">
                                    @if ($schedule->path_image_hours || $schedule->event_time)
                                        <img src="{{ asset('storage/' . $schedule->path_image_hours) }}" alt=""
                                            class="sche01-show__content__header__topics__item__icon">
                                        {{ date('H:i', strtotime($schedule->event_time)) }}
                                    @endif
                                </li>
                                <li class="sche01-show__content__header__topics__item">
                                    @if ($schedule->path_image_sub || $schedule->subtitle)
                                        <img src="{{ asset('storage/' . $schedule->path_image_sub) }}" alt=""
                                            class="sche01-show__content__header__topics__item__icon">
                                        {{ $schedule->subtitle }}
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </header>
                    <main class="sche01-show__content__main d-flex flex-column">
                        @if ($schedule->path_image)
                            <img src="{{ asset('storage/' . $schedule->path_image) }}" alt=""
                                class="sche01-show__content__img">
                        @endif
                        <h3 class="sche01-show__content__subtitle">Descrição</h3>
                        <div class="sche01-show__content__desc">
                            @if ($schedule->description)
                                <p>
                                    {!! $schedule->text !!}
                                </p>
                            @endif
                        </div>
                        <h3 class="sche01-show__content__subtitle">Local</h3>
                        <div class="sche01-show__content__desc">
                            @if ($schedule->information)
                                <p>
                                    {!! $schedule->information !!}
                                </p>
                            @endif
                        </div>
                        @if ($schedule->link_button)
                            <a href="{{ getUri($schedule->link_button) }}" target="{{ $schedule->target_link_button }}"
                                class="sche01-show__content__cta">
                                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                    class="sche01-show__content__cta__icon">
                                @if ($schedule->title_button)
                                    {{ $schedule->title_button }}
                                @endif
                            </a>
                        @endif
                    </main>
                </article>
                <aside class="sche01-show__cont__aside d-flex flex-column align-items-stretch justify-content-start">
                    @if ($contact)
                        <div class="sche01-form d-flex flex-column align-items-start justify-content-start">
                            @if ($contact->title || $contact->subtitle)
                                <h4 class="sche01-form__subtitle">{{ $contact->subtitle }}</h4>
                                <h3 class="sche01-form__title">{{ $contact->title }}</h3>
                            @endif
                            <div class="sche01-form__desc">
                                @if ($contact->description)
                                    <p>
                                        {!! $contact->description !!}
                                    </p>
                                @endif
                            </div>
                            {!! Form::open([
                                'route' => 'lead.store',
                                'method' => 'post',
                                'files' => true,
                                'class' =>
                                    'send_form_ajax sche01-form__form d-flex w-100 flex-column align-items-stretch form-contact parsley-validate align-items-center',
                            ]) !!}
                            <div class="sche01-form__form__inputs d-flex flex-column w-100 align-items-stretch">
                                <input type="hidden" name="target_lead" value="{{ $contact->title }}">
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
                                    {{-- <input type="checkbox" name='checkbox' id=""> Lorem ipsum dolor sit amet,
                                    consectetur a --}}
                                    {!! Form::checkbox('term_accept', 1, null, [
                                        'class' => 'form-check-input me-1',
                                        'id' => 'term_accept',
                                        'required' => true,
                                    ]) !!}
                                    {!! Form::label('term_accept', 'Aceito os termos descritos na ', ['class' => 'form-check-label']) !!}
                                    <a href="{{ getUri($compliance->link ?? '#') }}" target="_blank"
                                        class="">Política de Privacidade</a>
                                </label>
                            </div>
                            <button type="submit" class="sche01-form__cta">
                                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}"
                                    class="sche01-form__cta__icon" alt="Ícone">
                                @if ($contact->title_button)
                                    {{ $contact->title_button }}
                                @endif
                            </button>
                            {!! Form::close() !!}
                        </div>
                    @endif
                    <ul class="sche01-month-categories w-100 d-flex flex-column align-items-stretch">
                        @foreach ($monthlyEventCounts as $month => $count)
                            <li
                                class="sche01-month-categories__item w-100 position-relative d-flex align-items-center justify-content-between">
                                <a href="#" class="link-full"></a>
                                <h3 class="sche01-month-categories__item__title">
                                    {{ ucfirst(\Carbon\Carbon::createFromFormat('m', $month)->formatLocalized('%B')) }}
                                </h3>
                                <h4 class="sche01-month-categories__item__subtitle">
                                    Eventos
                                    <span class="sche01-month-categories__item__counter">{{ $count }}</span>
                                </h4>
                            </li>
                        @endforeach
                    </ul>
                </aside>
            </div>
        </section>
    </div>
    {{-- Finish Content page Here --}}
    @foreach ($sections as $section)
        {!! $section !!}
    @endforeach
@endsection
