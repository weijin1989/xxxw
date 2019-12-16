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
                        <h2>单位管理<small></small></h2>
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
                        <li><a href="{{ url('/system/company') }}">单位管理</a></li>
                        <li class="active">添加单位</li>
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
                                        <form id="form" method="post" class="form-horizontal" action="/system/company/add_save">
                                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">
                                                    父级单位
                                                </label>
                                                <div class="col-sm-10">
                                                    <select class="form-control required" name="pid" id="pid" >
                                                        <option value="0"  data-no="0">选择父级单位（不选则当前就是父类）</option>
                                                        @foreach($p_list as $p)
                                                            <option value="{{$p['id']}}" data-no="{{$p['company_no']}}" >{{$p['company_name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">
                                                    <span style="color:#c00">*</span>
                                                    单位编号
                                                </label>
                                                <div class="col-sm-10">
                                                    <input name="company_no" id="company_no" type="text" class="form-control required" value=""  placeholder="单位编号如：433100" />
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">
                                                    <span style="color:#c00">*</span>
                                                    单位名称
                                                </label>
                                                <div class="col-sm-10">
                                                    <input name="company_name" type="text" class="form-control required" value="" placeholder="单位名称" />
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">
                                                    排序
                                                </label>
                                                <div class="col-sm-10">
                                                    <input name="sort" type="text" class="form-control" value="1"  placeholder="排序只能为数字" />
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">单位状态</label>
                                                <div class="status btn-group m-l p_l_15">
                                                    <input name="status" id="status" type="hidden" value="1" >
                                                    <button  type="button" data-status="1" class="btn btn-primary active">有效</button>
                                                    <button  type="button" data-status="0" class="btn btn-default">无效</button>
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">
                                                    单位类型
                                                </label>
                                                <div class="col-sm-10">
                                                    <select class="form-control required" name="company_type">
                                                        @foreach(config('configure.company_type') as $k=>$v)
                                                            <option value="{{$k}}">{{$v}}</option>
                                                        @endforeach
                                                    </select>
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
            $('#pid').change(function () {
                var no=$('#pid option:selected').data('no');
                $("#company_no").val(no+'-')
            });
            //验证
            var post_token = '<?php echo csrf_token(); ?>';
            $("#form").validate({
                onkeyup: false, //关闭输入时验证
                ignore: ".ignore",  //开启隐藏域验证
                rules: {
                    company_no: {
                        required: true,
                        remote: genAjaxRemote("", "/system/company/ajax_check_no", post_token)   //AJAX验重
                    },
                    company_name:{
                        required:true,
                        remote: genAjaxRemote("", "/system/company/ajax_check_name", post_token)   //AJAX验重
                    }
                },
                messages: {
                    company_no: {
                        required: " * 单位编号不能为空",
                        remote: "* 单位编号已存在"
                    },
                    company_name:{
                        required:" * 单位名称不能为空",
                        remote: "* 单位名称已存在"
                    }
                }
            });
        });
    </script>
@endsection