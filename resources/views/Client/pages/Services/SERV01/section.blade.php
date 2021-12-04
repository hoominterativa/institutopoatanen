<section id="SERV01" class="service container-fluid">
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
                    <li><a href="{{route('serv01.category.page', ['SERV01ServicesCategories' => $category->slug])}}">{{$category->name}}</a></li>
                @endforeach
            </ul>
        </nav>
        <div class="wrap-box-service w-100 d-block">
            <div class="carousel-box-service owl-carousel">
                @foreach ($services as $service)
                    <article class="box-service">
                        <div class="content">
                            <a href="{{route('serv01.service.show', ['SERV01ServicesCategories' => $service->getCategory->slug, 'SERV01ServicesSubcategories' => $service->getSubcategory->slug])}}" class="link-full"></a>
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
        </div>
    </div>
</section>
