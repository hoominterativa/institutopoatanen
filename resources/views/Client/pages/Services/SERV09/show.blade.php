@extends('Client.Core.client')
@section('content')
    <main id="root" class="serv09-show">
        @if ($service->active_banner == 1)
            <section class="serv09-show__banner"
                style="background-image: url({{ asset('storage/' . $service->path_image_desktop) }});  background-color: {{ $service->background_color }};">

                @if ($service->title_banner)
                    <h1 class="serv09-show__banner__title">{{ $service->title_banner }}</h1>
                @endif

                @if ($service->subtitle_banner)
                    <h2 class="serv09-show__banner__subtitle">{{ $service->subtitle_banner }}</h2>
                @endif

                @if ($service->percentage)
                    <div class="serv09-show__banner__progress">

                        <span class="serv09-show__banner__progress__title">
                            Andamento da Obra: {{ $service->percentage === 100 ? 'Concluído' : 'Em andamento' }}
                        </span>

                        <div class="serv09-show__banner__progress__bar">
                            <span class="serv09-show__banner__progress__bar__fill" style="width: {{$service->percentage}}%;"></span>
                        </div>

                        <span class="serv09-show__banner__progress__number">
                            {{$service->percentage}}%
                        </span>
                    </div>
                @endif

            </section>
        @endif

        @if ($topicsUp->count())
            <section class="serv09-show__topics">
                <div class="serv09-show__topics__swiper-wrapper swiper-wrapper">
                    @foreach ($topicsUp as $topicUp)
                        <div class="serv09-show__topics__item swiper-slide">
                            @if ($topicUp->path_image)
                                <img src="{{ asset('storage/'.$topicUp->path_image) }}"
                                alt="Ícone de {{$topicUp->title}}" loading="lazy"
                                class="serv09-show__topics__item__icon">
                            @endif
                            @if ($topicUp->title)
                                <span class="serv09-show__topics__item__title">{{$topicUp->title}}</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <section class="serv09-show__main">

            <div class="serv09-show__main__information">
                @if ($service->title || $service->subtitle)
                    <h2 class="serv09-show__main__information__title">{{ $service->title }}</h2>
                    <h3 class="serv09-show__main__information__subtitle">{{ $service->subtitle }}
                    </h3>
                @endif
                @if ($service->text)
                    <div class="serv09-show__main__information__paragraph">
                        {!! $service->text !!}
                    </div>
                @endif

                @if ($topics->count())
                    <ul class="serv09-show__main__information__topics">
                        @foreach ($topics as $topic)
                            <li class="serv09-show__main__information__topics__item">
                                @if ($topic->path_image)
                                    <img src="{{ asset('storage/' . $topic->path_image) }}"
                                        alt="Ícone do {{ $topic->title }}" loading='lazy'
                                        class="serv09-show__main__information__topics__item__icon ">
                                @endif

                                {{ $topic->title }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div class="serv09-show__main__form-area">

                <h3 class="serv09-show__main__form-area__title">{{ $service->title_info }}</h3>

                @if ($service->price)
                    <span class="serv09-show__main__form-area__price">
                        R${{$service->price}} por dia
                    </span>
                @endif

                @if ($service->informations)
                    <div class="serv09-show__main__form-area__paragraph">
                        {!! $service->informations !!}
                    </div>
                @endif

                @if ($service->link)
                    <a class="serv09-show__main__form-area__cta" href="{{ getUri($service->link) }}" target="_blank">
                        Reservar agora
                    </a>
                @else
                    {!! Form::model(
                        ['column_preco_text' => 'R$ ' . $service->price],
                        [
                            'route' => 'lead.store',
                            'method' => 'post',
                            'files' => true,
                            'class' => 'serv09-show__main__form-area__form send_form_ajax form-contact parsley-validate',
                        ],
                    ) !!}
                    <input type="hidden" name="target_lead" value="{{ $service->title }} - {{ $service->subtitle }}">
                    <input type="hidden" name="target_send" value="{{ base64_encode('teste@teste.com') }}">

                    @include('Client.Components.inputs', [
                        'name' => 'column_chekin_date',
                        'placeholder' => 'Chek-in',
                        'required' => true,
                        'type' => 'date',
                    ])
                    @include('Client.Components.inputs', [
                        'name' => 'column_chekout_date',
                        'placeholder' => 'chek-out',
                        'required' => true,
                        'type' => 'date',
                    ])
                    @include('Client.Components.inputs', [
                        'name' => 'column_preco_text',
                        'placeholder' => 'Preco',
                        'required' => true,
                        'type' => 'text',
                    ])
                    @include('Client.Components.inputs', [
                        'name' => 'column_nomecompleto_text',
                        'placeholder' => 'Nome completo',
                        'required' => true,
                        'type' => 'text',
                    ])
                    @include('Client.Components.inputs', [
                        'name' => 'column_email_email',
                        'placeholder' => 'Email',
                        'required' => true,
                        'type' => 'email',
                    ])
                    @include('Client.Components.inputs', [
                        'name' => 'column_contato_cellphone',
                        'placeholder' => 'Contato',
                        'required' => true,
                        'type' => 'cellphone',
                    ])
                    <button class="serv09-show__main__form-area__cta" type="submit">
                        Reservar agora
                    </button>
                    {!! Form::close() !!}
                @endif
            </div>

        </section>

        @if ($galleries->count())
            <div class="serv09-show__gallery">
                <div class="serv09-show__gallery__swiper-wrapper swiper-wrapper">
                    @foreach ($galleries as $gallery)
                        <img src="{{ asset('storage/' . $gallery->path_image) }}" loading='lazy' alt="Imagem da galeria"
                            class="serv09-show__gallery__item swiper-slide">
                    @endforeach
                </div>

                <div class="serv09-show__gallery__swiper-pagination swiper-pagination"></div>
            </div>
        @endif

        @if ($contents->count())
            <section class="serv09-show__faq">

                @foreach ($contents as $content)
                    <details class="serv09-show__faq__item">
                        @if ($content->title)
                            <summary class="serv09-show__faq__item__title">
                                {{ $content->title }}
                            </summary>
                        @endif

                        <div class="serv09-show__faq__item__paragraph details-content">
                            @if ($content->text)
                                <p>
                                    {!! $content->text !!}
                                </p>
                            @endif
                        </div>
                    </details>
                @endforeach

            </section>
        @endif

        @if ($feedbacks->count())
            <section class="serv09-show__feedbacks">

                @if ($section->active_feedback)
                    <header class="serv09-show__feedbacks__header">
                        @if ($section->title_feedback)
                            <h4 class="serv09-show__feedbacks__header__title">{{ $section->title_feedback }}
                            </h4>
                        @endif
                    </header>
                @endif

                <main class="serv09-show__feedbacks__carousel">
                    <div class="serv09-show__feedbacks__carousel__swiper-wrapper swiper-wrapper">
                        @foreach ($feedbacks as $feedback)
                            <div class="serv09-show__feedbacks__carousel__item swiper-slide">
                                @if ($feedback->text)
                                    <div class="serv09-show__feedbacks__carousel__item__paragraph">
                                        {!! $feedback->text !!}
                                    </div>
                                @endif

                                @if ($feedback->path_image)
                                    <div class="serv09-show__feedbacks__carousel__item__avatar">
                                        <img src="{{ asset('storage/' . $feedback->path_image) }}"
                                            alt="Imagem de {{ $feedback->name }}" loading='lazy'
                                            class="serv09-show__feedbacks__carousel__item__avatar__img">
                                    </div>
                                @endif

                                @if ($feedback->name)
                                    <span class="serv09-show__feedbacks__carousel__item__name">
                                        {{ $feedback->name }}</span>
                                @endif

                                @if ($feedback->profession)
                                    <span class="serv09-show__feedbacks__carousel__item__role">
                                        {{ $feedback->profession }}</span>
                                @endif

                            </div>
                        @endforeach

                    </div>

                    <div class="serv09-show__feedbacks__carousel__nav">
                        <div class="serv09-show__feedbacks__carousel__nav__swiper-button-prev swiper-button-prev"></div>
                        <div class="serv09-show__feedbacks__carousel__nav__swiper-button-next swiper-button-next"></div>
                    </div>
                </main>

            </section>
        @endif

        <section class="serv09-show__map">
            {{-- FRONTEND ajustar os spans --}}
            <span>Localização</span>
            <span>{{$service->address}}</span>
            <iframe src="{{getUri($service->map_link)}}" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </section>

        <section class="serv09-show__related">
            <aside class="serv09-show__related__categories">
                <menu class="serv09-show__related__categories__swiper-wrapper swiper-wrapper">
                    @foreach ($categories as $category)
                        <li class="serv09-show__related__categories__item swiper-slide">
                            <a href="{{ route('serv09.category.page', ['SERV09ServicesCategory' => $category->slug]) }}"
                                class="link-full" title="{{ $category->title }}">
                            </a>
                            @if ($category->path_image)
                                <img src="{{ asset('storage/' . $category->path_image) }}"
                                    alt="Icone da categoria: {{ $category->title }}"
                                    class="serv09-show__related__categories__item__icon" loading="lazy">
                            @endif
                            {{ $category->title }}
                        </li>
                    @endforeach
                </menu>
            </aside>

            <main class="serv09-show__related__main">
                <div class="serv09-show__related__main__carousel">
                    <div class="serv09-show__related__main__carousel__swiper-wrapper swiper-wrapper">
                        @foreach ($services as $service)
                            <article class="serv09-show__related__main__item swiper-slide">

                                <a href="{{ route('serv09.page.content', ['SERV09ServicesCategory' => $service->categories->slug, 'SERV09Services' => $service->slug]) }}"
                                    class="link-full" title="{{ $service->title }}">
                                </a>

                                <div class="serv09-show__related__main__item__information">

                                    @if ($service->title)
                                        <h3 class="serv09-show__related__main__item__information__title">
                                            {{ $service->title }}</h3>
                                    @endif

                                    @if ($service->subtitle)
                                        <h4 class="serv09-show__related__main__item__information__subtitle">
                                            {{ $service->subtitle }}</h4>
                                    @endif

                                    @if ($service->price)
                                        <span class="serv09-show__related__main__item__information__price">
                                            R$ {{$service->price}}
                                        </span>
                                    @endif

                                    @if ($service->description)
                                        <div class="serv09-show__related__main__item__information__paragraph">
                                            <p>
                                                {!! $service->description !!}
                                            </p>
                                        </div>
                                    @endif

                                    @if ($service->topics->count())
                                        <ul class="serv09-show__related__main__item__information__topics">
                                            @foreach ($service->topics as $topic)
                                                <li class="serv09-show__related__main__item__information__topics__item">
                                                    @if ($topic->path_image)
                                                        <img src="{{ asset('storage/' . $topic->path_image) }}"
                                                            alt="Ícone de {{ $topic->title }}" loading="lazy"
                                                            class="serv09-show__related__main__item__information__topics__item__icon">
                                                    @endif

                                                    {{ $topic->title }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    @if ($service->percentage)
                                        <div class="serv09-show__related__main__item__information__progress">

                                            <span class="serv09-show__related__main__item__information__progress__title">
                                                {{ $service->percentage === 100 ? 'Concluído' : 'Em andamento' }}
                                            </span>

                                            <div class="serv09-show__related__main__item__information__progress__bar">
                                                <span
                                                    class="serv09-show__related__main__item__information__progress__bar__fill"
                                                    style="width: {{$service->percentage}}%;"></span>
                                            </div>

                                            <span class="serv09-show__related__main__item__information__progress__number">
                                                {{$service->percentage}}%
                                            </span>
                                        </div>
                                    @endif

                                </div>

                                <img src="{{ asset('storage/' . $service->path_image) }}"
                                    alt="Imagem do serviço {{ $service->title }}"
                                    class="serv09-show__related__main__item__image">

                            </article>
                        @endforeach
                    </div>

                    <div class="serv09-show__related__main__carousel__swiper-pagination swiper-pagination"></div>

                </div>
                <a href="{{ route('serv09.category.page', ['SERV09ServicesCategory' => $service->categories->slug]) }}" class="serv09-show__related__main__cta">
                    CTA
                </a>
            </main>
        </section>

        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
