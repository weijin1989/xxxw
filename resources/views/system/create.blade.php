@extends('base')
@section('content')

    <link href="/css/common.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/js/selectator-master/fm.selectator.jquery.css') }}">
    <div class="main-content">
        <!-- end: SPANEL CONFIGURATION MODAL FORM -->
        <div class="container">
            <!-- start: PAGE HEADER -->
            <!-- start: TOOLBAR -->
            <div class="toolbar row">
                <div class="col-sm-6 hidden-xs">
                    <div class="page-header">
                        <h2>账户管理<small></small></h2>
                    </div>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <a href="#" class="back-subviews">
                        <i class="fa fa-chevron-left"></i> 返回
                    </a>
                    <div class="toolbar-tools pull-right">
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
                        <li><a href="/system?com_id={{$company_info->id}}">账户管理</a></li>
                        <li class="active">创建账户</li>
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
                                            <strong>新增</strong>
                                        </h5>
                                    </div>
                                    <div class="ibox-content">
                                        <form id="form" method="post" class="form-horizontal" action="/system/doadd">
                                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                            <input type="hidden" name="com_id" value="{{$company_info->id}}">
                                            <div class="form-group">
                                                <fieldset>
                                                    <div class="row col-lg-3 col-md-4 col-sm-5 col-xs-10 col-xs-offset-1">
                                                        <div class="form-group">
                                                            <label class="control-label">所属单位</label>
                                                            <div class="controls">
                                                                <select class="form-control"  name="company_id"  style="height: 30px; padding: 0;">
                                                                    @foreach($company_list as $l)
                                                                        <option class="option" @if($l->id == $company_info->id) selected @endif value="{{$l->id}}">{{$l->company_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row col-lg-3 col-md-4 col-sm-5 col-xs-10 col-xs-offset-1">
                                                        <div class="form-group">
                                                            <label class="control-label">用户名</label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control required" name="email">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row col-lg-3 col-md-4 col-sm-5 col-xs-10 col-xs-offset-1">
                                                        <div class="form-group">
                                                            <label class="control-label">新密码</label>
                                                            <div class="controls">
                                                                <input type="password" class="form-control password required" name="password" id="password">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row col-lg-3 col-md-4 col-sm-5 col-xs-10 col-xs-offset-1">
                                                        <div class="form-group">
                                                            <label class="control-label">确认密码</label>
                                                            <div class="controls">
                                                                <input type="password" class="form-control repass" name="repass">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row col-lg-3 col-md-4 col-sm-5 col-xs-10 col-xs-offset-1">
                                                        <div class="form-group">
                                                            <label class="control-label">姓名</label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control name" name="name">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row col-lg-3 col-md-4 col-sm-5 col-xs-10 col-xs-offset-1">
                                                        <div class="form-group">
                                                            <label class="control-label">角色</label>
                                                            <div class="controls">
                                                                <select id="role" class="form-control role" name="role"  style="height: 30px; padding: 0;">
                                                                    @foreach($roleInfo as $l)
                                                                        <option class="option" value="{{$l->id}}">{{$l->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="hr-line-dashed"></div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">状态</label>
                                                <div class="status btn-group m-l p_l_15">
                                                    <input name="status" id="status" type="hidden" value="1" >
                                                    <button  type="button" data-status="1" class="btn btn-primary active">开启</button>
                                                    <button  type="button" data-status="0" class="btn btn-default">禁用</button>
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            <div class="form-group">
                                                <div class="col-sm-4 col-sm-offset-2" id="submut_div">
                                                    <button class="btn btn-info save-note" type="submit">
                                                        保存
                                                    </button>
                                                    <button class="btn btn-white" type="button" onclick="history.go(-1);">取 消</button>
                                                    {{--<button class="btn btn-info save_to_userAgent" type="submit" name="save_to_userAgent" value="act" style="display: none">保存并跳转到代理人设置</button>--}}
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
    <style>
        .col-lg-3{height:75px}
    </style>
    @endsection
@section('jscontent')
    <script src="{{ asset('/js/admin/nav/system.js') }}"></script>
    <!-- start: CORE JAVASCRIPTS  -->
    <script src="{{ asset('/js/main.js') }}"></script>
    <script src="{{ asset('/js/common.js') }}"></script>
    <link href="/css/toastr/toastr.min.css" rel="stylesheet">
    <script src="{{ asset('/js/selectator-master/fm.selectator.jquery.js') }}"></script>
    <!-- end: CORE JAVASCRIPTS  -->
    <script>
        jQuery(document).ready(function() {
            Main.init();
            status();
            //角色多选
            {{--var $role = $('#role');--}}
            {{--if ($role.data('selectator') === undefined) {--}}
                {{--$role.selectator({--}}
                    {{--showAllOptionsOnFocus: true,--}}
                    {{--keepOpen: true--}}
                {{--});--}}
            {{--} else {--}}
                {{--$role.selectator('destroy');--}}
            {{--}--}}


            {{--//验证--}}
            var post_token = '<?php echo csrf_token(); ?>';
            {{--$('#role').change(function(){--}}
                {{--if($(this).val().indexOf('2')>-1||$(this).val().indexOf('3')>-1||$(this).val().indexOf('20')>-1){--}}
                    {{--$('.wx_kf').show();--}}
                    {{--$('.save_to_userAgent').show();--}}
                {{--}else{--}}
                    {{--$('.wx_kf').hide();--}}
                    {{--$('.save_to_userAgent').hide();--}}
                {{--}--}}
            {{--});--}}

            $("#form").validate({
                onkeyup: false, //关闭输入时验证
                ignore: ".ignore",  //开启隐藏域验证
                rules: {
                    role : {
                        required : true
                    },
                    name : {
                        required : true
                    },
                    email: {
                        required: true,
                        remote: genAjaxRemote("", "/system/addcheck", post_token)   //AJAX验重
                    },
                    password: {
                        minlength: 6  //密码验证 不少于6位数字
                    },
                    repass: {
                        equalTo: "#password"  //再次输入密码验证
                    }
                },
                messages: {
                    role : {
                        required : ' *角色不能为空'
                    },
                    name : {
                        required : ' *姓名不能为空'
                    },
                    email: {
                        required: "用户名不能为空",
                        remote: "该用户名已被使用"
                    },
                    password: {
                        required: "密码不能为空",
                        minlength: "密码不能少于6位"
                    },
                    repass: {
                        equalTo: "密码不一致"
                    }
                }
            });
        });
    </script>
@endsection