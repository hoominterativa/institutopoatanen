<footer id="FOOT06" class="foot06">
    <div class="foot06__container container">
        <div class="foot06__row row align-items-center">
            <div class="foot06__item foot06__item__logo col-12 col-md-4">
                <a href="{{route('home')}}">
                    <img src="{{asset('storage/'.$generalSetting->path_logo_footer_light??$generalSetting->path_logo_footer_dark)}}" width="234" class="foot06__logo" alt="{{env('APP_NAME')}}">
                </a>
            </div>
            {{-- END .foot06__item--logo --}}
            <div class="foot06__item foot06__item__socials col-12 col-md-4 text-center">
                <h3 class="foot06__item__socials__title">Título</h3>
                <div class="d-flex justify-content-center align-items-center">
                    @foreach ($socials as $social)
                        <a href="{{$social->link}}" title="{{$social->title}}" target="_blank" class="foot06__item__socials__link transition">
                            <img src="{{asset('storage/'.$social->path_image_icon)}}" width="36" alt="">
                        </a>
                    @endforeach
                </div>
            </div>
            {{-- END .foot06__item--socials --}}
            <div class="foot06__item foot06__item__cta col-12 col-md-4">
                @if ($linksCtaFooter->count())
                    @foreach ($linksCtaFooter as $linkCtaHeader)
                        <a class="foot06__item__cta__link" href="{{$linkCtaHeader->link}}" target="{{$linkCtaHeader->link_target}}" rel="next">
                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" class="me-2" alt="">
                            {{$linkCtaHeader->title}}
                        </a>
                    @endforeach
                @endif
            </div>
        </div>
        {{-- END .foot06__row --}}
    </div>
    {{-- END .foot06__container --}}
</footer>
