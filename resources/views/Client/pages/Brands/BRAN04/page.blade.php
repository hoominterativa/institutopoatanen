@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}

@if ($section)
    <div>
        <div>
            @if ($section->title || $section->subtitle)
                <h2>{{ $section->title }}</h2>
                <h3>{{ $section->subtitle }}</h3>
                <hr>
            @endif
        </div>
        <div>
            @if ($section->description)
            <p>
                {!! $section->description !!}
            </p>
            @endif
        </div>
    </div>
@endif
@if ($brands->count())
    <div>
        @foreach ($brands as $brand)
            <div>
                <a href="{{getUri($brand->link?? '#')}}" target="_blank" class="link-full" @if (!$brand->link) style="cursor: default;" @endif></a>
                <div style="background-image:url({{ asset('storage/' . $brand->path_image) }});">
                    <div>
                        @if ($brand->path_image_icon)
                            <img src="{{ asset('storage/' . $brand->path_image_icon) }}" alt="Logo" loading="lazy">
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
