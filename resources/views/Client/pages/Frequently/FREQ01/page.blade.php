@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<div id="FREQ01" class="freq01-page container-fluid px-0">
    <section class="freq01-page__faq">
        <header class="freq01-page__faq__header"
            style="background-image: url({{asset('storage/uploads/tmp/bg-banner-inner.jpg')}}); background-color:;">
                <div class="freq01-pag__faq__header__mask"></div>
                <div class="container container--freq01-page">
                    <h2 class=" d-block text-center">
                        <span class="freq01-page__faq__header__title d-block">Título da Página</span>
                        <span class="freq01-page__faq__header__subtitle d-block">Subtitulo</span>
                    </h2>
                    <hr class="freq01-page__faq__header__line mb-0">
                </div>
        </header>
        <div class="freq01-page__faq__content">
            <div class="container">
                <div class="accordion freq01-page__faq__content__box" id="accordionExample">
                    <div class="accordion-item freq01-page__faq__content__box__item">
                        <h2 class="accordion-header freq01-page__faq__content__box__item__title">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Pergunta
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse freq01-page__faq__content__box__item__text" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                               <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero.
                                    Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus.
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero.
                                    Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere.
                                    Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                    Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, v
                                    el tempus mi pretium sed. In et arcu eget
                                    purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consect
                               </p>
                            </div>
                        </div>
                    </div>
                {{-- END .freq01-page__box --}}
                <div class="accordion freq01-page__faq__content__box" id="accordionExample">
                    <div class="accordion-item freq01-page__faq__content__box__item">
                        <h2 class="accordion-header freq01-page__faq__content__box__item__title">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapseTwo">
                                Pergunta
                            </button>
                        </h2>
                        <div id="collapse2" class="accordion-collapse collapse freq01-page__faq__content__box__item__text" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                               <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero.
                                    Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus.
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero.
                                    Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere.
                                    Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                    Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, v
                                    el tempus mi pretium sed. In et arcu eget
                                    purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consect
                               </p>
                            </div>
                        </div>
                    </div>
                {{-- END .freq01-page__box --}}
            </div>
        </div>
    </section>
    <section class="freq01-page__form">

    </section>
</div>

{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
