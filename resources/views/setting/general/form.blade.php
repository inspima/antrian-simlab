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
                        <li class="breadcrumb-item">Edit</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit</h4>
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
                          action="{{ route("setting.general.update", $data->id)}}">
                        {{ method_field('PUT') }}
                        @csrf
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="name">Code</label>
                            </div>
                            <div class="col-sm-10">
                                <input id="code" type="text" class="form-control" value="{{$data->code}}" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="name">Name</label>
                            </div>
                            <div class="col-sm-10">
                                <input id="name" name="name" type="text" class="form-control"
                                       placeholder="Name" value="{{$data->name}}" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="name">Description</label>
                            </div>
                            <div class="col-sm-10">
                                <input id="name" name="description" type="text" class="form-control"
                                       placeholder="Description" value="{{$data->description}}" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="name">Value</label>
                            </div>
                            <div class="col-sm-10">
                                <input id="name" name="value" type="text" class="form-control"
                                       placeholder="Value" value="{{$data->value}}" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
                                <button type="button" class="btn btn-danger waves-effect"
                                        onclick="window.location.href ='{{route("setting.general.index")}}'">Back</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>
@endsection

@section('script-bottom')
    <script type="text/javascript">

    </script>
@endsection

