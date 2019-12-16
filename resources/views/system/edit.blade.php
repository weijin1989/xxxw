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
                        <li class="active">编辑账户</li>
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
                                            <strong>编辑</strong>
                                        </h5>
                                    </div>
                                    <div class="ibox-content">
                                        <form id="form" method="post" class="form-horizontal" action="/system/doedit">
                                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                            <input type="hidden" name="change_id" value="{{$usersOneInfo->id}}">
                                            <input type="hidden" name="com_id" value="{{$com_id}}">

                                            <div class="form-group">
                                                <fieldset>
                                                    <div class="row col-lg-3 col-md-4 col-sm-5 col-xs-10 col-xs-offset-1">
                                                        <div class="form-group">
                                                            <label class="control-label">用户名</label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control email required" disabled name="email" value = "{{$usersOneInfo->email}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row col-lg-3 col-md-4 col-sm-5 col-xs-10 col-xs-offset-1">
                                                        <div class="form-group">
                                                            <label class="control-label">新密码</label>
                                                            <div class="controls">
                                                                <input type="password" class="form-control password" value="" placeholder="不输入表示不修改" name="password" id="password">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row col-lg-3 col-md-4 col-sm-5 col-xs-10 col-xs-offset-1">
                                                        <div class="form-group">
                                                            <label class="control-label">确认密码</label>
                                                            <div class="controls">
                                                                <input type="password" class="form-control repass" value="" placeholder="不输入表示不修改"  name="repass">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row col-lg-3 col-md-4 col-sm-5 col-xs-10 col-xs-offset-1">
                                                        <div class="form-group">
                                                            <label class="control-label">姓名</label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control name required" name="name" value = "{{$usersOneInfo->name}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row col-lg-3 col-md-4 col-sm-5 col-xs-10 col-xs-offset-1">
                                                    <div class="form-group">
                                                        <label class="control-label">角色</label>
                                                        <div class="controls">
                                                            <select id="role" class="form-control role required"  name="role" style="height: 30px; padding: 0;">
                                                                @foreach($roleInfo as $l)
                                                                    <option class="option" value="{{$l->id}}" @if($l->id==$usersOneInfo->role)) selected @endif>{{$l->name}}</option>
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
                                                    <?php
                                                    $status_css0="btn btn-default";
                                                    $status_css1="btn btn-default";
                                                    if($usersOneInfo->status==0){
                                                        $status_css0="btn btn-primary active";
                                                    }elseif($usersOneInfo->status==1){
                                                        $status_css1="btn btn-primary active";
                                                    }
                                                    ?>
                                                    <input name="status" id="status" type="hidden" value="{{$usersOneInfo->status}}" >
                                                    <button type="button" data-status="1" class="{{$status_css1}}">开启</button>
                                                    <button type="button" data-status="0" class="{{$status_css0}}">禁用</button>
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            <div class="form-group">
                                                <div class="col-sm-4 col-sm-offset-2" id="submut_div">
                                                    <button class="btn btn-info save-note" type="submit">
                                                        保存
                                                    </button>
                                                    <button class="btn btn-white" type="button" onclick="history.go(-1);">取 消</button>
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
    <script src="{{ asset('/js/main.js') }}"></script>
    <script src="{{ asset('/js/common.js') }}"></script>
    {{--<script src="{{ asset('/js/selectator-master/jquery-1.11.0.min.js') }}"></script>--}}
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

            {{--$('#role').change(function(){--}}
                {{--if($(this).val().indexOf('2')>-1||$(this).val().indexOf('3')>-1||$(this).val().indexOf('20')>-1){--}}
                    {{--$('.wx_kf').show();--}}
                {{--}else{--}}
                    {{--$('.wx_kf').hide();--}}
                {{--}--}}
            {{--});--}}
            {{--$('.kf_account').change(function(){--}}
                {{--var isselect=0;--}}
                {{--var text=$('.kf_account option:selected').text();--}}
                {{--var val=$('.kf_account option:selected').val();--}}
                {{--$.ajax({--}}
                    {{--async:false,--}}
                    {{--type:'POST',--}}
                    {{--url:'/system/check_kf_account',--}}
                    {{--dataType:'json',--}}
                    {{--data:{nickname:text,kf_account:val,id:{{$usersOneInfo->id}},_token:post_token},--}}
                    {{--success: function(data)--}}
                    {{--{--}}
                        {{--if(data['code'] != 0)--}}
                        {{--{--}}
                            {{--isselect=1;--}}
                            {{--$('#iskf').val(1);--}}
                            {{--pop('提示',data['msg'],3);--}}
                            {{--return false;--}}
                        {{--}--}}

                    {{--},--}}
                    {{--error : function() {--}}
                        {{--pop('提示','网络异常',3)--}}
                    {{--}--}}
                {{--});--}}
                {{--if(isselect!=1) {--}}
                    {{--$('#iskf').val(0);--}}
                    {{--$('#nickname').val(text);--}}
                {{--}--}}
            {{--});--}}

            //验证
            var post_token = '<?php echo csrf_token(); ?>';
            $("#form").validate({
                onkeyup: false, //关闭输入时验证
                ignore: ".ignore",  //开启隐藏域验证
                rules: {
//                    email: {
//                        required: true,
//                        remote: genAjaxRemote("", "/system/addcheck", post_token)   //AJAX验重
//                    },
                    password: {
                        minlength: 6  //密码验证 不少于6位数字
                    },
                    repass: {
                        equalTo: "#password"  //再次输入密码验证
                    }
                },
                messages: {
//                    email: {
//                        required: "用户名唯一且不能为空",
//                        remote: "该邮箱已被使用"
//                    },
                    password: {
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