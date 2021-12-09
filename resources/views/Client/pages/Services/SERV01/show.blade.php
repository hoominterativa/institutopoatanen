@extends('Client.Core.client')
@section('content')
<section id="SERV01" class="service-page container-fluid">
    <div class="container py-5">
        <div class="wrap-box-service w-100 d-block">
            <ul class="list-inline d-flex">
                <li class="me-3"><a href="{{route('home')}}">Home</a></li>
                <li class="me-3"><a href="{{route('serv01.subcategory.page', ['SERV01ServicesCategories' => $category->slug])}}">{{$category->name}}</a></li>
                <li class="me-3"><a href="{{route('serv01.subcategory.page', ['SERV01ServicesCategories' => $category->slug, 'SERV01ServicesSubcategories' => $subcategory->slug])}}">{{$subcategory->name}}</a></li>
                <li>{{$service->title}}</li>
            </ul>
            <article class="box-service">
                <div class="content">
                    <div class="image">
                        <img class="w-100" src="{{url('storage/'.$service->path_image_box)}}" title="{{$service->title}}" alt="{{$service->title}}">
                    </div>
                    <div class="description">
                        <h2 class="title">{{$service->title}}</h2>
                        <p>{!!$service->text!!}</p>
                    </div>
                </div>
            </article>
        </div>
    </div>
</section>
@endsection
