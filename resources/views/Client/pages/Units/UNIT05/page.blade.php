@extends('Client.Core.client')
@section('content')
    {{-- BEGIN Page content --}}
    <h1>teste</h1>
    {{-- Finish Content page Here --}}
    @foreach ($sections as $section)
        {!! $section !!}
    @endforeach
@endsection
