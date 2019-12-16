@extends('base')
@section('content')

    <link href="/css/common.css" rel="stylesheet">

    <div class="main-content">
        <!-- end: SPANEL CONFIGURATION MODAL FORM -->
        <div class="container">
            <!-- start: PAGE HEADER -->
            <!-- start: TOOLBAR -->
            <div class="toolbar row">
                <div class="col-sm-6 hidden-xs">
                    <div class="page-header">
                        <h2>个人信息<small></small></h2>
                    </div>
                </div>
            </div>
            <!-- end: TOOLBAR -->
            <!-- end: PAGE HEADER -->
            <!-- start: BREADCRUMB -->
            <div class="row">
                <div class="col-md-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/') }}">首页</a></li>
                        <li class="active">个人信息</li>
                    </ol>
                </div>
            </div>
            <!-- end: BREADCRUMB -->
            <!-- start: PAGE CONTENT -->
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-white">
                            <div class="panel-body">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5>
                                            <strong>个人信息</strong>
                                        </h5>
                                    </div>
                                    <div class="ibox-content">
                                        <form id="form" method="post" class="form-horizontal" action="/system/modifyPassword_save">
                                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">
                                                    用户名称
                                                </label>
                                                <div class="col-sm-10">
                                                    <input name="name" id="name" type="text" class="form-control required" value="{{Auth::user()->email}}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">
                                                    原始密码
                                                </label>
                                                <div class="col-sm-10">
                                                    <input name="o_password" id="o_password" type="password" class="form-control required" value="">
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">
                                                    新密码
                                                </label>
                                                <div class="col-sm-10">
                                                    <input name="n_password" id="n_password" type="password" class="form-control required" value="">
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">
                                                    确认新密码
                                                </label>
                                                <div class="col-sm-10">
                                                    <input name="a_password" id="a_password"  type="password" class="form-control required" value="">
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>
                                            <div class="form-group">
                                                <div class="col-sm-4 col-sm-offset-2" id="submut_div">
                                                    <button class="btn btn-primary" type="submit" id="submut_divaa">保 存</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- end: PAGE CONTENT-->
                </div>
            </div>
        </div>
        <div class="subviews">
            <div class="subviews-container"></div>
        </div>
        <!-- end: PAGE -->
    </div>
    <!-- end: MAIN CONTAINER -->
    @endsection
    @section('subview')
    @endsection
    @section('jscontent')
            <!-- start: CORE JAVASCRIPTS  -->
    <script src="{{ asset('/js/main.js') }}"></script>
    <script src="{{ asset('/js/common.js') }}"></script>
    <!-- end: CORE JAVASCRIPTS  -->
    <!-- Toastr style -->
    <link href="/css/toastr/toastr.min.css" rel="stylesheet">
    <script>
        var post_token = '<?php echo csrf_token(); ?>';
        var is_pop = @if (session('is_pop')){{session('is_pop')}}@else 0 @endif ;
        jQuery(document).ready(function() {
            Main.init();
            status();
            if (is_pop > 0) {
                pop_template(is_pop);
            }

            $('#submut_divaa').click(function(){
                var n_password=$('#n_password').val();
                if(n_password!="") {
                    //验证
                    $("#form").validate({
                        onkeyup: false, //关闭输入时验证
                        ignore: ".ignore",  //开启隐藏域验证
                        rules: {
                            o_password: {
                                required: true,
                                remote: genAjaxRemote("", "/system/ajax_check_pwd", post_token)
                            },
                            n_password: {
                                minlength: 6  //密码验证 不少于6味数字
                            },
                            a_password: {
                                equalTo: "#n_password"  //再次输入密码验证
                            }
                        },
                        messages: {
                            o_password: {
                                required: "原始密码不能为空",
                                remote: "原始密码不正确"
                            },
                            n_password: {
                                minlength: "密码不能少于6位"
                            },
                            a_password: {
                                equalTo: "2次密码不一致"
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection