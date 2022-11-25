@extends('Client.Core.client')
@section('content')
<div id="lightbox-prod02-1" class="lightbox-prod02 row">
    <div class="row px-0 px-0 mx-0">
        <ul class="lightbox-prod02_navigation">
            <li><a href="#">Categorias  </a></li>
        </ul>
        <div class="caroussel-galeria">
            <div class="lightbox-prod02__image px-0 col-md-6">
                <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" class="h-100 w-100" alt="Subtitulo">
            </div>
        </div>

        {{-- END .lightbox-prod02__image --}}
        <div class="lightbox-prod02__description p-5 col-md-6 d-block">
            <h3 class="lightbox-prod02__subtitle">Subtitulo</h3>
            <h2 class="lightbox-prod02__title mb-0">Titulo</h2>
            <hr class="lightbox-prod02__line">
            <div class="lightbox-prod02__paragraph">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi  
                </p>
            </div>
            <a href="#lightbox-product" class="prod02__page__content__product__item__cta transition d-flex justify-content-center align-items-center mx-auto">
                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="prod02__page__content__product__item__cta__icon me-3 transition">
                CTA
            </a>
        </div>
        {{-- END .lightbox-prod02__description --}}
    </;div>
</div>
{{-- END .lightbox-prod02 --}}
@endsection
