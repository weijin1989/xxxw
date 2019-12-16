@extends('base')
@section('content')
        <!-- start: PAGE -->
<div class="main-content">
    <!-- start: PANEL CONFIGURATION MODAL FORM -->
    <div class="modal fade" id="panel-config" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
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
                    <h2>角色管理<small></small></h2>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12">
                <a href="#" class="back-subviews">
                    <i class="fa fa-chevron-left"></i> 返回
                </a>
                <a href="#" class="close-subviews">
                    <i class="fa fa-times"></i> 关闭
                </a>
            </div>
        </div>
        <!-- end: TOOLBAR -->
        <!-- end: PAGE HEADER -->
        <!-- start: BREADCRUMB -->
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="{{ url('/') }}">首页</a></li>
                    <li class="active">角色管理</li>
                </ol>
            </div>
        </div>
        <!-- end: BREADCRUMB -->
        <!-- start: PAGE CONTENT -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-body">
                        <div class="bootstrap-table">
                        <div class="ibox-tools clearfix">
                            <button type="button" onclick="location='/roles/add';" class="btn btn-blue refresh pull-right"> 增加 </button>
                        </div>
                        <div class="fixed-table-container" style="margin-top:10px">
                            {{--<div class="fixed-table-loading" style="top: 41px; display: none;">正在努力地加载数据中，请稍候……</div>--}}
                            <div class="fixed-table-body">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    {{--<th><div class="th-inner "></div></th>--}}
                                    <th><div class="th-inner ">角色名称</div></th>
                                    <th><div class="th-inner ">创建日期</div></th>
                                    <th><div class="th-inner ">修改日期</div></th>
                                    <th><div class="th-inner ">角色状态</div></th>
                                    <th><div class="th-inner ">操作</div></th>
                                </tr>
                                </thead>
                                @if(count($list)>0)
                                    <tbody>
                                    @foreach($list as $l)
                                        <tr>
                                            <td>{{$l->name}}</td>
                                            <td>{{$l->created_at}}</td>
                                            <td>{{$l->updated_at}}</td>
                                            <td id="status_{{$l->id}}">
                                                @if($l->status==1)
                                                    <span class="badge badge-success">启用</span>
                                                @else
                                                    <span class="badge badge-danger">禁用</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{--<button class="btn btn-primary btn-xs" onclick="deleteRole({{$l->id}})" type="button">删除</button>--}}
                                                <span id="but_{{$l->id}}">
                                                     <button class="btn @if($l->status==1) btn-danger @else btn-primary @endif btn-xs" onclick="chageStatus('{{$l->id}}','{{$l->status}}')" type="button">
                                                         @if($l->status==0)
                                                             启用
                                                         @else
                                                             禁用
                                                         @endif
                                                     </button>
                                                </span>
                                                <button class="btn btn-primary btn-xs" onclick="location.href='/roles/roleAuthority/{{$l->id}}'" type="button">权限设置</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                @endif
                            </table>
                            </div>
                        </div>
                    </div>
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
<!-- end: SUBVIEW SAMPLE CONTENTS -->
@endsection
@section('jscontent')
            <!-- start: CORE JAVASCRIPTS  -->
    <script src="{{ asset('/js/admin/nav/system.js') }}"></script>
    <!-- start: CORE JAVASCRIPTS  -->
    <script src="{{ asset('/js/main.js') }}"></script>
    <script src="{{ asset('/js/common.js') }}"></script>
    <link href="/css/toastr/toastr.min.css" rel="stylesheet">
    <!--弹框  -->
    {{--<script src="/plugins/toastr/toastr.min.js"></script>--}}
    <!-- end: CORE JAVASCRIPTS  -->
    <script>

        // 提示
        var is_pop = @if (session('is_pop')){{session('is_pop')}}@else 0 @endif ;
        var post_token="<?php echo csrf_token(); ?>";
        $(document).ready(function () {
            if (is_pop > 0) {
                pop_template(is_pop);
            }
        });
        //启用禁用
        function chageStatus(id,type){
            swal({
                title: "确认操作吗",
                text: '',
                showCancelButton: true,
                closeOnConfirm: true,
                animation: "slide-from-top"
            },function(){
                $.ajax({
                    async:false,
                    type:'POST',
                    url:'/roles/chageRolesStatus',
                    dataType:'json',
                    data:{id:id,status:type,_token:post_token},
                    success: function(data)
                    {
                        if(data['code'] != 0)
                        {
                            pop('提示',data['msg'],3);
                            return false;
                        }
                        pop('提示','操作成功',1);
                        var status_text='<span class="badge badge-success">启用</span>';
    //                        var but_text='<a href="javascript:;" onclick="chageStatus('+id+',1)">禁用</a>';
                        var but_text='<button class="btn btn-danger btn-xs" onclick="chageStatus('+id+',1)" type="button">禁用</button>';

                        if(type==1){//1禁用；0启用
                            status_text='<span class="badge badge-danger">禁用</span>';
                            but_text='<button class="btn btn-primary btn-xs" onclick="chageStatus('+id+',0)" type="button">启用</button>';
                        }
                        $('#status_'+id).html(status_text);
                        $('#but_'+id).html(but_text);
                    },
                    error : function() {
                        pop('提示','网络异常',3)
                    }
                });
            });
        }
        jQuery(document).ready(function() {
            Main.init();
        });

        // 删除保险
        function deleteRole(id){
            swal({
                title: "确认删除该角色吗？",
                text: '',
                showCancelButton: true,
                closeOnConfirm: true,
                animation: "slide-from-top"
            },function(){
                $.ajax({
                    async:false,
                    type:'POST',
                    url:'/roles/deleteRole',
                    dataType:'json',
                    data:{id:id,_token:post_token},
                    success: function(data)
                    {
                        if(data['code'] != 0)
                        {
                            pop('提示',data['msg'],3);
                            return false;
                        }
                        window.location.reload();
                        pop('提示','删除成功',1);
                    },
                    error : function() {
                        pop('提示','删除失败',3)
                    }
                });
                return false;
            });
        }
    </script>
@endsection