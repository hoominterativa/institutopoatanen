@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}

@if ($section)
    <div id="bran04" class="bran04">
        <div class="container">
            <div class="bran04__encompass">
                @if ($section->title || $section->subtitle)
                    <h2 class="bran04__encompass__title">{{ $section->title }}</h2>
                    <h3 class="bran04__encompass__subtitle">{{ $section->subtitle }}</h3>
                    <hr class="bran04__encompass__line">
                @endif
                <div class="bran04__encompass__paragraph">
                    @if ($section->description)
                    <p>
                        {!! $section->description !!}
                    </p>
                    @endif
                </div> 
            </div>
            @if ($brands->count())
                <div class="bran04__content row">
                    @foreach ($brands as $brand)
                        <div class="bran04__box col-sm-4 d-flex -justify-content-center align-items-center">
                            <a href="{{getUri($brand->link?? '#')}}" target="_blank" class="link-full" @if (!$brand->link) style="cursor: default;" @endif></a>
                            <div class="bran04__box__image" style="background-image:url({{ asset('storage/' . $brand->path_image) }});">
                                @if ($brand->path_image_icon)
                                    <img src="{{ asset('storage/' . $brand->path_image_icon) }}" alt="Logo" loading="lazy">
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endif

{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
