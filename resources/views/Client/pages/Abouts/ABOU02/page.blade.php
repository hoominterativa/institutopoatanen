@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}


<!-- @include('Client.pages.Abouts.ABOU02.show'); -->

{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
