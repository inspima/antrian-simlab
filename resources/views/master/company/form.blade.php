@extends('layouts.master')


@section('breadcrumb')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group pull-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Company</li>
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
                        @if($data->id)
                            <div class="row form-group">
                                <div class="col-sm-2">
                                    <label for="name">Code</label>
                                </div>
                                <div class="col-sm-10">
                                    <input id="name" type="text" class="form-control"
                                           value="{{$data->code}}" disabled>
                                </div>
                            </div>
                        @endif
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="name">Short Name</label>
                            </div>
                            <div class="col-sm-10">
                                <input id="short_name" name="short_name" type="text" class="form-control"
                                       placeholder="Short Name" value="{{$data->short_name}}" required>
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
                        <hr>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="name">Country</label>
                            </div>
                            <div class="col-sm-10">
                                <input id="country" name="country" type="text" class="form-control"
                                       placeholder="Country" value="{{$data->country}}">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="name">Province</label>
                            </div>
                            <div class="col-sm-10">
                                <input id="province" name="province" type="text" class="form-control"
                                       placeholder="Province" value="{{$data->province}}">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="name">City</label>
                            </div>
                            <div class="col-sm-10">
                                <input id="city" name="city" type="text" class="form-control"
                                       placeholder="City" value="{{$data->city}}">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="name">District</label>
                            </div>
                            <div class="col-sm-10">
                                <input id="district" name="district" type="text" class="form-control"
                                       placeholder="District" value="{{$data->district}}">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="name">Subdistrict</label>
                            </div>
                            <div class="col-sm-10">
                                <input id="sub_district" name="sub_district" type="text" class="form-control"
                                       placeholder="Subdistrict" value="{{$data->sub_district}}">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="name">Address</label>
                            </div>
                            <div class="col-sm-10">
                                <input id="address" name="address" type="text" class="form-control" required
                                       placeholder="Address" value="{{$data->address}}">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="name">Postal Code</label>
                            </div>
                            <div class="col-sm-10">
                                <input id="postal_code" name="postal_code" type="text" class="form-control"
                                       placeholder="Postal Code" value="{{$data->postal_code}}">
                            </div>
                        </div>

                        <hr>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="name">Map Address</label>
                            </div>
                            <div class="col-sm-10">
                                <input id="map_address" name="map_address" type="text" class="form-control"
                                       placeholder="Map Address" value="{{$data->map_address}}">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="name">Lat / lng</label>
                            </div>
                            <div class="col-sm-5">
                                <input id="latitude" name="latitude" type="text" class="form-control"
                                       placeholder="Latitude" value="{{$data->latitude}}">
                            </div>
                            <div class="col-sm-5">
                                <input id="longitude" name="longitude" type="text" class="form-control"
                                       placeholder="Longitude" value="{{$data->longitude}}">
                            </div>
                        </div>
                        <hr>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="name">Phone</label>
                            </div>
                            <div class="col-sm-10">
                                <input id="phone" name="phone" type="text" class="form-control" required
                                       placeholder="Phone" value="{{$data->phone}}">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="name">Email</label>
                            </div>
                            <div class="col-sm-10">
                                <input id="email" name="email" type="email" class="form-control"
                                       placeholder="Email" value="{{$data->email}}">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="name">Fax</label>
                            </div>
                            <div class="col-sm-10">
                                <input id="fax" name="fax" type="text" class="form-control"
                                       placeholder="Fax" value="{{$data->fax}}">
                            </div>
                        </div>
                        <hr>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="name">PKP</label>
                            </div>
                            <div class="col-sm-10">
                                <input id="is_pkp" name="is_pkp" type="checkbox"
                                       value="1" @if($data->is_pkp==1) checked @endif>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="name">NPWP</label>
                            </div>
                            <div class="col-sm-10">
                                <input id="npwp" name="npwp" type="text" class="form-control"
                                       placeholder="NPWP" value="{{$data->npwp}}">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="name">TDP</label>
                            </div>
                            <div class="col-sm-10">
                                <input id="tdp" name="tdp" type="text" class="form-control"
                                       placeholder="TDP" value="{{$data->tdp}}">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="name">SIUP</label>
                            </div>
                            <div class="col-sm-10">
                                <input id="siup" name="siup" type="text" class="form-control"
                                       placeholder="SIUP" value="{{$data->siup}}">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="name">Domisili</label>
                            </div>
                            <div class="col-sm-10">
                                <input id="domisili" name="domisili" type="text" class="form-control"
                                       placeholder="Domisili" value="{{$data->domisili}}">
                            </div>
                        </div>
                        <hr>
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

