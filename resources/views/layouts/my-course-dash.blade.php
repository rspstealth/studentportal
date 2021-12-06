<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('css/demo.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato|Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.943/pdf.min.js"></script>
    <!-- Icons Css -->
    <link media="all" type="text/css" rel="stylesheet" href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link media="all" type="text/css" rel="stylesheet" href="{{ asset('css/icomoon/style.css') }}">
    <!-- Libs CSS -->
{{--<link rel="stylesheet"  href="{{ asset('css/theme/feather.min.css') }}">--}}
{{--<link rel="stylesheet" href="{{ asset('css/theme/vs2015.css') }}">--}}
{{--<link rel="stylesheet" href="{{ asset('css/theme/select2.min.css') }}">--}}
{{--<link rel="stylesheet" href="{{ asset('css/theme/flatpickr.min.css') }}">--}}
<!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-3.3.7-dist/css/bootstrap.min.css') }}" id="stylesheetLight">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

</head>
<body>
<div class="wrapper" id="header">
    <div class="container">
        <div class="row">
            <div id="header_left" class="col-md-6">
                <a href="#" class="logo"><h2><b>Student Portal</b></h2></a>
                <a href="{{url('/impersonate/destroy')}}" class="btn btn-outline-secondary"><b>Back to Admin session</b></a>

            </div>
            <div id="header_right" class="col-md-6">
                @include('layouts.my-account')
            </div>
        </div>
    </div>
</div>
@show
@yield('content')
</body>

</html>
