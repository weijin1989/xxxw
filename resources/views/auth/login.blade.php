<!DOCTYPE html>
<!-- Template Name: Rapido - Responsive Admin Template build with Twitter Bootstrap 3.x Version: 1.2 Author: ClipTheme -->
<!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
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
    <meta name="description" content="wbb">
    <meta name="author" content="Belync Inc.">
    <meta name="keyword" content="湘西土家族苗族自治州新闻管理平台">
    <!-- end: META -->
    <!-- start: MAIN CSS -->
    <link rel="stylesheet" href="{{ asset('/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/animate.css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/iCheck/skins/all.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/styles-responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/iCheck/skins/all.css') }}">
<!--[if IE 7]>
    <link rel="stylesheet" href="{{ asset('/plugins/font-awesome/css/font-awesome-ie7.min.css') }}">
    <![endif]-->
    <!-- end: MAIN CSS -->
    <!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
    <!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
</head>
<!-- end: HEAD -->
<!-- start: BODY -->
<body class="login">
<div class="row">
    <div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
        <div class="logo">
            {{--<img src="{{ asset('/images/newlogo.png') }}">--}}
        </div>
        <!-- start: LOGIN BOX -->
        <div class="box-login">
            <h3>登录到您的帐户</h3>
            <p>
                请输入您的用户名和密码以登录。
            </p>
            <form class="form-login" action="{{ url('/login') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="errorHandler alert alert-danger no-display" style="display:<?php if(count($errors) > 0){echo 'block';}else{echo 'none';}?>">
                    <i class="fa fa-remove-sign"></i> 您有一些错误，请检查下面。
                    @if(count($errors) > 0)
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <fieldset>
                    <div class="form-group">
								<span class="input-icon">
									<input type="text" class="form-control" name="email" placeholder="用户名">
									<i class="fa fa-user"></i> </span>
                    </div>
                    <div class="form-group form-actions">
								<span class="input-icon">
									<input type="password" class="form-control password" name="password" placeholder="密码">
									<i class="fa fa-lock"></i>
                                    {{--<a class="forgot" href="#">--}}
                                    {{--忘记密码--}}
                                    {{--</a> --}}
                                </span>
                    </div>
                    <div class="form-actions">
                        {{--<label for="remember" class="checkbox-inline">--}}
                        {{--<input type="checkbox" class="grey remember" id="remember" name="remember">--}}
                        {{--记住我--}}
                        {{--</label>--}}
                        <button type="submit" class="btn btn-green pull-right">
                            登录 <i class="fa fa-arrow-circle-right"></i>
                        </button>
                    </div>
                    {{--<div class="new-account">--}}
                    {{--还没有账号？--}}
                    {{--<a href="#" class="register">--}}
                    {{--创建一个账户--}}
                    {{--</a>--}}
                    {{--</div>--}}
                </fieldset>
            </form>
            <!-- start: COPYRIGHT -->
            <div class="copyright">
                2019 &copy; 湘西土家族苗族自治州新闻管理平台
            </div>
            <!-- end: COPYRIGHT -->
        </div>
        <!-- end: LOGIN BOX -->
    </div>
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
<script src="{{ asset('/plugins/iCheck/jquery.icheck.min.js') }}"></script>
<script src="{{ asset('/plugins/jquery.transit/jquery.transit.js') }}"></script>
<script src="{{ asset('/plugins/TouchSwipe/jquery.touchSwipe.min.js') }}"></script>
<script src="{{ asset('/js/main.js') }}"></script>
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="{{ asset('/plugins/jquery-validation/dist/jquery.validate.min.js') }}"></script>
<script src="{{ asset('/js/admin/login/login.js') }}"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script>
    jQuery(document).ready(function() {
        Main.init();
        Login.init();
    });
</script>
</body>
<!-- end: BODY -->
</html>