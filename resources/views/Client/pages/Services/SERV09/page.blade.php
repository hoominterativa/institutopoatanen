@extends('Client.Core.client')
@section('content')
    <main id="root" class="serv09-page">
        @if ($section)
            <section class="serv09-page__banner"
                style="background-image: url({{ asset('storage/' . $section->path_image_desktop) }});  background-color: {{ $section->background_color }};">

                @if ($section->title_banner)
                    <h1 class="serv09-page__banner__title">{{ $section->title_banner }}</h1>
                @endif

                @if ($section->subtitle_banner)
                    <h2 class="serv09-page__banner__subtitle">{{ $section->subtitle_banner }}</h2>
                @endif
            </section>
        @endif

        @if ($categories->count())
            <aside class="serv09-page__aside">
                <div class="serv09-page__aside__categories">
                    <menu class="serv09-page__aside__categories__swiper-wrapper swiper-wrapper">
                        @foreach ($categories as $category)
                            <li
                                class="serv09-page__aside__categories__item swiper-slide {{ $category->id == $categoryGet->id ? 'active' : '' }}">
                                <a href="{{ route('serv09.category.page', ['SERV09ServicesCategory' => $category->slug]) }}"
                                    class="link-full" title="{{ $category->title }}"></a>
                                <img src="{{ asset('storage/' . $category->path_image) }}"
                                    alt="Ícone da categoria {{ $category->title }}"
                                    class="serv09-page__aside__categories__item__icon" loading='lazy'>
                                {{ $category->title }}
                            </li>
                        @endforeach
                    </menu>
                </div>

                <div class="serv09-page__aside__filter quedinha">
                    {{-- FRONTEND o formulário está fechando quando o input é selecionado --}}
                    <button class="serv09-page__aside__filter__btn quedinha__btn">
                        Filtro
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                            fill="none">
                            <path
                                d="M1.25 4.37503H1.33875C1.47517 4.91102 1.78629 5.38627 2.22295 5.72572C2.65961 6.06516 3.19692 6.24944 3.75 6.24944C4.30308 6.24944 4.84039 6.06516 5.27705 5.72572C5.71371 5.38627 6.02483 4.91102 6.16125 4.37503H18.75C18.9158 4.37503 19.0747 4.30918 19.1919 4.19197C19.3092 4.07476 19.375 3.91579 19.375 3.75003C19.375 3.58427 19.3092 3.42529 19.1919 3.30808C19.0747 3.19087 18.9158 3.12503 18.75 3.12503H6.16125C6.02483 2.58904 5.71371 2.11378 5.27705 1.77433C4.84039 1.43489 4.30308 1.25061 3.75 1.25061C3.19692 1.25061 2.65961 1.43489 2.22295 1.77433C1.78629 2.11378 1.47517 2.58904 1.33875 3.12503H1.25C1.08424 3.12503 0.925268 3.19087 0.808058 3.30808C0.690848 3.42529 0.625 3.58427 0.625 3.75003C0.625 3.91579 0.690848 4.07476 0.808058 4.19197C0.925268 4.30918 1.08424 4.37503 1.25 4.37503ZM3.75 2.50003C3.99723 2.50003 4.2389 2.57334 4.44446 2.71069C4.65002 2.84804 4.81024 3.04326 4.90485 3.27167C4.99946 3.50008 5.02421 3.75141 4.97598 3.99389C4.92775 4.23637 4.8087 4.45909 4.63388 4.63391C4.45907 4.80873 4.23634 4.92778 3.99386 4.97601C3.75139 5.02424 3.50005 4.99949 3.27165 4.90488C3.04324 4.81027 2.84801 4.65005 2.71066 4.44449C2.57331 4.23893 2.5 3.99725 2.5 3.75003C2.5 3.41851 2.6317 3.10056 2.86612 2.86614C3.10054 2.63172 3.41848 2.50003 3.75 2.50003ZM18.75 9.37503H18.6612C18.5248 8.83904 18.2137 8.36378 17.7771 8.02433C17.3404 7.68489 16.8031 7.50061 16.25 7.50061C15.6969 7.50061 15.1596 7.68489 14.7229 8.02433C14.2863 8.36378 13.9752 8.83904 13.8387 9.37503H1.25C1.08424 9.37503 0.925268 9.44087 0.808058 9.55808C0.690848 9.67529 0.625 9.83427 0.625 10C0.625 10.1658 0.690848 10.3248 0.808058 10.442C0.925268 10.5592 1.08424 10.625 1.25 10.625H13.8387C13.9752 11.161 14.2863 11.6363 14.7229 11.9757C15.1596 12.3152 15.6969 12.4994 16.25 12.4994C16.8031 12.4994 17.3404 12.3152 17.7771 11.9757C18.2137 11.6363 18.5248 11.161 18.6612 10.625H18.75C18.9158 10.625 19.0747 10.5592 19.1919 10.442C19.3092 10.3248 19.375 10.1658 19.375 10C19.375 9.83427 19.3092 9.67529 19.1919 9.55808C19.0747 9.44087 18.9158 9.37503 18.75 9.37503ZM16.25 11.25C16.0028 11.25 15.7611 11.1767 15.5555 11.0394C15.35 10.902 15.1898 10.7068 15.0951 10.4784C15.0005 10.25 14.9758 9.99864 15.024 9.75616C15.0722 9.51369 15.1913 9.29096 15.3661 9.11614C15.5409 8.94133 15.7637 8.82228 16.0061 8.77404C16.2486 8.72581 16.4999 8.75057 16.7284 8.84518C16.9568 8.93979 17.152 9.1 17.2893 9.30556C17.4267 9.51113 17.5 9.7528 17.5 10C17.5 10.3315 17.3683 10.6495 17.1339 10.8839C16.8995 11.1183 16.5815 11.25 16.25 11.25ZM18.75 15.625H12.4113C12.2748 15.089 11.9637 14.6138 11.5271 14.2743C11.0904 13.9349 10.5531 13.7506 10 13.7506C9.44692 13.7506 8.90961 13.9349 8.47295 14.2743C8.03629 14.6138 7.72517 15.089 7.58875 15.625H1.25C1.08424 15.625 0.925268 15.6909 0.808058 15.8081C0.690848 15.9253 0.625 16.0843 0.625 16.25C0.625 16.4158 0.690848 16.5748 0.808058 16.692C0.925268 16.8092 1.08424 16.875 1.25 16.875H7.58875C7.72517 17.411 8.03629 17.8863 8.47295 18.2257C8.90961 18.5652 9.44692 18.7494 10 18.7494C10.5531 18.7494 11.0904 18.5652 11.5271 18.2257C11.9637 17.8863 12.2748 17.411 12.4113 16.875H18.75C18.9158 16.875 19.0747 16.8092 19.1919 16.692C19.3092 16.5748 19.375 16.4158 19.375 16.25C19.375 16.0843 19.3092 15.9253 19.1919 15.8081C19.0747 15.6909 18.9158 15.625 18.75 15.625ZM10 17.5C9.75277 17.5 9.5111 17.4267 9.30554 17.2894C9.09998 17.152 8.93976 16.9568 8.84515 16.7284C8.75054 16.5 8.72579 16.2486 8.77402 16.0062C8.82225 15.7637 8.9413 15.541 9.11612 15.3661C9.29093 15.1913 9.51366 15.0723 9.75614 15.024C9.99861 14.9758 10.2499 15.0006 10.4784 15.0952C10.7068 15.1898 10.902 15.35 11.0393 15.5556C11.1767 15.7611 11.25 16.0028 11.25 16.25C11.25 16.5815 11.1183 16.8995 10.8839 17.1339C10.6495 17.3683 10.3315 17.5 10 17.5Z"
                                fill="#000" />
                        </svg>
                    </button>

                    <div class="serv09-page__aside__filter__content quedinha__content">
                        {!! Form::model([
                            'method' => 'post',
                            'class' => 'serv09-page__aside__filter__content__form send_form_ajax form-contact parsley-validate',
                        ]) !!}

                        @include('Client.Components.inputs', [
                            'name' => 'uf',
                            'placeholder' => 'Estado',
                            'required' => true,
                            'type' => 'select',
                            'options' => 'Rio de Janeiro, Bahia',
                        ])

                        @include('Client.Components.inputs', [
                            'name' => 'cidade',
                            'placeholder' => 'Cidade',
                            'required' => true,
                            'type' => 'select',
                            'options' => 'Petrópolis, Salvador',
                        ])

                        <button type="submit" class="serv09-page__aside__filter__content__form__cta">Buscar</button>

                        {!! Form::close() !!}

                    </div>
                </div>

            </aside>
        @endif

        @if ($services->count())
            <section class="serv09-page__main">
                <div class="serv09-page__main__list">
                    @foreach ($services as $service)
                        <article class="serv09-page__main__list__item">

                            <a href="{{ route('serv09.page.content', ['SERV09ServicesCategory' => $service->categories->slug, 'SERV09Services' => $service->slug]) }}"
                                class="link-full" title="{{ $service->title }}">
                            </a>

                            <div class="serv09-page__main__list__item__information">

                                @if ($service->title)
                                    <h3 class="serv09-page__main__list__item__information__title">{{ $service->title }}
                                    </h3>
                                @endif

                                @if ($service->subtitle)
                                    <h4 class="serv09-page__main__list__item__information__subtitle">
                                        {{ $service->subtitle }}</h4>
                                @endif

                                @if ($service->price)
                                    <span class="serv09-page__main__list__item__information__price">
                                        R$ {{ $service->price }}
                                    </span>
                                @endif

                                @if ($service->description)
                                    <div class="serv09-page__main__list__item__information__paragraph">
                                        <p>
                                            {!! $service->description !!}
                                        </p>
                                    </div>
                                @endif

                                @if ($service->topics->count())
                                    <ul class="serv09-page__main__list__item__information__topics">
                                        @foreach ($service->topics as $topic)
                                            <li class="serv09-page__main__list__item__information__topics__item">
                                                @if ($topic->path_image)
                                                    <img src="{{ asset('storage/' . $topic->path_image) }}"
                                                        alt="Ícone de {{ $topic->title }}" loading='lazy'
                                                        class="serv09-page__main__list__item__information__topics__item__icon">
                                                @endif

                                                {{ $topic->title }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                                @if ($service->percentage)
                                    <div class="serv09-page__main__list__item__information__progress">

                                        <span class="serv09-page__main__list__item__information__progress__title">
                                            {{ $service->percentage === 100 ? 'Concluído' : 'Em andamento' }}
                                        </span>

                                        <div class="serv09-page__main__list__item__information__progress__bar">
                                            <span class="serv09-page__main__list__item__information__progress__bar__fill"
                                                style="width: {{ $service->percentage }}%;"></span>
                                        </div>

                                        <span class="serv09-page__main__list__item__information__progress__number">
                                            {{ $service->percentage }}%
                                        </span>
                                    </div>
                                @endif

                            </div>

                            <img src="{{ asset('storage/' . $service->path_image) }}"
                                alt="Imagem do serviço {{ $service->title }}" class="serv09-page__main__list__item__image">

                        </article>
                    @endforeach
                </div>

                {{ $services->links() }}
            </section>
        @endif

        <div id="teste"></div>
        @foreach ($sections as $section)
            {!! $section !!}
        @endforeach
    </main>
@endsection
