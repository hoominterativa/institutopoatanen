@extends('Client.Core.client')
@section('content')
<style>
    .blog03 {
        background-color: #FFF;
        padding-bottom: 7rem;
    }
    .blog03__header__title {
        color: #1A2069;
    }
</style>
{{-- BEGIN Page content --}}
    <section class="bapa01__banner" style="background-image: url({{asset('images/banner-bapa01.png')}})">
        <h1 class="bapa01__banner__title">O que fazemos</h1>
    </section>
{{-- Finish Content page Here --}}
<main id="root">
    @foreach ($sections as $section)
    {!!$section!!}
    @endforeach
</main>
@endsection
