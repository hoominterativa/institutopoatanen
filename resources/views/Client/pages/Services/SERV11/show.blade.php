<div class="serv11-show" id="M{{$service->id}}">
    @if ($service->path_image)
        <img class="serv11-show__image" src="{{asset('storage/'.$service->path_image)}}" alt="Imagem do serviço {{$service->title}}">
    @endif
    <div class="serv11-show__information">
        <header class="serv11-show__information__header">
            @if ($service->subtitle)
                <h3 class="serv11-show__information__header__subtitle">{{$service->subtitle}}</h3>
            @endif
            @if ($service->title)
                <h2 class="serv11-show__information__header__title">{{$service->title}}</h2>
            @endif
            @if ($service->path_image_icon)
                <img src="{{asset('storage/'.$service->path_image_icon)}}" alt="Ícone do serviço {{$service->title}} " class="serv11-show__information__header__icon">
            @endif
        </header>
        @if ($service->text)
            <div class="serv11-show__information__paragraph">
                <p>
                    {!! $service->text !!}
                </p>
            </div>
        @endif
    </div>
</div>
