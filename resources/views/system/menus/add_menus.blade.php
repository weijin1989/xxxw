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
                        <h2>栏目管理<small></small></h2>
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
                        <li><a href="{{ url('/system/menusList') }}">栏目管理</a></li>
                        <li class="active">添加栏目</li>
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
                                            <strong>添加</strong>
                                        </h5>
                                    </div>
                                    <div class="ibox-content">
                                        <form id="form" method="post" class="form-horizontal" action="/system/menus/add_menus_save">
                                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">
                                                    父级栏目
                                                </label>
                                                <div class="col-sm-10">
                                                    <select class="form-control required" name="pid">
                                                        <option value="0">选择父级栏目</option>
                                                        @foreach($p_menus as $p)
                                                        <option value="{{$p['id']}}">{{$p['catname']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">
                                                    <span style="color:#c00">*</span>
                                                    栏目名称
                                                </label>
                                                <div class="col-sm-10">
                                                    <input name="catname" type="text" class="form-control required" value="" placeholder="栏目名称" />
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">
                                                    栏目图标
                                                </label>
                                                <div class="col-sm-10">
                                                    <input name="icon" type="text" class="form-control" value="" placeholder="栏目图标，如：fa fa-folder-open" />
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">
                                                    URL路径
                                                </label>
                                                <div class="col-sm-10">
                                                    <input name="url" type="text" class="form-control" value=""  placeholder="URL路径，如/system/menusList" />
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">
                                                    排序
                                                </label>
                                                <div class="col-sm-10">
                                                    <input name="sort" type="text" class="form-control" value=""  placeholder="排序只能为数字" />
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">是否显示</label>
                                                <div class="status btn-group m-l p_l_15">
                                                    <input name="status" id="status" type="hidden" value="1" >
                                                    <button  type="button" data-status="1" class="btn btn-primary active">显示</button>
                                                    <button  type="button" data-status="0" class="btn btn-default">隐藏</button>
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">
                                                    栏目描述
                                                </label>
                                                <div class="col-sm-10">
                                                    <textarea name="describe" id="describe" class="form-control" placeholder="栏目描述"></textarea>
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            <div class="form-group">
                                                <div class="col-sm-4 col-sm-offset-2" id="submut_div">
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
                        remote: genAjaxRemote("", "/system/menus/ajax_menus", post_token)   //AJAX验重
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