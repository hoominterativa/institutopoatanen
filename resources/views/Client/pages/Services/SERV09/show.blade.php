@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<main id="root">
    <div id="serv09-show" class="sesh">
        <header class="sesh__header">
            @if ($service->active_banner)
                <div class="sesh__header__bg"
                    style="background-image: url({{ asset('storage/' . $service->path_image_desktop) }});  background-color: {{ $service->background_color }};">
                    <div class="sesh__header__bg__content">
                        @if ($service->title_banner || $service->subtitle_banner)
                            <h4 class="sesh__header__bg__content__title">{{ $service->subtitle_banner }}</h4>
                            <h3 class="sesh__header__bg__content__subtitle">{{ $service->title_banner }}</h3>
                        @endif
                    </div>
                </div>
            @endif
        </header>

        <main class="sesh__main">
            <section class="sesh__section-show">
                <div class="container container--section-show">
                    <div class="row row--section-show justify-content-between">
                        <div class="sesh__section-show__left col-sm-5">
                            <div class="sesh__section-show__left__description">
                                @if ($service->title || $service->subtitle)
                                    <h3 class="sesh__section-show__left__description__title">{{ $service->title }}</h3>
                                    <h4 class="sesh__section-show__left__description__subtitle">{{ $service->subtitle }}</h4>
                                    <hr class="sesh__section-show__left__description__line">
                                @endif
                                @if ($service->text)
                                    <div class="sesh__section-show__left__description__paragraph">
                                        {!! $service->text !!}
                                    </div>
                                @endif
                            </div>
                            @if ($topics->count())
                                <div class="sesh__section-show__left__topics">
                                    @foreach ($topics as $topic)
                                        <div class="sesh__section-show__left__topics__topic">
                                            @if ($topic->path_image)
                                                <div class="sesh__section-show__left__topics__topic__icon">
                                                    <img src="{{ asset('storage/' . $topic->path_image) }}" alt="Imagem" class="">
                                                </div>
                                            @endif
                                            <div class="sesh__section-show__left__topics__topic__description">
                                                @if ($topic->title)
                                                    <h4 class="sesh__section-show__left__topics__topic__description__title">{{ $topic->title }}</h4>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <aside class="sesh__section-show__right col-sm-5">
                            <h4 class="sesh__section-show__right__title">{{$service->title_info}}</h4>
                            @if ($service->price)
                                <h3 class="sesh__section-show__right__price"><span>R$</span>{{number_format($service->price, 2, ',', '.')}} <span>por dia</span></h3>
                            @endif
                            @if ($service->informations)
                                <div class="sesh__section-show__right__paragraph">
                                    {!! $service->informations !!}
                                </div>
                            @endif
                            @if ($service->link)
                                <a class="sesh__section-show__right__btn" href="{{getUri($service->link)}}" target="_blank">
                                    Reservar agora
                                </a>
                            @else
                                <div class="form-sesh">
                                    {!! Form::model(['column_preco_text' => 'R$ ' . number_format($service->price, 2, ',', '.'),],[
                                        'route' => 'lead.store',
                                        'method' => 'post',
                                        'files' => true,
                                        'class' => 'send_form_ajax serv09-form__form d-flex w-100 flex-column align-items-stretch form-contact parsley-validate align-items-center',
                                    ]) !!}
                                    <div class="d-flex flex-column w-100 align-items-stretch">
                                        <input type="hidden" name="target_lead" value="{{$service->title}} - {{$service->subtitle}}">
                                        <input type="hidden" name="target_send" value="{{ base64_encode('teste@teste.com') }}">

                                        <div class="engDate">
                                            @include('Client.Components.inputs', [
                                                'name' => 'column_chekin_date',
                                                'placeholder' => 'Chek-in',
                                                'required' => true,
                                                'type' => 'date',
                                                'class' => 'col-md-8',
                                            ])
                                            @include('Client.Components.inputs', [
                                                'name' => 'column_chekout_date',
                                                'placeholder' => 'chek-out',
                                                'required' => true,
                                                'type' => 'date',
                                                'class' => 'col-md-8',
                                            ])
                                        </div>
                                        <div class="d-none">
                                            @include('Client.Components.inputs', [
                                                'name' => 'column_preco_text',
                                                'placeholder' => 'Preco',
                                                'required' => true,
                                                'type' => 'text',
                                                'class' => 'col-md-8',

                                                ])
                                        </div>
                                        @include('Client.Components.inputs', [
                                            'name' => 'column_nomecompleto_text',
                                            'placeholder' => 'Nome completo',
                                            'required' => true,
                                            'type' => 'text',
                                            'class' => 'col-md-8',
                                        ])
                                        @include('Client.Components.inputs', [
                                            'name' => 'column_email_email',
                                            'placeholder' => 'Email',
                                            'required' => true,
                                            'type' => 'email',
                                            'class' => 'col-md-8',
                                        ])
                                        @include('Client.Components.inputs', [
                                            'name' => 'column_contato_cellphone',
                                            'placeholder' => 'Contato',
                                            'required' => true,
                                            'type' => 'cellphone',
                                            'class' => 'col-md-8',
                                        ])
                                    </div>
                                    <button class="sesh__section-show__right__btn" type="submit" class="">
                                        Reservar agora
                                    </button>
                                    {!! Form::close() !!}
                                </div>
                            @endif
                        </aside>
                    </div>
                </div>
            </section>
            {{-- fim-sesh__section-show --}}
            @if ($galleries->count())
                <div class="sesh__section-gallery">
                    <div class="container container--sesh__section-gallery">
                        <div class="sesh__section-gallery__content carousel-section-gallery owl-carousel">
                            @foreach ($galleries as $gallery)
                                @if ($gallery->path_image)
                                    <div class="sesh__section-gallery__content__image">
                                        <img src="{{ asset('storage/' . $gallery->path_image) }}" alt="Imagem" class="">
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            {{-- fim-sesh__section-gallery --}}
            @if ($contents->count())
                <section class="sesh__section-faq">
                    <div class="sesh__section-faq__content container">
                        @foreach ($contents as $content)
                            <div class="sesh__section-faq__content__box">
                                <button class="sesh__section-faq__content__box__tab accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-{{ $content->id }}" aria-expanded="false" aria-controls="collapseTwo">
                                    @if ($content->title)
                                        <h4 class="sesh__section-faq__content__box__tab__title">{{ $content->title }}</h4>
                                    @endif
                                </button>
                                <div id="faq-{{ $content->id }}" class="sesh__section-faq__content__box__description accordion-collapse collapse" data-bs-parent="#faq-{{ $content->id }}">
                                    @if ($content->text)
                                        <div class="sesh__section-faq__content__box__description__paragraph">
                                            <p>
                                                {!! $content->text !!}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif
            {{-- fim-sesh__section-faq --}}
            @if ($feedbacks->count())
                <div class="sesh__section-feedbacks">
                    <div class="container container--sesh__section-feedbacks">
                        @if ($section->active_feedback)
                            <div class="sesh__section-feedbacks__encompass">
                                @if ($section->title_feedback)
                                    <h4 class="sesh__section-feedbacks__encompass__title">{{ $section->title_feedback }}</h4>
                                    <hr class="sesh__section-feedbacks__encompass__hr">
                                @endif
                            </div>
                        @endif
                        <div class="sesh__section-feedbacks__content  carousel-section-feedbacks owl-carousel">
                            @foreach ($feedbacks as $feedback)
                                <div class="sesh__section-feedbacks__content__box text-center">
                                    <div class="sesh__section-feedbacks__content__box__text text-center">
                                        @if ($feedback->text)
                                            {!! $feedback->text !!}
                                        @endif
                                    </div>
                                    @if ($feedback->path_image)
                                        <div class="sesh__section-feedbacks__content__box__image">
                                            <img src="{{ asset('storage/' . $feedback->path_image) }}" alt="Imagem">
                                        </div>
                                    @endif
                                    <div class="sesh__section-feedbacks__content__box__description text-center">
                                        @if ($feedback->name)
                                            <h4 class="sesh__section-feedbacks__content__box__description__title">{{ $feedback->name }}</h4>
                                        @endif
                                        @if ($feedback->profession)
                                            <h4 class="sesh__section-feedbacks__content__box__description__subtitle">{{ $feedback->profession }}</h4>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            
                        </div>
                    </div>
                </div>
            @endif
            {{-- fim-sesh__section-feedbacks --}}
            <section class="sesh__service-related">
                <div class="sesh__service-related__category">
                    <div class="container sesh__service-related__category__content">
                        @if ($categories->count())
                            <nav class="sesh__service-related__category__content__navigation">
                                <ul class="sesh__service-related__category__content__navigation__list">
                                    @foreach ($categories as $category)
                                        <li class="sesh__service-related__category__content__navigation__list__item {{isset($category->selected) ? 'active':''}}">
                                            <a href="{{route('serv09.category.page', ['SERV09ServicesCategory' =>$category->slug])}}">
                                                <img src="{{ asset('storage/' . $category->path_image) }}" alt="" class="">
                                                {{$category->title}}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </nav>
                        @endif
                         <div class="sesh__service-related__category__dropdow-mobile">
                                <button class="sesh__service-related__category__dropdow-mobile__tab  accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#category" aria-expanded="false" aria-controls="collapseTwo">
                                    <img class="sesh__service-related__category__dropdow-mobile__tab__left" src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="Ícone">
                                    Selecione as categorias
                                </button>
                                <ul id="category" class="sesh__service-related__category__dropdow-mobile__description accordion-collapse collapse" data-bs-parent="#category">
                                    @foreach ($categories as $category)
                                        <li >
                                            <a href="{{route('serv09.category.page', ['SERV09ServicesCategory' => $category->slug])}}" >
                                                @if ($category->path_image)
                                                    <img src="{{ asset('storage/' . $category->path_image) }}" alt="Icone categoria" class="sesh__service-related__category__dropdow-mobile__description__icon">
                                                @endif
                                                {{$category->title}}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                    </div>
                </div>
                <div class="sesh__service-related__main container">
                    <div class="carousel-service-related owl-carousel">
                        @foreach ($services as $service)
                        <article class="sesh__service-related__main__box w-100 d-flex justify-content-between row mx-auto">
                            <div class="sesh__service-related__main__box__left col-sm-6">
                                <div class="sesh__service-related__main__box__left__content">
                                    @if ($service->title || $service->subtitle)
                                        <h3 class="serv09__box__left__content__title">{{$service->title}}</h3>
                                        <h4 class="serv09__box__left__content__subtitle">{{$service->subtitle}}</h4>
                                    @endif
                                    @if ($service->price)
                                        <h3 class="sesh__service-related__main__box__left__content__price"><span>R$</span>{{number_format($service->price, 2, ',', '.')}}</h3>
                                    @endif

                                    <div class="sesh__service-related__main__box__left__content__paragraph">
                                        @if ($service->description)
                                            <p>
                                                {!! $service->description !!}
                                            </p>
                                        @endif
                                    </div>
                                    @if ($service->topics->count())
                                        <div class="sesh__service-related__main__box__left__content__engBox">
                                            @foreach ($service->topics as $topic)
                                                <div class="sesh__service-related__main__box__left__content__engBox__button">
                                                    @if ($topic->path_image)
                                                        <img src="{{ asset('storage/' . $topic->path_image) }}" alt="Ícon" class="serv09__box__left__content__engBox__button__icon">
                                                    @endif
                                                    @if ($topic->title)
                                                        <h4 class="sesh__service-related__main__box__left__content__engBox__button__title">{{$topic->title}}</h4>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="serv09__box__right col-sm-6">
                                <img src="{{ asset('storage/' . $service->path_image) }}" alt="" class="serv09__box__right__image">
                                <a href="{{route('serv09.page.content', ['SERV09ServicesCategory' => $service->categories->slug, 'SERV09Services' => $service->slug])}}" class="serv09__box__right__btn">
                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="Ícon" class="serv09__box__right__btn__icon">
                                    CTA
                                </a>
                            </div>
                        </article>
                    @endforeach
                    </div>
                </div>
            </section>
            {{-- fim-sesh__service-related --}}
        </main>
    </div>
    {{-- Finish Content page Here --}}
    @foreach ($sections as $section)
        {!! $section !!}
    @endforeach
</main>
{{-- Finish Content page Here --}}
@endsection
