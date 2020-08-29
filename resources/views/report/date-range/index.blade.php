@extends('layouts.master')

@section('breadcrumb')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group pull-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">Report</a></li>
                        <li class="breadcrumb-item active">Date Range</li>
                    </ol>
                </div>
                <h4 class="page-title">Date Range Report</h4>
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
                        <div class="form-group col-sm-3">
                            <select name="workGroupId" id="workGroupId" class="form-control">
                                <option value="">All</option>
                                @foreach($workGroups as $workGroup)
                                    <option value="{{$workGroup->id}}">{{$workGroup->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class=" form-group col-sm-3">
                            <div class="input-group input-daterange">
                                <input type="text" class="form-control daterange" value="{{$startDate}}"
                                       name="startDate">
                                <div class="input-group-addon">to</div>
                                <input type="text" class="form-control daterange" value="{{$endDate}}"
                                       name="endDate">
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
    <link href="{{ URL::asset('assets/plugins/bootstrap-datepicker-1.9.0/css/bootstrap-datepicker3.min.css') }}"
          rel="stylesheet"
          type="text/css"/>
    <style>
        /*td.details-control {*/
        /*    background: url('/assets/images/details_open.png') no-repeat center center;*/
        /*    cursor: pointer;*/
        /*}*/

        /*tr.shown td.details-control {*/
        /*    background: url('/assets/images/details_close.png') no-repeat center center;*/
        /*}*/
    </style>
@endsection

@section('script')
    <!-- Datatable js -->
    <script src="{{ URL::asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
    <!-- Responsive examples -->
    <script src="{{ URL::asset('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/bootstrap-datepicker-1.9.0/js/bootstrap-datepicker.min.js') }}"></script>
@endsection

@section('script-bottom')
    <script type="text/javascript">
        $(document).ready(function () {
            var table = $('#datatable').DataTable({
                "processing": true,
                "responsive": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route($route.'datatable') }}",
                    "type": "get",
                    "data": function (d) {
                        d.workGroupId = $("select[name=workGroupId]").val();
                        d.startDate = $("input[name=startDate]").val();
                        d.endDate = $("input[name=endDate]").val();
                    }
                },
                "lengthMenu": [10, 25, 50, 100],
                "scrollX": true,
                "columns": [
                    {
                        "className": 'details-control',
                        "orderable": false,
                        "data": null,
                        "defaultContent": '',
                        "width": "5%",
                        render: function () {
                            return '<button class="btn btn-sm btn-info">Detail</button>'
                        }
                    },
                    {data: 'work_id_number', title: 'Work ID No.', orderable: true, searchable: true},
                    {data: 'name', title: 'Name', orderable: true, searchable: true},
                    {data: 'work_group_name', title: 'Work Group', orderable: true, searchable: true},
                ],
            });

            function format(d) {
                let html = '<table class="table table-bordered" cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                    '<tr>' +
                    '<th style="text-align: center">Shift</th>' +
                    '<th style="text-align: center">Date</th>' +
                    '<th style="text-align: center">Work Time</th>' +
                    '<th style="text-align: center">Time In</th>' +
                    '<th style="text-align: center">Time Out</th></tr>'

                d.detail.forEach(function (data) {
                    html += '<tr>' +
                        '<td>' + data.shift_name + '</td>' +
                        '<td style="text-align: center">' + data.date + '</td>' +
                        '<td style="text-align: center">' + data.work_time + '</td>' +
                        '<td style="text-align: center">' + data.time_in + '</td>' +
                        '<td style="text-align: center">' + data.time_out + '</td></tr>'
                }, html)

                html += '</table>'

                return html
            }

            // Add event listener for opening and closing details
            $('#datatable tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    // Open this row
                    row.child(format(row.data())).show();
                    tr.addClass('shown');
                }
            });

            $('#workGroupId').change(function (data) {
                table.ajax.reload();
            })

            $('.daterange').change(function (data) {
                table.ajax.reload();
            })

            $("#excel").click(function () {
                window.open("{{ route($route.'excel') }}?startDate=" + $("input[name=startDate]").val() + "&endDate=" + $("input[name=endDate]").val() + "&workGroupId=" + $("select[name=workGroupId]").val(), '_blank');
            })

            $('.input-daterange input').each(function () {
                $(this).datepicker({
                    "autoclose": true,
                    "format": 'yyyy-mm-dd'
                });
            });
        });
    </script>

@endsection

