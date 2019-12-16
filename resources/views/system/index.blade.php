@extends('base')
@section('content')
        <!-- start: PAGE -->
<div class="main-content" xmlns:padding-left="http://www.w3.org/1999/xhtml">
    <div class="container">
        <!-- start: PAGE HEADER -->
        <!-- start: TOOLBAR -->
        <div class="toolbar row">
            <div class="col-sm-6 hidden-xs">
                <div class="page-header">
                    <h2>账户管理【{{$com_info->company_name}}】<small></small></h2>
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
                    <li><a href="/system/company">单位管理</a></li>
                    <li class="active">账户管理</li>
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
                                <button type="button" onclick="location='/system/add?com_id={{$com_info->id}}';" class="btn btn-blue refresh pull-right"> 增加 </button>
                            </div>
                            <div class="fixed-table-container" style="margin-top:10px">
                                <table class="table table-striped ">
                                    <thead>
                                    <tr>
                                        <th><div class="th-inner ">所属单位</div></th>
                                        <th><div class="th-inner ">登陆名称</div></th>
                                        <th><div class="th-inner ">用户名</div></th>
                                        <th><div class="th-inner ">角色</div></th>
                                        <th><div class="th-inner ">创建日期</div></th>
                                        <th><div class="th-inner ">状态</div></th>
                                        <th><div class="th-inner ">操作</div></th>
                                    </tr>
                                    </thead>
                                    @if(count($usersInfo)>0)
                                        <tbody>
                                            @foreach($usersInfo as $l)
                                                <tr>
                                                    <td>{{$l->company_name}}</td>
                                                    <td>{{$l->email}}</td>
                                                    <td>{{$l->name}}</td>
                                                    <td>
                                                        {{$l->rolesname}}
                                                    </td>
                                                    {{--<td> {{$l->rolesname}} </td>--}}
                                                    <td>{{$l->created_at}}</td>
                                                    <td id="status_{{$l->id}}">
                                                        @if($l->status==1)
                                                            <span class="badge badge-success">启用</span>
                                                        @else
                                                            <span class="badge badge-danger">禁用</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-primary btn-xs" onclick="location.href='/system/edit/{{$l->id}}?com_id={{$com_info->id}}'" type="button">编辑</button>
                                                        {{--<button class="btn btn-danger btn-xs" onclick="deleteRole('{{$l->id}}','{{$l->name}}')" type="button">删除</button>--}}
                                                        <span id="but_{{$l->id}}">
                                                             <button class="btn @if($l->status==1) btn-warning @else btn-primary @endif btn-xs" onclick="chageStatus('{{$l->id}}','{{$l->status}}')" type="button">
                                                                 @if($l->status==0)
                                                                     启用
                                                                 @else
                                                                     禁用
                                                                 @endif
                                                             </button>
                                                        </span>
                                                        <button class="btn btn-primary btn-xs" onclick="reset('{{$l->id}}')" type="button">密码重置</button>
                                                        <button class="btn btn-danger btn-xs" onclick="chageStatus('{{$l->id}}',9)"  type="button">删除</button>
                                                        {{--<button class="btn btn-primary btn-xs" onclick="location.href='/system/userRegion/{{$l->id}}'" type="button">区域设置</button>--}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    @else
                                        <tbody>
                                        <tr>
                                            <td colspan="7" align="center">暂无信息!</td>
                                        </tr>
                                        </tbody>
                                    @endif
                                </table>
                            </div>
                            @if(count($usersInfo)>0)
                                {!!
                                $usersInfo->appends(['com_id' => $com_info->id])->render()
                                !!}
                            @endif
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
</div>
    <!-- end: MAIN CONTAINER -->
    @endsection
    @section('subview')
    @endsection
    @section('jscontent')
        <script src="{{ asset('/js/admin/nav/system.js') }}"></script>
        <!-- start: CORE JAVASCRIPTS  -->
        <script src="{{ asset('/js/main.js') }}"></script>
        <script src="{{ asset('/js/common.js') }}"></script>
        <link href="/css/toastr/toastr.min.css" rel="stylesheet">
        <!-- end: CORE JAVASCRIPTS  -->

        <script>
            var is_pop = @if (session('is_pop')){{session('is_pop')}}@else 0 @endif ;
            var post_token="<?php echo csrf_token(); ?>";
            jQuery(document).ready(function() {
                Main.init();
                FormElements.init();
                system.init();
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
                        url:'/system/chageUsesStatus',
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
                            if(type==9){
                                window.location.reload();
                                return;
                            }
                            var status_text='<span class="badge badge-success">启用</span>';
//                        var but_text='<a href="javascript:;" onclick="chageStatus('+id+',1)">禁用</a>';
                            var but_text='<button class="btn btn-warning btn-xs" onclick="chageStatus('+id+',1)" type="button">禁用</button>';

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
            // 删除用户
            function deleteRole(id){
                swal({
                    title: "确认删除该用户吗",
                    text: '',
                    showCancelButton: true,
                    closeOnConfirm: true,
                    animation: "slide-from-top"
                },function(){
                    $.ajax({
                        async:false,
                        type:'POST',
                        url:'/system/deleteUser',
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
                });
            }
//            密码重置
            function reset(id){
                swal({
                    title: "确认重置吗",
                    text: '',
                    showCancelButton: true,
                    closeOnConfirm: true,
                    animation: "slide-from-top"
                },function(){
                    $.ajax({
                        async:false,
                        type:'POST',
                        url:'/system/reset',
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
                            pop('提示','重置成功，新密码：123456',1);
                        },
                        error : function() {
                            pop('提示','网络异常',3)
                        }
                    });
                });
            }
        </script>
@endsection