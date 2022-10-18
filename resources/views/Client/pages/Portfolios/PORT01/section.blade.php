@if ($section)
    <section id="PORT01" class="container-fluid">
        <div class="row">
            <div class="col-12 col-sm-5 information-section d-flex flex-column justify-content-center align-items-end" style="background-image: url({{asset('storage/'.$section->path_image)}});">
                <div class="content">
                    <h2 class="title">{{$section->title}}</h2>
                    {!!$section->description!!}
                </div>
            </div>
            <div class="col-12 col-sm-7">
                <nav class="navigation-categories d-flex flex-column justify-content-center h-100">
                    @foreach ($categories as $category)
                        <div class="category-item d-flex align-items-center">
                            <div class="d-flex align-items-center">
                                <a href="{{route('port01.category.page', ['PORT01PortfoliosCategory' => $category->slug])}}" class="link d-flex align-items-center">
                                    <img src="{{asset('storage/'.$category->path_image_icon)}}" alt="{{$category->title}}" class="image" width="60" sizes="(max-width: 710px) 45px">
                                    <h3 class="title ms-4 me-4">{{$category->title}}</h3>
                                </a>
                                <svg width="36" height="22" viewBox="0 0 36 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.825073 11H32.3251" stroke="black"/> <path d="M35.3251 11L24.8251 0.5" stroke="black"/> <path d="M35.3251 11L24.8251 21.5" stroke="black"/>
                                </svg>
                            </div>
                            <div class="subcategories ms-3">
                                <div class="d-flex">
                                    @foreach ($category->subcategories as $subcategory)
                                        <a href="{{route('port01.subcategory.page', ['PORT01PortfoliosCategory' => $category->slug, 'PORT01PortfoliosSubategory' => $subcategory->slug])}}" class="subcategory-item">{{$subcategory->title}}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </nav>
            </div>
        </div>
        {{-- END ROW --}}
    </section>
@endif
