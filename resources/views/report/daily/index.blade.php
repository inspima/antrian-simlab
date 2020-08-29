@extends('layouts.master')

@section('breadcrumb')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group pull-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">Report</a></li>
                        <li class="breadcrumb-item active">Daily</li>
                    </ol>
                </div>
                <h4 class="page-title">Daily Report</h4>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <input type="text" class="datepicker form-control">
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <button type="button" class="btn btn-success" id="excel">Excel</button>
                        </div>
                    </div>
                    <table id="datatable" class="table table-striped dt-responsive nowrap table-vertical" width="100%"
                           cellspacing="0">
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <!-- Responsive datatable examples -->
    <link href="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
    <link href="{{ URL::asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ URL::asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}"
          rel="stylesheet"
          type="text/css"/>
          
@endsection

@section('script')
    <!-- Datatable js -->
    <script src="{{ URL::asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
    <!-- Responsive examples -->
    <script src="{{ URL::asset('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>\
@endsection

@section('script-bottom')
    <script type="text/javascript">
        $(document).ready(function () {

            var now = new Date().toISOString().replace(/T/, ' ').replace(/\..+/, '');
            $('.datepicker').val(now.split(" ")[0])

            var table = $('#datatable').DataTable({
                "processing": true,
                "responsive": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('report.daily.datatable') }}",
                    "type": "get",
                    "data": function (d) {
                        d.date = $(".datepicker").val();
                    }
                },
                "lengthMenu": [10, 25, 50, 100],
                "scrollX": true,
                "columns": [
                    {data: 'name', title: 'Name', orderable: true, searchable: true},
                    {data: 'date', title: 'Date', orderable: false, searchable: false},
                    {data: 'work_time', title: 'Work Time', orderable: false, searchable: false},
                    {data: 'in_time', title: 'Checked In', orderable: false, searchable: false},
                    {data: 'out_time', title: 'Checked Out', orderable: false, searchable: false},
                    {data: 'rest_in_time', title: 'Rest In', orderable: false, searchable: false},
                    {data: 'rest_out_time', title: 'Rest Out', orderable: false, searchable: false},
                ],
            });

            $('#datatable tbody td.image-popup-vertical-fit').each(function (e) {
                console.log(e);
                // note - call draw() to update the table's draw state with the new data
                $(e).magnificPopup({
                        type: 'image',
                        closeOnContentClick: true,
                        mainClass: 'mfp-img-mobile',
                        image: {
                            verticalFit: true
                        }
                    });
            } );

            new $.fn.dataTable.Buttons(table, {
                buttons: [
                    'copy', 'excel', 'pdf'
                ]
            });
            $('.datepicker').change(function (data) {
                table.ajax.reload();
                
            })
            $('.datepicker').datepicker({
                "autoclose": true,
                "format": 'yyyy-mm-dd'
            });

            $("#excel").click(function () {
                window.open("{{ route('report.daily.excel') }}?date=" + $(".datepicker").val(), '_blank');
            })
        });
    </script>

@endsection

