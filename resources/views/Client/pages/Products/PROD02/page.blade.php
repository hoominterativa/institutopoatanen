@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<section class="container-fluid px-0 prod02__page">
    @if ($banner)
        <header class="prod02__page__header w-100 d-flex justify-content-center align-items-end" style="background-image: url({{asset('storage/'.$banner->path_image_desktop)}});background-color: {{$banner->background_color}}">
            <div class="d-flex">
                @if ($banner->title)
                    <h4 class="prod02__page__header__title">{{$banner->title}}</h4>
                @endif
            </div>
        </header>
    @endif
    {{-- Finish prod02__page__header --}}
    <div class="prod02__page__content container">
        @if ($categories->count())
        <ul class="prod02__page__content__category  container-fluid d-flex flex-row justify-content-center align-items-center px-0 flex-wrap">
            @foreach ($categories as $category)
                <li class="col-md-2 prod02__page__content__category_li">
                    <a class="w-100 d-flex justify-content-center align-items-center" href="{{route('prod02.category.page', ['PROD02ProductsCategory' => $category->slug ])}}">
                        @if ($category->path_image_icon)
                            <img src="{{asset('storage/' . $category->path_image_icon)}}" alt="" class="prod02__page__content__category__li__img">
                            @if ($category->title)
                                {{$category->title}}
                            @endif
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
        @endif
        {{-- Finish prod02__page__content__category --}}
        @if ($products->count())
            <div class="prod02__page__content__product container">
                <div class="row prod02__page__content--row">
                    @foreach ($products as $product)
                        <article class="prod02__page__content__product__item col-md-3 ">
                            <div class="prod02__page__content__product__item__image w-100 h-100">
                                <img src="{{asset('storage/uploads/tmp/image-box.jpg')}}" class="w-100 h-100" alt="Titulo Topico">
                            </div>
                            <div class="prod02__page__content__product__item__description d-flex  flex-column justify-content-end mx-0 w-100 h-100 text-center">
                                @if ($product->title)
                                    <h2 class="prod02__page__content__product__item__description__title mx-0 px-0">{{$product->title}}</h2>
                                @endif
                                <div class="prod02__page__content__product__item__description_paragraph mx-0 px-0 ">
                                    @if ($product->description)
                                        <p>
                                            {!! $product->description !!}
                                        </p>
                                    @endif
                                </div>
                                <a rel="next" href="javascript-void(0);" data-fancybox="{{$product->slug}}" data-src="#lightbox-prod02-1-{{$product->slug}}" class="prod02__page__content__product__item__cta transition d-flex justify-content-center align-items-center mx-auto">
                                    <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="w-100  prod02__page__content__product__item__cta__icon me-3 transition">
                                    CTA
                                </a>
                            </div>
                            @include('Client.pages.Products.PROD02.show', [
                                'product' => $product
                            ])
                        </article>
                    @endforeach
                    {{-- Finish prod02__page__content__product__item --}}
                </div>
                {{-- Finish row prod02__page__content--row --}}
            </div>
            {{-- Finish prod02__page__content__product --}}
        @endif
    </div>
</section>
{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
