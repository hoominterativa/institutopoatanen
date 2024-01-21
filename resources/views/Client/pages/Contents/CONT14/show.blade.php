<div id="cont13__right__engBox" class="cont13__right__engBox">
    <div class="carousel-gallery-cont13 owl-carousel">
        @for($i=0; $i <= 2; $i++)
            <div class="cont13__right__engBox__box">
                <h4 class="cont13__right__engBox__box__title">Título Conteúdo{{$i}}</h4>
                <h5 class="cont13__right__engBox__box__subtitle">Subtítulo Conteúdo</h5>
                <div class="cont13__right__engBox__box__image">
                    <img src="{{asset('storage/uploads/tmp/thumbnail-b.png')}}" class="h-100 w-100" alt="Imagem">
                    <iframe src="" frameborder="0"></iframe>
                </div>
                <div class="cont13__right__engBox__box__paragraph">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus 
                        gravida sollicitudin vel non libero. Vivamus commodo porta velit, vel tempus mi pretium sed. 
                    </p>
                </div>
            </div>
            <!-- Fim-cont13__right__box -->
        @endfor
    </div>    
</div>