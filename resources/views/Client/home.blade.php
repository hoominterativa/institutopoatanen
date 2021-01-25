@php
    echo App\Http\Controllers\CoreController::Header();
@endphp
@section('content')
    <main id="root">
        {{-- @foreach ($sections as $section)
            {{$section}}
        @endforeach --}}
    </main>
@endsection
@php
    // echo App\Http\Controllers\CoreController::Footer();
@endphp
