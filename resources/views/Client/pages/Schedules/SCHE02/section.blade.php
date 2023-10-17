@if ($section)
    <section id="SCHE02" style="background-image: url({{ asset('storage/' . $section->path_image_desktop_section) }}); background-color: {{$section->background_color_section}};">
        @if ($section->path_image_desktop_section)
            <div class="sche02__mask"></div>
        @endif
        <header>
            @if ($section->title_section || $section->subtitle_section)
                <h1>{{$section->title_section}}</h1>
                <h2>{{$section->subtitle_section}}</h2>
                <hr>
            @endif
            <div>
                @if ($section->description_section)
                    <p>
                        {!! $section->description_section !!}
                    </p>
                @endif
            </div>
        </header>
        <main>
            <div>
                @foreach ($schedules as $schedule)
                    <div>
                        <div>
                            <span>{{Carbon\Carbon::parse($schedule->event_date)->formatLocalized('%d')}}</span>
                            <span>{{Carbon\Carbon::parse($schedule->event_date)->formatLocalized('%b')}}</span>
                        </div>
                        <div>
                            <span>{{ucfirst(Carbon\Carbon::parse($schedule->event_date)->formatLocalized('%A'))}}</span>
                            <h3>{{$schedule->event_locale}}</h3>
                        </div>
                        <div>
                            <p>{!! $schedule->informations !!}</p>
                            @if ($schedule->link_button_one)
                                <a href="{{getUri($schedule->link_button_one)}}" target="{{$schedule->target_link_button_one}}">
                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}">
                                    @if ($schedule->title_button_one)
                                        {{$schedule->title_button_one}}
                                    @endif
                                </a>
                            @endif
                            @if ($schedule->link_button_two)
                                <a href="{{getUri($schedule->link_button_two)}}" target="_blank">
                                    <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}">
                                    @if ($schedule->title_button_two)
                                        {{$schedule->title_button_two}}
                                    @endif
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div>
                @if ($section->path_image_section)
                    <img src="{{ asset('storage/' . $section->path_image_section) }}">
                @endif
            </div>
        </main>
    </section>
@endif
