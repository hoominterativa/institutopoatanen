@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    <main id="root">
        <section id="COTA01" class="cota01-show container-fluid px-0">
            @if ($contact->title_banner || $contact->description_banner)
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
                        <div class="cota01-show__form-section__form col-12 {{$contact->topicsForm->count()?'col-lg-7':''}}">
                            @if ($contact->title_form || $contact->description_form)
                                <div class="cota01-show__form__header">
                                    <h2 class="cota01-show__form__header__title">{{$contact->title_form}}</h2>
                                    <p class="cota01-show__form__header__paragraph">{{$contact->description_form}}</p>
                                </div>
                            @endif
                            {!! Form::open(['route' => 'home', 'method' => 'post', 'class'=>'cota01-show__form__item parsley-validate d-table w-100']) !!}
                                <input type="hidden" name="target_lead" value="{{$contact->title_page}}">
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
                                    <div class="cota01-show__form__compliance form-check d-flex align-items-center">
                                        {!! Form::checkbox('term_accept', 1, null, ['class'=>'form-check-input me-1', 'id'=> 'term_accept', 'required'=>true]) !!}
                                        {!! Form::label('term_accept', 'Aceito os termos descritos na ', ['class'=>'form-check-label']) !!}
                                        <a href="{{$compliance->link??'#'}}" target="_blank" class="cota01-show__form__compliance__link ms-1">Política de Privacidade</a>
                                    </div>
                                    <button type="submit" class="cota01-show__form__item__submit ms-auto">
                                        <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" width="26" class="icon__button me-2" alt="">
                                        {{$contact->title_button_form}}
                                    </button>
                                </div>
                            {!! Form::close() !!}
                        </div>
                        {{-- END .cota01-show__form --}}
                        @if ($contact->topicsForm->count())
                            <div class="cota01-show__topics-form col-12 col-lg-5">
                                @foreach ($contact->topicsForm as $topicForm)
                                    <div class="cota01-show__topics-form__item d-flex align-items-center">
                                        <img src="{{asset('storage/'.$topicForm->path_image_icon)}}" class="cota01-show__topics-form__icon" width="26" alt="{{$topicForm->title}}">
                                        <div class="cota01-show__topics-form__description">
                                            <h4 class="cota01-show__topics-form__title">{{$topicForm->title}}</h4>
                                            <p class="cota01-show__topics-form__paragraph">{{$topicForm->description}}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            {{-- END .cota01-show__topics-form --}}
                        @endif
                    </div>
                    {{-- END .row --}}
                </div>
                {{-- END .container --}}
            </div>
            {{-- END. cota01-show__form__section --}}
            @if ($contact->topicsSection->count())
                <div class="cota01-show__topics-section">
                    <div class="container">
                        <div class="row">
                            <div class="cota01-show__topics col-12 col-sm-8">
                                <div class="row">
                                    @foreach ($contact->topicsSection as $topicSection)
                                        <div class="col-12 col-lg-6">
                                            <div class="cota01-show__topics__item d-flex align-items-center">
                                                <img src="{{asset('storage/'.$topicSection->path_image_icon)}}" width="26" class="cota01-show__topics__icon" alt="{{$topicSection->title}}">
                                                <div class="cota01-show__topics__description">
                                                    <h4 class="cota01-show__topics__title">{{$topicSection->title}}</h4>
                                                    <p class="cota01-show__topics__paragraph">{{$topicSection->description}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <img src="{{asset('storage/'.$contact->path_image_section_topic)}}" class="cota01-show__topics__image col-12 col-sm-4" alt="">
                        </div>
                        {{-- END .row --}}
                    </div>
                    {{-- END .container --}}
                </div>
                {{-- END .cota01-show__topics-section --}}
            @endif
        </section>
    </main>
    {{-- END #root --}}

    {{-- Finish Content page Here --}}
    @foreach ($sections as $section)
        {!!$section!!}
    @endforeach
@endsection
