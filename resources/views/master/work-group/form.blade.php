@extends('layouts.master')


@section('breadcrumb')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group pull-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Work Group</li>
                        @if($data->id)
                            <li class="breadcrumb-item">Edit</li>
                        @else
                            <li class="breadcrumb-item">Create</li>
                        @endif
                    </ol>
                </div>
                @if($data->id)
                    <h4 class="page-title">Edit</h4>
                @else
                    <h4 class="page-title">Create</h4>
                @endif
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
                    <form method="POST"
                          action="{{ ($data->id)?route($route."update", $data->id):route($route."store")}}">
                        @if($data->id)
                            {{ method_field('PUT') }}
                        @endif
                        @csrf
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="work_id_number">Company</label>
                            </div>
                            <div class="col-sm-10">
                                <select id="company_id" name="company_id" class="select2 form-control "
                                        data-placeholder="Choose ..." required>
                                    @if($data->company)
                                        <option
                                            value="{{$data->company->id}}">{{$data->company->name}}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="work_id_number">Shift</label>
                            </div>
                            <div class="col-sm-10">
                                <select id="shift_id" name="shift_id" class="select2 form-control "
                                        data-placeholder="Choose ..." required>
                                    @if($data->shift)
                                        <option
                                            value="{{$data->shift->id}}">{{$data->shift->name}}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="name">Name</label>
                            </div>
                            <div class="col-sm-10">
                                <input id="name" name="name" type="text" class="form-control"
                                       placeholder="Name" value="{{$data->name}}" required>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10">
                                <input type="hidden" name="id" value="{{$data->id}}">
                                <button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
                                <button type="button" class="btn btn-danger waves-effect"
                                        onclick="window.location.href ='{{route($route."index")}}'">Back
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <!-- Select 2 -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
          rel="stylesheet"
          type="text/css"/>
@endsection

@section('script')
    <!-- select2 js -->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>
@endsection

@section('script-bottom')
    <script type="text/javascript">
        $("#company_id").select2({
            ajax: {
                url: "{{ route('master.company.select2') }}",
                cache: false,
                dataType: 'json',
                data: function (params) {
                    return {
                        q: params.term,
                    };
                }
            },
            minimumInputLength: 1,
        });

        $("#company_id").change(function () {
            $("#shift_id").select2({
                ajax: {
                    url: "{{ route('master.shift.select2') }}",
                    cache: false,
                    dataType: 'json',
                    data: function (params) {
                        var query = {
                            q: params.term,
                            company_id: $("#company_id").val()
                        }
                        return query;
                    }
                },
                minimumInputLength: 1,
            });
        });

        $("#shift_id").select2({
            ajax: {
                url: "{{ route('master.shift.select2') }}",
                cache: false,
                dataType: 'json',
                data: function (params) {
                    var query = {
                        q: params.term,
                        company_id: $("#company_id").val()
                    }
                    return query;
                }
            },
            minimumInputLength: 1,
        });

        $('.timepicker').timepicker({
            timeFormat: 'HH:mm',
            interval: 60,
            minTime: '00',
            maxTime: '23:00',
            // defaultTime: '09',
            startTime: '00:00',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });
        $('.timepicker2').timepicker({
            timeFormat: 'HH:mm',
            interval: 60,
            minTime: '00',
            maxTime: '23:00',
            // defaultTime: '18',
            startTime: '00:00',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });
    </script>

@endsection

