@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<section id="ligtbox-sche02-page" class="lipa">
    <header class="lipa__banner">
        <a href="#" class="lipa__banner__close">Agenda</a>
        <div class="lipa__banner__mask"></div>
        <div class="container d-flex justify-content-center">
            <div class="lipa__banner__left">
                <h4 class="lipa__banner__left__title">Titulo do banner</h4>
                <h5 class="lipa__banner__left__subtitle">SUBTITULO</h5>
            </div>
            <div class="lipa__banner__right">
                <div class="lipa__banner__right__logo">
                        <img src="" alt="">
                </div>
            </div>    
        </div>
    </header>
    <div id="calendar" class="lipa__calendar">

    </div>
</section>    
{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection

