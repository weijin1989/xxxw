@extends('base')
@section('content')
        <!-- start: PAGE -->
<div class="main-content">
    <!-- start: PANEL CONFIGURATION MODAL FORM -->
    <div class="modal fade" id="panel-config" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button>
                    <h4 class="modal-title">Panel Configuration</h4>
                </div>
                <div class="modal-body">
                    Here will be a configuration form
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary">
                        Save changes
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- /.modal -->
    <!-- end: SPANEL CONFIGURATION MODAL FORM -->
    <div class="container">
        <!-- start: PAGE HEADER -->
        <!-- start: TOOLBAR -->
        <div class="toolbar row">
            <div class="col-sm-6 hidden-xs">
                <div class="page-header">
                    <h2>日志列表<small></small></h2>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12">
                <a href="#" class="back-subviews">
                    <i class="fa fa-chevron-left"></i> 返回
                </a>
                <a href="#" class="close-subviews">
                    <i class="fa fa-times"></i> 关闭
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
                    <li class="active">日志列表</li>
                </ol>
            </div>
        </div>
        <!-- end: BREADCRUMB -->
        <!-- start: PAGE CONTENT -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-body">

                        <legend>日志列表</legend>
                        <div id="myToolbar">
                            <div id="toolbar">
                                <form class="form-inline">
                                    <div class="form-group" style="margin:15px 0px 0px 15px;">
                                        <label for="usernameID">操作者：</label>
                                        <input type="text" class="form-control username" id="usernameID" placeholder="真实姓名" />
                                    </div>
                                    <div class="form-group" style="margin:15px 0px 0px 15px;">
                                        <label for="contentID">操作内容：</label>
                                        <input type="text" class="form-control content" id="contentID" placeholder="操作内容" />
                                    </div>
                                    <div class="form-group" style="margin:15px 0px 0px 15px;">
                                        <label for="created_atID">开始时间：</label>
                                        <input id="starttime" class="form-control starttime" type="text"  placeholder="请选择时间" name="starttime" />
                                    </div>
                                    <div class="form-group" style="margin:15px 0px 0px 15px;">
                                        <label for="created_atID">结束时间：</label>
                                        <input id="endtime" class="form-control endtime" type="text"  placeholder="请选择时间" name="endtime" />
                                    </div>
                                    <button type='button' class="btn btn-blue searchMember" style="margin:15px 0px 0px 15px;"> 搜索 </button>
                                </form>
                            </div>
                        </div>
                        <table id="myLogsTable">
                            <thead>
                            <tr>
                                <th data-field="id" data-align="center">编号</th>
                                <th data-field="username" data-align="center">操作人姓名</th>
                                <th data-field="content" data-align="left">操作内容</th>
                                <th data-field="created_at" data-align="center">操作时间</th>
                            </tr>


                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end: PAGE CONTENT-->
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
    <script src="{{ asset('/js/admin/nav/logs.js') }}"></script>
    <script src="{{ asset('/plugins/laydate/laydate.js')  }}"></script>

    <!-- start: CORE JAVASCRIPTS  -->
    <script src="{{ asset('/js/main.js') }}"></script>
    <script src="{{ asset('/js/common.js') }}"></script>
    <!-- Toastr style -->
    <link href="/css/toastr/toastr.min.css" rel="stylesheet">
    <!-- end: CORE JAVASCRIPTS  -->
    <script>
        jQuery(document).ready(function() {
            Main.init();
            FormElements.init();
            Logs.init();
        });


        var start = {
            elem: '#starttime',
            format: 'YYYY-MM-DD hh:mm:ss',
            max: laydate.now(), //设定最小日期为当前日期
//            max: '2099-06-16 23:59:59', //最大日期
            istime: true,
            istoday: false,
            choose: function(datas){
                end.min = datas; //开始日选好后，重置结束日的最小日期
                end.start = datas //将结束日的初始值设定为开始日
            }
        };
        var end = {
            elem: '#endtime',
            format: 'YYYY-MM-DD hh:mm:ss',
            max: laydate.now(),
            //max: '2099-06-16 23:59:59',
            istime: true,
            istoday: false,
            choose: function(datas){
                start.max = datas; //结束日选好后，重置开始日的最大日期
            }
        };
        laydate(start);
        laydate(end);

    </script>
@endsection