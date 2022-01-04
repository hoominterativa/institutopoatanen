@extends('Client.Core.client')
@section('content')
{{-- Page content --}}
---
{{-- BEGIN Page content --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
