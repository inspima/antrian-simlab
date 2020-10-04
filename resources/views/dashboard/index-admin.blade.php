@extends('layouts.master')


@section('breadcrumb')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group pull-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    </ol>
                </div>
                <h4 class="page-title">Dashboard Administrator</h4>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-4">
            <div class="mini-stat clearfix bg-white">
                <span class="font-40 text-info mr-0 float-right"><i class="mdi mdi-bank"></i></span>
                <div class="mini-stat-info">
                    <h3 class="counter font-light mt-0">{{$total_organization}}</h3>
                </div>
                <div class="clearfix"></div>
                <p class=" mb-0 m-t-10 text-muted">Total Instansi <span class="pull-right"><a class="btn btn-sm btn-secondary" href="{{route('master.organization.index')}}">Selengkapnya <i class="ti-angle-right"></i></a></span></p>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="mini-stat clearfix bg-white">
                <span class="font-40 text-danger mr-0 float-right"><i class=" dripicons-medical"></i></span>
                <div class="mini-stat-info">
                    <h3 class="counter font-light mt-0">{{$total_patient}}</h3>
                </div>
                <div class="clearfix"></div>
                <p class=" mb-0 m-t-10 text-muted">Total Pasien Terkirim <span class="pull-right"></p>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="mini-stat widget-chart-sm clearfix bg-white">
                <span class="peity-pie float-left" data-peity='{ "fill": ["#13a142", "#f2f2f2"]}' data-width="60" data-height="60">{{$quota_info['filled']}}/{{$quota_info['quota']}}</span>
                <div class="mini-stat-info text-right">
                    <span class="counter text-success">{{$quota_info['filled']}} / {{$quota_info['quota']}}</span>
                    Kuota Terpenuhi
                </div>
                <div class="clearfix"></div>
                <p class="text-muted mb-0 m-t-20"> Persentase <span class="pull-right">{{number_format($quota_info['percentage'])}} %</span></p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20 m-t-20">
                <h6 style="line-height: 1.8" class="card-header mt-0 bg-info text-light">Monitoring Kuota <span class="pull-right"><a class="btn btn-sm btn-secondary" href="{{route('report.quota.index')}}">Selengkapnya <i class="ti-angle-right"></i></a></span></h6>
                <div class="card-body">
                    <table id="datatable" class="table table-striped dt-responsive nowrap table-vertical" width="100%" cellspacing="0">
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/morris/morris.css') }}">

    <link href="{{ URL::asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css"/>
     <!-- DataTables -->
     <link href="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
<!-- Responsive datatable examples -->
<link href="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection


@section('script')
    <!-- Peity chart JS -->
    <script src="{{ URL::asset('assets/plugins/peity-chart/jquery.peity.min.js') }}"></script>
    <!--C3 Chart-->
    <script type="text/javascript" src="{{ URL::asset('assets/plugins/d3/d3.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/plugins/c3/c3.min.js') }}"></script>
    <!--Morris Chart-->
    <script src="{{ URL::asset('assets/plugins/morris/morris.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/raphael/raphael-min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery-knob/jquery.knob.js') }}"></script>    
    <!-- Datatable js -->
    <script src="{{ URL::asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Responsive examples -->
    <script src="{{ URL::asset('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
    <!-- Page specific js -->
    <script src="{{ URL::asset('assets/pages/dashboard.js') }}"></script>
    <!-- Widget init JS -->
    <script src="{{ URL::asset('assets/pages/widget-init.js') }}"></script>
@endsection


@section('script-bottom')
    <script>
        $(document).ready(function () {
            $('#datatable').DataTable({
                "processing": true,
                "responsive": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route($route.'datatable-monitoring-quota') }}",
                    "type": "get",
                    "data": function (d) {
                        // d.additional_param = additional_value;
                    }
                },
                "searching": false,
                "paging":   false,
                "ordering": false,
                "info":     false,
                "scrollX": true,                
                "aaSorting": [],
                "columns": [
                    {data: 'code', title: 'Kode', orderable: false, searchable: true},
                    {data: 'date', title: 'Tanggal', orderable: false, searchable: true},
                    {data: 'quota', title: 'Kuota', orderable: false, searchable: true},
                    {data: 'filled', title: 'Terisi', orderable: false, searchable: true},
                    {data: 'available', title: 'Sisa', orderable: false, searchable: true},
                ],
            });
        });
    </script>
@endsection

