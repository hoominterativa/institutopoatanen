<div id="FOOT04" class="foot04">
    <div class="foot04__contacts">
        @if ($generalSetting->phone || $generalSetting->whatsapp)
            <div class="foot04__contacts__item">
                <h3 class="foot04__contacts__item__title">Contato</h3>
                <a class="foot04__contacts__item__link"
                    href="tel:{{ $generalSetting->phone }}">{{ $generalSetting->phone }}</a>
                <a class="foot04__contacts__item__link"
                    href="https://api.whatsapp.com/send?phone=55{{ Str::slug($generalSetting->whatsapp, '') }}"
                    target="_blank">{{ $generalSetting->whatsapp }}</a>
            </div>
        @endif

        @if ($generalSetting->email)
            <div class="foot04__contacts__item">
                <h3 class="foot04__contacts__item__title">Email</h3>
                <a class="foot04__contacts__item__link" href="mailto:{{ $generalSetting->email }}">
                    {{ $generalSetting->email }}
                </a>
            </div>
        @endif

        @if ($generalSetting->address)
            <div class="foot04__contacts__item">
                <h3 class="foot04__contacts__item__title">Endereço</h3>
                <a class="foot04__contacts__item__link"
                    href="https://www.google.com/maps/search/?api=1&query={{ urlencode($generalSetting->address) }}"
                    target="_blank">
                    {{ $generalSetting->address }}
                </a>

            </div>
        @endif
    </div>

    <a title="ir para a página inicial" class="foot04__logo" href="{{ route('home') }}">
        <img class="foot04__logo__img"
            src="{{ asset('storage/' . $generalSetting->path_logo_footer_light ?? $generalSetting->path_logo_footer_dark) }}"
            alt="{{ env('APP_NAME') }}">
    </a>


    <div class="foot04__copyright">
        <ul class="foot04__copyright__list">
            @if ($linksCtaFooter->count())
                @foreach ($linksCtaFooter as $linkCtaHeader)
                    <li class="foot04__copyright__list__item">
                        <a title="{{ $linkCtaHeader->title }}" class="link-full"
                            href="{{ getUri($linkCtaHeader->link) }}" target="{{ $linkCtaHeader->link_target }}"></a>
                        {{ $linkCtaHeader->title }}
                    </li>
                @endforeach
            @endif

            @foreach (getCompliance() as $compliance)
                <li class="foot04__copyright__list__item">
                    <a class="link-full" href="{{ $compliance->link }}" target="_blank" class=""></a>
                    {{ $compliance->title_page }}
                </li>
            @endforeach
        </ul>

        <div class="foot04__copyright__hoom">
            <a title="Logo da hoom interativa" href="http://hoom.com.br" target="_blank" class="link-full"></a>
            <img class="foot04__copyright__hoom__img" src="{{ asset('storage/uploads/tmp/hoom.png') }}"
                alt="Hoom Interativa">

        </div>
    </div>
</div>
