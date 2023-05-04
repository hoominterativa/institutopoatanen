@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}

{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
