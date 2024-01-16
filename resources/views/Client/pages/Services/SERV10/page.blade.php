@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<section id="serv10-page" class="serv10-page">
    <div class="serv10-page__banner">
        <div class="container container--edit px-0">
            <h4 class="serv10-page__banner__title">Titulo Pagina</h4>
            <div class="serv10-page__banner__paragraph">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. 
                    Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt
                    dignissim faucibus. 
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor
                </p>
            </div>
        </div>
    </div>
    {{-- END serv10-page__banner --}}
    <div class="serv10-page__main container px-0">
        <div class="serv10-page__main__navigation">
            <nav>
                <ul>
                    @for($i = 0; $i <= 5; $i ++)
                        <li class="serv10-page__main__navigation__title"><a href="#">Categoria 1</a></li>
                    @endfor
                </ul>
            </nav>
            <div class="serv10-page__main__navigation__dropdown-mobile">
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header serv10-page__main__navigation__dropdown-mobile__item">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseOne" aria-expanded="false"
                                aria-controls="flush-collapseOne">
                                Categorias
                            </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <ul>
                                    <li class="serv10-page__main__navigation__dropdown-mobile__item">
                                        <a href="#">
                                            Categoria 1
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- END serv10-page__main__titleDest --}}
        <div class="serv10-page__main__engBox row">
            @for($i = 0; $i <= 5; $i ++)
            <div class="serv10-page__main__engBox__box col-sm-3">
                <div class="serv10-page__main__engBox__box__content">
                    <div class="serv10-page__main__engBox__box__bg">
                        <img src="{{asset('storage/uploads/tmp/bg-boxitem.png')}}" alt="Bg">
                    </div>
                    <div class="serv10-page__main__engBox__box__description">
                        <div class="serv10-page__main__engBox__box__description__icon">
                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="ícone">
                        </div>
                        <h4 class="serv10-page__main__engBox__box__description__title">Titulo Topico</h4>
                        <div class="serv10-page__main__engBox__box__description__paragraph">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                        </div>
                        <a href="#" class="serv10-page__main__engBox__box__description__btn">
                            <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="ícone Button">
                            CTA
                        </a>
                    </div>
                </div>
            </div>
            {{-- END serv10-page__main__engBox__box --}}
            @endfor
        </div>
        {{-- END serv10-page__main__engBox --}}
    </div>
    {{-- END serv10-page__main --}}
</section>
{{-- END serv10-page --}}
{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
