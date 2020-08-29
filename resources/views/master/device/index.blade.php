@extends('layouts.master')

@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <!-- Responsive datatable examples -->
    <link href="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
          type="text/css"/>
@endsection

@section('breadcrumb')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group pull-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Device</li>
                    </ol>
                </div>
                <h4 class="page-title">Device</h4>
            </div>
        </div>
    </div>
    <!-- end page title end breadcrumb -->
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body">
                    <table id="datatable" class="table table-striped dt-responsive nowrap table-vertical" width="100%"
                           cellspacing="0">
                    </table>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <!-- Datatable js -->
    <script src="{{ URL::asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Responsive examples -->
    <script src="{{ URL::asset('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
@endsection

@section('script-bottom')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#datatable').DataTable({
                "processing": true,
                "responsive": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route($route.'datatable') }}",
                    "type": "get",
                    "data": function (d) {
                        // d.additional_param = additional_value;
                    }
                },
                "lengthMenu": [10, 25, 50, 100],
                "scrollX": true,
                "dom": 'Bfrtip',
                "columns": [
                    // {data: 'work_id_number', title: 'Work Identity No.', orderable: true, searchable: true},
                    {data: 'name', title: 'Name', orderable: true, searchable: true},
                    {data: 'email', title: 'Email', orderable: true, searchable: true},
                    {data: 'manufacture', title: 'Manufacture', orderable: true, searchable: true},
                    {data: 'brand', title: 'Brand', orderable: true, searchable: true},
                    {data: 'model', title: 'Model', orderable: true, searchable: true},
                    {data: 'imei', title: 'IMEI', orderable: true, searchable: true},
                    {data: 'serial', title: 'Serial', orderable: true, searchable: true},
                    {data: 'device_id', title: 'Device ID', orderable: true, searchable: true},
                    {
                        data: 'action',
                        title: 'Action', orderable: false, searchable: false,
                        render: function (data) {
                            return data
                        }
                    },
                ],
            })
            ;
        });

        function deleteData(id) {
            var url = "{{ route($route.'delete', ':id') }}";
            url = url.replace(':id', id);
            swal_delete(url, "{{csrf_token()}}");
        }
    </script>

@endsection

