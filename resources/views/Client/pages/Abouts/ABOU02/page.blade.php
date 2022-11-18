@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<section id="ABOU02" class="abou02-page container-fluid">
    <div class="container">
        <div class="abou02-page__boxLeft">
            <div class="abou02-page__description">
                <h4 class="abou02-page__subtitle">subtitulo</h4>
                <h5 class="abou02-page__title">Titulo</h5>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor
                    eu purus gravida sollicitudin vel non libero. Vivamus commodo porta 
                    velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. 
                </p>
            </div>
        </div>
        <div class="abou02__boxRight">
            <div class="carrossel_abou02">
                <article class="abou02-page__box__item">
                    <a href=""></a>
                    <div class="abou02-page__image">
                        <img src="" class="fluid" alt="Imagem Titulo">
                    </div>
                    <div class="abou02-page__box__description">
                        <h4 class="abou02-page__box__subtitle">subtitulo</h4>
                        <h5 class="abou02-page__box__title">Titulo</h5>
                    </div>
                    @include('Client.pages.Abouts.ABOU02.show');
                </article>
            </div>
        </div>
    </div>
</section>



{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
