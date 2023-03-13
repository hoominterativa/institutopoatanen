@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<main id="root">
    <div id="SERV04" class="serv04-page">
        <section class="container-fluid px-0">
            <header class="serv04-page__header">
                <div class="container d-flex flex-column justify-content-center align-items-center">
                    <h3 class="serv04-page__header__title">Titulo Pagina</h3>
                    <div class="serv04-page__header__paragraph">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida
                            sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed.
                            In et arcu eget purus mattis posuere. Donec tincidunt
                        </p>
                    </div>
                </div>
            </header>
            <div class="serv04-page__content">
                <nav class="serv04-page__navigation">
                    <div class="container">
                        <ul>
                            <li><a href="#">Categoria</a></li>
                            <li><a href="#">Categoria</a></li>
                            <li><a href="#">Categoria</a></li>
                        </ul>
                    </div>
                </nav>
                <div class="serv04-page__description">
                    <h2 class="serv04-page__description__title">Categoria</h2>
                    <div class="serv04-page__description__paragraph">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida
                            sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In
                            et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet,
                            consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero.
                            Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere.
                            Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel
                            tempus mi pretium sed. In et arcu eget purus mattis posuere.
                            Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectet
                        </p>
                    </div>
                </div>
            </div>
            {{-- END .serv04-page__content --}}
        </section>
        {{-- END .serv04-page --}}

        <section class="serv04-page__subcategory container-fluid">
            <div class="container">
                <div class="serv04-page__subcategory__nav">
                    <div class="row carousel-serv04-page__subcategory">

                    </div>
                </div>
                <div class="serv04-page__subcategory__content">
                    <div class="serv04-page__subcategory__content__box">
                        <div class="serv04-page__subcategory__content__box__image">
                            <img src="" alt="" laoding="lazy">
                        </div>
                        <div class="serv04-page__subcategory__content__box__description">
                            <h2 class="serv04-page__content__title">Categoria</h2>
                            <div class="serv04-page__content__paragraph">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida
                                    sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In
                                    et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet,
                                    consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero.
                                    Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere.
                                    Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                    Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel
                                    tempus mi pretium sed. In et arcu eget purus mattis posuere.
                                    Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectet
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="serv04-page__subcategory__content__accordion">
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div class="accordion-item coqe__boxQuestion__title">
                                <h2 class="accordion-header" id="flush-headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-1" aria-expanded="false" aria-controls="flush-collapseOne">
                                        Lorem ipsum dolor sit amet,
                                    </button>
                                </h2>
                                <div id="flush-collapse-1" class="accordion-collapse collapse coqe__boxQuestion__description" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body ">
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetvLorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu ege
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="card">
                              <div class="card-header" id="headingOne">
                                <h5 class="mb-0">
                                  <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Collapsible Group Item #1
                                  </button>
                                </h5>
                              </div>

                              <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                <div class="card-body">
                                  Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                </div>
                              </div>
                            </div>
                            <div class="card">
                              <div class="card-header" id="headingTwo">
                                <h5 class="mb-0">
                                  <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Collapsible Group Item #2
                                  </button>
                                </h5>
                              </div>
                              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                <div class="card-body">
                                  Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                </div>
                              </div>
                            </div>
                            <div class="card">
                              <div class="card-header" id="headingThree">
                                <h5 class="mb-0">
                                  <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Collapsible Group Item #3
                                  </button>
                                </h5>
                              </div>
                              <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                <div class="card-body">
                                  Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                </div>
                              </div>
                            </div>
                          </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- END .serv04-page__subcategory --}}
    </div>
    {{-- END .serv04-page --}}
</main>
{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
