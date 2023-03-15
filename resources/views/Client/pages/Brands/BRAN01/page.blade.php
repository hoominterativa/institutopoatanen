@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<section id="BRAN01" class="bran01-page container-fluid px-0">
    <header class="bran01-page__header" style="background-image: url({{asset('storage/uploads/tmp/bg-banner-inner.jpg')}})">
        <h2 class="container container--bran01-page d-block text-center">
            <span class="bran01-page__header__title d-block">Titulo</span>
            <span class="bran01-page__header__subtitle d-block">Subtitulo</span>
            <hr class="bran01-page__header__line mb-0">
        </h2>
    </header>
    <main class="bran01-page__main">
        <div class="container container--bran01-page__main">
            <div class="bran01-page__encompass px-0 text-center mx-auto w-100">
                <h2 class="bran01-page__encompass__title">Titulo</h2>
                <h3 class="bran01-page__encompass__subtitle">subtitulo</h3>
                <hr class="bran01-page__encompass__line">
                <div class="bran01-page__encompass__paragraph mx-auto">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor
                        eu purus gravida sollicitudin vel non libero. Vivamus commodo porta 
                        velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. 
                    </p>
                </div>
            </div>
            <div class="bran01-page__content">
                <div class="row row--bran01-page w-100 mx-auto">
                    <div class="bran01-page__box col-sm-3">
                        <div class="bran01-page__box__content">
                            <div class="bran01-page__box__image">
                                <img src="{{asset('storage/uploads/tmp/logo.svg')}}" alt="Logo" loading="lazy">
                        </div>
                        </div>
                    </div>
                    {{-- END .bran01-page__box --}}
                    <div class="bran01-page__box col-sm-3">
                        <div class="bran01-page__box__content">
                            <div class="bran01-page__box__image">
                                <img src="{{asset('storage/uploads/tmp/logo.svg')}}" alt="Logo" loading="lazy">
                        </div>
                        </div>
                    </div>
                    {{-- END .bran01-page__box --}}
                    <div class="bran01-page__box col-sm-3">
                        <div class="bran01-page__box__content">
                            <div class="bran01-page__box__image">
                                <img src="{{asset('storage/uploads/tmp/logo.svg')}}" alt="Logo" loading="lazy">
                        </div>
                        </div>
                    </div>
                    {{-- END .bran01-page__box --}}
                    <div class="bran01-page__box col-sm-3">
                        <div class="bran01-page__box__content">
                            <div class="bran01-page__box__image">
                                <img src="{{asset('storage/uploads/tmp/logo.svg')}}" alt="Logo" loading="lazy">
                        </div>
                        </div>
                    </div>
                    {{-- END .bran01-page__box --}}
                    <div class="bran01-page__box col-sm-3">
                        <div class="bran01-page__box__content">
                            <div class="bran01-page__box__image">
                                <img src="{{asset('storage/uploads/tmp/logo.svg')}}" alt="Logo" loading="lazy">
                        </div>
                        </div>
                    </div>
                    {{-- END .bran01-page__box --}}
                </div>
            </div>
        </div>
    </div>
</section>    
{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
