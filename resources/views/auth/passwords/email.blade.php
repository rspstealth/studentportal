@extends('layouts.login')

@section('content')
    <div class="container main-content">
        <div class="row justify-content-center">
            <div class="col-12 text-center">
                <h3 style="padding:30px;color:#2c7be5"><b>Reset Password</b></h3>
                <hr class="hr-login"/>
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4 justify-content-center">
                <div class="card">

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="control-label lb-lg">Email Address</label>

                                <input id="email" type="email" class="form-control" name="email"
                                       value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary lb-lg ">
                                    Send Password Reset Link
                                </button>
                                <br>
                                <br>
                                <p class="text-muted text-center mb-5">
                                    You will be sent an email with a password reset link. Please wait few minutes for email to arrive...
                                </p>
                                <a href="{{url('/login')}}" title="Login">< Back to Login</a>

                            </div>
                        </form>
                    </div>
                </div>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
@endsection
