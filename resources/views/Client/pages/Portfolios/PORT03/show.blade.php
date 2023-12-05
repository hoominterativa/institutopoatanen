@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<section id="PORT03" class="posh-show posh">
    <div class="container container--posh">
        <header class="posh__header text-center">
            <h2 class="posh__header__title">Título Tópico</h2>
            <h3 class="posh__header__subtitle">Subtitulo</h3>
        </header>
        <div class="posh__content carousel-posh">
            <div class="posh__box">
                <div class="posh__box__engImage">
                    <div class="posh__box__engImage__content">
                        <div class="posh__box__engImage__content__flow image-container">
                            <div class="posh__box__engImage__content__flow__images">
                                <img src="{{asset('storage/uploads/tmp/box-port01.png')}}" alt="Image 1" class="posh__box__engImage__content__flow__images__img image1">
                                <img src="{{asset('storage/uploads/tmp/box-port02.png')}}" alt="Image 2" class="posh__box__engImage__content__flow__images__img image2">
                            </div>
                        </div>
                        <div class="posh__box__engImage__content__divider divider">
                            <span class="before-text">Antes</span>
                            <span class="after-text">Depois</span>
                        </div>
                    </div>
                </div>
                <div class="posh__box__description">
                    <a href="#" class="posh__box__description__btn transition d-flex justify-content-center align-items-center">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="icon" class="posh__box__description__btn__icon me-3 transition">
                        CTA
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- #PORT02 --}}
{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
