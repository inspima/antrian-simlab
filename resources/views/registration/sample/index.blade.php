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
                        <li class="breadcrumb-item"><a href="#">Registrasi</a></li>
                        <li class="breadcrumb-item active">Sample</li>
                    </ol>
                </div>
                <h4 class="page-title">Registrasi - Sample</h4>
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
                    <a class="btn btn-success" href="{{route($route.'create')}}"><i class="ion-plus-round"></i> Buat Baru</a>
                    <br>
                    <br>
                    <table id="datatable" class="table table-striped dt-responsive nowrap table-vertical" width="100%" cellspacing="0">
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
                "aaSorting": [],
                "columns": [
                    {data: 'code', title: 'Kode', orderable: false,sorting:false, searchable: true},
                    {data: 'date', title: 'Tanggal Reg.', orderable: false, searchable: true},
                    {data: 'description', title: 'Catatan', orderable: false, searchable: true},
                    {data: 'queue', title: 'Antrian',className: 'text-center', orderable: false, searchable: true},
                    {data: 'status', title: 'Status',className: 'text-center', orderable: false, searchable: true},
                    {
                        data: 'action', title: 'Action', className: 'text-center',orderable: false, searchable: false,
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
        function sendData(id) {
            var url = "{{ route($route.'send', ':id') }}";
            url = url.replace(':id', id);
            swal_confirm(url, "{{csrf_token()}}");
        }
    </script>

@endsection

