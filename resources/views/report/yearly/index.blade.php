@extends('layouts.master')

@section('breadcrumb')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group pull-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">Report</a></li>
                        <li class="breadcrumb-item active">Yearly</li>
                    </ol>
                </div>
                <h4 class="page-title">Yearly Report</h4>
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
                    {{--                    <div id="myGrid" class="aggrid ag-theme-material"></div>--}}
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <form action="">
                                    <input type="text" class="datepicker form-control" name="year" value="{{$year}}"
                                           onchange="this.form.submit()">
                                </form>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <button type="button" class="btn btn-success" id="excel">Excel</button>
                        </div>
                    </div>
                    <div class="table-multi-columns table-fill">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th width="5%" rowspan="2" style="text-align: center">No</th>
                                <th rowspan="2" style="text-align: center">Name</th>
                                @foreach($header as $m)
                                    <th style="text-align: center" colspan="{{count($m['dates'])}}">{{$m['month']}}</th>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach($header as $m)
                                    @foreach($m['dates'] as $d)
                                        <th style="text-align: center">{{$d['day']}}</th>
                                    @endforeach
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($dataPersonals as$index=> $i)
                                <tr>
                                    <td style="text-align: center">{{$index+1}}</td>
                                    <td>{{$i->name}}</td>
                                    @foreach($header as $m)
                                        @foreach($m['dates'] as $d)
                                            <td style="text-align: center">{{$i['attendances'][$d['date']]}}</td>
                                        @endforeach
                                    @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('css')
    {{--    <link href="{{ URL::asset('assets/plugins/ag-grid/ag-grid.css') }}" rel="stylesheet" type="text/css"/>--}}
    {{--    <link--}}
    {{--        href="{{ URL::asset('assets/plugins/ag-grid/ag-theme-material.css') }}"--}}
    {{--        rel="stylesheet" type="text/css"/>--}}
    {{--    <link href="{{ URL::asset('assets/plugins/ag-grid/aggrid.css') }}"--}}
    {{--          rel="stylesheet"--}}
    {{--          type="text/css"/>--}}

    <link href="{{ URL::asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}"
          rel="stylesheet"
          type="text/css"/>
@endsection

@section('script')

    {{--    <script src="{{ URL::asset('assets/plugins/ag-grid/ag-grid-community.min.noStyle.js') }}"></script>--}}
    <script src="{{ URL::asset('assets/plugins/freeze-table/freeze-table.min.js') }}"></script>

    <script src="{{ URL::asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $(".table-multi-columns").freezeTable({
            'columnNum': 2,
        });
        $('.datepicker').datepicker({
            autoclose: true,
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years"
        });

        $("#excel").click(function () {
            window.open("{{ route('report.yearly.excel') }}?year=" + $(".datepicker").val(), '_blank');
        })
        {{--$(document).ready(function () {--}}
        {{--    /*** COLUMN DEFINE ***/--}}
        {{--    var columnDefs = [--}}
        {{--        {--}}
        {{--            headerName: "Name",--}}
        {{--            field: "name",--}}
        {{--            // editable: true,--}}
        {{--            // sortable: true,--}}
        {{--            width: 175,--}}
        {{--            // filter: true,--}}
        {{--            // checkboxSelection: true,--}}
        {{--            // headerCheckboxSelectionFilteredOnly: true,--}}
        {{--            // headerCheckboxSelection: true--}}
        {{--            pinned: "left"--}}
        {{--        },--}}
        {{--        {--}}
        {{--            headerName: "Last Name",--}}
        {{--            field: "lastname",--}}
        {{--            // editable: true,--}}
        {{--            // sortable: true,--}}
        {{--            // filter: true,--}}
        {{--            width: 175--}}
        {{--        },--}}
        {{--    ];--}}

        {{--    $.get("{{route("report.yearly.header")}}", function (data) {--}}
        {{--        data.forEach(function (i) {--}}
        {{--            columnDefs.push({--}}
        {{--                headerName: i.day,--}}
        {{--                field: i.date,--}}
        {{--                width: 100,--}}
        {{--            })--}}
        {{--        })--}}
        {{--    })--}}

        {{--    columnDefs.push({--}}
        {{--        headerName: "saya",--}}
        {{--        field: "saya",--}}
        {{--        width: 100,--}}
        {{--    })--}}
        {{--    console.log(columnDefs)--}}

        {{--    /*** GRID OPTIONS ***/--}}
        {{--    var gridOptions = {--}}
        {{--        columnDefs: columnDefs,--}}
        {{--        rowSelection: "multiple",--}}
        {{--        floatingFilter: false,--}}
        {{--        filter: false,--}}
        {{--        pagination: true,--}}
        {{--        paginationPageSize: 20,--}}
        {{--        pivotPanelShow: "always",--}}
        {{--        colResizeDefault: "shift",--}}
        {{--        animateRows: true,--}}
        {{--        resizable: true--}}
        {{--    };--}}

        {{--    /*** DEFINED TABLE VARIABLE ***/--}}
        {{--    var gridTable = document.getElementById("myGrid");--}}

        {{--    /*** GET TABLE DATA FROM URL ***/--}}

        {{--    agGrid--}}
        {{--        .simpleHttpRequest({url: "{{route('report.yearly.data')}}"})--}}
        {{--        .then(function (data) {--}}
        {{--            console.log(data)--}}
        {{--            gridOptions.api.setRowData(data);--}}
        {{--        });--}}

        {{--    // /*** FILTER TABLE ***/--}}
        {{--    // function updateSearchQuery(val) {--}}
        {{--    //     gridOptions.api.setQuickFilter(val);--}}
        {{--    // }--}}

        {{--    // $(".ag-grid-filter").on("keyup", function () {--}}
        {{--    //     updateSearchQuery($(this).val());--}}
        {{--    // });--}}

        {{--    // /*** CHANGE DATA PER PAGE ***/--}}
        {{--    // function changePageSize(value) {--}}
        {{--    //     gridOptions.api.paginationSetPageSize(Number(value));--}}
        {{--    // }--}}

        {{--    // $(".sort-dropdown .dropdown-item").on("click", function () {--}}
        {{--    //     var $this = $(this);--}}
        {{--    //     changePageSize($this.text());--}}
        {{--    //     $(".filter-btn").text("1 - " + $this.text() + " of 500");--}}
        {{--    // });--}}

        {{--    /*** EXPORT AS CSV BTN ***/--}}
        {{--    $(".ag-grid-export-btn").on("click", function (params) {--}}
        {{--        gridOptions.api.exportDataAsCsv();--}}
        {{--    });--}}

        {{--    /*** INIT TABLE ***/--}}
        {{--    var aggrid = new agGrid.Grid(gridTable, gridOptions);--}}

        {{--    /*** SET OR REMOVE EMAIL AS PINNED DEPENDING ON DEVICE SIZE ***/--}}

        {{--    // if ($(window).width() < 768) {--}}
        {{--    //     gridOptions.columnApi.setColumnPinned("name", null);--}}
        {{--    // } else {--}}
        {{--    //     gridOptions.columnApi.setColumnPinned("name", "left");--}}
        {{--    // }--}}
        {{--    // $(window).on("resize", function () {--}}
        {{--    //     if ($(window).width() < 768) {--}}
        {{--    //         gridOptions.columnApi.setColumnPinned("name", null);--}}
        {{--    //     } else {--}}
        {{--    //         gridOptions.columnApi.setColumnPinned("name", "left");--}}
        {{--    //     }--}}
        {{--    // });--}}
        {{--});--}}


    </script>
@endsection

