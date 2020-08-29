@extends('layouts.master-without-nav')

@section('content')
    <!-- Begin page -->
    <div class="accountbg"></div>
    <div class="wrapper-page">
        <div class="card">
            <div class="card-body">
                <h3 class="text-center m-0">
                    <a href="index" class="logo logo-admin"><img src="{{ URL::asset('assets/images/logo-asaba.png') }}"
                                                                 height="100" alt="logo"></a>
                </h3>
                <div class="p-3">
                    <h4 class="text-muted font-18 m-b-5 text-center">ASABA COMPUTER CENTER</h4>
                    <p class="text-muted text-center">Welcome to QR Attendance System</p>
                    <form class="form-horizontal m-t-30">
                        <div class="user-thumb text-center m-b-30">
                            <img src="{{ URL::asset('assets/images/users/avatar.png') }}"
                                 class="rounded-circle img-thumbnail" alt="thumbnail">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="qrcode" placeholder="Enter QR CODE">
                        </div>

                        {{--                        <div class="form-group row">--}}
                        {{--                            <div class="col-12 text-center">--}}
                        {{--                                <a href="{{route('register')}}" class="btn btn-primary w-md waves-effect waves-light"--}}
                        {{--                                   type="submit">Register</a>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                    </form>
                </div>
            </div>
        </div>
        <div class="m-t-10 text-center">
            <p class="text-white">© {{date('Y')}} Asaba.
        </div>
    </div>
@endsection
@section('css')
    <!-- Responsive datatable examples -->
@endsection

@section('script')
    <script>
        $("#qrcode").focus();
        $('div').click(function () {
            $('#qrcode').focus();
        });

        $("form").on('submit', function (e) {
            check();
            e.preventDefault()
        });


        var counter = 0
        var voice = "{{$voice}}"
        var msg = new SpeechSynthesisUtterance();
        msg.voiceURI = "{{$voice_uri}}";
        msg.volume = 1; // 0 to 1
        msg.rate = parseFloat("{{$voice_rate}}"); // 0.1 to 10
        msg.pitch = parseFloat("{{$voice_pitch}}");  //0 to 2
        msg.lang = "{{$voice_lang}}";

        function check() {
            var data = $("#qrcode").val();
            if (data) {
                if (counter == 0) {
                    counter++;
                    $.post("{{route('attendance.check')}}", {
                        data: data,
                        "_token": "{{ csrf_token() }}"
                    }, function (data, status) {
                        if (voice == "file_voice") {
                            if (data.audio) {
                                var audio = new Audio(data.audio);
                                audio.play();
                            }
                        } else if (voice == "local_voice") {

                            msg.text = data.message;
                            window.speechSynthesis.speak(msg);
                        }

                        if (status == "success") {
                            toastr.success(data.message)
                            $("#qrcode").val("")
                        } else {
                            toastr.error(data.message)
                            $("#qrcode").val("")
                        }
                        counter = 0;
                    }).fail(function (data) {
                        data = data = data.responseJSON
                        if (voice == "file_voice") {
                            if (data.audio) {
                                var audio = new Audio(data.audio);
                                audio.play();
                            }
                        } else if (voice == "local_voice") {
                            msg.text = data.message;
                            window.speechSynthesis.speak(msg);
                        }
                        toastr.error(data.message)
                        $("#qrcode").val("")
                        counter = 0;
                    });
                } else {
                    $("#qrcode").val("")
                }
            }
        }
    </script>
@endsection

