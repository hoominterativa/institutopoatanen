@extends('Client.Core.client')
@section('content')
    <main id="root">

        <section class="cota05-page__banner"
            style="background-image: url({{ asset('storage/uploads/tmp/box-port01.png') }});">
            <h1 class="cota05-page__banner__title">Titulo Pagina</h1>
            <h2 class="cota05-page__banner__subtitle">Subtítulo</h2>
        </section>

        {!! Form::open([
            'method' => 'post',
            'files' => true,
            'class' => 'cota05-page__form send_form_ajax parsley-validate',
        ]) !!}

        <div class="cota05-page__form__radio-group">
            <div class="cota05-page__form__information">
                <h2 class="cota05-page__form__information__title">
                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}"
                        class="cota05-page__form__information__title__icon" alt="Ícone de (BACKEND ADD O TÍTULO AQUI)"
                        loading="lazy">

                    Avaliação de Experiência
                </h2>

                <div class="cota05-page__form__information__paragraph">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida
                        sollicitudin vel non liberolor sit amet, consectetur adipiscing elit. Cras vel tortor</p>
                </div>
            </div>

            <ul class="cota05-page__form__radio-group__list">
                <li class="cota05-page__form__radio-group__list__item">
                    <img loading="lazy" src="{{ asset('images/cota05-icon01.png') }}" alt="ícone de bom"
                        class="cota05-page__form__radio-group__list__item__icon">
                </li>
                <li class="cota05-page__form__radio-group__list__item">
                    <img loading="lazy" src="{{ asset('images/cota05-icon02.png') }}" alt="ícone de mais ou menos"
                        class="cota05-page__form__radio-group__list__item__icon">
                </li>
                <li class="cota05-page__form__radio-group__list__item">
                    <img loading="lazy" src="{{ asset('images/cota05-icon03.png') }}" alt="icone de ruim"
                        class="cota05-page__form__radio-group__list__item__icon">
                </li>
            </ul>
        </div>

        @for ($i = 0; $i < 4; $i++)
            <div class="cota05-page__form__radio-group">
                <p class="cota05-page__form__radio-group__title">Atendimento</p>

                <ul class="cota05-page__form__radio-group__list">
                    <li class="cota05-page__form__radio-group__list__item">
                        <input type="radio" name="item01" class="cota05-page__form__radio-group__list__item__input">
                    </li>
                    <li class="cota05-page__form__radio-group__list__item">
                        <input type="radio" name="item01" class="cota05-page__form__radio-group__list__item__input">
                    </li>
                    <li class="cota05-page__form__radio-group__list__item">
                        <input type="radio" name="item01" class="cota05-page__form__radio-group__list__item__input">
                    </li>
                </ul>
            </div>
        @endfor

        <div class="cota05-page__form__radio-group">
            <p class="cota05-page__form__radio-group__title">Atendimento</p>

            <ul class="cota05-page__form__radio-group__list">
                <li class="cota05-page__form__radio-group__list__item">
                    <span class="cota05-page__form__radio-group__list__item__title">Sim</span>
                    <input type="radio" name="item02" class="cota05-page__form__radio-group__list__item__input">
                </li>
                <li class="cota05-page__form__radio-group__list__item">
                    <span class="cota05-page__form__radio-group__list__item__title">Não</span>
                    <input type="radio" name="item02" class="cota05-page__form__radio-group__list__item__input">
                </li>
                <li class="cota05-page__form__radio-group__list__item">
                    <span class="cota05-page__form__radio-group__list__item__title">Talvez</span>
                    <input type="radio" name="item02" class="cota05-page__form__radio-group__list__item__input">
                </li>
            </ul>
        </div>

        <div class="cota05-page__form__inputs-group">

            @include('Client.Components.inputs', [
                'name' => 'name',
                'placeholder' => 'Nome',
                'type' => 'text',
                'required' => false,
            ])

            @include('Client.Components.inputs', [
                'name' => 'email',
                'placeholder' => 'E-mail',
                'type' => 'email',
                'required' => false,
            ])

            @include('Client.Components.inputs', [
                'name' => 'cellphone',
                'placeholder' => 'Celular',
                'type' => 'cellphone',
                'required' => false,
            ])

            @include('Client.Components.inputs', [
                'name' => 'textarea',
                'placeholder' => 'Sugestões para melhorar',
                'type' => 'textarea',
                'required' => false,
            ])

        </div>

        <button type="submit" class="cota05-page__form__cta">
            CTA
        </button>

        {!! Form::close() !!}

        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
