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
                        <h2>区域管理<small></small></h2>
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
                        <li><a href="{{ url('/system/area') }}">区域管理</a></li>
                        <li class="active">修改区域</li>
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
                                            <strong>修改</strong>
                                        </h5>
                                    </div>
                                    <div class="ibox-content">
                                        <form id="form" method="post" class="form-horizontal" action="/system/area/edit_save/{{$info->id}}">
                                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">
                                                    父级区域
                                                </label>
                                                <div class="col-sm-10">
                                                    <select class="form-control required" name="pid">
                                                        <option value="0">选择父级</option>
                                                        @foreach($p_list as $k=>$v)
                                                            <option value="{{$k}}" @if($info->pid==$k) selected @endif>{{$v}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">
                                                    <span style="color:#c00">*</span>
                                                    区域名称
                                                </label>
                                                <div class="col-sm-10">
                                                    <input name="area" type="text" class="form-control required" value="{{$info->area}}" placeholder="区域名称" />
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">状态</label>
                                                <div class="status btn-group m-l p_l_15">
                                                    <?php
                                                    $status_css0="btn btn-default";
                                                    $status_css1="btn btn-default";
                                                    if($info->status==0){
                                                        $status_css0="btn btn-primary active";
                                                    }elseif($info->status==1){
                                                        $status_css1="btn btn-primary active";
                                                    }
                                                    ?>
                                                    <input name="status" id="status" type="hidden" value="{{$info->status}}" >
                                                    <button type="button" data-status="1" class="{{$status_css1}}">开启</button>
                                                    <button type="button" data-status="0" class="{{$status_css0}}">禁用</button>
                                                </div>
                                             </div>
                                            <div class="hr-line-dashed"></div>

                                            <div class="form-group">
                                                <div class="col-sm-4 col-sm-offset-2" id="submut_div">
                                                    <input type="hidden" name="id" value="{{$info->id}}">
                                                    <button class="btn btn-primary" type="submit" >保 存</button>
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
    <div id="qrcodeSubview" style="display:none;">

    </div>
    @endsection
    @section('jscontent')
            <!-- start: CORE JAVASCRIPTS  -->
    <script src="{{ asset('/js/main.js') }}"></script>
    <script src="{{ asset('/js/common.js') }}"></script>

    <!-- end: CORE JAVASCRIPTS  -->
    <script>
        jQuery(document).ready(function() {
            Main.init();
            status();
            //验证
            var post_token = '<?php echo csrf_token(); ?>';
            $("#form").validate({
                onkeyup: false, //关闭输入时验证
                ignore: ".ignore",  //开启隐藏域验证
                rules: {
                    catname: {
                        required: true,
                        remote: genAjaxRemote("{{$info->id}}", "/system/menus/ajax_menus", post_token)   //AJAX验重
                    },
                    sort:{
                        number:true
                    }
                },
                messages: {
                    catname: {
                        required: " * 栏目路径不能为空",
                        remote: "栏目名称已存在"
                    },
                    sort:{
                        number:" * 排序只能是数字"
                    }
                }
            });
        });
    </script>
@endsection