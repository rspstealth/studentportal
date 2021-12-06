<div>
    <!-- Right Side Of Navbar -->
    <ul class="nav navbar-nav  navbar-expand-lg navbar-right" style="float:right">
        <!-- Authentication Links -->
        @guest
        <li><a class="nav-link login" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Login </a></li>
        {{--<li><a class="nav-link register" href="{{ route('register') }}">Register</a></li>--}}
        @else
                <div id="header_profile">
                    <div id="left">
                        <?php
                        $photo = \App\Http\Controllers\UserController::getUserPhoto();
                        if(!empty($photo)){
                            echo '<img src="'.url('/public/').'/'.$photo.'" alt="'.Auth::user()->name.' photo" />';
                        }else{
                            echo '<i class="fas fa-user-circle profile_icon"></i>';
                        }
                        ?>
                    </div>
                    <div id="right">
                        <a title="my account" href="{{url('/')}}/my-account" id="manage_profile_button">My Account</a>
                        <a class="btn btn-outline-secondary tiny" href="{{ route('logout') }}"
                           onclick="e.preventDefault();document.getElementById('logout-form').submit();">
                            Logout</a>
                    </div>
                </div>
                {{--<span class="caret"></span>--}}
                <ul class="dropdown-menu profile-panel">
                    <div class="row margin-bottom-md">
                        <div class="col-md-4 no-padding">
                            <div class="profile-logo-medium margin-left-md">
                                <img src="" title="No Image"/>
                            </div>
                        </div>
                        <div class="col-md-6 no-padding">
                            <b>{{Auth::user()->name}}</b>
                        </div>
                        <div class="col-md-6 no-padding">
                            <p>{{Auth::user()->email}}</p>
                        </div>
                    </div>
                    <div class="row profile-panel padding-y-lg">
                        <div class="col-md-6 no-padding">
                            <a class="btn-block" href="my-account">
                                My Account
                            </a>
                        </div>
                        <div class="col-md-6 no-padding text-right">
                            <a class="btn-block" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                            >
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>


                    </div>

                </ul>
            </li>
            <div class="clearfix"></div>
            @endguest
    </ul>
</div>