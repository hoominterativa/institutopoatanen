@push('indexCss')
    <!-- Plugins css -->
    <link href="{{url(mix('admin/assets/libs/bootstrap-table.min.css'))}}" rel="stylesheet" type="text/css" />
    <link href="{{url(mix('admin/assets/libs/sweetalert2.min.css'))}}" rel="stylesheet" type="text/css" />
@endpush

@push('indexJs')
    <!-- Plugin js-->
    <script src="{{url(mix('admin/assets/libs/bootstrap-table.min.js'))}}"></script>
    <script src="{{url(mix('admin/assets/libs/jquery.tabledit.min.js'))}}"></script>
    <script src="{{url(mix('admin/assets/libs/sweetalert2.all.min.js'))}}"></script>

    <!-- Pages init js-->
    <script src="{{url(mix('admin/assets/js/pages/bootstrap-tables.init.js'))}}"></script>
@endpush
