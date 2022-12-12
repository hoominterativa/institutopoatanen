@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}

{{-- BEGIN Page content --}}
<div id="UNIT01" class="unit01-page">
    <section class="container-fluid px-0">
        <header class="unit01-page__header" style="background-image: url({{asset('storage/uploads/tmp/bg-banner-inner.jpg')}})">
            <h2 class="container container--unit01-header d-block text-center">
                <span class="unit01-page__header__title d-block">Titulo do banner</span>
                <span class="unit01-page__header__subtitle d-block text-uppercase">SUBTITULO</span>
                <hr class="unit01-page__header__line mb-0">
            </h2>
        </header>
    </section>
    <div class="unit01-page__divisor">
        <div class="unit01-page__divisor__section">
            <div class="row px-0 mx0 justify-content-between">
                <div class="unit01-page__divisor__section__boxLeft col-sm-6 px-0">
                <h4 class="unit01-page__divisor__section__boxLeft__title">Título</h4>
                <hr class="unit01-page__divisor__section__boxLeft__line mb-0">
                <h4 class="unit01-page__divisor__section__boxLeft__subtitle">Título</h4>
                <div class="unit01-page__divisor__section__boxLeft__paragraph">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur
                    </p>
                </div>
                <div class="unit01-page__divisor__section__boxLeft__topics row px-0 mx-0">
                    <div class="unit01-page__divisor__section__boxLeft__topic col-sm-3 px-0 position-relative">
                        <a rel="next" href="javascript-void(0);" data-fancybox="" data-src="#lightbox-unit01-1" >
                        <div class="unit01-page__divisor__section__boxLeft__topic__image position-absolute w-100 h-100">
                            <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" class="w-100 h-100" alt="Logo">
                        </div>
                        <div class="unit01-page__divisor__section__boxLeft__topic__description position-absolute w-100 h-100">
                            <div class="unit01-page__divisor__section__boxLeft__topic__description__icone">
                                <img src="{{asset('storage/uploads/tmp/favicon.png')}}" alt="Ícone" class="w-100 h-100">
                            </div>
                            <h2 class="unit01-page__divisor__section__boxLeft__topic__description__title">Título</h2>
                        </div>
                        </a>
                        @include('Client.pages.Units.UNIT01.show')
                    </div>
                </div>
                </div>
                <div class="unit01-page__divisor__section__boxRight col-sm-5 px-0">
                <div class="carrossel-unit01">
                    <div class="unit01-page__divisor__section__boxRight__imageBox">
                        <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" alt="Imagem" class="w-100 h-100">
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="unit01-page__divisor__section">
            <div class="unit01-page__divisor__section__boxLeft">
                <h4 class="unit01-page__divisor__section__boxLeft__title">Título</h4>
                <h4 class="unit01-page__divisor__section__boxLeft__subtitle">Título</h4>
                <div class="unit01-page__divisor__section__boxLeft__paragraph">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur
                    </p>
                </div>
                <div class="unit01-page__divisor__section__boxLeft__topics">
                    <div class="unit01-page__divisor__section__boxLeft__topic">
                        <div class="unit01-page__divisor__section__boxLeft__topic__image">
                            <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" alt="Logo">
                        </div>
                        <div class="unit01-page__divisor__section__boxLeft__topic__description">
                            <h2 class="unit01-page__divisor__section__boxLeft__topic__description__title">Título</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="unit01-page__divisor__section__boxRight">
                <div class="carrossel-unit01 owl-carousel">
                    <div class="unit01-page__divisor__section__boxRight__imageBox">
                        <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" alt="Imagem" class="w-100 h-100">
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
{{-- END .unit01-page__content --}}

{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
