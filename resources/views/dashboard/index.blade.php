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
                <h4 class="page-title">Dashboard</h4>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-4">
            <div class="mini-stat clearfix bg-white">
                <span class="font-40 text-info mr-0 float-right"><i class="ion-clipboard"></i></span>
                <div class="mini-stat-info">
                    <h3 class="counter font-light mt-0">{{$total_registration}}</h3>
                </div>
                <div class="clearfix"></div>
                <p class=" mb-0 m-t-10 text-muted">Total Registrasi <span class="pull-right"><a class="btn btn-sm btn-secondary" href="{{route('registration.sample.index')}}">Selengkapnya <i class="ti-angle-right"></i></a></span></p>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="mini-stat clearfix bg-white">
                <span class="font-40 text-danger mr-0 float-right"><i class=" dripicons-medical"></i></span>
                <div class="mini-stat-info">
                    <h3 class="counter font-light mt-0">{{$total_patient}}</h3>
                </div>
                <div class="clearfix"></div>
                <p class=" mb-0 m-t-10 text-muted">Total Pasien <span class="pull-right"><a class="btn btn-sm btn-secondary" href="{{route('registration.sample.index')}}">Selengkapnya <i class="ti-angle-right"></i></a></span></p>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="mini-stat widget-chart-sm clearfix bg-white">
                <span class="peity-pie float-left" data-peity='{ "fill": ["#13a142", "#f2f2f2"]}' data-width="60" data-height="60">{{$total_registration_sent}}/{{$total_registration}}</span>
                <div class="mini-stat-info text-right">
                    <span class="counter text-success">{{$total_registration_sent}} / {{$total_registration}}</span>
                    Registrasi Terkirim
                </div>
                <div class="clearfix"></div>
                <p class="text-muted mb-0 m-t-20"> Persentase Terkirim 
                    <span class="pull-right">
                    @if ($total_registration>0)
                    {{number_format($total_registration_sent/$total_registration*100)}} %
                    @else
                    0 %
                    @endif 
                    </span>
                </p>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/morris/morris.css') }}">

    <link href="{{ URL::asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}"
          rel="stylesheet" type="text/css"/>
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

    <script src="{{ URL::asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

    <script src="{{ URL::asset('assets/plugins/jquery-knob/jquery.knob.js') }}"></script>
    <!-- Page specific js -->
    <script src="{{ URL::asset('assets/pages/dashboard.js') }}"></script>
    <!-- Widget init JS -->
    <script src="{{ URL::asset('assets/pages/widget-init.js') }}"></script>
@endsection


@section('script-bottom')
    <script>
        $(document).ready(function () {


        });
    </script>
@endsection

