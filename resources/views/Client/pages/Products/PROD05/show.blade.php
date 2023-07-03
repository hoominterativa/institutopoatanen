@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}

    <section class="prod05-show">
        @if ($product->title_banner || $product->subtitle_banner)
            <header class="prod05-show__banner" style="background-image: url({{asset('storage/'.$product->path_image_banner)}})">
                <div class="prod05-show__banner__container container">
                    <div class="prod05-show__banner__description">
                        <h3 class="prod05-show__banner__title">{{$product->title_banner}}</h3>
                        <h4 class="prod05-show__banner__subtitle">{{$product->subtitle_banner}}</h4>
                        <hr class="prod05-show__banner__line">
                    </div>
                    {{-- END .prod05-show__banner__description --}}
                </div>
                {{-- END .prod05-show__banner__container --}}
            </header>
            {{-- END .prod05-show__banner --}}
        @endif
        <main>
            <div class="prod05-show__contentTitle">
                <div class="prod05-show__contentTitle__container container">
                    <div class="prod05-show__wrapForm">
                        <button class="prod05-show__btnForm prod05-show__btnForm--showForm" type="button">Faça seu Orçamento</button>

                        {!! Form::open(['route' => 'lead.store', 'method' => 'post', 'files' => true, 'class'=>'send_form_ajax prod05-show__form parsley-validate']) !!}
                            <input type="hidden" name="target_lead" value="Orçamento {{$product->title}}">
                            <input type="hidden" name="target_send" value="anderson@hoom.com.br">
                            @include('Client.Components.inputs', [
                                'name' => 'nome',
                                'options' => null,
                                'placeholder' => 'Nome',
                                'type' => 'text',
                                'required' => false
                            ])

                            @include('Client.Components.inputs', [
                                'name' => 'email',
                                'options' => null,
                                'placeholder' => 'E-mail',
                                'type' => 'email',
                                'required' => false
                            ])
                            @include('Client.Components.inputs', [
                                'name' => 'mensagem',
                                'options' => null,
                                'placeholder' => 'Mensagem',
                                'type' => 'textarea',
                                'required' => false
                            ])
                            {!! Form::submit('Enviar', ['class' => 'prod05-show__form__submit']) !!}
                        {!! Form::close() !!}
                    </div>
                    {{-- END .prod05-show__banner__wrapForm --}}

                    <div class="prod05-show__contentTitle__wrap">
                        <div class="row">
                            <div class="col-12 col-md-6"></div>
                            <div class="col-12 col-md-6 prod05-show__contentTitle__sideRight">
                                <h1 class="prod05-show__contentTitle__title">{{$product->title}}</h1>
                                <h3 class="prod05-show__contentTitle__subtitle">{{$product->subtitle}}</h3>
                                <hr class="prod05-show__contentTitle__line">
                            </div>
                        </div>
                    </div>
                    {{-- END .prod05-show__contentTitle__wrap --}}
                </div>
                {{-- END .prod05-show__content__container --}}
            </div>
            {{-- END .prod05-show__contentTitle --}}
            <div class="prod05-show__info">
                <div class="prod05-show__info__container container">
                    <div class="row">
                        <div class="col-12 col-md-6 prod05-show__info__gallery">
                            <div id="receiveGallery">
                                <div class="prod05-show__info__gallery__wrap">
                                    <img src="{{ asset('storage/'.$product->path_image) }}" width="100%" class="prod05-show__info__gallery__imgMain" alt="{{$product->title}}">
                                    @if ($galleryTypesFirst)
                                        <div class="prod05-show__info__gallery__carousel">
                                            @foreach ($galleryTypesFirst->galleries as $galleryTypeGallery)
                                                <img src="{{ asset('storage/'.$galleryTypeGallery->path_image) }}" class="prod05-show__info__gallery__thumbnail" alt="{{$product->title}}">
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                            {{-- END .prod05-show__info__gallery__wrap --}}
                            <div class="prod05-show__info__gallery__options">
                                @foreach ($galleryTypes as $galleryType)
                                    <a href="javascript:void(0)" data-id="{{$galleryType->id}}" data-url="{{route('admin.prod05.getGallery')}}" class="prod05-show__info__gallery__options__item {{$galleryTypesFirst->id == $galleryType->id ? 'prod05-show__info__gallery__options__item--active' : ''}}"><span style="background-color: {{$galleryType->color}}"></span></a>
                                @endforeach
                            </div>
                        </div>
                        {{-- END .prod05-show__info__gallery --}}
                        <div class="col-12 col-md-6 prod05-show__info__description">
                            {!! $product->text !!}
                            <a href="#" class="prod05-show__info__description__cta">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="31px" class="me-2" alt="">
                                CTA
                            </a>
                        </div>
                        {{-- END .prod05-show__info__description --}}
                    </div>
                    {{-- END .row --}}
                </div>
                {{-- END .container --}}
            </div>
            {{-- END .prod05-show__content__info --}}
            <div class="prod05-show__galleries prod05-show__galleries__carousel row justify-content-center">
                @foreach ($galleriesSection as $gallerySection)
                    <a href="{{ asset('storage/'.$gallerySection->path_image) }}" class="col px-0" data-fancybox="titulo-do-produto">
                        <img src="{{ asset('storage/'.$gallerySection->path_image) }}" width="100%" class="prod05-show__galleries__thumbnail" alt="{{$product->title}}">
                    </a>
                @endforeach
            </div>
            {{-- END .prod05-show__galleries --}}

            <div class="prod05-show__details">
                @if ($product->title_section_topic || $product->subtitle_section_topic)
                    <div class="prod05-show__details__header">
                        <div class="container">
                            <h4 class="prod05-show__details__header__title">{{$product->title_section_topic}}</h4>
                            <h4 class="prod05-show__details__header__subtitle">{{$product->subtitle_section_topic}}</h4>
                            <hr class="prod05-show__details__header__line">
                        </div>
                    </div>
                    {{-- END .prod05-show__details__header --}}
                @endif
                <div class="prod05-show__details__content">
                    <div class="container">
                        <ul class="prod05-show__details__content__nav-tabs nav nav-tabs mb-3">
                            @foreach ($topicCategories as $topicCategory)
                                <li class="prod05-show__details__content__nav-item nav-item" role="presentation">
                                    <button class="prod05-show__details__content__nav-link nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#{{Str::slug($topicCategory->title)}}" type="button" role="tab">
                                        {{$topicCategory->title}}
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    {{-- END .container --}}
                    <div class="prod05-show__details__content__tab-content tab-content" id="pills-tabContent">
                        @foreach ($topicCategories as $topicCategory)
                            <div class="prod05-show__details__content__tab-pane tab-pane fade show active" id="{{Str::slug($topicCategory->title)}}" role="tabpanel">
                                <div class="container">
                                    <div class="prod05-show__details__content__accordion accordion">
                                        @foreach ($topicCategory->topics as $key => $topic)
                                            <div class="prod05-show__details__content__accordion-item accordion-item">
                                                <button class="prod05-show__details__content__accordion-button accordion-button {{$key<>0?'collapsed':''}}" type="button" data-bs-toggle="collapse" data-bs-target="#topic-{{$topic->id}}" aria-expanded="true">
                                                    {{$topic->title}}
                                                </button>
                                                <div id="topic-{{$topic->id}}" class="prod05-show__details__content__accordion-collapse accordion-collapse collapse {{$key==0?'show':''}}">
                                                    <div class="accordion-body">
                                                        {!! $topic->text !!}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        {{-- END .prod05-show__details__content__accordion-item --}}
                                    </div>
                                    {{-- END .prod05-show__details__content__accordion --}}
                                </div>
                                {{-- END .container --}}
                            </div>
                        @endforeach
                        {{-- END .prod05-show__details__content__tab-pane --}}
                    </div>
                    {{-- END .prod05-show__details__content__tab-content --}}
                </div>
                {{-- END .prod05-show__details__content --}}
            </div>
            {{-- END .prod05-show__details --}}
        </main>
    </section>
    {{-- END .prod05-show --}}

    {{-- Finish Content page Here --}}
    @foreach ($sections as $section)
        {!!$section!!}
    @endforeach
@endsection
