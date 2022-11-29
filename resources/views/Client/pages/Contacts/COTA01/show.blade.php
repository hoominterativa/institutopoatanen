@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
        <main id="root">
            <section id="COTA01" class="cota01-show container-fluid px-xl-0">
                @if ($contact->path_image_banner || $contact->title_banner || $contact->description_banner)
                    <header class="cota01-show__banner" style="background-image: ur({{asset('storage/'.$contact->path_image_banner)}})">
                        <div class="container">
                            <h2 class="cota01-show__banner__title">{{$contact->title_banner}}</h2>
                            <p class="cota01-show__banner__paragraph">{{$contact->description_banner}}</p>
                        </div>
                    </header>
                    {{-- END .cota01-show__header --}}
                @endif
                <div class="cota01-show__form-section">
                    <div class="container">
                        @if ($contact->title_section || $contact->description_section)
                            <div class="cota01-show__form-section__header">
                                <h2 class="cota01-show__form-section__title">{{$contact->title_section}}</h2>
                                <p class="cota01-show__form-section__paragraph">{{$contact->description_section}}</p>
                            </div>
                        @endif
                        <div class="row">
                            <div class="cota01-show__form-section__form col-12 col-sm-7">
                                @if ($contact->title_section || $contact->description_section)
                                    <div class="cota01-show__form__header">
                                        <h2 class="cota01-show__form__header__title">{{$contact->title_section}}</h2>
                                        <p class="cota01-show__form__header__paragraph">{{$contact->description_section}}</p>
                                    </div>
                                @endif
                                {!! Form::open(['route' => 'home', 'method' => 'post', 'class'=>'cota01-show__form__item parsley-validate d-table w-100']) !!}
                                    <div class="row">
                                        @foreach ($inputs as $name => $input)
                                            <div class="cota01-show__form__item__input col-12 {{$input->type<>'textarea'?'col-sm-6':''}}">
                                                @include('Client.Components.inputs', [
                                                    'name' => $name,
                                                    'options' => $input->option,
                                                    'placeholder' => $input->placeholder,
                                                    'type' => $input->type
                                                ])
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="cota01-show__form__compliance form-check">
                                            {!! Form::checkbox('term_accept', 1, null, ['class'=>'form-check-input', 'id'=> 'term_accept']) !!}
                                            {!! Form::label('term_accept', 'Aceito os termos descritos na ', ['class'=>'form-check-label']) !!}
                                            <a href="">Política de Privacidade</a>
                                        </div>
                                        {!! Form::button('Enviar', ['class'=>'btn btn-primary ms-auto', 'type' => 'submit']) !!}
                                    </div>
                                {!! Form::close() !!}
                            </div>
                            {{-- END .cota01-show__form --}}
                            <div class="cota01-show__form-section__topics-form col-12 col-sm-5">
                                @foreach ($contact->topicsForm as $topicForm)
                                    <div class="cota01-show__topics-form__item d-flex align-items-center">
                                        <img src="{{asset('storage/'.$topicForm->path_image_icon)}}" width="26" alt="{{$topicForm->title}}">
                                        <div class="cota01-show__topics-form__description">
                                            <h4 class="cota01-show__topics-form__title">{{$topicForm->title}}</h4>
                                            <p class="cota01-show__topics-form__paragraph">{{$topicForm->description}}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            {{-- END .cota01-show__topics-form --}}
                        </div>
                        {{-- END .row --}}
                    </div>
                    {{-- END .container --}}
                </div>
                {{-- END. cota01-show__form__section --}}

                <div class="cota01-show__topics-section">
                    <div class="container">
                        <div class="row">
                            <div class="cota01-show__topics-section col-12 col-sm-7">
                                @foreach ($contact->topicsSection as $topicSection)
                                    <div class="cota01-show__topics-section__item d-flex align-items-center">
                                        <img src="{{asset('storage/'.$topicSection->path_image_icon)}}" width="26" alt="{{$topicSection->title}}">
                                        <div class="cota01-show__topics-section__description">
                                            <h4 class="cota01-show__topics-section__title">{{$topicSection->title}}</h4>
                                            <p class="cota01-show__topics-section__paragraph">{{$topicSection->description}}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <img src="{{asset('storage/'.$contact->path_image_section_topic)}}" class="cota01-show__topics-section__image col-12 col-sm-5" alt="">
                        </div>
                        {{-- END .row --}}
                    </div>
                    {{-- END .container --}}
                </div>
                {{-- END .cota01-show__topics-section --}}
            </section>
        </main>
        {{-- END #root --}}
    {{-- Finish Content page Here --}}
    @foreach ($sections as $section)
        {!!$section!!}
    @endforeach
@endsection
