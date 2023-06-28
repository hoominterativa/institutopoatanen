@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}

    <section class="prod05-show">
        <header class="prod05-show__banner" style="background-image: url({{asset('storage/uploads/tmp/bg-banner-inner.jpg')}})">
            <div class="prod05-show__banner__container container">
                <div class="prod05-show__banner__description">
                    <h3 class="prod05-show__banner__title">Título do Banner</h3>
                    <h4 class="prod05-show__banner__subtitle">Subtítulo</h4>
                    <hr class="prod05-show__banner__line">
                </div>
                {{-- END .prod05-show__banner__description --}}
            </div>
            {{-- END .prod05-show__banner__container --}}
        </header>
        {{-- END .prod05-show__banner --}}

        <div class="prod05-show__contentTitle">
            <div class="prod05-show__contentTitle__container container">
                <div class="prod05-show__wrapForm">
                    <button class="prod05-show__btnForm prod05-show__btnForm--showForm" type="button">Faça seu Orçamento</button>

                    {!! Form::open(['route' => 'lead.store', 'method' => 'post', 'files' => true, 'class'=>'send_form_ajax prod05-show__form parsley-validate']) !!}
                        <input type="hidden" name="target_lead" value="Produtos">
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
                        <div class="col-12 col-md-6">
                            <h1 class="prod05-show__contentTitle__title">Título do Produto</h1>
                            <h3 class="prod05-show__contentTitle__subtitle">Categoria</h3>
                        </div>
                    </div>
                </div>
            </div>
            {{-- END .prod05-show__content__container --}}
        </div>
        {{-- END .prod05-show__content --}}
    </section>
    {{-- END .prod05-show --}}

    {{-- Finish Content page Here --}}
    @foreach ($sections as $section)
        {!!$section!!}
    @endforeach
@endsection
