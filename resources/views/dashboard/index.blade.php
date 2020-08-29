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
        <div class="col-xl-3">
            <div class="card m-b-20">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Daily Checkin</h4>
                    <div class="row text-center m-t-20">
                        <div class="col-6">
                            <h5 class="" id="employee">0</h5>
                            <p class="text-muted font-14">Employee</p>
                        </div>
                        <div class="col-6">
                            <h5 class="checkin">0</h5>
                            <p class="text-muted font-14">Checkin</p>
                        </div>
                    </div>

                    <div id="daily-checkin" style="height: 300px"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3">
            <div class="card m-b-20">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Daily Checkout</h4>
                    <div class="row text-center m-t-20">
                        <div class="col-6">
                            <h5 class="checkin">0</h5>
                            <p class="text-muted font-14">Checkin</p>
                        </div>
                        <div class="col-6">
                            <h5 class="" id="checkout">0</h5>
                            <p class="text-muted font-14">Checkout</p>
                        </div>
                    </div>

                    <div id="daily-checkout" style="height: 300px"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3">
            <div class="card m-b-20">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Daily Late</h4>
                    <div class="row text-center m-t-20">
                        <div class="col-6">
                            <h5 class="" id="ontime">0</h5>
                            <p class="text-muted font-14">Ontime</p>
                        </div>
                        <div class="col-6">
                            <h5 class="" id="late">0</h5>
                            <p class="text-muted font-14">Late</p>
                        </div>
                    </div>

                    <div id="daily-late" style="height: 300px"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3">
            <div class="card m-b-20">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Daily Overtime</h4>
                    <div class="row text-center m-t-20">
                        <div class="col-6">
                            <h5 class="checkin">0</h5>
                            <p class="text-muted font-14">Checkin</p>
                        </div>
                        <div class="col-6">
                            <h5 class="" id="overtime">0</h5>
                            <p class="text-muted font-14">Overtime</p>
                        </div>
                    </div>

                    <div id="daily-overtime" style="height: 300px"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card m-b-20">
                <div class="card-title"></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-10">
                            <h4 class="mt-0 header-title">Monthly Attendance</h4>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <form action="">
                                    <input type="text" class="datepicker form-control" value="{{$month}}">
                                </form>
                            </div>
                        </div>
                    </div>

                    <div id="morris-area-example" style="height: 300px"></div>
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
    <!--Morris Chart-->
    <script src="{{ URL::asset('assets/plugins/morris/morris.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/raphael/raphael-min.js') }}"></script>

    <script src="{{ URL::asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

    <!-- Page specific js -->
    {{--    <script src="{{ URL::asset('assets/pages/dashborad-2.js') }}"></script>--}}
@endsection


@section('script-bottom')
    <script>
        $(document).ready(function () {

            $.get("{{route("dashboard.percentage")}}", function (data) {
                console.log(data);
                $("#employee").html(data.employee);
                $(".checkin").html(data.checkin);
                $("#checkout").html(data.checkout);
                $("#late").html(data.late);
                $("#ontime").html(data.ontime);
                $("#overtime").html(data.overtime);

                var checkin = (data.checkin / data.employee) * 100
                Morris.Donut({
                    element: "daily-checkin",
                    data: [
                        {label: "Checkin", value: checkin.toFixed(0)},
                        {label: "Not Checkin", value: 100 - checkin.toFixed(0)},
                    ],
                    resize: true,
                    colors: ['#f0f1f4', '#6d60b0', '#009688'],
                    formatter: function (y) {
                        return y + "%"
                    }
                });
                var checkout = (data.checkout / data.checkin) * 100
                Morris.Donut({
                    element: "daily-checkout",
                    data: [
                        {label: "Checkout", value: checkout.toFixed(0)},
                        {label: "Not Checkout", value: 100 - checkout.toFixed(0)},
                    ],
                    resize: true,
                    colors: ['#f0f1f4', '#6d60b0', '#009688'],
                    formatter: function (y) {
                        return y + "%"
                    }
                });

                var late = (data.late / data.checkin) * 100
                var ontime = (data.ontime / data.checkin) * 100
                Morris.Donut({
                    element: "daily-late",
                    data: [
                        {label: "Late", value: late.toFixed(0)},
                        {label: "On Time", value: ontime.toFixed(0)},
                    ],
                    resize: true,
                    colors: ['#f0f1f4', '#6d60b0', '#009688'],
                    formatter: function (y) {
                        return y + "%"
                    }
                });

                var overtime = (data.overtime / data.checkin) * 100
                Morris.Donut({
                    element: "daily-overtime",
                    data: [
                        {label: "Overtime", value: overtime.toFixed(0)},
                        {label: "On Time", value: 100 - overtime.toFixed(0)},
                    ],
                    resize: true,
                    colors: ['#f0f1f4', '#6d60b0', '#009688'],
                    formatter: function (y) {
                        return y + "%"
                    }
                });
            })


            $('.datepicker').datepicker({
                autoclose: true,
                format: "yyyy-mm",
                viewMode: "months",
                minViewMode: "months"
            });
            setGrafik();

            $('.datepicker').change(function () {
                setGrafik();
            })

            function setGrafik() {
                $.get("{{route("dashboard.grafik")}}?month=" + $(".datepicker").val(), function (data) {
                    console.log(data)
                    Morris.Area({
                        element: "morris-area-example",
                        pointSize: 0,
                        lineWidth: 0,
                        data: data,
                        xkey: 'y',
                        ykeys: ['a', 'b', 'c'],
                        labels: ['Checkin', 'Late', 'Checkout'],
                        resize: true,
                        gridLineColor: '#eee',
                        hideHover: 'auto',
                        lineColors: ['#009688', '#fb8c00', '#6d60b0'],
                        fillOpacity: .6,
                        behaveLikeLine: true
                    });
                })

            }

        });
    </script>
@endsection

