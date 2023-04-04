@if ($galleries->count())
    <section id="GALL01" class="gall01 container-fluid px-0">
        <div class="row row-cols-2 row-cols-sm-2 row-cols-md-5 mx-auto">
            @foreach ($galleries as $gallery)
                <div class="gall01__box col px-0 position-relative">
                    <a href="{{ asset('storage/' . $gallery->path_image) }}" data-fancybox="gall01"  class="link-full"></a>
                    <div class="gall01__box__image">
                        @if ($gallery->path_image)
                            <img src="{{ asset('storage/' . $gallery->path_image) }}" />
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endif
