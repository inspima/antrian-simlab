<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta content="ITD Unair" name="description"/>
    <meta content="Nambi Sembilu" name="author"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    @include('layouts.head')
</head>

<body>
<!-- Loader -->
<div id="preloader">
    <div id="status">
        <div class="spinner"></div>
    </div>
</div>
<div id="wrapper">
    @include('layouts.header')
    <div class="wrapper">
        <div class="container-fluid">
            @yield('breadcrumb')
            @yield('content')

            <div id="loading" style="display: none">
                <div style="width: 120px;height: 120px;position: absolute;left: 48%;top: 40%;margin: -20px 0 0 -20px;text-align: center">
                    <i class="fa fa-spin fa-spinner" style="color:#1d9de8;font-size:50px;width: auto;height: auto; line-height: 2px; margin-right: 10px;"></i>
                    <br/>
                    <b style="color: grey">Please Wait</b>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer')
</div>
@include('layouts.footer-script')
</body>
</html>
