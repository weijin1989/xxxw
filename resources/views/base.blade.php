<!DOCTYPE html>
<!-- Template Name: Rapido - Responsive Admin Template build with Twitter Bootstrap 3.x Version: 1.2 Author: ClipTheme -->
<!--[if IE 8]><html class="ie8" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- start: HEAD -->

<head>
    <title>湘西土家族苗族自治州新闻管理平台</title>
    <!-- start: META -->
    <meta charset="utf-8" />
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <meta name="description" content="wbb">
    <meta name="author" content="Belync Inc.">
    <meta name="keyword" content="湘西土家族苗族自治州新闻管理平台">
    <!-- end: META -->
    <!-- start: MAIN CSS -->
    {{--<link href='http://fonts.googleapis.com/css?family=Raleway:400,300,500,600,700,200,100,800' rel='stylesheet' type='text/css'>--}}
    <link rel="stylesheet" href="{{ asset('/plugins/bootstrap/css/bootstrap3.3.7.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/font-awesome/css/font-awesome.min.css') }}">
    {{--    <link rel="stylesheet" href="{{ asset('/newctl/plugins/iCheck/skins/all.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('/plugins/perfect-scrollbar/src/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/animate.css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/bootstrap-table/dist/bootstrap-table.css') }}">
    <!-- end: MAIN CSS -->
    <!-- start: CSS REQUIRED FOR SUBVIEW CONTENTS -->
    <link rel="stylesheet" href="{{ asset('/plugins/owl-carousel/owl-carousel/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/owl-carousel/owl-carousel/owl.theme.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/owl-carousel/owl-carousel/owl.transitions.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/ztree/zTreeStyle.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('/plugins/bootstrap-datepicker/css/datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/sweetalert/dist/sweetalert.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/plugins/weather-icons/css/weather-icons.min.css') }}">
    <!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
    <!-- start: CORE CSS -->
    <link rel="stylesheet" href="{{ asset('/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/styles-responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/themes/theme-style7.css') }}" type="text/css" id="skin_color">
    <link href="{{ asset('/css/chosen/chosen.css') }}" rel="stylesheet">
    <!-- end: CORE CSS -->
    <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}"/>
    {{--弹窗--}}
    <link href="/css/toastr/toastr.min.css" rel="stylesheet">

    <!-- ueditor-mz 配置文件 -->
    <script type="text/javascript" src="{{asset('/js/ueditor/ueditor.config.js')}}"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="{{asset('/js/ueditor/ueditor.all.js')}}"></script>

    ﻿<link rel="stylesheet" type="text/css" href="/js/ueditor/third-party/video-js/video-js.min.css"/>
    <script type="text/javascript" src="/js/ueditor/third-party/video-js/video.js"></script>
    <script src="http://cdn.bootcss.com/html5media/1.1.8/html5media.min.js"></script>
    <style>
        /*.modal-backdrop{height:100%;}*/
    </style>
</head>
<!-- end: HEAD -->
<!-- start: BODY -->

<body>
<div class="main-wrapper">
    <!-- start: TOPBAR -->
    <header class="topbar navbar navbar-inverse navbar-fixed-top inner">
        <!-- start: TOPBAR CONTAINER -->
        <div class="container">
            <div class="navbar-header">
                <a class="sb-toggle-left hidden-md hidden-lg" href="#main-navbar">
                    <i class="fa fa-bars"></i>
                </a>
            </div>
            <div style="float:left;color:#fff;padding-bottom:10px">
                <img src="/images/title.png" />
            </div>
            <div class="topbar-tools" style="margin-top:5px;">
                <!-- start: TOP NAVIGATION MENU -->
                <ul class="nav navbar-right">
                    <!-- start: USER DROPDOWN -->
                    <li class="dropdown current-user">
                        <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" data-close-others="true" href="#">
                            <img src="{{ asset('/images/anonymous.jpg') }}" width="30" height="30" class="img-circle" alt=""> <span class="username hidden-xs">{{ Auth::user()->name }}</span> <i class="fa fa-caret-down "></i>
                        </a>
                        <ul class="dropdown-menu dropdown-dark">
                            {{--<li>--}}
                                {{--<a href="{{ url('/system/modifyPassword') }}">--}}
                                    {{--修改密码--}}
                                {{--</a>--}}
                            {{--</li>--}}
                            <li>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                                <a href="{{ url('/logout') }}" onclick="event.preventDefault();
                                           document.getElementById('logout-form').submit();">
                                    退出系统
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- end: USER DROPDOWN -->
                    {{--<li class="right-menu-toggle">--}}
                        {{--<a href="#" class="sb-toggle-right">--}}
                            {{--<i class="fa fa-globe toggle-icon"></i> <i class="fa fa-caret-right"></i>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                </ul>
                <!-- end: TOP NAVIGATION MENU -->
            </div>
        </div>
        <!-- end: TOPBAR CONTAINER -->
    </header>
    <!-- end: TOPBAR -->
    <!-- start: PAGESLIDE LEFT -->
    <a class="closedbar inner hidden-sm hidden-xs" href="#">
    </a>
    @include('nav')
    <!-- end: PAGESLIDE LEFT -->
    <!-- start: PAGESLIDE RIGHT 右-->
    <div id="pageslide-right" class="pageslide slide-fixed inner" >
        <div class="right-wrapper">
            <ul class="nav nav-tabs nav-justified" id="sidebar-tab">
                <li class="active">
                    <a href="javascript:void(0)" role="tab" data-toggle="tab"><i class="fa fa-gear"></i> 样式设置 </a>
                </li>
            </ul>
            <div class="hidden-xs" id="style_selector">
                <div id="style_selector_container">
                    <div class="pageslide-title">
                        样式选择
                    </div>
                    <div class="box-title">
                        选择你的布局样式
                    </div>
                    <div class="input-box">
                        <div class="input">
                            <select name="layout" class="form-control">
                                <option value="default">默认</option><option value="boxed">盒子型</option>
                            </select>
                        </div>
                    </div>
                    <div class="box-title">
                        选择你的头部样式
                    </div>
                    <div class="input-box">
                        <div class="input">
                            <select name="header" class="form-control">
                                <option value="fixed">固定</option><option value="default">可活动</option>
                            </select>
                        </div>
                    </div>
                    <div class="box-title">
                        选择你的侧边栏样式
                    </div>
                    <div class="input-box">
                        <div class="input">
                            <select name="sidebar" class="form-control">
                                <option value="fixed">固定</option><option value="default">可活动</option>
                            </select>
                        </div>
                    </div>
                    <div class="box-title">
                        选择你的尾部样式
                    </div>
                    <div class="input-box">
                        <div class="input">
                            <select name="footer" class="form-control">
                                <option value="default">可活动</option><option value="fixed">固定</option>
                            </select>
                        </div>
                    </div>
                    <div class="box-title">
                        10 种预定义颜色方案
                    </div>
                    <div class="images icons-color">
                        <a href="#" id="default"><img src="{{ asset('/images/color-1.png') }}" alt="" class="active"></a>
                        <a href="#" id="style2"><img src="{{ asset('/images/color-2.png') }}" alt=""></a>
                        <a href="#" id="style3"><img src="{{ asset('/images/color-3.png') }}" alt=""></a>
                        <a href="#" id="style4"><img src="{{ asset('/images/color-4.png') }}" alt=""></a>
                        <a href="#" id="style5"><img src="{{ asset('/images/color-5.png') }}" alt=""></a>
                        <a href="#" id="style6"><img src="{{ asset('/images/color-6.png') }}" alt=""></a>
                        <a href="#" id="style7"><img src="{{ asset('/images/color-7.png') }}" alt=""></a>
                        <a href="#" id="style8"><img src="{{ asset('/images/color-8.png') }}" alt=""></a>
                        <a href="#" id="style9"><img src="{{ asset('/images/color-9.png') }}" alt=""></a>
                        <a href="#" id="style10"><img src="{{ asset('/images/color-10.png') }}" alt=""></a>
                    </div>
                    <div class="box-title">
                        盒子型背景
                    </div>
                    <div class="images boxed-patterns">
                        <a href="#" id="bg_style_1"><img src="{{ asset('/images/bg.png') }}" alt=""></a>
                        <a href="#" id="bg_style_2"><img src="{{ asset('/images/bg_2.png') }}" alt=""></a>
                        <a href="#" id="bg_style_3"><img src="{{ asset('/images/bg_3.png') }}" alt=""></a>
                        <a href="#" id="bg_style_4"><img src="{{ asset('/images/bg_4.png') }}" alt=""></a>
                        <a href="#" id="bg_style_5"><img src="{{ asset('/images/bg_5.png') }}" alt=""></a>
                    </div>
                    <div class="style-options">
                        <a href="#" class="clear_style">
                            清除样式
                        </a>
                        <a href="#" class="save_style">
                            保存样式
                        </a>
                    </div>
                </div>
                <div class="style-toggle open"></div>
            </div>
        </div>
    </div>
    <!-- end: PAGESLIDE RIGHT -->
    <!-- start: MAIN CONTAINER -->
    <div class="main-container bljsgetwidth" >
        @yield('content')
    </div>
    <!-- start: FOOTER -->
    <footer class="">
        <div class="footer-inner">
            <div class="pull-left">
                2019 &copy; Hunan Hanc Network Technology Co.,Ltd. All Rights Reserved 服务热线:400-885-3080
            </div>
            <div class="pull-right">
                <span class="go-top"><i class="fa fa-chevron-up"></i></span>
            </div>
        </div>
    </footer>
    <!-- end: FOOTER -->
    @yield('subview')
</div>
<!-- start: MAIN JAVASCRIPTS -->
<!--[if lt IE 9]>
<script src="{{ asset('/plugins/respond.min.js') }}"></script>
<script src="{{ asset('/plugins/excanvas.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/plugins/jQuery/jquery-1.11.1.min.js') }}"></script>
<![endif]-->
<!--[if gte IE 9]><!-->
<script src="{{ asset('/plugins/jQuery/jquery-2.1.1.min.js') }}"></script>
<!--<![endif]-->
<script src="{{ asset('/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js') }}"></script>
<script src="{{ asset('/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/plugins/blockUI/jquery.blockUI.js') }}"></script>
{{--<script src="{{ asset('/newctl/plugins/iCheck/jquery.icheck.min.js') }}"></script>--}}
{{--<script src="{{ asset('/newctl/plugins/moment/min/moment.min.js') }}"></script>--}}
<script src="{{ asset('/plugins/perfect-scrollbar/src/jquery.mousewheel.js') }}"></script>
<script src="{{ asset('/plugins/perfect-scrollbar/src/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('/plugins/bootbox/bootbox.min.js') }}"></script>
<script src="{{ asset('/plugins/jquery.scrollTo/jquery.scrollTo.min.js') }}"></script>
<script src="{{ asset('/plugins/ScrollToFixed/jquery-scrolltofixed-min.js') }}"></script>
<script src="{{ asset('/plugins/jquery.appear/jquery.appear.js') }}"></script>
<script src="{{ asset('/plugins/jquery-cookie/jquery.cookie.js') }}"></script>
<script src="{{ asset('/plugins/velocity/jquery.velocity.min.js') }}"></script>
<script src="{{ asset('/plugins/TouchSwipe/jquery.touchSwipe.min.js') }}"></script>
<script src="{{ asset('/plugins/bootstrap-table/dist/bootstrap-table.js') }}"></script>
<script src="{{ asset('/plugins/bootstrap-table/bootstrap-table-zh-CN.js') }}"></script>
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: JAVASCRIPTS REQUIRED FOR SUBVIEW CONTENTS -->
<script src="{{ asset('/plugins/owl-carousel/owl-carousel/owl.carousel.js') }}"></script>
<script src="{{ asset('/plugins/toastr/toastr.js') }}"></script>
<script src="{{ asset('/plugins/bootstrap-modal/js/bootstrap-modal.js') }}"></script>
<script src="{{ asset('/plugins/bootstrap-modal/js/bootstrap-modalmanager.js') }}"></script>
{{--<script src="{{ asset('/newctl/plugins/fullcalendar/fullcalendar/fullcalendar.min.js') }}"></script>--}}
{{--<script src="{{ asset('/newctl/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js') }}"></script>--}}
{{--<script src="{{ asset('/newctl/plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>--}}
{{--<script src="{{ asset('/plugins/jquery-validation/dist/jquery.validate.min.js') }}"></script>--}}

<!-- 验证 -->
<script src="{{ asset('/plugins/validate/jquery.validate.min.js') }}"></script>
<script src="{{ asset('/plugins/validate/jquery.validate.prompt.js') }}"></script>

{{--<script src="{{ asset('/newctl/plugins/bootstrap-fileupload/bootstrap-fileupload.min.js') }}"></script>--}}
{{--<script src="{{ asset('/newctl/plugins/DataTables/media/js/jquery.dataTables.min.js') }}"></script>--}}
<script src="{{ asset('/plugins/truncate/jquery.truncate.js') }}"></script>
{{--<script src="{{ asset('/newctl/plugins/summernote/dist/summernote.min.js') }}"></script>--}}
{{--<script src="{{ asset('/newctl/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>--}}
<script src="{{ asset('/js/subview.js') }}"></script>
<script src="{{ asset('/plugins/autosize/jquery.autosize.min.js') }}"></script>
{{--<script src="{{ asset('/newctl/plugins/select2/select2.min.js') }}"></script>--}}
{{--<script src="{{ asset('/newctl/plugins/select2/select2_locale_zh-CN.js') }}"></script>--}}
{{--<script src="{{ asset('/newctl/plugins/jquery.maskedinput/src/jquery.maskedinput.js') }}"></script>--}}
{{--<script src="{{ asset('/newctl/plugins/jquery-inputlimiter/jquery.inputlimiter.1.3.1.min.js') }}"></script>--}}
{{--<script src="{{ asset('/newctl/plugins/jquery-maskmoney/jquery.maskMoney.js') }}"></script>--}}
<script src="{{ asset('/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
{{--<script src="{{ asset('/newctl/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>--}}
{{--<script src="{{ asset('/newctl/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>--}}
{{--<script src="{{ asset('/newctl/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}"></script>--}}
{{--<script src="{{ asset('/newctl/plugins/bootstrap-colorpicker/js/commits.js') }}"></script>--}}
{{--<script src="{{ asset('/newctl/plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js') }}"></script>--}}
<script src="{{ asset('/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js') }}"></script>
{{--<script src="{{ asset('/js/bootstrap-switch.min.js') }}"></script>--}}
<script src="{{ asset('/plugins/jQuery-Tags-Input/jquery.tagsinput.js') }}"></script>
{{--<script src="{{ asset('/newctl/plugins/ckeditor/ckeditor.js') }}"></script>--}}
{{--<script src="{{ asset('/newctl/plugins/ckeditor/adapters/jquery.js') }}"></script>--}}
<script src="{{ asset('/js/form-elements.js') }}"></script>
<script src="{{ asset('/plugins/sweetalert/dist/sweetalert.min.js') }}"></script>
<!-- 下拉 -->
<script src="{{ asset('/plugins/chosen/chosen.jquery.js')}}"></script>
<script src="{{ asset('/js/common.js')}}"></script>
{{--<script src="{{ asset('/newctl/plugins/jQuery-autoComplete/jquery.auto-complete.min.js') }}"></script>--}}
<!-- end: JAVASCRIPTS REQUIRED FOR SUBVIEW CONTENTS -->
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
@yield('jscontent')
<style>
    .main-container{
        margin-top: 77px !important;
    }
</style>
</body>
<!-- end: BODY -->

<script>
    function online(line){
        $.ajax({
            type:'POST',
            url:'/system/online',
            data:{line:line},
            dataType:'json',
            headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')},
            success: function(msg) {
                if(msg){
                    $('.individuation tr').remove();
                    $('.individuation').append('<tr> <td>编号</td> <td>险种</td> <td>价钱</td> <td>操作</td> </tr>');
                    for(var i = 0;i < msg.length;i++){
                        var bh = i + 1;
                        var tr = '<tr><td>'+ bh +'</td><td>'+msg[i].name+'</td><td>'+msg[i].price+'</td><td><button class="delGXH">删除</button></td> </tr>';
                        $('.individuation').append(tr);
                    }
                }
            }
        });
    }
</script>
</html>