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
                        <li class="breadcrumb-item active">Staff</li>
                    </ol>
                </div>
                <h4 class="page-title">Staff</h4>
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
                    <a class="btn btn-success" href="{{route('master.staff.create')}}">Create</a>
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped dt-responsive nowrap table-vertical"
                               width="100%"
                               cellspacing="0">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="myModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Qr Code</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" style="text-align: center">
                    <div id="qr-image"></div>
                    <div id="qr-download"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-close">Close</button>
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
        function openModal(qr) {
            $("#qr-image").html('<img src="' + qr + '" class="img-fluid">');
            $("#qr-download").html('<a download="qr.png" target="_blank" href="' + qr + '">Download</a>');
            $("#myModal").modal('show');
        }

        $(".btn").click(function () {
            $("#myModal").modal('hide');
        });

        $(document).ready(function () {
            $('#datatable').DataTable({
                responsive: {
                    details: false
                },
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('master.staff.datatable') }}",
                    "type": "get",
                    "data": function (d) {
                        // d.additional_param = additional_value;
                    }
                },
                "lengthMenu": [10, 25, 50, 100],
                "scrollX": true,
                "dom": 'Bfrtip',
                "columns": [
                    // {
                    //     data: 'pict',
                    //     title: '',
                    //     orderable: false,
                    //     searchable: false,
                    //     class: 'product-list-img',
                    //     render: function (data) {
                    //         return '<img src="' + data + '" class="img-fluid" alt="tbl">'
                    //     }
                    // },
                    {data: 'qr', title: 'QR', orderable: false, searchable: false},
                    {data: 'work_id_number', title: 'Work Identity No.', orderable: true, searchable: true},
                    {data: 'name', title: 'Name', orderable: true, searchable: true},
                    {data: 'email', title: 'Email', orderable: true, searchable: true},
                    {data: 'id_number', title: 'NIK', orderable: true, searchable: true},
                    {data: 'address', title: 'Address', orderable: true, searchable: true},
                    {data: 'mobile', title: 'Mobile', orderable: true, searchable: true},
                    {
                        data: 'action',
                        title: 'Action', orderable: false, searchable: false,
                        render: function (data) {
                            return data
                        }
                    },
                ],
                // "destroy" : true
            })
            ;
        });

        function deleteData(id) {
            var url = "{{ route('master.staff.delete', ':id') }}";
            url = url.replace(':id', id);
            swal_delete(url, "{{csrf_token()}}");
        }
    </script>

@endsection

