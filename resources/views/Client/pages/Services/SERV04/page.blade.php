@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}

@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
