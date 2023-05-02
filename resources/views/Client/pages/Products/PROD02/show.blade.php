<div id="lightbox-prod02-1-{{$product->slug}}" class="lightbox-prod02 row">
    <div class="row px-0 px-0 mx-0">
        <div class="lightbox-prod02__content__carrossel px-0 col-md-6">
            <div class="caroussel_prod02-show">
                @foreach ($product->galleries as $gallery)
                    <div class="lightbox-prod02__image h-100">
                        <img src="{{asset('storage/' . $gallery->path_image)}}" class="h-100 w-100" alt="Subtitulo">
                    </div>
                @endforeach
                {{-- END .caroussel_prod02-show --}}
            </div>
            {{-- END .caroussel_prod02-show --}}
        </div>
        {{-- END .lightbox-prod02__content__carrossel --}}
        <div class="lightbox-prod02__description col-md-6 d-block">
            <ul class="lightbox-prod02__navigation px-0">
                <li><a href="{{route('prod02.page')}}" rel="prev"><img src="{{asset('storage/uploads/tmp/icone-voltar.svg')}}" alt="Ícone Voltar"> Categorias</a></li>
            </ul>
            @if ($product->title || $product->subtitle)
                <h2 class="lightbox-prod02__title mb-0">{{$product->title}}</h2>
                <h3 class="lightbox-prod02__subtitle mb-0">{{$product->subtitle}}</h3>
                <hr class="lightbox-prod02__line">
            @endif
            <div class="lightbox-prod02__paragraph">
                @if ($product->text)
                    <p>
                       {!! $product->text !!}
                    </p>
                @endif
            </div>
            <a href="{{ $product->link_button ? getUri($product->link_button) : 'javascript:void(0)' }}" target="{{ $product->target_link_button }}" class="lightbox-prod02__cta transition d-flex justify-content-center align-items-center mx-auto">
                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="lightbox-prod02__cta__icon me-3 transition">
                @if ($product->title_button)
                    {{$product->title_button}}
                @endif
        </div>
        {{-- END .lightbox-prod02__description --}}
    </div>
</div>
{{-- END .lightbox-prod02 --}}
