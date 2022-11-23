@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<h4>Olá mundo</h4>
{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
