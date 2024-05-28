@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    <main id="root" class="sche01-page">
        @if ($section->active_banner)
            @if ($section->path_image_desktop || $section->title_banner || $section->subtitle_banner)
                <section class="sche01-page__banner"
                    style="background-image: url({{ asset('storage/' . $section->path_image_desktop) }});">
                    @if ($section->title_banner)
                        <h1 class="sche01-page__banner__title">{{ $section->title_banner }}</h1>
                    @endif
                    @if ($section->subtitle_banner)
                        <h2 class="sche01-page__banner__subtitle">{{ $section->subtitle_banner }}</h2>
                    @endif
                </section>
            @endif
        @endif
        <section class="sche01-page__content">
            <div class="sche01-page__content__main">
                @if ($section->active_section)
                    @if ($section->title_section || $section->subtitle_section)
                        <div class="sche01-page__content__main__top">
                            @if ($section->title_section)
                                <h2 class="sche01-page__content__main__top__title">{{ $section->title_section }}</h2>
                            @endif
                            @if ($section->subtitle_section)
                                <h3 class="sche01-page__content__main__top__subtitle">{{ $section->subtitle_section }}</h3>
                            @endif
                        </div>
                    @endif
                @endif
                @if ($schedules->count())
                    <div class="sche01-page__content__main__list">
                        @foreach ($schedules as $schedule)
                            <article class="sche01-page__content__main__list__item">
                                <header class="sche01-page__content__main__list__item__header">
                                    @if ($schedule->event_date)
                                        <div class="sche01-page__content__main__list__item__header__date">
                                            <span class="sche01-page__content__main__list__item__header__date__day">{{ Carbon\Carbon::parse($schedule->event_date)->formatLocalized('%d') }}</span>
                                            <span class="sche01-page__content__main__list__item__header__date__month">{{ monthFull(strtotime($schedule->event_date)) }}</span>
                                            <span class="sche01-page__content__main__list__item__header__date__year">{{ Carbon\Carbon::parse($schedule->event_date)->formatLocalized('%Y') }}</span>
                                        </div>
                                    @endif
                                    <div class="sche01-page__content__main__list__item__header__information">
                                        @if ($schedule->title)
                                            <h3 class="sche01-page__content__main__list__item__header__information__title">
                                                {{ $schedule->title }}
                                            </h3>
                                        @endif
                                        @if ($schedule->path_image_hours || $schedule->event_time || $schedule->path_image_sub || $schedule->subtitle)
                                            <ul class="sche01-page__content__main__list__item__header__information__topics">
                                                @if ($schedule->path_image_hours || $schedule->event_time)
                                                    <li class="sche01-page__content__main__list__item__header__information__topics__item">
                                                        @if ($schedule->path_image_hours)
                                                            <img src="{{ asset('storage/' . $schedule->path_image_hours) }}" alt="ícone de relógio"
                                                            class="sche01-page__content__main__list__item__header__information__topics__item__icon">
                                                        @endif
                                                        @if ($schedule->event_time)
                                                            {{ date('H:i', strtotime($schedule->event_time)) }}
                                                        @endif
                                                    </li>
                                                @endif
                                                @if ($schedule->path_image_sub || $schedule->subtitle)
                                                    <li class="sche01-page__content__main__list__item__header__information__topics__item">
                                                        @if ($schedule->path_image_sub)
                                                            <img src="{{ asset('storage/' . $schedule->path_image_sub) }}" alt="ícone do {{ $schedule->subtitle }}"
                                                            class="sche01-page__content__main__list__item__header__information__topics__item__icon">
                                                        @endif
                                                        @if ($schedule->subtitle)
                                                            {{ $schedule->subtitle }}
                                                        @endif
                                                    </li>
                                                @endif
                                            </ul>
                                        @endif
                                    </div>
                                </header>
                                @if ($schedule->path_image)
                                    <img src="{{ asset('storage/' . $schedule->path_image) }}" alt="Imagem do {{$schedule->title}}" class="sche01-page__content__main__list__item__img">
                                @endif
                                @if ($schedule->description)
                                    <div class="sche01-page__content__main__list__item__paragraph">
                                        {!! $schedule->description !!}
                                    </div>
                                @endif
                                <a href="{{ route('sche01.show.content', ['SCHE01Schedules' => $schedule->slug]) }}" class="sche01-page__content__main__list__item__cta">
                                    CTA
                                </a>
                            </article>
                        @endforeach
                    </div>
                    <div class="sche01-page__content__pagination">
                        {{ $schedules->links() }}
                    </div>
                @endif
            </div>
            @if ($monthlyEventCounts->count() || $contact)
                <aside class="sche01-page__content__aside">
                    @if ($contact)
                        {!! Form::open([
                            'route' => 'lead.store',
                            'method' => 'post',
                            'files' => true,
                            'class' => 'send_form_ajax form-contact parsley-validate sche01-page__content__aside__form',
                        ]) !!}
                        @if ($contact->subtitle || $contact->title || $contact->description)
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
                        @endif
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
                            @if ($contact->title_button)
                                <button type="submit" class="sche01-page__content__aside__form__inputs__cta">
                                    {{ $contact->title_button }}
                                </button>
                            @endif
                        </div>
                        {!! Form::close() !!}
                    @endif
                    @if ($monthlyEventCounts->count())
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
                                        <span class="sche01-page__content__aside__month-categories__item__subtitle__counter">{{ $count }}</span>
                                    </h4>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </aside>
            @endif
        </section>
        {{-- Finish Content page Here --}}
        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
