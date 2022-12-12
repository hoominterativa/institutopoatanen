@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<h4>sdasdasda</h4>
{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
