@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}

        <section id="cota04" class="cota04">
            <div class="container-fluid px-0">
                <header class="cota04__header d-flex flex-column align-items-center justify-content-center"
                    style="background-image: url({{ asset('uploads/tmp/') }}); background-color: ;">
                
                    <div class="cota04__header__mask"></div>
    
                    <div class="container container--cota04-page-header">
                        <h2 class="cota04__header__title d-block">Titulo Pagina</h2>
                        <h3 class="cota04__header__subtitle d-block">Subtítulo</h3>
                        <hr class="cota04__header__line mb-0">
                    </div>
                </header>
                {{-- fim-cota04__boxForm --}}
                <div class="cota04__boxForm"
                    style="background-image: url({{ asset('storage/uploads/tmp/bg-slide.png') }}); background-color: ;">
                    <div class="container container--boxForm">
                        <div class="row justify-content-center">
                                <div class="cota04__boxForm__item">
                                    <div class="cota04__boxForm__item__content">
                                        <div class="cota04__boxForm__item__content__image mx-auto">
                                            <img src="{{ asset('storage/uploads/tmp/image-pmg.png') }}" class="w-100 h-100" alt="Imagem Perfil">
                                        </div>
                                        <div class="cota04__boxForm__item__content__description">
                                            <h2 class="cota04__boxForm__item__content__description__title">Titulo</h2>
                                            <h3 class="cota04__boxForm__item__content__description__subtitle">Subtitulo</h3>
                                            <hr class="cota04__boxForm__item__content__description__line">
                                            <div class="cota04__boxForm__item__content__description__paragraph">
                                                <p>
                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. 
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                {{-- fim-cota04__boxForm --}}
                {!! Form::open(['route' => 'lead.store', 'method' => 'post', 'files' => true, 'class'=>'send_form_ajax  parsley-validate d-table w-100']) !!}
                    <div class="cota04__form box"
                        style="background-image: url({{ asset('storage/uploads/tmp/') }}); background-color: ;">
                        <div class="container">
                            <div class="cota04__form__header">
                                <h2 class="cota04__form__header__title">Form Completo</h2>
                                <hr class="cota04__form__header__line">
                                <div class="cota04__form__header__paragraph">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non liberolor sit amet, consectetur adipiscing elit. Cras vel tortor</p>
                                </div>
                            </div>
                            <div class="cota04__form__category">
                                <ul class="nav">
                                    <li>
                                        <button class="tab" data-tab="tab1">
                                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="me-3 transition">
                                            Categoria
                                        </button>
                                    </li>
                                    <li>
                                        <button class="tab" data-tab="tab2">
                                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="me-3 transition">
                                            Categoria
                                        </button>
                                    </li>
                                    <li>
                                        <button class="tab" data-tab="tab3">
                                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="me-3 transition">
                                            Categoria
                                        </button>
                                    </li>
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
                                                        <li>
                                                            <button class="tab" data-tab="tab1">
                                                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="me-3 transition">
                                                                Categoria
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button class="tab" data-tab="tab2">
                                                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="me-3 transition">
                                                                Categoria
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button class="tab" data-tab="tab3">
                                                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="me-3 transition">
                                                                Categoria
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cota04__form__engInputs">
                                <div class="cota04__form__inputs tab-content tab1">
                                
                                    <div class="row">            
                                        @include('Client.Components.inputs', [
                                            'name' => 'Nome',
                                            'options' => '',
                                            'placeholder' => 'Nome',
                                            'type' => 'text',
                                            'required' => 'false',
                                        ])
                                        @include('Client.Components.inputs', [
                                            'name' => 'email',
                                            'options' => '',
                                            'placeholder' => 'E-mail',
                                            'type' => 'text',
                                            'required' => 'false',
                                        ])
                                        @include('Client.Components.inputs', [
                                            'name' => 'Telefone',
                                            'options' => '',
                                            'placeholder' => 'Telefone',
                                            'type' => 'text',
                                            'required' => 'false',
                                        ])
                                        @include('Client.Components.inputs', [
                                            'name' => 'Celular',
                                            'options' => '',
                                            'placeholder' => 'Celular',
                                            'type' => 'text',
                                            'required' => 'false',
                                        ])
                                    </div>
                                </div>
                                {{-- fim-cota04__form__inputs --}}
                                <div class="cota04__form__inputs tab-content tab2">
                                
                                    <div class="row">            
                                        @include('Client.Components.inputs', [
                                            'name' => 'email',
                                            'options' => '',
                                            'placeholder' => 'E-mail',
                                            'type' => 'text',
                                            'required' => 'false',
                                        ])
                                        @include('Client.Components.inputs', [
                                            'name' => 'email',
                                            'options' => '',
                                            'placeholder' => 'E-mail',
                                            'type' => 'text',
                                            'required' => 'false',
                                        ])
                                        @include('Client.Components.inputs', [
                                            'name' => 'email',
                                            'options' => '',
                                            'placeholder' => 'E-mail',
                                            'type' => 'text',
                                            'required' => 'false',
                                        ])
                                        @include('Client.Components.inputs', [
                                            'name' => 'email',
                                            'options' => '',
                                            'placeholder' => 'E-mail',
                                            'type' => 'text',
                                            'required' => 'false',
                                        ])
                                    </div>
                                </div>
                                {{-- fim-cota04__form__inputs --}}
                                <div class="cota04__form__inputs tab-content tab3">
                                
                                    <div class="row">            
                                        @include('Client.Components.inputs', [
                                            'name' => 'email',
                                            'options' => '',
                                            'placeholder' => 'E-mail',
                                            'type' => 'text',
                                            'required' => 'false',
                                        ])
                                        @include('Client.Components.inputs', [
                                            'name' => 'email',
                                            'options' => '',
                                            'placeholder' => 'E-mail',
                                            'type' => 'text',
                                            'required' => 'false',
                                        ])
                                        @include('Client.Components.inputs', [
                                            'name' => 'email',
                                            'options' => '',
                                            'placeholder' => 'E-mail',
                                            'type' => 'text',
                                            'required' => 'false',
                                        ])
                                        @include('Client.Components.inputs', [
                                            'name' => 'email',
                                            'options' => '',
                                            'placeholder' => 'E-mail',
                                            'type' => 'text',
                                            'required' => 'false',
                                        ])
                                    </div>
                                </div>
                                {{-- fim-cota04__form__inputs --}}
                            </div>
                            {{-- cota04__form__engInputs --}}
                        </div>
                    </div>
                    {{-- fim-cota04__form --}}
                    <div class="cota04__form box"
                        style="background-image: url({{ asset('storage/uploads/tmp/') }}); background-color: ;">
                        <div class="container">
                            <div class="cota04__form__header">
                                <h2 class="cota04__form__header__title">Form Completo</h2>
                                <hr class="cota04__form__header__line">
                                <div class="cota04__form__header__paragraph">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non liberolor sit amet, consectetur adipiscing elit. Cras vel tortor</p>
                                </div>
                            </div>
                            <div class="cota04__form__category">
                                <ul class="nav">
                                    <li>
                                        <button class="tab" data-tab="tab1">
                                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="me-3 transition">
                                            Categoria
                                        </button>
                                    </li>
                                    <li>
                                        <button class="tab" data-tab="tab2">
                                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="me-3 transition">
                                            Categoria
                                        </button>
                                    </li>
                                    <li>
                                        <button class="tab" data-tab="tab3">
                                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="me-3 transition">
                                            Categoria
                                        </button>
                                    </li>
                                </ul>

                                <div class="cota04__form__dropdown">
                                    <div class="accordion accordion-flush" id="accordionFlushExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#flush-collapse-2" aria-expanded="false"
                                                    aria-controls="flush-collapseOne">
                                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="" class="prod05-categories__dropdown-mobile__item__icon">
                                                    Categorias
                                                </button>
                                            </h2>
                                            <div id="flush-collapse-2" class="accordion-collapse collapse"
                                                data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body">
                                                    <ul>
                                                        <li>
                                                            <button class="tab" data-tab="tab1">
                                                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="me-3 transition">
                                                                Categoria
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button class="tab" data-tab="tab2">
                                                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="me-3 transition">
                                                                Categoria
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button class="tab" data-tab="tab3">
                                                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="me-3 transition">
                                                                Categoria
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cota04__form__engInputs">
                                <div class="cota04__form__inputs tab-content tab1">
                                
                                    <div class="row">            
                                        @include('Client.Components.inputs', [
                                            'name' => 'Nome',
                                            'options' => '',
                                            'placeholder' => 'Nome',
                                            'type' => 'text',
                                            'required' => 'false',
                                        ])
                                        @include('Client.Components.inputs', [
                                            'name' => 'email',
                                            'options' => '',
                                            'placeholder' => 'E-mail',
                                            'type' => 'text',
                                            'required' => 'false',
                                        ])
                                        @include('Client.Components.inputs', [
                                            'name' => 'Telefone',
                                            'options' => '',
                                            'placeholder' => 'Telefone',
                                            'type' => 'text',
                                            'required' => 'false',
                                        ])
                                        @include('Client.Components.inputs', [
                                            'name' => 'Celular',
                                            'options' => '',
                                            'placeholder' => 'Celular',
                                            'type' => 'text',
                                            'required' => 'false',
                                        ])
                                    </div>
                                </div>
                                {{-- fim-cota04__form__inputs --}}
                                <div class="cota04__form__inputs tab-content tab2">
                                
                                    <div class="row">            
                                        @include('Client.Components.inputs', [
                                            'name' => 'email',
                                            'options' => '',
                                            'placeholder' => 'E-mail',
                                            'type' => 'text',
                                            'required' => 'false',
                                        ])
                                        @include('Client.Components.inputs', [
                                            'name' => 'email',
                                            'options' => '',
                                            'placeholder' => 'E-mail',
                                            'type' => 'text',
                                            'required' => 'false',
                                        ])
                                        @include('Client.Components.inputs', [
                                            'name' => 'email',
                                            'options' => '',
                                            'placeholder' => 'E-mail',
                                            'type' => 'text',
                                            'required' => 'false',
                                        ])
                                        @include('Client.Components.inputs', [
                                            'name' => 'email',
                                            'options' => '',
                                            'placeholder' => 'E-mail',
                                            'type' => 'text',
                                            'required' => 'false',
                                        ])
                                    </div>
                                </div>
                                {{-- fim-cota04__form__inputs --}}
                                <div class="cota04__form__inputs tab-content tab3">
                                
                                    <div class="row">            
                                        @include('Client.Components.inputs', [
                                            'name' => 'email',
                                            'options' => '',
                                            'placeholder' => 'E-mail',
                                            'type' => 'text',
                                            'required' => 'false',
                                        ])
                                        @include('Client.Components.inputs', [
                                            'name' => 'email',
                                            'options' => '',
                                            'placeholder' => 'E-mail',
                                            'type' => 'text',
                                            'required' => 'false',
                                        ])
                                        @include('Client.Components.inputs', [
                                            'name' => 'email',
                                            'options' => '',
                                            'placeholder' => 'E-mail',
                                            'type' => 'text',
                                            'required' => 'false',
                                        ])
                                        @include('Client.Components.inputs', [
                                            'name' => 'email',
                                            'options' => '',
                                            'placeholder' => 'E-mail',
                                            'type' => 'text',
                                            'required' => 'false',
                                        ])
                                    </div>
                                </div>
                                {{-- fim-cota04__form__inputs --}}
                            </div>
                            {{-- cota04__form__engInputs --}}
                        </div>
                    </div>
                    {{-- fim-cota04__form --}}
                    <div class="cota04__form__action">
                        <div class="cota04__form__action__content">
                            <div class="cota04__form__action__boxAction d-flex align-items-center">
                                <div class="cota04__form__action__boxAction__image">
                                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="transition">
                                </div>
                                <div class="cota04__form__action__boxAction__description">
                                    <h4 class="cota04__form__action__boxAction__description__title">Titulo</h4>
                                    <h5 class="cota04__form__action__boxAction__description__subtitle">Subtitulo</h5>
                                </div>
                            </div>
                            <div class="cota04__form__compliance form-check d-flex align-items-center">
                                {!! Form::checkbox('term_accept', 1, null, ['class' => 'form-check-input me-1', 'id' => 'term_accept', 'required' => true]) !!}
                                {!! Form::label('term_accept', 'Aceito os termos descritos na ', ['class' => 'form-check-label']) !!}
                                <a href="#" target="_blank" class="cota04__form__compliance__link ms-1">Política de Privacidade</a>
                            </div>
                            <button type="submit" class="cota04__form__inputs__formIput__input-submit ms-auto">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="transition">
                                CTA
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
@endsection
