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
                        <li class="breadcrumb-item active">Guest</li>
                    </ol>
                </div>
                <h4 class="page-title">Guest</h4>
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
                    <a class="btn btn-success" href="{{route('master.guest.create')}}">Create</a>
                    <table id="datatable" class="table table-striped dt-responsive nowrap table-vertical" width="100%"
                           cellspacing="0">
                        {{--                        <thead>--}}
                        {{--                        <tr>--}}
                        {{--                            <th>Image</th>--}}
                        {{--                            <th>Name</th>--}}
                        {{--                            <th>Email</th>--}}
                        {{--                            <th>No. Identity</th>--}}
                        {{--                            <th>Address</th>--}}
                        {{--                            <th>Mobile</th>--}}
                        {{--                            <th>Action</th>--}}
                        {{--                        </tr>--}}
                        {{--                        </thead>--}}
                        {{--                        <tbody>--}}
                        {{--                        <tr>--}}
                        {{--                            <td>--}}
                        {{--                                <div class="product-list-img"><img--}}
                        {{--                                        src="{{ URL::asset('assets/images/products/1.jpg') }}" class="img-fluid"--}}
                        {{--                                        alt="tbl"></div>--}}
                        {{--                            </td>--}}
                        {{--                            <td>--}}
                        {{--                                <h6 class="mt-0 m-b-5">Riverston Glass Chair</h6>--}}
                        {{--                                <p class="m-0 font-14">Lorem ipsum dolor sit consec te imperdiet iaculis ipsum..</p>--}}
                        {{--                            </td>--}}
                        {{--                            <td>22/05/2017</td>--}}
                        {{--                            <td>$521</td>--}}
                        {{--                            <td>5841</td>--}}
                        {{--                            <td>--}}
                        {{--                                <div class="progress m-b-10" style="height: 5px;">--}}
                        {{--                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 25%;"--}}
                        {{--                                         aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>--}}
                        {{--                                </div>--}}
                        {{--                            </td>--}}
                        {{--                            <td>--}}
                        {{--                                <a href="javascript:void(0);" class="m-r-15 text-muted" data-toggle="tooltip"--}}
                        {{--                                   data-placement="top" title="" data-original-title="Edit"><i--}}
                        {{--                                        class="mdi mdi-pencil font-18"></i></a>--}}
                        {{--                                <a href="javascript:void(0);" class="text-muted" data-toggle="tooltip"--}}
                        {{--                                   data-placement="top" title="" data-original-title="Delete"><i--}}
                        {{--                                        class="mdi mdi-close font-18"></i></a>--}}
                        {{--                            </td>--}}
                        {{--                        </tr>--}}
                        {{--                        </tbody>--}}
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
                // "processing": true,
                "responsive": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('master.guest.datatable') }}",
                    "type": "get",
                    "data": function (d) {
                        // d.additional_param = additional_value;
                    }
                },
                "lengthMenu": [10, 25, 50, 100],
                "scrollX": true,
                "dom": 'Bfrtip',
                "columns": [
                    {data: 'event_name', title: 'Event', orderable: true, searchable: true},
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

