<header class="p-3 bg-dark text-white">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/" class="d-flex align-items-center mb-2 mr-5 mb-lg-0 text-white text-decoration-none">
                <h3>Painel Hoom</h3>
            </a>

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="{{url('')}}" class="nav-link px-2 text-white">Home</a></li>
                @foreach ($listMenu as $menu)
                    @if (count(get_object_vars($menu->ListMenu)))
                        <li><a href="{{$menu->ListMenu->Anchor}}" class="nav-link px-2 text-white">{{$menu->ListMenu->Title}}</a></li>
                    @endif
                @endforeach
            </ul>

            <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
                <input type="search" class="form-control form-control-dark" placeholder="Search..." aria-label="Search">
            </form>

            <div class="text-end">
                <button type="button" class="btn btn-outline-light me-2">Login</button>
                <button type="button" class="btn btn-warning">Sign-up</button>
            </div>
        </div>
    </div>
</header>



@foreach ($categoryHeader as $categoryHeader)
    <a href="{{$categoryHeader->name}}" class="ancora">{{$categoryHeader->name}}</a>
@endforeach

