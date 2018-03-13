@extends('frontend.layouts.app')

@section('title', app_name() . ' | '.__('navs.general.home'))

@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-xs-12 col-md-8">
                    <div class="pull-left"><a href="#" class="prevnext"><i class="fa fa-angle-left"></i></a></div>
                    <div class="pull-left">
                        <ul class="paginationforum">
                            <li class="hidden-xs"><a href="#">1</a></li>
                            <li class="hidden-xs"><a href="#">2</a></li>
                            <li class="hidden-xs"><a href="#">3</a></li>
                            <li class="hidden-xs"><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                            <li><a href="#">6</a></li>
                            <li><a href="#" class="active">7</a></li>
                            <li><a href="#">8</a></li>
                            <li class="hidden-xs"><a href="#">9</a></li>
                            <li class="hidden-xs"><a href="#">10</a></li>
                            <li class="hidden-xs hidden-md"><a href="#">11</a></li>
                            <li class="hidden-xs hidden-md"><a href="#">12</a></li>
                            <li class="hidden-xs hidden-sm hidden-md"><a href="#">13</a></li>
                        </ul>
                    </div>
                    <div class="pull-left"><a href="#" class="prevnext last"><i class="fa fa-angle-right"></i></a></div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>


        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8">
                    @foreach($news as $new)
                        <!-- POST -->
                        @if($new->publish())
                                <div class="post">
                                    <div class="wrap-ut pull-left">
                                        <div class="userinfo pull-left">
                                            <div class="avatar">
                                                <img src="{{url('img/avatar.jpg')}}" alt="">
                                                <div class="status green">&nbsp;</div>
                                            </div>

                                            <div class="icons">
                                                <img src="{{url('img/icon1.jpg')}}" alt=""><img src="{{url('img/icon4.jpg')}}" alt="">
                                            </div>
                                        </div>
                                        <div class="posttext pull-left">
                                            <h2><a href="02_topic.html">{{$new->title}}</a></h2>
                                            <p>{{$new->content}}</p>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="postinfo pull-left">
                                        <div class="comments">
                                            <div class="commentbg">
                                                3
                                                <div class="mark"></div>
                                            </div>

                                        </div>
                                        <div class="views"><i class="fa fa-eye"></i> 15</div>
                                        <div class="time"><i class="fa fa-clock-o"></i> {{$new->time}}</div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div><!-- POST -->
                        @endif
                    @endforeach

                </div>
                <div class="col-lg-4 col-md-4">

                    <!-- -->
                    <div class="sidebarblock">
                        <h3>Categories</h3>
                        <div class="divline"></div>
                        <div class="blocktxt">
                            <ul class="cats">
                                @foreach($top_cate as $cate)
                                    <li><a href="#">{{$cate->name}} <span class="badge pull-right">{{$cate->count}}</span></a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>



        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-xs-12">
                    <div class="pull-left"><a href="#" class="prevnext"><i class="fa fa-angle-left"></i></a></div>
                    <div class="pull-left">
                        <ul class="paginationforum">
                            <li class="hidden-xs"><a href="#">1</a></li>
                            <li class="hidden-xs"><a href="#">2</a></li>
                            <li class="hidden-xs"><a href="#">3</a></li>
                            <li class="hidden-xs"><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                            <li><a href="#">6</a></li>
                            <li><a href="#" class="active">7</a></li>
                            <li><a href="#">8</a></li>
                            <li class="hidden-xs"><a href="#">9</a></li>
                            <li class="hidden-xs"><a href="#">10</a></li>
                            <li class="hidden-xs hidden-md"><a href="#">11</a></li>
                            <li class="hidden-xs hidden-md"><a href="#">12</a></li>
                            <li class="hidden-xs hidden-sm hidden-md"><a href="#">13</a></li>
                        </ul>
                    </div>
                    <div class="pull-left"><a href="#" class="prevnext last"><i class="fa fa-angle-right"></i></a></div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>


    </div>
@endsection
