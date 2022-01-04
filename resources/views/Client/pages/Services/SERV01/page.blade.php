@extends('Client.Core.client')
@section('content')
<section id="SERV01" class="service-page container-fluid">
    <div class="container py-5">
        @if ($serviceSection)
            @if ($serviceSection->active)
                <header class="header-service">
                    <h2 class="title">{{$serviceSection->title}}</h2>
                    <p class="ms-auto me-auto mb-0">{{$serviceSection->description}}</p>
                </header>
            @endif
        @endif
        <nav class="wrap-categories-service">
            <ul class="list-inline d-flex">
                @foreach ($categories as $category)
                    <li class="{{isActive(route('serv01.subcategory.page', ['SERV01ServicesCategories' => $category->slug]))}}">
                        <a href="{{route('serv01.subcategory.page', ['SERV01ServicesCategories' => $category->slug])}}">{{$category->name}}</a>
                        <ul>
                            @foreach ($category->subcategories as $subcategory)
                                <li class="{{isActive(route('serv01.subcategory.page', ['SERV01ServicesCategories' => $category->slug, 'SERV01ServicesSubcategories' => $subcategory->slug]))}}"><a href="{{route('serv01.subcategory.page', ['SERV01ServicesCategories' => $category->slug, 'SERV01ServicesSubcategories' => $subcategory->slug])}}">{{$subcategory->name}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </nav>
        <div class="wrap-box-service w-100 d-block">
            <div class="row">
                @foreach ($services as $service)
                    <article class="box-service col-3">
                        <div class="content">
                            <a href="{{route('serv01.service.show', ['SERV01ServicesCategories' => $service->category->slug, 'SERV01ServicesSubcategories' => $service->subcategory->slug, 'SERV01Services' => $service->slug])}}" class="link-full"></a>
                            <div class="image">
                                <img class="w-100" src="{{url('storage/'.$service->path_image_box)}}" title="{{$service->title}}" alt="{{$service->title}}">
                            </div>
                            <div class="description">
                                <h2 class="title">{{$service->title}}</h2>
                                <p>{{$service->description}}</p>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
            {{$services->links()}}
        </div>
    </div>
</section>
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
