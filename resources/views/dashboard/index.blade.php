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
            <div class="card m-b-20">
                <div class="card-body">
                    <h4 class="mt-0 header-title m-b-30">Kuota Hari Ini</h4>

                    <div class="text-center">
                        <input class="knob" data-width="120" data-height="120" data-linecap=round
                               data-fgColor="#51b5dc" value="95" data-skin="tron" data-angleOffset="180"
                               data-readOnly=true data-thickness=".1"/>

                        <div class="clearfix"></div>
                        <ul class="list-inline row m-t-30 clearfix">
                            <li class="col-4">
                                <p class="m-b-5 font-18 font-600">200</p>
                                <p class="mb-0">Total</p>
                            </li>
                            <li class="col-4">
                                <p class="m-b-5 font-18 font-600">180</p>
                                <p class="mb-0">Terisi</p>
                            </li>
                            <li class="col-4">
                                <p class="m-b-5 font-18 font-600">20</p>
                                <p class="mb-0">Tersedia</p>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card m-b-20">
                <div class="card-body">
                    <h4 class="mt-0 header-title m-b-30">Kuota Besok</h4>

                    <div class="text-center">
                        <input class="knob" data-width="120" data-height="120" data-linecap=round
                               data-fgColor="#025ba7" value="50" data-skin="tron" data-angleOffset="180"
                               data-readOnly=true data-thickness=".1"/>

                        <div class="clearfix"></div>
                        <ul class="list-inline row m-t-30 clearfix">
                            <li class="col-4">
                                <p class="m-b-5 font-18 font-600">200</p>
                                <p class="mb-0">Total</p>
                            </li>
                            <li class="col-4">
                                <p class="m-b-5 font-18 font-600">100</p>
                                <p class="mb-0">Terisi</p>
                            </li>
                            <li class="col-4">
                                <p class="m-b-5 font-18 font-600">100</p>
                                <p class="mb-0">Tersedia</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card m-b-20">
                <div class="card-body">
                    <h4 class="mt-0 header-title m-b-30">Kuota Lusa</h4>

                    <div class="text-center">
                        <input class="knob" data-width="120" data-height="120" data-linecap=round
                               data-fgColor="#0e9018" value="25" data-skin="tron" data-angleOffset="180"
                               data-readOnly=true data-thickness=".1"/>

                        <div class="clearfix"></div>
                        <ul class="list-inline row m-t-30 clearfix">
                            <li class="col-4">
                                <p class="m-b-5 font-18 font-600">200</p>
                                <p class="mb-0">Total</p>
                            </li>
                            <li class="col-4">
                                <p class="m-b-5 font-18 font-600">50</p>
                                <p class="mb-0">Terisi</p>
                            </li>
                            <li class="col-4">
                                <p class="m-b-5 font-18 font-600">150</p>
                                <p class="mb-0">Tersedia</p>
                            </li>
                        </ul>

                    </div>
                </div>
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
@endsection


@section('script-bottom')
    <script>
        $(document).ready(function () {


        });
    </script>
@endsection

