<nav id="FOOT02" class="foot02">
    <div class="foot02__navigation">
        <div class="foot02__navigation__client-info">
            <img class="foot02__navigation__client-info__logo"
                src="{{ asset('storage/' . $generalSetting->path_logo_footer_light ?? $generalSetting->path_logo_footer_dark) }}"
                alt="{{ env('APP_NAME') }}" loading= 'lazy'>

            @if ($socials->count() > 0)
                <ul class="foot02__navigation__client-info__socials">
                    @foreach ($socials as $social)
                        <li class="foot02__navigation__client-info__socials__item" title="{{ $social->title }}">
                            <a href="{{ $social->link }}" class="link-full" target="_blank"
                                title="{{ $social->title }}"></a>
                            <img class="foot02__navigation__client-info__socials__item__icon"
                                src="{{ asset('storage/' . $social->path_image_icon) }}" alt="{{ $social->title }}"
                                loading= 'lazy'>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <ul class="foot02__navigation__pages">
            <li class="foot02__navigation__pages__header">Site Map</li>
            <li class="foot02__navigation__pages__item">
                <a title="Home" href="{{ route('home') }}" class="foot02__navigation__pages__item__link">Home</a>
            </li>

            @foreach ($listMenu as $module => $menu)
                <li class="foot02__navigation__pages__item">
                    <a href="{{ $menu->anchor ? route('home') . $menu->link : $menu->link }}"
                        target="{{ $menu->target_link ?? '_self' }}"
                        class="foot02__navigation__pages__item__link">{{ $menu->title }}</a>
                </li>
            @endforeach
        </ul>

        @foreach ($listModelFooter as $menuFooter)
            <ul class="foot02__navigation__pages">
                <li class="foot02__navigation__pages__header">
                    <a href="{{ route($menuFooter->link) }}"
                        class="foot02__navigation__pages__header__link">{{ $menuFooter->title }}</a>

                </li>

                @if ($menuFooter->dropdown)
                    @foreach ($menuFooter->dropdown as $item)
                        <li class="foot02__navigation__pages__item">
                            <a href="{{ $item->route }}"
                                class="foot02__navigation__pages__item__link">{{ $item->name }}</a>
                        </li>
                    @endforeach
                @endif
            </ul>
        @endforeach

        @if ($generalSetting->phone || $generalSetting->whatsapp || $generalSetting->email || $generalSetting->address)

            <ul class="foot02__navigation__client-contact">
                <li class="foot02__navigation__client-contact__header">Contatos</li>

                @if ($generalSetting->phone)
                    <li class="foot02__navigation__client-contact__item">
                        <a title="telefone para contato" href="tel:{{ $generalSetting->phone }}"
                            class="foot02__navigation__client-contact__item">{{ $generalSetting->phone }}</a>
                    </li>
                @endif

                @if ($generalSetting->whatsapp)
                    <li class="foot02__navigation__client-contact__item">
                        <a title="Whatsapp para contato"
                            href="https://api.whatsapp.com/send?phone=55{{ Str::slug($generalSetting->whatsapp, '') }}"
                            target="_blank"
                            class="foot02__navigation__client-contact__item__link">{{ $generalSetting->whatsapp }}</a>
                    </li>
                @endif

                @if ($generalSetting->email)
                    <li class="foot02__navigation__client-contact__item">
                        <a title="Email para cotato" href="mailto:{{ $generalSetting->email }}"
                            class="foot02__navigation__client-contact__item__link">
                            {{ $generalSetting->email }}
                        </a>
                    </li>
                @endif

                @if ($generalSetting->address)
                    <li class="foot02__navigation__client-contact__item">
                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($generalSetting->address) }}"
                            target="_blank" class="foot02__navigation__client-contact__item__link">
                            {{ $generalSetting->address }}
                        </a>
                    </li>
                @endif
            </ul>

        @endif

        <button title="scroll para o topo" class="foot02__navigation__button"
            onclick="window.scrollTo({
                top: 0,
                left: 0,
                behavior: 'smooth'
              })">
            <img src="{{ asset('storage/uploads/tmp/seta.png') }}" alt="Seta para cima">
        </button>
    </div>

    <div class="foot02__copyright">
        <ul class="foot02__copyright__compliances">
            @foreach (getCompliance() as $compliance)
                <li>
                    <a href="{{ $compliance->link }}"
                        target="_blank"class="foot02__copyright__compliances__item">{{ $compliance->title_page }}</a>

                </li>
            @endforeach

            @if ($linksCtaFooter->count())
                @foreach ($linksCtaFooter as $linkCtaHeader)
                    <li class="foot02__copyright__compliances__item">
                        <a href="{{ getUri($linkCtaHeader->link) }}" target="{{ $linkCtaHeader->link_target }}"
                            class="foot02__copyright__compliances__item__link">{{ $linkCtaHeader->title }}</a>
                    </li>
                @endforeach
            @endif
        </ul>


        <a title="Logo da hoom interativa" href="http://hoom.com.br" target="_blank" class="">
            <img class="foot02__logo__hoom" src="{{ asset('storage/uploads/tmp/hoom.png') }}" alt="Hoom Interativa">
        </a>


    </div>
</nav>
