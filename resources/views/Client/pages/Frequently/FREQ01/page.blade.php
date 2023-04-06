@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<section id="BRAN01" class="bran01-page container-fluid px-0">
    <header class="bran01-page__header"
        style="background-image: url(); background-color:;">
            <div class="bran01-page__header__mask"></div>
            <h2 class="container container--bran01-page d-block text-center">
                <span class="bran01-page__header__title d-block">Título da Página</span>
                <span class="bran01-page__header__subtitle d-block">Subtitulo</span>
                <hr class="bran01-page__header__line mb-0">
            </h2>
    </header>

    <main class="bran01-page">
        <div class="container container--bran01-page__main">
            <div class="bran01-page__encompass px-0 text-center mx-auto w-100">
                <h2 class="bran01-page__encompass__title"></h2>
                <h3 class="bran01-page__encompass__subtitle"></h3>
                <hr class="bran01-page__encompass__line">
                <div class="bran01-page__encompass__paragraph mx-auto">
                    <p></p>
                </div>
            </div>
            <div class="bran01-page__content">
                <div class="row row--bran01-page w-100 mx-auto">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                          <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                              Accordion Item #2
                            </button>
                          </h2>
                          <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                              <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                            </div>
                          </div>
                      </div>
                    {{-- END .bran01-page__box --}}
                </div>
            </div>
        </div>
    </main>
</section>
{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
