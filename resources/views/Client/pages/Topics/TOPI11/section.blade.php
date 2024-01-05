<section id="TOPI11" class="topi11">
    <div class="topi11__container container">
        @if ($section)
            <div class="topi11__header">
                @if ($section->title || $section->subtitle)
                    <h3 class="topi11__header__title">{{$section->title}}</h3>
                    <h4 class="topi11__header__subtitle">{{$section->subtitle}}</h4>
                    <hr class="topi11__header__line">
                @endif
                @if ($section->description)
                    <p class="topi11__header__paragraph">{!! $section->description !!}</p>
                @endif
            </div>
        @endif
        {{-- END .topi11__header --}}
        <div class="topi11__wrapper">
            <div class="topi11__wrapper__row row">
                <div class="topi11__wrapper__items col-12 {{$section?($section->path_image?'col-md-8':''):''}}">
                    <div class="accordion" id="accordion__topi11">
                        @foreach ($topics as $topic)
                            <div class="topi11__wrapper__item accordion-item">
                                <h3 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{$topic->id}}" aria-expanded="false" aria-controls="collapseOne">
                                        {{$topic->title}}
                                    </button>
                                </h3>
                                <div id="collapse-{{$topic->id}}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordion__topi11">
                                    <div class="accordion-body">
                                        {!!$topic->text!!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        {{-- END .topi11__wrapper__item --}}
                    </div>
                    {{-- END .accordion --}}
                </div>
                {{-- END .topi11__wrapper__items --}}
                @if ($section)
                    @if ($section->path_image)
                        <div class="topi11__wrapper__image col-12 col-md-4">
                            <img src="{{asset('storage/'.$section->path_image)}}" class="topi11__wrapper__image__img" alt="">
                        </div>
                    @endif
                @endif
            </div>
            {{-- END .topi11__wrapper --}}
        </div>
        {{-- END .topi11__wrapper-items --}}
    </div>
    {{-- END .container --}}
</section>
{{-- END #TOPI11 --}}
