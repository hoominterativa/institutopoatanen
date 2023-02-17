@extends('Client.Core.client')
@section('content')
    <main id="root">
        <header class="confirmation__header container-fluid">
            <div class="container">
                <h3 class="confirmation__header__wrapper-title">
                    <span class="confirmation__header__title">Sua Mensagem foi</span>
                    <span class="confirmation__header__subtitle"> Enviada com Sucesso!</span>
                </h3>
                <p class="confirmation__header__paragraph"></p>
            </div>
        </header>
        {{-- {!!$section!!} --}}
    </main>
@endsection
