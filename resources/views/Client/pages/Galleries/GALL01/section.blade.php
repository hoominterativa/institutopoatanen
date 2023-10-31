@if ($images->count())
    <section id="GALL01" class="gall01 container-fluid px-0">
        <div class="row row-cols-2 row-cols-sm-2 row-cols-md-5 mx-auto">
            @foreach ($images as $image)
                <div class="gall01__box col px-0 position-relative">
                    <a href="{{ asset('storage/' . $image->path_image) }}" data-fancybox="gall01"  class="link-full"></a>
                    <div class="gall01__box__image">
                        @if ($image->path_image)
                            <img src="{{ asset('storage/' . $image->path_image) }}" />
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endif
