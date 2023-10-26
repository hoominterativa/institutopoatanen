@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}

{{-- Finish Content page Here --}}
<main id="root">
    @foreach ($sections as $section)
    {!!$section!!}
    @endforeach
</main>
@endsection
