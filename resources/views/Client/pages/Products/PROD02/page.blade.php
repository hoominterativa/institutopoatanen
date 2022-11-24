@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<section class="container-fluid px-0 prod02_page">
    <header>
        <div class="container d-flex">
            <h4 class="title">Titulo do banner</h4>
        </div>
    </header>
    <div class="prod02_page_content container">
        
    </div>
</section>
{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
