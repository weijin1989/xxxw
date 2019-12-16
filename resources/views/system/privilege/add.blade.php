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
                    <h2>权限节点管理<small></small></h2>
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
                    <li><a href="{{ url('/system/menusList') }}">栏目管理</a></li>
                    <li><a href="{{ url('/system/privilege?menu_id=').$menu_info->id  }}">权限节点管理列表</a></li>
                    <li class="active">新增权限节点</li>
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
                                <form id="form" method="post" class="form-horizontal" action="/system/privilege/add_save">
                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            <span style="color:#c00">*</span>
                                            所属栏目
                                        </label>
                                        <div class="col-sm-10">
                                            <input type="hidden" name="menu_id" value="{{$menu_info->id}}">
                                            <input type="text"  disabled class="form-control" value="{{$menu_info->catname}}">
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            <span style="color:#c00">*</span>
                                            权限名称
                                        </label>
                                        <div class="col-sm-10">
                                            <input name="privilege_name" type="text" class="form-control required privilege_name" value="">
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            <span style="color:#c00">*</span>
                                            权限路径
                                        </label>
                                        <div class="col-sm-10">
                                            <input name="path" type="text" placeholder="如：/system 带数字已*号代替如： /system/*" class="form-control required path" value="">
                                        </div>
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
                                            <button class="btn btn-primary" type="submit" id="submut_divaa">保 存</button>
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
        function chage_sub_menu(pid){
            $.blockUI({
                message:'<i class="fa fa-spinner fa-spin"></i> '
            });
            $.ajax({
                type:'POST',
                url:'/system/privilege/findMenuListByPid',
                data:{pid:pid,_token:post_token},
                dataType:'json',
                success: function(json) {
                    if(json['code'] == 0){
                        var menus_list=json['data'];
                        $('.menu_id').empty();
                        var html = '';
                        $('.menu_id').append('<option value="">请选择</option>');
                        menus_list.forEach(function(m){
                            html += '<option value="' + m["id"] + '"';
                            html += '>'+m['catname'];
                        })
                        html += '</option>';
                        $('.menu_id').append(html);
                        $.unblockUI();
                    }


                }
            });
        }
        $('.menu_pid').change(function(){
            var pid =$(this).val();
            chage_sub_menu(pid);
        });
        jQuery(document).ready(function() {
            Main.init();
            status();
            //验证
            $("#form").validate({
                onkeyup: false, //关闭输入时验证
                ignore: ".ignore",  //开启隐藏域验证
                rules: {
                    path: {
                        required: true,
                        remote:genAjaxRemote("", "/system/privilege/chagePath", post_token)   //AJAX验重
                    },
                    privilege_name: {
                        required: true
                    }
                },
                messages: {
                    path: {
                        required: "权限路径不能为空",
                        remote:"该权限路径已经存在"
                    },
                    privilege_name: {
                        required: "权限名称"
                    }
                }
            });
        });
    </script>
@endsection