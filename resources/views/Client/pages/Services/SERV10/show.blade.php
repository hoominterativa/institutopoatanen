@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<section id="serv10-show" class="serv10-show">
    <div class="serv10-show__banner" style="background-image:url('{{asset('storage/uploads/tmp/bannercopa02.png')}}'); background:;">
        {{-- <div class="serv10-show__banner__mask"></div> --}}
        <div class="container container--edit">
            <h4 class="serv10-show__banner__title">Titulo do banner</h4>
        </div>
    </div>
    {{-- END serv10__banner --}}
    <div class="serv10-show__emphasis">
        <div class="container container--emp">
            <div class="serv10-show__emphasis__image">
                <img src="{{asset('storage/uploads/tmp/gall01_image1.png')}}" alt="Imagem Box">
            </div>
            <div class="serv10-show__emphasis__description">
                <h4 class="serv10-show__emphasis__description__title">Titulo</h4>
                <hr class="serv10-show__emphasis__description__line">
                <div class="serv10-show__emphasis__description__paragraph">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. 
                        Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim 
                        faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non 
                        libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt 
                        dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin
                        vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. 
                        Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectet
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="serv10-show__faq">
        <div class="container container--faq">
            <div class="serv10-show__faq__header">
                <h2 class="serv10-show__faq__header__title">Titulo</h2>
                <h3 class="serv10-show__faq__header__subtitle">Subtitulo</h3>
                <hr class="serv10-show__faq__header__line">
                <div class="serv10-show__faq__header__paragraph">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida 
                        sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. 
                        In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. 
                    </p>
                </div>
            </div>
            <div class="serv10-show__faq__main">
                <div class="serv10-show__faq__main__box">
                    <button class="serv10-show__faq__main__box__tab accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-1" aria-expanded="false" aria-controls="collapseTwo">
                        <h4 class="serv10-show__faq__main__box__tab__title">Lorem ipsum dolor sit amet,</h4>
                    </button>
                    <div id="faq-1" class="serv10-show__faq__main__box__description accordion-collapse collapse" data-bs-parent="#faq-1">
                        <div class="serv10-show__faq__main__box__description__paragraph">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. 
                                Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim 
                                faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non 
                                libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt 
                                dignissim faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida 
                                sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu eget purus mattis 
                                posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor sit amet, consectetvLorem ipsum dolor sit amet, 
                                consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. Vivamus commodo porta velit,
                                 vel tempus mi pretium sed. In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. Lorem ipsum dolor 
                                 sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non libero. 
                                Vivamus commodo porta velit, vel tempus mi pretium sed. In et arcu ege
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="serv10-show__featuredBox">
        <div class="container container--feat">
            <div class="serv10-show__featuredBox__header">
                <h2 class="serv10-show__featuredBox__header__title">Titulo</h2>
                <h3 class="serv10-show__featuredBox__header__subtitle">Subtitulo</h3>
                <hr class="serv10-show__featuredBox__header__line">
                <div class="serv10-show__featuredBox__header__paragraph">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida 
                        sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. 
                        In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. 
                    </p>
                </div>
            </div>
            <div class="serv10-show__featuredBox__main row mx-auto">
                @for($i = 0; $i <= 3; $i ++)
                <div class="serv10-show__featuredBox__main__box col-sm-3">
                    <div class="serv10-show__featuredBox__main__box__content">
                        <div class="serv10-show__featuredBox__main__box__bg">
                            <img src="{{asset('storage/uploads/tmp/image-box-white.jpg')}}" alt="Bg">
                        </div>
                        <div class="serv10-show__featuredBox__main__box__description">
                            <div class="serv10-show__featuredBox__main__box__description__icon">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="ícone">
                            </div>
                            <h4 class="serv10-show__featuredBox__main__box__description__title">Titulo Topico</h4>
                            <div class="serv10-show__featuredBox__main__box__description__paragraph">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- END serv10-show__featuredBox__main__box --}}
                @endfor
            </div>
        </div>
    </div>
    <div class="serv10-show__gallery">
        <div class="container container--gall">
            <div class="serv10-show__gallery__header">
                <h2 class="serv10-show__gallery__header__title">Galeria</h2>
                <div class="serv10-show__gallery__header__paragraph">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida 
                        sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. 
                        In et arcu eget purus mattis posuere. Donec tincidunt dignissim faucibus. 
                    </p>
                </div>
            </div>
            <div class="serv10-show__gallery__main row mx-auto">
                @for($i = 0; $i <= 3; $i ++)
                    <div class="serv10-show__gallery__main__box col-sm-3">
                        <figure class="serv10-show__gallery__main__box__content">
                            <img src="{{asset('storage/uploads/tmp/gall01_image1.png')}}" alt="Imagem Galeria">
                        </figure>
                    </div>
                    {{-- END serv10-show__gallery__main__box --}}
                @endfor
            </div>
        </div>
    </div>
</section>
{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
