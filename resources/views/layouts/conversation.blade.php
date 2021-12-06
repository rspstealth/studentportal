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
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>


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
                @impersonate()
                <a href="{{url('/impersonate/destroy')}}" class="btn btn-outline-secondary"><b><i class="fas fa-chevron-left"></i> Back to Admin session</b></a>
                @endimpersonate
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
