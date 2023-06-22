@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    <div class="sche01-page">
        @if ($banner)
            <section class="sche01-page__banner w-100"
                style="background-image: url({{ asset('storage/' . $banner->path_image_desktop) }}); background-color: {{ $banner->background_color }};">
                <header
                    class="sche01-page__banner__content container d-flex flex-column align-items-center justify-content-center">
                    @if ($banner->title || $banner->subtitle)
                        <h1 class="sche01-page__banner__title text-center">{{ $banner->title }}</h1>
                        <h2 class="sche01-page__banner__subtitle text-center">{{ $banner->subtitle }}</h2>
                        <hr class="sche01-page__banner__line">
                    @endif
                </header>
            </section>
        @endif
        <section class="sche01-page__cont">
            <div class="sche01-page__cont__body container">
                <main class="sche01-page__cont__main d-flex flex-column align-items-stretch">
                    @if ($sectionSchedule)
                        <div class="sche01-page__cont__top d-flex flex-column align-items-start">
                            @if ($sectionSchedule->title || $sectionSchedule->subtitle)
                                <h2 class="sche01-page__cont__title">{{ $sectionSchedule->title }}</h2>
                                <h3 class="sche01-page__cont__subtitle">{{ $sectionSchedule->subtitle }}</h3>
                                <hr class="sche01-page__cont__line">
                            @endif
                        </div>
                    @endif
                    @if ($schedules->count())
                        <div class="sche01-page__cont__list w-100 d-flex flex-column">
                            @foreach ($schedules as $schedule)
                                <article class="sche01-page__cont__item d-flex flex-column">
                                    <header class="sche01-page__cont__item__header w-100 d-flex flex-row">
                                        <div
                                            class="sche01-page__cont__item__date d-flex flex-column align-items-center justify-content-center">
                                            <span
                                                class="sche01-page__cont__item__day">{{ Carbon\Carbon::parse($schedule->event_date)->formatLocalized('%d') }}</span>
                                            <span
                                                class="sche01-page__cont__item__month">{{ Carbon\Carbon::parse($schedule->event_date)->formatLocalized('%B') }}</span>
                                            <span
                                                class="sche01-page__cont__item__year">{{ Carbon\Carbon::parse($schedule->event_date)->formatLocalized('%Y') }}</span>
                                        </div>
                                        <div
                                            class="sche01-page__cont__item__right d-flex flex-column align-items-start justify-content-start">
                                            @if ($schedule->title)
                                                <h3 class="sche01-page__cont__item__title">{{ $schedule->title }}</h3>
                                                <hr class="sche01-page__cont__item__line">
                                            @endif
                                            <ul class="sche01-page__cont__item__header__topics">
                                                <li class="sche01-page__cont__item__header__topics__item">
                                                    @if ($schedule->path_image_hours || $schedule->event_time)
                                                        <img src="{{ asset('storage/' . $schedule->path_image_hours) }}"
                                                            alt=""
                                                            class="sche01-page__cont__item__header__topics__item__icon">
                                                        {{ date('H:i', strtotime($schedule->event_time)) }}
                                                    @endif
                                                </li>
                                                <li class="sche01-page__cont__item__header__topics__item">
                                                    @if ($schedule->path_image_sub || $schedule->subtitle)
                                                        <img src="{{ asset('storage/' . $schedule->path_image_sub) }}"
                                                            alt=""
                                                            class="sche01-page__cont__item__header__topics__item__icon">
                                                        {{ $schedule->subtitle }}
                                                    @endif
                                                </li>
                                            </ul>
                                        </div>
                                    </header>
                                    <main class="sche01-page__cont__item__main d-flex flex-column">
                                        @if ($schedule->path_image)
                                            <img src="{{ asset('storage/' . $schedule->path_image) }}" alt=""
                                                class="sche01-page__cont__item__img">
                                        @endif
                                        <div class="sche01-page__cont__item__desc">
                                            @if ($schedule->description)
                                                <p>
                                                    {!! $schedule->description !!}
                                                </p>
                                            @endif
                                        </div>
                                        <a href="{{ route('sche01.show.content', ['SCHE01Schedules' => $schedule->slug]) }}"
                                            class="sche01-page__cont__item__cta">
                                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt=""
                                                class="sche01-page__cont__item__cta__icon">
                                            CTA
                                        </a>
                                    </main>
                                </article>
                            @endforeach
                        </div>

                        {{ $schedules->links() }}
                    @endif
                </main>


                <aside class="sche01-page__cont__aside d-flex flex-column align-items-stretch justify-content-start">
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
                                <a href="{{ route('sche01.monthlyEventCounts', ['SCHE01Schedules' => $schedule->slug]) }}"
                                    class="link-full"></a>
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
