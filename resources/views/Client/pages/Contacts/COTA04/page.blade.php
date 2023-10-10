@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    @if ($contact)
        <section id="cota04" class="cota04">
            <div class="container-fluid px-0">
                <header class="cota04__header d-flex flex-column align-items-center justify-content-center"
                    style="background-image: url({{ asset('storage/' . $contact->path_image_banner_desktop) }}); background-color: {{ $contact->background_color_banner }};">
                    @if ($contact->path_image_banner_desktop)
                        <div class="cota04__header__mask"></div>
                    @endif
                    <div class="container container--cota04-page-header">
                        @if ($contact->title_banner || $contact->subtitle_banner)
                            <h2 class="cota04__header__title d-block">{{$contact->title_banner}}</h2>
                            <h3 class="cota04__header__subtitle d-block">{{$contact->subtitle_banner}}</h3>
                            <hr class="cota04__header__line mb-0">
                        @endif
                    </div>
                </header>
                {{-- fim-cota04__boxForm --}}
                <div class="cota04__boxForm"
                    style="background-image: url({{ asset('storage/uploads/tmp/bg-slide.png') }}); background-color: ;">
                    <div class="container container--boxForm">
                        <div class="row justify-content-center">
                            <div class="cota04__boxForm__item">
                                <div class="cota04__boxForm__item__content">
                                    @if ($contact->path_image_content)
                                        <div class="cota04__boxForm__item__content__image mx-auto">
                                            <img src="{{ asset('storage/' . $contact->path_image_content) }}" class="w-100 h-100" alt="Imagem Perfil">
                                        </div>
                                    @endif
                                    <div class="cota04__boxForm__item__content__description">
                                        @if ($contact->title_content || $contact->subtitle_content)
                                            <h2 class="cota04__boxForm__item__content__description__title">{{$contact->title_content}}</h2>
                                            <h3 class="cota04__boxForm__item__content__description__subtitle">{{$contact->subtitle_content}}</h3>
                                            <hr class="cota04__boxForm__item__content__description__line">
                                        @endif
                                        @if ($contact->description_content)
                                            <div class="cota04__boxForm__item__content__description__paragraph">
                                                <p>
                                                    {!! $contact->description_content !!}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- fim-cota04__boxForm --}}
                {!! Form::open(['route' => 'lead.store', 'method' => 'post', 'files' => true, 'class'=>'send_form_ajax  parsley-validate d-table w-100']) !!}
                @foreach ($sectionss as $section)
                    <div class="cota04__form box" style="background-image: url({{ asset('storage/uploads/tmp/') }}); background-color: ;">
                        <div class="container">
                            <div class="cota04__form__header">
                                @if ($section->title)
                                    <h2 class="cota04__form__header__title">{{$section->title}}</h2>
                                    <hr class="cota04__form__header__line">
                                @endif
                                <div class="cota04__form__header__paragraph">
                                    <p>{!! $section->description !!}</p>
                                </div>
                            </div>
                            <div class="cota04__form__category">
                                <ul class="nav">
                                    @foreach ($section->categories as $category)
                                        <li>
                                            <button class="tab" data-tab="tab{{$category->id}}">
                                                @if ($category->path_image)
                                                    <img src="{{asset('storage/' . $category->path_image)}}" alt="" class="me-3 transition">
                                                @endif
                                                {{$category->title}}
                                            </button>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="cota04__form__dropdown">
                                    <div class="accordion accordion-flush" id="accordionFlushExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#flush-collapse-1" aria-expanded="false"
                                                    aria-controls="flush-collapseOne">
                                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="prod05-categories__dropdown-mobile__item__icon">
                                                    Categorias
                                                </button>
                                            </h2>
                                            <div id="flush-collapse-1" class="accordion-collapse collapse"
                                                data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body">
                                                    <ul>
                                                        @foreach ($section->categories as $category)
                                                            <li>
                                                                <button class="tab" data-tab="tab{{$category->id}}">
                                                                    <img src="{{asset('storage/' . $category->path_image)}}" alt="" class="me-3 transition">
                                                                    {{$category->title}}
                                                                </button>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cota04__form__engInputs">
                                @foreach ($section->forms as $form)
                                    <div class="cota04__form__inputs tab-content tab{{$form->category_id}}">
                                        <div class="row">
                                            @foreach (json_decode($form->inputs_form) as $name => $input)
                                                @include('Client.Components.inputs', [
                                                    'name' => $name,
                                                    'options' => $input->option,
                                                    'placeholder' => $input->placeholder,
                                                    'type' => $input->type,
                                                    'required' => isset($input->required) ? $input->required : false,
                                                ])
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                                {{-- fim-cota04__form__inputs --}}
                            </div>
                            {{-- cota04__form__engInputs --}}
                        </div>
                    </div>
                @endforeach
                {{-- fim-cota04__form --}}
                <div class="cota04__form__action">
                    <div class="cota04__form__action__content">
                        <div class="cota04__form__action__boxAction d-flex align-items-center">
                            <div class="cota04__form__action__boxAction__image">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="transition">
                            </div>
                            <div class="cota04__form__action__boxAction__description">
                                @if ($contact->title_compliance || $contact->subtitle_compliance)
                                    <h4 class="cota04__form__action__boxAction__description__title">{{$contact->title_compliance}}</h4>
                                    <h5 class="cota04__form__action__boxAction__description__subtitle">{{$contact->subtitle_compliance}}</h5>
                                @endif
                            </div>
                        </div>
                        <div class="cota04__form__compliance form-check d-flex align-items-center">
                            {!! Form::checkbox('term_accept', 1, null, ['class' => 'form-check-input me-1', 'id' => 'term_accept', 'required' => true]) !!}
                            {!! Form::label('term_accept', 'Aceito os termos descritos na ', ['class' => 'form-check-label']) !!}
                            <a href="{{ getUri($compliance->link ?? '#') }}" target="_blank" class="cota04__form__compliance__link ms-1">Política de Privacidade</a>
                        </div>
                        <button type="submit" class="cota04__form__inputs__formIput__input-submit ms-auto">
                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="transition">
                            {{ $contact->title_button_form }}
                        </button>
                    </div>
                </div>
                {{-- fim-cota04__form__action --}}
                {!! Form::close() !!}
                {{-- fim-form --}}
            </div>
        </section>
        {{-- Finish Content page Here --}}
        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    @endif
@endsection

