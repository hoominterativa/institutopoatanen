@extends('layouts.master')
@section('content')
<main id="root">
    @foreach ($sections as $section)
        {{$section}}
    @endforeach
</main>
@endsection
