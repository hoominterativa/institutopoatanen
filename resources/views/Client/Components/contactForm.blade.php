@switch($model)
    @case('FORM01')
    <section class="form01 container-fluid px-0" style="background-image: url({{asset('storage/uploads/tmp/bg-slide.jpg')}})">
        <div class="container container--pd ">
            <div class="row mx-auto px-0 d-flex justify-content-between align-items-center">
                <div class="form01__boxLeft col-sm-7">
                    <div class="form01__boxLeft__content">
                        <h4 class="form01__boxLeft__content__title">{{$content->title->value}}</h4>
                        <div class="form01__boxLeft__content__paragraph">
                            <p>
                                {{$content->description->value}}
                            </p>
                        </div>
                    </div>
                    <div class="w-100 px-0">
                        {!! Form::open(['route' => 'lead.store', 'method' => 'post', 'files' => true, 'class'=>'send_form_ajax form01__boxLeft__form form-contact parsley-validate d-flex row mx-0']) !!}
                            <input type="hidden" name="target_lead" value="TITULO COM DESCRIÇÃO Subtitulo">
                            <input type="hidden" name="target_send" value="{{base64_encode($contactForm->email)}}">
                            @foreach ($inputs as $name => $input)
                                @include('Client.Components.inputs', [
                                    'name' => $name,
                                    'options' => $input->option,
                                    'placeholder' => $input->placeholder,
                                    'required' => $input->required??false,
                                    'type' => $input->type
                                ])
                            @endforeach
                            <label for="" class="form01__boxLeft__form__checkbox-label">
                                {!! Form::checkbox('term_accept', 1, null, [
                                    'class' => 'form-check-input me-1',
                                    'id' => 'term_accept',
                                    'required' => true,
                                ]) !!}
                                {!! Form::label('term_accept', 'Aceito os termos descritos na ', ['class' => 'form-check-label']) !!}
                                <a href="{{ $compliance->link ?? '#' }}" target="_blank" class="">Política de Privacidade</a>
                            </label>
                            <button type="submit" class="form01__boxLeft__form__cta">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="Ícone">
                                CTA
                            </button>
                        {!! Form::close() !!}
                    </div>
                </div>
                <div class="form01__boxRight col-sm-5 d-flex justify-content-center align-items-end px-0">
                    <div class="form01__boxRight__image">
                        <img src="{{asset('storage/'.$content->path_image_content->value)}}" alt="Imagem form">
                    </div>
                </div>
            </div>
        </div>
    </section>
    @break
    @case('FORM02')
        <section class="form02 container-fluid px-0" style="background-image: url({{asset('storage/uploads/tmp/bg-slide.jpg')}})">
            <div class="container container--pd">
                <div class="row mx-0">
                    <div class="form02__content col-lg-8 px-0 d-flex justify-content-between align-items-center">
                        <h2 class="form02__content__title">{{$content->title->value}}</h2>
                        <div class="form02__content__paragraph">
                            <p>
                                {{$content->description->value}}
                            </p>
                        </div>

                        {!! Form::open(['route' => 'lead.store', 'method' => 'post', 'files' => true, 'class'=>'send_form_ajax form02__content__form form-contact parsley-validate align-items-center']) !!}
                            <div class="form02__content__inputs d-flex justify-content-between">
                                <input type="hidden" name="target_lead" value="TITULO COM DESCRIÇÃO Subtitulo">
                                <input type="hidden" name="target_send" value="{{base64_encode($contactForm->email)}}">
                                @php
                                    $i=1;
                                @endphp
                                @foreach ($inputs as $name => $input)
                                    @if ($i<=3)
                                        @include('Client.Components.inputs', [
                                            'name' => $name,
                                            'options' => $input->option,
                                            'placeholder' => $input->placeholder,
                                            'required' => $input->required??false,
                                            'type' => $input->type,
                                            'class' => 'col-md-8'
                                        ])
                                    @endif

                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                            </div>
                        {!! Form::close() !!}

                        <a href="#lightbox-form" data-fancybox="fomulario-de-inscricao" class="form02__content__cta data-fancybox" >
                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="Ícone">
                            CTA
                        </a>

                        <div id="lightbox-form" class="lifo" style="display: none;">
                            <div class="lifo__boxLeft col-lg-4 px-0">
                                <h2 class="lifo__boxLeft__title">{{$content->title_inner->value}}</h2>
                                <div class="lifo__boxLeft__paragraph">
                                    <p>
                                        {!!$content->description_inner->value!!}
                                    </p>
                                </div>
                                {!! Form::open(['route' => 'lead.store', 'method' => 'post', 'files' => true, 'class'=>'send_form_ajax lifo__boxLeft__form form-contact parsley-validate align-items-center']) !!}
                                    <div class="lifo__boxLeft__inputs d-flex justify-content-between">
                                        <input type="hidden" name="target_lead" value="TITULO COM DESCRIÇÃO Subtitulo">
                                        <input type="hidden" name="target_send" value="{{base64_encode($contactForm->email)}}">
                                        @foreach ($inputs as $name => $input)
                                            @include('Client.Components.inputs', [
                                                'name' => $name,
                                                'options' => $input->option,
                                                'placeholder' => $input->placeholder,
                                                'required' => $input->required??false,
                                                'type' => $input->type,
                                                'class' => 'col-md-8'
                                            ])
                                        @endforeach
                                        <label for="" class="form02-form__form__checkbox-label">
                                            {!! Form::checkbox('term_accept', 1, null, [
                                                'class' => 'form-check-input me-1',
                                                'id' => 'term_accept',
                                                'required' => true,
                                            ]) !!}
                                            {!! Form::label('term_accept', 'Aceito os termos descritos na ', ['class' => 'form-check-label']) !!}
                                            <a href="{{ $compliance->link ?? '#' }}" target="_blank"
                                                class="">Política de Privacidade</a>
                                        </label>
                                    </div>
                                    <button type="submit" class="lifo__boxRight__cta">
                                        <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="Ícone">
                                        CTA
                                    </button>
                                {!! Form::close() !!}
                            </div>
                            <div class="lifo__boxRight col-lg-8 px-0 d-flex justify-content-between align-items-center">
                                <div class="lifo__boxRight__image">
                                    <img src="{{asset('storage/'.$content->path_image_inner->value)}}" width="300" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @break
    @case('FORM03')
    <section class="form03 container-fluid px-0" style="background-image: url({{asset('storage/' . $content->path_image_inner->value )}})">
        <div class="container container--pd">
            <div class="row mx-0 justify-content-between">
                <div class="form03__boxLeft d-flex flex-column">
                    <h2 class="form03__boxLeft__title">{{$content->title->value}}</h2>
                    <h2 class="form03__boxLeft__subtitle">{{$content->subtitle->value}}</h3>
                    <div class="form03__boxLeft__paragraph">
                        <p>
                            {!!$content->description->value!!}
                        </p>
                    </div>
                    <div class="form03__boxLeft__buttons">
                        @if ($socials)
                            @foreach ($socials as $social)
                                <a class="form03__boxLeft__buttons__cta" href="{{ $social->link }}" target="_blank">
                                    <img src="{{asset('storage/' . $social->path_image_icon)}}" alt="">
                                    {{ $social->title }}
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="form03__boxRight d-flex flex-column">
                    <h2 class="form03__boxRight__title">{{$content->title_inner->value}}</h2>
                    <div class="form03__boxRight__paragraph">
                        <p>
                            {!!$content->description_inner->value!!}
                        </p>
                    </div>

                    {!! Form::open(['route' => 'lead.store', 'method' => 'post', 'files' => true, 'class'=>'send_form_ajax form03__boxRight__form form-contact parsley-validate align-items-center']) !!}
                        <div class="form03__boxRight__inputs d-flex justify-content-between">
                            <input type="hidden" name="target_lead" value="TITULO COM DESCRIÇÃO Subtitulo">
                            <input type="hidden" name="target_send" value="{{base64_encode($contactForm->email)}}">
                            @foreach ($inputs as $name => $input)
                                @include('Client.Components.inputs', [
                                    'name' => $name,
                                    'options' => $input->option,
                                    'placeholder' => $input->placeholder,
                                    'required' => $input->required??false,
                                    'type' => $input->type,
                                    'class' => 'col-md-8'
                                ])
                            @endforeach
                            <label for="" class="form03-form__form__checkbox-label">
                                {!! Form::checkbox('term_accept', 1, null, [
                                    'class' => 'form-check-input me-1',
                                    'id' => 'term_accept',
                                    'required' => true,
                                ]) !!}
                                {!! Form::label('term_accept', 'Aceito os termos descritos na ', ['class' => 'form-check-label']) !!}
                                <a href="{{ $compliance->link ?? '#' }}" target="_blank"
                                    class="">Política de Privacidade</a>
                            </label>
                        </div>
                        <button type="submit" class="form03__boxRight__cta">
                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="Ícone">
                            CTA
                        </button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>
    @break
    @case('FORM101')
        <section class="form101 container-fluid px-0" style="background-image: url({{asset('storage/uploads/tmp/bg-slide.jpg')}})">
            <div class="container container--pd">
                <div class="row mx-0">
                    <div class="form101__content col-lg-6 px-0">
                        <h2 class="form101__content__subtitle text-center">{{$content->subtitle->value}}</h2>
                        <h4 class="form101__content__title">{{$content->title->value}}</h4>
                        <div class="form101__content__paragraph">
                            <p>
                                {{$content->description->value}}
                            </p>
                        </div>
                    </div>
                    <div class="form101__content col-lg-6 px-0">
                        {!! Form::open(['route' => 'lead.store', 'method' => 'post', 'files' => true, 'class'=>'send_form_ajax form101__content__form form-contact parsley-validate d-flex row mx-0']) !!}
                            <input type="hidden" name="target_lead" value="TITULO COM DESCRIÇÃO Subtitulo">
                            <input type="hidden" name="target_send" value="{{base64_encode($contactForm->email)}}">
                            @foreach ($inputs as $name => $input)
                                @include('Client.Components.inputs', [
                                    'name' => $name,
                                    'options' => $input->option,
                                    'placeholder' => $input->placeholder,
                                    'required' => $input->required??false,
                                    'type' => $input->type
                                ])
                            @endforeach
                            <label for="" class="form101-form__form__checkbox-label">
                                {!! Form::checkbox('term_accept', 1, null, [
                                    'class' => 'form-check-input me-1',
                                    'id' => 'term_accept',
                                    'required' => true,
                                ]) !!}
                                {!! Form::label('term_accept', 'Aceito os termos descritos na ', ['class' => 'form-check-label']) !!}
                                <a href="{{ $compliance->link ?? '#' }}" target="_blank"
                                    class="">Política de Privacidade</a>
                            </label>
                            <button type="submit" class="form101__content__cta">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="Ícone">
                                CTA
                            </button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </section>
    @break
    @case('FORM102')
    <section class="form102 container-fluid px-0" style="background-image: url({{asset('storage/uploads/tmp/bg-slide.jpg')}})">
        <div class="container container--pd">
            <div class="row mx-0">
                <div class="form102__content col-lg-4 px-0">
                    <h2 class="form102__content__subtitle">{{$content->title->value}}</h2>
                </div>
                <div class="form102__content col-lg-8 px-0 d-flex justify-content-between align-items-center">
                    {!! Form::open(['route' => 'lead.store', 'method' => 'post', 'files' => true, 'class'=>'send_form_ajax form102__content__form form-contact parsley-validate align-items-center']) !!}
                        <div class="form102__content__inputs d-flex justify-content-between">
                            <input type="hidden" name="target_lead" value="TITULO COM DESCRIÇÃO Subtitulo">
                            <input type="hidden" name="target_send" value="{{base64_encode($contactForm->email)}}">
                            @foreach ($inputs as $name => $input)
                                @include('Client.Components.inputs', [
                                    'name' => $name,
                                    'options' => $input->option,
                                    'placeholder' => $input->placeholder,
                                    'required' => $input->required??false,
                                    'type' => $input->type,
                                    'class' => 'col-md-8'
                                ])
                            @endforeach
                            <label for="" class="form102__content__form__checkbox-label">
                                {!! Form::checkbox('term_accept', 1, null, [
                                    'class' => 'form-check-input me-1',
                                    'id' => 'term_accept',
                                    'required' => true,
                                ]) !!}
                                {!! Form::label('term_accept', 'Aceito os termos descritos na ', ['class' => 'form-check-label']) !!}
                                <a href="{{ $compliance->link ?? '#' }}" target="_blank"
                                    class="">Política de Privacidade</a>
                            </label>
                        </div>
                        <button type="submit" class="form102__content__cta">
                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="Ícone">
                            CTA
                        </button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>
    @break
@endswitch
