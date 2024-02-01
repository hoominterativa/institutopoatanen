@if ($contents->count())
    @foreach ($contents as $content)
        <section id="CONT12" class="cont12">
            @if ($content)
                <header class="cont12__header">
                    <div class="container cont12__header__container">
                        @if ($content->title || $content->subtitle)
                            <h2 class="cont12__title">{{$content->title}}</h2>
                            <h3 class="cont12__subtitle">{{$content->subtitle}}</h3>
                            <hr class="cont12__line">
                        @endif
                    </div>
                </header>
            @endif
            @if ($content->topics->count())
                <main class="cont12__main">
                    <ul class="cont12__list container">
                        @foreach ($content->topics as $topic)
                            <li class="cont12__list__item">
                                <div class="cont12__list__item__left">
                                    @if ($topic->path_image_icon || $topic->title)
                                        <img src="{{ asset('storage/' . $topic->path_image_icon) }}" alt="" class="cont12__list__item__icon">
                                        <h4 class="cont12__list__item__title">{{$topic->title}}</h4>
                                    @endif
                                </div>
                                <div class="cont12__list__item__right">
                                    @if ($topic->path_archive)
                                        <a href="{{asset('storage/'.$topic->path_archive)}}" download="" class="cont12__list__item__cta">
                                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" class="cont12__list__item__cta__icon" alt="">
                                            Download do arquivo
                                        </a>
                                    @endif
                                    @if ($topic->link_button)
                                        <a href="{{getUri($topic->link_button)}}" target="{{$topic->target_link_button}}"  class="cont12__list__item__cta">
                                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}" class="cont12__list__item__cta__icon" alt="">
                                            {{$topic->title_button}}
                                        </a>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </main>
            @endif
        </section>
    @endforeach
@endif
