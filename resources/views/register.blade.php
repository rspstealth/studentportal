<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">


    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <!-- Country Code Jquery -->
    <link media="all" type="text/css" rel="stylesheet" href="{{ asset('js/country_code/css/intlTelInput.css') }}">
    <script src="{{ asset('js/country_code/js/intlTelInput.min.js') }}"></script>

    <!-- Angular JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.2/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.2/angular-route.min.js"></script>
    <link media="all" type="text/css" rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- MY App -->
    {{--<script src="{{ asset('app/packages/dirPagination.js') }}"></script>--}}
    <script src="{{ asset('angular/routes.js') }}"></script>
{{--<script src="{{ asset('app/services/myServices.js') }}"></script>--}}
{{--<script src="{{ asset('app/helper/myHelper.js') }}"></script>--}}

<!-- App Controller -->
    {{--<script src="{{ asset('/angular/controllers/RegisterController.js') }}"></script>--}}
    <!-- Styles -->
</head>
<body ng-app="main-App">
<!--<div class="container">
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
            <a href="{{ url('/home') }}">Home</a>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
                @endauth
        </div>
    @endif
</div>-->



<div class="container">
    <div class="row row-centered">
        <div class="col-xs-4 col-centered">&nbsp;</div>
        <div class="col-xs-4 col-centered" style="text-align: center;padding: 40px;">
            <h1 style="font-weight: bold;"><img src="logo.png" alt="Techno School">
            </h1>
        </div>
        <div class="col-xs-4 col-centered">&nbsp;</div>
    </div>
</div>

<div class="container">

<div class="row row-centered">

<div class="col-md-3">&nbsp;</div>

<div class="col-md-6">

<div class="jumbotron">

<form class="ng-pristine ng-valid">
  <div>
      <div>
    <div class="form-group lb-lg">
        <h2 style="text-align: center"><hr style="width:13%;float:left"/>Create a New Account<hr style="width:13%;float:right" /></h2>
    </div>
  <div class="form-group">
    <label class="lb-lg" for="Name">Name</label>
    <input type="text" class="form-control input-lg" id="name" placeholder="eg: John Smith">
  </div>

  <div class="form-group">
    <label class="lb-lg" for="Email">Email Address</label>
    <input type="email" class="form-control input-lg" id="email" placeholder="name@company.com">
  </div>

	<div class="form-group">
    <label  class="lb-lg" for="phone">Phone Number</label>
    <input class="form-control input-lg" id="phone" type="tel">
  </div>

  	<div class="form-group">
    <label class="lb-lg" for="password">Password</label>
    <input type="password" class="form-control input-lg" id="password" placeholder="Enter Password">
  </div>

  	<div class="form-group">
    <label class="lb-lg" for="confirm_password">Confirm Password</label>
    <input type="password" class="form-control input-lg" id="confirm_password" placeholder="Confirm Password">
  </div>

	<a href="#!verification" title="Login" style="font-weight: bold;font-size: x-large;" class="btn btn-primary btn-block">Next</a>
      </div>
  </div>
    <!-- Step 2 -->
</form>
    <br>
    <div class="row">
        <div class="col-md-12 form-group text-center lb-lg">
                        <span>Already have an account? <a href="/login" title="Login">Log In</a>
                        </span>
        </div>
    </div>
    <div ng-view></div>
</div>


</div>

<div class="col-md-3">&nbsp;</div>

</div>

</div>
{{--<a href="#/">home</a>--}}
{{--<a href="#/verification">verification</a>--}}
{{--<a href="#/register/register">register</a>--}}
 <!-- Country Code Jquery -->
<script src="{{ asset('js/country_code/js/countrycode.js') }}"></script>

</body>
</html>