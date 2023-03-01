@push('dashboardCss')
    <!-- Plugins css -->
    <link href="{{url(mix('Admin/assets/libs/dropzone.min.css'))}}" rel="stylesheet" type="text/css" />
    <link href="{{url(mix('Admin/assets/libs/dropify.min.css'))}}" rel="stylesheet" type="text/css" />
    <link href="{{url(mix('Admin/assets/libs/cropper.min.css'))}}" rel="stylesheet" type="text/css" />
    <link href="{{url(mix('Admin/assets/libs/rcrop.css'))}}" rel="stylesheet" type="text/css" />
@endpush

@push('dashboardJs')
    <!-- Plugin js-->
    <script src="{{url(mix('Admin/assets/libs/parsley.min.js'))}}"></script>
    <script src="{{url(mix('Admin/assets/libs/i18n/pt-br.js'))}}"></script>
    <script src="{{url(mix('Admin/assets/libs/dropzone.min.js'))}}"></script>
    <script src="{{url(mix('Admin/assets/libs/dropify.min.js'))}}"></script>
    <script src="{{url(mix('Admin/assets/libs/cropper.min.js'))}}"></script>
    <script src="{{url(mix('Admin/assets/libs/rcrop.js'))}}"></script>

    <!-- Pages init js-->
    <script src="{{url(mix('Admin/assets/js/pages/form-validation.init.js'))}}"></script>
    <script src="{{url(mix('Admin/assets/js/pages/form-imagecrop.init.js'))}}"></script>
@endpush

