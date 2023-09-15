@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}

<div id="lightbox-serv08" class="lightbox-serv08 row">
    <h3>Olá</h3>
</div>

{{-- Finish Content page Here --}}
@foreach ($sections as $section)
{!!$section!!}
@endforeach
@endsection