<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Log In</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato|Roboto" rel="stylesheet">
   {{--Jquery--}}
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!-- Angular JS -->
    <link media="all" type="text/css" rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-5 col-xl-4 my-5">

            <!-- Heading -->
            <h1 class="display-4 text-center mb-3">
                Sign in
            </h1>

            <!-- Subheading -->
            <p class="text-muted text-center mb-5">
                To Access your dashboard
            </p>

            <!-- Form -->
            <form>

                <!-- Email address -->
                <div class="form-group">

                    <!-- Label -->
                    <label>Email 1414Address</label>

                    <!-- Input -->
                    <input type="email" class="form-control" placeholder="Name@address.com">

                </div>

                <!-- Password -->
                <div class="form-group">

                    <div class="row">
                        <div class="col">

                            <!-- Label -->
                            <label>Password</label>

                        </div>
                        <div class="col-auto">

                            <!-- Help text -->
                            <a href="password-reset.html" class="form-text small text-muted">
                                Forgot password?
                            </a>

                        </div>
                    </div> <!-- / .row -->

                    <!-- Input group -->
                    <div class="input-group input-group-merge">

                        <!-- Input -->
                        <input type="password" class="form-control form-control-appended" placeholder="Enter your password">

                        <!-- Icon -->
                        <div class="input-group-append">
                  <span class="input-group-text">
                    <i class="fe fe-eye"></i>
                  </span>
                        </div>

                    </div>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-lg btn-block btn-primary mb-3">
                    Sign in
                </button>

                <!-- Link -->
                <div class="text-center">
                    <small class="text-muted text-center">
                        Don't have an account yet? <a href="sign-up.html">Sign up</a>.
                    </small>
                </div>

            </form>

        </div>
    </div> <!-- / .row -->
</div>

{{--<div class="container">
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

</div>--}}
{{--<div class="container">
    <div class="row row-centered">
        <div class="col-xs-4 col-centered">&nbsp;</div>
        <div class="col-xs-4 col-centered" style="text-align: center;padding: 40px;">
            <h1 style="font-weight: bold;"><img src="logo.png" alt="Techno School"/>
            </h1>
        </div>
        <div class="col-xs-4 col-centered">&nbsp;</div>
    </div>
</div>--}}

<div class="container">
        <div class="row row-centered">
            <div class="col-xs-3 col-centered">&nbsp;</div>
            <div class="col-xs-6 col-centered">
                <div class="jumbotron">
                    <form class="ng-pristine ng-valid">
                        <div class="form-group lb-lg">
                            <h2 style="text-align: center"><hr style="width:35%;float:left"/>Log In<hr style="width:35%;float:right" /></h2>
                        </div>
                        <div class="form-group lb-lg">
                            <label for="exampleInputEmail1">Email Address</label>
                            <i class="mail icon"></i>
                            <input type="email" class="form-control input-lg" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="name@company.com">
                        </div>
                        <div class="form-group lb-lg">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control input-lg" id="exampleInputPassword1" placeholder="Password">
                        </div>
                        <div class="form-check">
                            <label style="vertical-align: text-bottom;" class="form-check-label lb-lg">
                                <input style="zoom: 1.5;vertical-align: inherit;" type="checkbox" class="form-check-input">
                                Remember Me
                            </label>
                        </div>
                        <button type="submit" style="font-weight: bold;font-size: x-large;" class="btn btn-primary btn-block input-lg">Log In</button>
                    </form>
                    <br>
                    <div class="row">
                        <div class="col-md-12 form-group text-center lb-lg">
                            <a href="/forgot-password" title="Don't remember your password?">Forgot password?</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group text-center lb-lg">
                        <span>Don’t have an account? <a href="/register" title="Create a new account">Sign Up</a>
                        </span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xs-3 col-centered">&nbsp;</div>
        </div>
</div>

</body>
</html>