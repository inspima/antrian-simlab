@extends('layouts.master')

@section('css')
    <!-- Select 2 -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('breadcrumb')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group pull-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Staff</li>
                        @if($dataUser->id)
                            <li class="breadcrumb-item">Edit</li>
                        @else
                            <li class="breadcrumb-item">Create</li>
                        @endif
                    </ol>
                </div>
                @if($dataUser->id)
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
                          action="{{ ($dataPersonal->id)?route("master.staff.update", $dataPersonal->id):route("master.staff.store")}}">
                        @if($dataPersonal->id)
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
                                    @if($dataPersonal->company)
                                        <option
                                            value="{{$dataPersonal->company->id}}">{{$dataPersonal->company->name}}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="work_id_number">Work Place</label>
                            </div>
                            <div class="col-sm-10">
                                <select id="work_place_id" name="work_place_id" class="select2 form-control "
                                        data-placeholder="Choose ..." required>
                                    @if($dataPersonal->work_place)
                                        <option
                                            value="{{$dataPersonal->work_place->id}}">{{$dataPersonal->work_place->name}}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="work_id_number">Work Group</label>
                            </div>
                            <div class="col-sm-10">
                                <select id="work_group_id" name="work_group_id" class="select2 form-control "
                                        data-placeholder="Choose ..." required>
                                    @if($dataPersonal->work_group)
                                        <option
                                            value="{{$dataPersonal->work_group->id}}">{{$dataPersonal->work_group->name}}</option>
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
                                    @if($dataPersonal->shift)
                                        <option
                                            value="{{$dataPersonal->shift->id}}">{{$dataPersonal->shift->name}}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="work_id_number">Work ID Number</label>
                            </div>
                            <div class="col-sm-10">
                                <input id="work_id_number" name="work_id_number" type="text" class="form-control"
                                       placeholder="Work ID Number" value="{{$dataPersonal->work_id_number}}" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="name">Name</label>
                            </div>
                            <div class="col-sm-10">
                                <input id="name" name="name" type="text" class="form-control"
                                       placeholder="Name" value="{{$dataPersonal->name}}" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="name">NIK</label>
                            </div>
                            <div class="col-sm-10">
                                <input id="name" name="nik" type="text" class="form-control"
                                       placeholder="NIK" value="{{$dataPersonal->id_number}}" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="name">Address</label>
                            </div>
                            <div class="col-sm-10">
                                <input id="name" name="address" type="text" class="form-control"
                                       placeholder="Address" value="{{$dataPersonal->address}}" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="name">Mobile</label>
                            </div>
                            <div class="col-sm-10">
                                <input id="name" name="mobile" type="text" class="form-control"
                                       placeholder="Mobile" value="{{$dataPersonal->mobile}}">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="name">Email</label>
                            </div>
                            <div class="col-sm-10">
                                <input id="name" name="email" type="email" class="form-control"
                                       placeholder="Email" required value="{{$dataUser->email}}">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="name">Password</label>
                            </div>
                            <div class="col-sm-10">
                                <input id="name" name="password" type="password" class="form-control"
                                       placeholder="Password" @if($dataUser->id) @else required @endif>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10">
                                <input type="hidden" name="user_id" value="{{$dataUser->id}}">
                                <input type="hidden" name="personal_id" value="{{$dataPersonal->id}}">
                                <button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
                                <button type="button" class="btn btn-danger waves-effect"
                                        onclick="window.location.href ='{{route("master.staff.index")}}'">Back
                                </button>
                            </div>
                        </div>
                        {{--                        <div class="row">--}}
                        {{--                            <div class="col-sm-6">--}}
                        {{--                                <div class="form-group">--}}
                        {{--                                    <label for="manufacturerbrand">Manufacturer Brand</label>--}}
                        {{--                                    <input id="manufacturerbrand" name="manufacturerbrand" type="text"--}}
                        {{--                                           class="form-control">--}}
                        {{--                                </div>--}}
                        {{--                                <div class="form-group">--}}
                        {{--                                    <label for="price">Price</label>--}}
                        {{--                                    <input id="price" name="price" type="text" class="form-control">--}}
                        {{--                                </div>--}}

                        {{--                                <div class="form-group">--}}
                        {{--                                    <label class="control-label">Category</label>--}}
                        {{--                                    <select class="form-control select2">--}}
                        {{--                                        <option>Select</option>--}}
                        {{--                                        <option value="AK">Alaska</option>--}}
                        {{--                                        <option value="HI">Hawaii</option>--}}
                        {{--                                    </select>--}}
                        {{--                                </div>--}}
                        {{--                                <div class="form-group">--}}
                        {{--                                    <label class="control-label">Features</label>--}}

                        {{--                                    <select class="select2 form-control select2-multiple" multiple="multiple"--}}
                        {{--                                            data-placeholder="Choose ...">--}}
                        {{--                                        <option value="AK">Alaska</option>--}}
                        {{--                                        <option value="HI">Hawaii</option>--}}
                        {{--                                        <option value="CA">California</option>--}}
                        {{--                                        <option value="NV">Nevada</option>--}}
                        {{--                                        <option value="OR">Oregon</option>--}}
                        {{--                                        <option value="WA">Washington</option>--}}
                        {{--                                    </select>--}}

                        {{--                                </div>--}}
                        {{--                            </div>--}}

                        {{--                            <div class="col-sm-6">--}}
                        {{--                                <div class="form-group">--}}
                        {{--                                    <label>Product Image</label> <br/>--}}
                        {{--                                    <img src="{{ URL::asset('assets/images/products/1.jpg') }}" alt="product img"--}}
                        {{--                                         class="img-fluid" style="max-width: 200px;"/>--}}
                        {{--                                    <br/>--}}
                        {{--                                    <button type="button" class="btn btn-purple m-t-10 waves-effect waves-light">Change--}}
                        {{--                                        Image--}}
                        {{--                                    </button>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}

                    </form>
                </div>
            </div>
        </div>
    </div>
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
                    var query = {
                        q: params.term,
                    }
                    return query;
                }
            },
            minimumInputLength: 1,
        });

        $("#company_id").change(function () {
            $("#work_group_id").select2({
                ajax: {
                    url: "{{ route('master.work-group.select2') }}",
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

            $("#work_place_id").select2({
                ajax: {
                    url: "{{ route('master.work-place.select2') }}",
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

        $("#work_place_id").select2({
            ajax: {
                url: "{{ route('master.work-place.select2') }}",
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
        $("#work_group_id").select2({
            ajax: {
                url: "{{ route('master.work-group.select2') }}",
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
    </script>

@endsection

