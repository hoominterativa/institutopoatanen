@if ($images->count())
    <section id="GALL01" class="gall01">
        @foreach ($images as $image)
            <img
            class="gall01__item"
            alt="Image da galeria"
            loading="lazy"
            src="{{ asset('storage/' . $image->path_image) }}" />
        @endforeach
    </section>
@endif
