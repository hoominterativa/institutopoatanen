<div class="foot04 container-fluid px-0 position-relative" style="background-color:#EFEFEF;">
    <div class="row row--pd d-flex justify-content-center">
        <div class="foot04__content d-flex justify-content-center row mx-auto pd-0">
            @if ($generalSetting->phone || $generalSetting->whatsapp)
                <div class="foot04__content__boxUnit col px-0 d-flex">
                    <div class="foot04__content__boxUnit__icone">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="Logo">
                    </div>
                    <div class="foot04__content__boxUnit__description">
                        <h4 class="foot04__content__boxUnit__description__title">Contato</h4>
                        <a href="tel:{{ $generalSetting->phone }}" class=""
                            style="margin: inherit;">{{ $generalSetting->phone }} </a> <br>
                        <a href="https://api.whatsapp.com/send?phone=55{{ Str::slug($generalSetting->whatsapp, '') }}"
                            target="_blank" class="" style="margin: inherit;">{{ $generalSetting->whatsapp }}</a>
                    </div>
                </div>
            @endif
            @if ($generalSetting->email)
                <div class="foot04__content__boxUnit col px-0 d-flex">
                    <div class="foot04__content__boxUnit__icone">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="Logo">
                    </div>
                    <div class="foot04__content__boxUnit__description">
                        <h4 class="foot04__content__boxUnit__description__title">Email</h4>
                        <a href="mailto:{{ $generalSetting->email }}" class="">
                            {{ $generalSetting->email }}
                        </a>
                    </div>
                </div>
            @endif
            @if ($generalSetting->address)
                <div class="foot04__content__boxUnit col px-0 d-flex">
                    <div class="foot04__content__boxUnit__icone">
                        <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" alt="Logo">
                    </div>
                    <div class="foot04__content__boxUnit__description">
                        <h4 class="foot04__content__boxUnit__description__title">Endereço</h4>
                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($generalSetting->address) }}"
                            target="_blank" class="">
                            {{ $generalSetting->address }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
        <div class="foot04__content__logo d-flex justify-content-center">
            <a href="{{ route('home') }}" rel="next">
                <img src="{{ asset('storage/' . $generalSetting->path_logo_footer_light ?? $generalSetting->path_logo_footer_dark) }}"
                    class="w-100 h-100" alt="{{ env('APP_NAME') }}">
            </a>
        </div>
    </div>
    <div class="foot04__credits d-flex justify-content-between align-items-center px-0">
        <div class="container px-0">
            <div class="row row--mobile">
                <div class="d-flex justify-content-between w-100 px-0 foot04__credits__content">
                    <nav class="foot04__credits__nav d-flex align-items-center">
                        <ul class="d-flex align-items-center justify-content-between px-0 mb-0">
                            @if ($linksCtaFooter->count())
                                @foreach ($linksCtaFooter as $linkCtaHeader)
                                    <li>
                                        <a href="{{ getUri($linkCtaHeader->link) }}" target="{{ $linkCtaHeader->link_target }}" rel="next">{{ $linkCtaHeader->title }}</a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </nav>
                    <div class="foot04__credits__logo">
                        <a href="#" rel="next">
                            <img src="{{ asset('storage/uploads/tmp/logo.png') }}" class="w-100 h-100" alt="Logo">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
