@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    <main id="root" class="sche01-page">
        @if ($banner)
            <section class="sche01-page__banner"
                style="background-image: url({{ asset('storage/' . $banner->path_image_desktop) }}); background-color: {{ $banner->background_color }};">
                @if ($banner->title)
                    <h1 class="sche01-page__banner__title">{{ $banner->title }}</h1>
                @endif
                @if ($banner->subtitle)
                    <h2 class="sche01-page__banner__subtitle">{{ $banner->subtitle }}</h2>
                @endif
            </section>
        @endif

        <section class="sche01-page__content">

            <div class="sche01-page__content__main">
                @if ($sectionSchedule)
                    <div class="sche01-page__content__main__top">
                        @if ($sectionSchedule->title || $sectionSchedule->subtitle)
                            <h2 class="sche01-page__content__main__top__title">{{ $sectionSchedule->title }}</h2>
                        @endif
                        @if ($sectionSchedule->title || $sectionSchedule->subtitle)
                            <h3 class="sche01-page__content__main__top__subtitle">{{ $sectionSchedule->subtitle }}</h3>
                        @endif
                    </div>
                @endif

                @if ($schedules->count())
                    <div class="sche01-page__content__main__list">

                        @foreach ($schedules as $schedule)
                            <article class="sche01-page__content__main__list__item">
                                <header class="sche01-page__content__main__list__item__header">
                                    <div class="sche01-page__content__main__list__item__header__date">
                                        <span
                                            class="sche01-page__content__main__list__item__header__date__day">{{ Carbon\Carbon::parse($schedule->event_date)->formatLocalized('%d') }}</span>
                                        <span
                                            class="sche01-page__content__main__list__item__header__date__month">{{ Carbon\Carbon::parse($schedule->event_date)->formatLocalized('%B') }}</span>
                                        <span
                                            class="sche01-page__content__main__list__item__header__date__year">{{ Carbon\Carbon::parse($schedule->event_date)->formatLocalized('%Y') }}</span>
                                    </div>

                                    <div class="sche01-page__content__main__list__item__header__information">
                                        @if ($schedule->title)
                                            <h3 class="sche01-page__content__main__list__item__header__information__title">
                                                {{ $schedule->title }}
                                            </h3>
                                        @endif

                                        <ul class="sche01-page__content__main__list__item__header__information__topics">
                                            <li
                                                class="sche01-page__content__main__list__item__header__information__topics__item">
                                                @if ($schedule->path_image_hours || $schedule->event_time)
                                                    <img src="{{ asset('storage/' . $schedule->path_image_hours) }}"
                                                        alt="ícone de relógio"
                                                        class="sche01-page__content__main__list__item__header__information__topics__item__icon">
                                                    {{ date('H:i', strtotime($schedule->event_time)) }}
                                                @endif
                                            </li>
                                            <li
                                                class="sche01-page__content__main__list__item__header__information__topics__item">
                                                @if ($schedule->path_image_sub || $schedule->subtitle)
                                                    <img src="{{ asset('storage/' . $schedule->path_image_sub) }}"
                                                        alt="ícone do subtítulo"
                                                        class="sche01-page__content__main__list__item__header__information__topics__item__icon">
                                                    {{ $schedule->subtitle }}
                                                @endif
                                            </li>
                                        </ul>
                                    </div>
                                </header>

                                <div class="sche01-page__content__main__list__item__main">
                                    @if ($schedule->path_image)
                                        <img src="{{ asset('storage/' . $schedule->path_image) }}" alt=""
                                            class="sche01-page__content__main__list__item__img">
                                    @endif

                                    @if ($schedule->description)
                                        <div class="sche01-page__content__main__list__item__paragraph">
                                            {!! $schedule->description !!}

                                        </div>
                                    @endif

                                    <a href="{{ route('sche01.show.content', ['SCHE01Schedules' => $schedule->slug]) }}"
                                        class="sche01-page__content__main__list__item__cta">
                                        CTA
                                    </a>

                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="sche01-page__content__pagination">
                        {{ $schedules->links() }}
                    </div>
                @endif
            </div>

            <aside class="sche01-page__content__aside">
                @if ($contact)
                    {!! Form::open([
                        'route' => 'lead.store',
                        'method' => 'post',
                        'files' => true,
                        'class' => 'send_form_ajax form-contact parsley-validate sche01-page__content__aside__form',
                    ]) !!}

                    <header class="sche01-page__content__aside__form__header">
                        @if ($contact->subtitle)
                            <h4 class="sche01-page__content__aside__form__header__subtitle">{{ $contact->subtitle }}</h4>
                        @endif

                        @if ($contact->title)
                            <h3 class="sche01-page__content__aside__form__header__title">{{ $contact->title }}</h3>
                        @endif

                        @if ($contact->description)
                            <div class="sche01-page__content__aside__form__header__paragraph">
                                {!! $contact->description !!}
                            </div>
                        @endif
                    </header>


                    <div class="sche01-page__content__aside__form__inputs">
                        <input type="hidden" name="target_lead" value="{{ $contact->title }}">
                        <input type="hidden" name="target_send" value="{{ base64_encode($contact->email) }}">

                        @foreach ($inputs as $name => $input)
                            @include('Client.Components.inputs', [
                                'name' => $name,
                                'options' => $input->option,
                                'placeholder' => $input->placeholder,
                                'required' => isset($input->required) ? $input->required : false,
                                'type' => $input->type,
                            ])
                        @endforeach

                        <div class="sche01-page__content__aside__form__inputs__compliance">
                            {!! Form::checkbox('term_accept', 1, null, [
                                'class' => 'form-check-input me-1',
                                'id' => 'term_accept',
                                'required' => true,
                            ]) !!}
                            {!! Form::label('term_accept', 'Aceito os termos descritos na ', ['class' => 'form-check-label']) !!}
                            <a href="{{ getUri($compliance->link ?? '#') }}" target="_blank"
                                class="sche01-page__content__aside__form__inputs__compliance__link">Política de
                                Privacidade</a>
                        </div>

                        <button type="submit" class="sche01-page__content__aside__form__inputs__cta">
                            @if ($contact->title_button)
                                {{ $contact->title_button }}
                            @endif
                        </button>
                    </div>
                    {!! Form::close() !!}
                @endif

                <ul class="sche01-page__content__aside__month-categories">
                    @foreach ($monthlyEventCounts as $month => $count)
                        <li class="sche01-page__content__aside__month-categories__item">
                            <a href="{{ route('sche01.monthlyEventCounts', ['month' => $month]) }}" class="link-full"
                                title="{{ $count }} eventos em {{ ucfirst(\Carbon\Carbon::createFromFormat('m', $month)->formatLocalized('%B')) }}"></a>
                            <h3 class="sche01-page__content__aside__month-categories__item__title">
                                {{ ucfirst(\Carbon\Carbon::createFromFormat('m', $month)->formatLocalized('%B')) }}
                            </h3>
                            <h4 class="sche01-page__content__aside__month-categories__item__subtitle">
                                Eventos
                                <span
                                    class="sche01-page__content__aside__month-categories__item__subtitle__counter">{{ $count }}</span>
                            </h4>
                        </li>
                    @endforeach
                </ul>
            </aside>

        </section>

        {{-- Finish Content page Here --}}
        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
