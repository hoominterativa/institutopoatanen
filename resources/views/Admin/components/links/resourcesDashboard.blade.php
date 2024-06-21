@push('dashboardCss')
    <!-- Plugins css -->
    <link href="{{url(('Admin/assets/libs/dropzone.min.css'))}}" rel="stylesheet" type="text/css" />
    <link href="{{url(('Admin/assets/libs/dropify.min.css'))}}" rel="stylesheet" type="text/css" />
    <link href="{{url(('Admin/assets/libs/cropper.min.css'))}}" rel="stylesheet" type="text/css" />
    <link href="{{url(('Admin/assets/libs/rcrop.css'))}}" rel="stylesheet" type="text/css" />
@endpush

@push('dashboardJs')
    <!-- Plugin js-->
    <script src="{{url(('Admin/assets/libs/parsley.min.js'))}}"></script>
    <script src="{{url(('Admin/assets/libs/i18n/pt-br.js'))}}"></script>
    <script src="{{url(('Admin/assets/libs/dropzone.min.js'))}}"></script>
    <script src="{{url(('Admin/assets/libs/dropify.min.js'))}}"></script>
    <script src="{{url(('Admin/assets/libs/cropper.min.js'))}}"></script>
    <script src="{{url(('Admin/assets/libs/rcrop.js'))}}"></script>

    <!-- Pages init js-->
    <script src="{{url(('Admin/assets/js/pages/form-validation.init.js'))}}"></script>
    <script src="{{url(('Admin/assets/js/pages/form-imagecrop.init.js'))}}"></script>
@endpush

