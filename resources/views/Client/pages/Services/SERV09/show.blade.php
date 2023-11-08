@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<main id="root">
    <section class="serv09-show">
        <header class="">
            <div class="">
                @if ($service->active_banner)
                    <div class=""
                        style="background-image: url({{ asset('storage/' . $service->path_image_desktop) }});  background-color: {{ $service->background_color }};">
                        @if ($service->title_banner || $service->subtitle_banner)
                            <div class="">
                                <h4 class="">{{ $service->subtitle_banner }}</h4>
                                <h3 class="">{{ $service->title_banner }}</h3>
                                <hr class="">
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </header>

        <main class="">
            <div>
                <div class="">
                    <div class="">
                        @if ($service->title || $service->subtitle)
                            <h3 class="">{{ $service->title }}</h3>
                            <h4 class="">{{ $service->subtitle }}</h4>
                            <hr class="">
                        @endif
                        @if ($service->text)
                            <div class="">
                                {!! $service->text !!}
                            </div>
                        @endif
                    </div>
                </div>
                @if ($topics->count())
                    <div class="">
                        <div class="">
                            @foreach ($topics as $topic)
                                <div class="">
                                    @if ($topic->path_image)
                                        <div class="">
                                            <img src="{{ asset('storage/' . $topic->path_image) }}" alt="Imagem" class="">
                                        </div>
                                    @endif
                                    <div class="">
                                        @if ($topic->title)
                                            <h4 class="">{{ $topic->title }}</h4>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                <aside class="">
                    <div>
                        <h4>{{$service->title_info}}</h4>
                        @if ($service->price)
                            <h3 class=""><span>R$</span>{{number_format($service->price, 2, ',', '.')}} <span>por dia</span></h3>
                        @endif
                        @if ($service->informations)
                            <div class="">
                                {!! $service->informations !!}
                            </div>
                        @endif
                    </div>
                    @if ($service->link)
                        <div>
                            <a href="{{getUri($service->link)}}" target="_blank">
                                Reservar agora
                            </a>
                        </div>
                    @else
                        <div class="">
                            {!! Form::model(['column_preco_text' => 'R$ ' . number_format($service->price, 2, ',', '.'),],[
                                'route' => 'lead.store',
                                'method' => 'post',
                                'files' => true,
                                'class' => 'send_form_ajax serv09-form__form d-flex w-100 flex-column align-items-stretch form-contact parsley-validate align-items-center',
                            ]) !!}
                            <div class="serv09-form__form__inputs d-flex flex-column w-100 align-items-stretch">
                                <input type="hidden" name="target_lead" value="{{$service->title}} - {{$service->subtitle}}">
                                <input type="hidden" name="target_send" value="{{ base64_encode('teste@teste.com') }}">

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
                            <button type="submit" class="">
                                Reservar agora
                            </button>
                            {!! Form::close() !!}
                        </div>
                    @endif
                </aside>
            </div>
            @if ($galleries->count())
                <div class="">
                    <div class="">
                        @foreach ($galleries as $gallery)
                            <div class="">
                                @if ($gallery->path_image)
                                    <div class="">
                                        <img src="{{ asset('storage/' . $gallery->path_image) }}" alt="Imagem" class="">
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            @if ($contents->count())
                <div class="">
                    <div class="">
                        @foreach ($contents as $content)
                            <div class="">
                                @if ($content->title)
                                    <h4 class="">{{ $content->title }}</h4>
                                @endif
                                @if ($content->text)
                                    <p class="">
                                        {!! $content->text !!}
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            @if ($feedbacks->count())
                <div class="">
                    @if ($section->active_feedback)
                        <div class="">
                            @if ($section->title_feedback)
                                <h4 class="">{{ $section->title_feedback }}</h4>
                                <hr class="">
                            @endif
                        </div>
                    @endif
                    <div class="">
                        @foreach ($feedbacks as $feedback)
                            <div class="">
                                <div class="">
                                    @if ($feedback->text)
                                        <p class="">
                                            {!! $feedback->text !!}
                                        </p>
                                    @endif
                                </div>
                                <div class="">
                                    @if ($feedback->path_image)
                                        <div class="">
                                            <img src="{{ asset('storage/' . $feedback->path_image) }}" alt="Imagem" class="">
                                        </div>
                                    @endif
                                </div>
                                <div class="">
                                    @if ($feedback->name)
                                        <h4 class="">{{ $feedback->name }}</h4>
                                    @endif
                                    @if ($feedback->profession)
                                        <h4 class="">{{ $feedback->profession }}</h4>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </main>
        <div class="">
            <div class="">
                @if ($categories->count())
                    <div class="">
                        <ul class="">
                            @foreach ($categories as $category)
                                <li class="serv09-categories__list__item {{isset($category->selected) ? 'active':''}}">
                                    <a href="{{route('serv09.category.page', ['SERV09ServicesCategory' =>$category->slug])}}">
                                        <img src="{{ asset('storage/' . $category->path_image) }}" alt="" class="">
                                        {{$category->title}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
        <div class="">
            <div class="">
                @foreach ($services as $service)
                    <article class="">
                        <div class="">
                            <div class="">
                                <div class="">
                                    <h3 class="">{{$service->title}}</h3>
                                    <h4 class="">{{$service->subtitle}}</h4>
                                    <h3 class=""><span>R$</span>{{number_format($service->price, 2, ',', '.')}}</h3>
                                </div>
                                <div class="">
                                    <ul class="">
                                       <p class="">
                                            {!! $service->description !!}
                                        </p>
                                    </ul>
                                </div>
                                @if ($service->topics->count())
                                    <div>
                                        @foreach ($service->topics as $topic)

                                            <div>
                                                <img src="{{ asset('storage/' . $topic->path_image) }}" alt="" class="">
                                                <h4>{{$topic->title}}</h4>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                        </div>
                        <div>
                            <img src="{{ asset('storage/' . $service->path_image) }}" alt="" class="">
                            <a href="{{route('serv09.page.content', ['SERV09ServicesCategory' => $service->categories->slug, 'SERV09Services' => $service->slug])}}">
                                <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="">
                                CTA
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>

    </section>
    {{-- Finish Content page Here --}}
    @foreach ($sections as $section)
        {!! $section !!}
    @endforeach
</main>
{{-- Finish Content page Here --}}
@endsection
