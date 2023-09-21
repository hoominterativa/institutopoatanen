<section id="CONT12" class="cont12">
    @if ($section)
        <header class="cont12__header">
            <div class="container cont12__header__container">
                @if ($section->title || $section->subtitle)
                    <h2 class="cont12__title">{{$section->title}}</h2>
                    <h3 class="cont12__subtitle">{{$section->subtitle}}</h3>
                    <hr class="cont12__line">
                @endif
            </div>
        </header>
    @endif
    @if ($contents)
        <main class="cont12__main">
            <ul class="cont12__list container">
                @foreach ($contents as $content)
                    <li class="cont12__list__item">
                        <div class="cont12__list__item__left">
                            @if ($content->path_image_icon || $content->title)
                                <img src="{{ asset('storage/' . $content->path_image_icon) }}" alt="" class="cont12__list__item__icon">
                                <h4 class="cont12__list__item__title">{{$content->title}}</h4>
                            @endif
                        </div>
                        <div class="cont12__list__item__right">
                            @if ($content->path_archive)
                                <a href="{{asset('storage/'.$content->path_archive)}}" download="" class="cont12__list__item__cta">
                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" class="cont12__list__item__cta__icon" alt="">
                                    Download do arquivo
                                </a>
                            @endif
                            @if ($content->link_button)
                                <a href="{{getUri($content->link_button)}}" target="{{$content->target_link}}"  class="cont12__list__item__cta">
                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" class="cont12__list__item__cta__icon" alt="">
                                    {{$content->title_button}}
                                </a>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        </main>
    @endif
</section>
