@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    <main id="root" class="sche01-show">
        @if ($schedule)
            <section class="sche01-show__banner"
                style="background-image: url({{ asset('storage/' . $schedule->path_image_desktop_banner) }});">
                @if ($schedule->title_banner)
                    <h1 class="sche01-show__banner__title">{{ $schedule->title_banner }}</h1>
                @endif
                @if ($schedule->subtitle_banner)
                    <h2 class="sche01-show__banner__subtitle">{{ $schedule->subtitle_banner }}</h2>
                @endif
            </section>
        @endif
        <section class="sche01-show__content">
            <article class="sche01-show__content__main">
                <header class="sche01-show__content__main__header">
                    @if ($schedule->event_date)
                        <div class="sche01-show__content__main__header__date">
                            <span class="sche01-show__content__main__header__date__day">{{ Carbon\Carbon::parse($schedule->event_date)->formatLocalized('%d') }}</span>
                            <span class="sche01-show__content__main__header__date__month">{{monthFull(strtotime($schedule->event_date))}}</span>
                            <span class="sche01-show__content__main__header__date__year">{{ Carbon\Carbon::parse($schedule->event_date)->formatLocalized('%Y') }}</span>
                        </div>
                    @endif
                    <div class="sche01-show__content__main__header__information">
                        @if ($schedule->title)
                            <h2 class="sche01-show__content__main__header__information__title">{{ $schedule->title }}</h2>
                        @endif
                        @if ($schedule->path_image_hours || $schedule->event_time || $schedule->path_image_sub || $schedule->subtitle)
                            <ul class="sche01-show__content__main__header__information__topics">
                                @if ($schedule->path_image_hours || $schedule->event_time)
                                    <li class="sche01-show__content__main__header__information__topics__item">
                                        @if ($schedule->path_image_hours)
                                            <img src="{{ asset('storage/' . $schedule->path_image_hours) }}" alt="Ícone do {{$schedule->event_time}}"
                                                class="sche01-show__content__main__header__information__topics__item__icon">
                                        @endif
                                        @if ($schedule->event_time)
                                            {{ date('H:i', strtotime($schedule->event_time)) }}
                                        @endif
                                    </li>
                                @endif
                                @if ($schedule->path_image_sub || $schedule->subtitle)
                                    <li class="sche01-show__content__main__header__information__topics__item">
                                        @if ($schedule->path_image_sub)
                                            <img src="{{ asset('storage/' . $schedule->path_image_sub) }}" alt="Ícone do {{$schedule->subtitle}}"
                                                class="sche01-show__content__main__header__information__topics__item__icon">
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
                    <img src="{{ asset('storage/' . $schedule->path_image) }}" alt="Imagem do {{ $schedule->title }}" loading="lazy"
                        class="sche01-show__content__main__img">
                @endif
                @if ($schedule->description)
                    <h3 class="sche01-show__content__main__subtitle">Descrição</h3>
                    <div class="sche01-show__content__main__paragraph">
                        <p>
                            {!! $schedule->description !!}
                        </p>
                    </div>
                @endif
                @if ($schedule->information)
                    <h3 class="sche01-show__content__main__subtitle">Local</h3>
                    <div class="sche01-show__content__main__paragraph">
                        <p>
                            {!! $schedule->information !!}
                        </p>
                    </div>
                @endif
                @if ($schedule->link_button)
                    <a href="{{ getUri($schedule->link_button) }}" target="{{ $schedule->target_link_button }}" class="sche01-show__content__main__cta">
                        @if ($schedule->title_button)
                            {{ $schedule->title_button }}
                        @endif
                    </a>
                @endif
            </article>
            <aside class="sche01-show__content__aside">
                @if ($contact)
                    {!! Form::open([
                        'route' => 'lead.store',
                        'method' => 'post',
                        'files' => true,
                        'class' => 'send_form_ajax form-contact parsley-validate sche01-show__content__aside__form',
                    ]) !!}
                    @if ($contact->subtitle || $contact->titles || $contact->description)
                        <header class="sche01-show__content__aside__form__header">
                            @if ($contact->subtitle)
                                <h4 class="sche01-show__content__aside__form__header__subtitle">{{ $contact->subtitle }}</h4>
                            @endif
                            @if ($contact->title)
                                <h3 class="sche01-show__content__aside__form__header__title">{{ $contact->title }}</h3>
                            @endif
                            @if ($contact->description)
                                <div class="sche01-show__content__aside__form__header__paragraph">
                                    {!! $contact->description !!}
                                </div>
                            @endif
                        </header>
                    @endif
                    <div class="sche01-show__content__aside__form__inputs">
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
                        <div class="sche01-show__content__aside__form__inputs__compliance">
                            {!! Form::checkbox('term_accept', 1, null, [ 'class' => 'form-check-input me-1',
                                'id' => 'term_accept',
                                'required' => true,
                            ]) !!}
                            {!! Form::label('term_accept', 'Aceito os termos descritos na ', ['class' => 'form-check-label']) !!}
                            <a href="{{ getUri($compliance->link ?? '#') }}" target="_blank"
                                class="sche01-show__content__aside__form__inputs__compliance__link">Política de
                                Privacidade</a>
                        </div>
                        <button type="submit" class="sche01-show__content__aside__form__inputs__cta">
                            @if ($contact->title_button)
                                {{ $contact->title_button }}
                            @endif
                        </button>
                    </div>
                    {!! Form::close() !!}
                @endif
                @if ($monthlyEventCounts->count())
                    <ul class="sche01-show__content__aside__month-categories">
                        @foreach ($monthlyEventCounts as $month => $count)
                            <li class="sche01-show__content__aside__month-categories__item">
                                <a href="{{ route('sche01.monthlyEventCounts', ['month' => $month]) }}" class="link-full"
                                    title="{{ $count }} eventos em {{ ucfirst(\Carbon\Carbon::createFromFormat('m', $month)->formatLocalized('%B')) }}"></a>
                                <h3 class="sche01-show__content__aside__month-categories__item__title">
                                    {{ ucfirst(\Carbon\Carbon::createFromFormat('m', $month)->formatLocalized('%B')) }}
                                </h3>
                                <h4 class="sche01-show__content__aside__month-categories__item__subtitle">
                                    Eventos
                                    <span class="sche01-show__content__aside__month-categories__item__subtitle__counter">{{ $count }}</span>
                                </h4>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </aside>
        </section>
        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
