@if ($about->title_section || $about->subtitle_section || $about->description_section)
    <section id="ABOU01" class="abou01 container-fluid" style="background-image: url({{asset('storage/uploads/tmp/bg-section-gray.jpg')}})">
        <div class="container">
            <h3 class="abou01__container-title">
                <span class="abou01__title">{{$about->title_section}}</span>
                <span class="abou01__subtitle">{{$about->subtitle_section}}</span>
            </h3>
            <hr class="abou01__line">
            <p class="abou01__paragraph">{{$about->description_section}}</p>
            <a href="{{route('abou01.page')}}" class="abou01__cta transition">
                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="" class="abou01__cta__icon me-3 transition">
                CTA
            </a>
        </div>
        {{-- END .container --}}
    </section>
    {{-- END #ABOU01 --}}
@endif
