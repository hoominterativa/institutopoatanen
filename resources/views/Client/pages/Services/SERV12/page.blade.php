@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<main id="serv12-page" class="serv12-page">
    <section class="blog01-page__banner"
        style="background-image: url({{ asset('storage/') }});">
        <h1 class="blog01-page__banner__title"></h1>
        <h2 class="blog01-page__banner__subtitle"></h2>
    </section>
    <aside class="serv12-page__categories">
        <menu class="serv12-page__categories__swiper-wrapper swiper-wrapper">
            <li class="serv12-page__categories__item active swiper-slide">
                <a href="#" class="link-full" title="categoria"></a>
                categoria
            </li>
            @for ($i = 1; $i < 5; $i++)
                <li class="serv12-page__categories__item swiper-slide">
                    <a href="#" class="link-full" title="categoria{{$i}}"></a>
                    categoria {{$i}}
                </li>
            @endfor
        </menu>
    </aside>
</main>
{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
