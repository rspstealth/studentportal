@extends('layouts.dashboard')
@section('content')


    <div class="container main-content">
            <div class="row col-md-12 no-padding">
                    <div class="col-md-2" id="sidebar-menu">
                            <ul class="nav navbar-nav">
                                @include('layouts.get-user-menu')
                            </ul>
                    </div>

                    <div id="right-content" class="col-md-10">
                        <div>
                            <h4 class="">Hi {{auth()->user()->name}}, Welcome Back!</h4>
                        </div>

                        <div class="row col-md-12 no-padding no-margin">

                            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                                <!-- Indicators -->
                                <ol class="carousel-indicators">
                                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                                    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                                    <li data-target="#carousel-example-generic" data-slide-to="3"></li>
                                    <li data-target="#carousel-example-generic" data-slide-to="4"></li>
                                </ol>

                                <!-- Wrapper for slides -->
                                <div class="carousel-inner" role="listbox">
                                    <div class="item">
                                        <img src="https://s26.postimg.cc/zccz3svft/cg6.jpg" width="100%">
                                        <div class="carousel-caption">
                                            <h3>Second slide</h3>
                                            <p>Caption goes here</p>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <img src="https://s26.postimg.cc/hyxmrttt5/cg1.jpg" width="100%">
                                        <div class="carousel-caption">
                                            <h3>Third slide</h3>
                                            <p>Caption goes here</p>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <img src="https://s26.postimg.cc/7g2ozrxgp/cg4.jpg" width="100%">
                                        <div class="carousel-caption">
                                            <h3>Fourth slide</h3>
                                            <p>Caption goes here</p>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <img src="https://s26.postimg.cc/l7244vg2x/cg2.jpg" width="100%">
                                        <div class="carousel-caption">
                                            <h3>Fifth slide</h3>
                                            <p>Caption goes here</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Controls -->
                                <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>

                        </div>



                        </div>

                        <div class="row col-md-12 no-padding no-margin">
                            <div class="col-md-7 dash_card_left">
                                <div class="card">
                                    <div class="col-md-12 no-padding">
                                        <h4>Events For Today</h4>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-12 no-padding">
                                            <ul>
                                                <li>
                                                    <a style="margin:10px 0;margin-top: 14px;font-size:16px;display:block" target="_blank" href="{{url('/')}}" title="Event">
                                                        Coming Soon
                                                    </a>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 dash_card_left">
                                    <div class="card">
                                        <div class="col-md-12 no-padding ">
                                            <h4>Announcements</h4>
                                        </div>
                                        <div class="col-md-12">
                                            <ul>
                                                <li>
                                                    <a style="margin:10px 0;margin-top: 14px;font-size:16px;display:block" target="_blank" href="{{url('/students/list/1')}}" title="Students">
                                                        Coming Soon
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5 dash_card_right">
                                <div class="card">
                                    <div class="col-md-12 no-padding">
                                        <div class="col-md-12 no-padding">
                                           <h4>Resources</h4>
                                        </div>
                                        <div class="col-md-12">
                                            <ul style="list-style:none;padding:0;">
                                            @foreach($student_resources as $resource)
                                                <li>
                                                    <a style="margin:6px 0;font-size:16px;display:block"  download href="{{asset('/public/resources/'.$resource->resource_file)}}" title="">
                                                        {{$resource->description}}
                                                    </a>
                                                </li>
                                            @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="col-md-12 no-padding">
                                        <div class="col-md-12 no-padding">
                                            <h4><a href="#">Contact Tutor</a></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="col-md-12 no-padding">
                                        <div class="col-md-12 no-padding">
                                            <h4><a href="#">Health & Wellbeing</a></h4>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
    </div>
    <script type="text/javascript">
        $(function () {
        $(".carousel").swipe({
            swipe: function(
                event,
                direction,
                distance,
                3000,
                fingerCount,
                fingerData
            ) {
                if (direction == "left") $(this).carousel("next");
                if (direction == "right") $(this).carousel("prev");
            },
            allowPageScroll: "vertical"
        });
        });
    </script>
@endsection
