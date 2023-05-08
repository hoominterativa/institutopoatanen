@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<section id="BLOG03" class="blog03-page container-fluid px-0">
    
</section>    
{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
