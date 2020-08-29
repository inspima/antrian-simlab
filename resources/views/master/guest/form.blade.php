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
                        <li class="breadcrumb-item active">Guest</li>
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
                          action="{{ ($dataGuest->id)?route("master.guest.update", $dataGuest->id):route("master.guest.store")}}">
                        @if($dataGuest->id)
                            {{ method_field('PUT') }}
                        @endif
                        @csrf
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="work_id_number">Event</label>
                            </div>
                            <div class="col-sm-10">
                                <select id="event_id" name="event_id" class="select2 form-control "
                                        data-placeholder="Choose ..." required>
                                    @if($dataGuest->event)
                                        <option
                                            value="{{$dataGuest->event->id}}">{{$dataGuest->event->name}}</option>
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
                                       placeholder="Name" value="{{$dataGuest->name}}" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="name">NIK</label>
                            </div>
                            <div class="col-sm-10">
                                <input id="name" name="nik" type="text" class="form-control"
                                       placeholder="NIK" value="{{$dataGuest->id_number}}" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="name">Address</label>
                            </div>
                            <div class="col-sm-10">
                                <input id="name" name="address" type="text" class="form-control"
                                       placeholder="Address" value="{{$dataGuest->address}}">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="name">Mobile</label>
                            </div>
                            <div class="col-sm-10">
                                <input id="name" name="mobile" type="text" class="form-control"
                                       placeholder="Mobile" value="{{$dataGuest->mobile}}">
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
                                <input type="hidden" name="guest_id" value="{{$dataGuest->id}}">
                                <button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
                                <button type="button" class="btn btn-danger waves-effect"
                                        onclick="window.location.href ='{{route("master.guest.index")}}'">Back
                                </button>
                            </div>
                        </div>

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
        $("#event_id").select2({
            ajax: {
                url: "{{ route('master.event.select2') }}",
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
    </script>

@endsection

