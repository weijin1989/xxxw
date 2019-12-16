
<nav id="pageslide-left" class="pageslide inner">
    <div class="navbar-content">
        <!-- start: SIDEBAR -->
        <div class="main-navigation left-wrapper transition-left">
            <div class="navigation-toggler hidden-sm hidden-xs">
                <a href="#main-navbar" class="sb-toggle-left">
                </a>
            </div>
            {{--<div class="user-profile border-top padding-horizontal-10 block">--}}
                {{--<div class="inline-block">--}}
                    {{--<img src="{{ asset('/images/anonymous.jpg') }}" width="50" height="50" alt="">--}}
                {{--</div>--}}
                {{--<div class="inline-block">--}}
                    {{--<h5 class="no-margin"> 欢迎</h5>--}}
                    {{--<h4 class="no-margin hyname" style="color:#fff"> {{ Auth::user()->name }} </h4>--}}
                {{--</div>--}}
            {{--</div>--}}
            <!-- start: MAIN NAVIGATION MENU -->
            @foreach($system_menu as $s)
                <ul class="main-navigation-menu">
                    <li @if($menu_pid==$s['id'])  class="open active" @endif >
                        <a href="javascript:void(0)"><i class="{{$s['icon']}}"></i> <span class="title"> {{$s['catname']}} </span><i class="icon-arrow"></i> </a>
                        @if(count($s['two'])>0)
                            <ul class="sub-menu">
                                @foreach($s['two'] as $v)
                                    <li  @if($menu_lid==$v['id'])  class="active" @endif >
                                        <a href="{{$v['url']}}?menu_pid={{$s['id']}}&menu_lid={{$v['id']}}">
                                            <i class="{{$v['icon']}}"></i> <span class="title"> {{$v['catname']}} </span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                </ul>
        @endforeach
        <!-- end: MAIN NAVIGATION MENU -->
        </div>
        <!-- end: SIDEBAR -->
    </div>
    <div class="slide-tools">
        {{--<div class="col-xs-6 text-left no-padding">--}}
            {{--<a class="btn btn-sm status @if(Auth::user()->is_online ===0) offline @endif" href="#">--}}
                {{--状态 <i class="fa fa-dot-circle-o text-green"></i> <span>@if(Auth::user()->is_online ===0) 离线 @else 在线 @endif</span>--}}
            {{--</a>--}}
        {{--</div>--}}
        {{--<div class="col-xs-6 text-right no-padding">--}}
            {{--<a class="btn btn-sm log-out text-right" href="{{ url('/logout') }}">--}}
                {{--<i class="fa fa-power-off"></i> 退出系统--}}
            {{--</a>--}}
        {{--</div>--}}
    {{--</div>--}}
</nav>


