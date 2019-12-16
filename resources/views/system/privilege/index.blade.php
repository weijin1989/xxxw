@extends('base')
@section('content')
        <!-- start: PAGE -->
<div class="main-content">
    <div class="container">
        <!-- start: PAGE HEADER -->
        <!-- start: TOOLBAR -->
        <div class="toolbar row">
            <div class="col-sm-6 hidden-xs">
                <div class="page-header">
                    <h2>查看【{{$menu_info->catname}}】URL权限<small></small></h2>
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
                    <li class="active">查看【{{$menu_info->catname}}】URL权限</li>
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

                                <button class="btn btn-blue refresh pull-right"  type="button" onclick="history.go(-1);" style="margin-left:10px">返 回</button>
                                <button type="button" onclick="location='/system/privilege/add?menu_id={{$menu_info->id}}';" class="btn btn-blue refresh pull-right" > 增加 </button>
                            </div>
                            <div class="fixed-table-container" style="margin-top:10px">
                                <table class="table table-striped ">
                                <thead>
                                <tr>
                                    <th><div class="th-inner">序号</div></th>
                                    <th><div class="th-inner">所属栏目</div></th>
                                    <th><div class="th-inner">权限名称</div></th>
                                    <th><div class="th-inner">权限路径</div></th>
                                    <th><div class="th-inner">状态</div></th>
                                    <th><div class="th-inner">操作</div></th>
                                </tr>
                                </thead>
                                @if(count($list)>0)
                                <tbody>
                                    @foreach($list as $k=>$l)
                                    <tr>
                                        <td>{{$k+1}}</td>
                                        <td>{{$l->menus->catname}}</td>
                                        <td>{{$l->privilege_name}}</td>
                                        <td>{{$l->path}}</td>
                                        <td id="status_{{$l->id}}">
                                            @if($l->status==1)
                                                <span class="badge badge-success">启用</span>
                                            @else
                                                <span class="badge badge-danger">禁用</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-xs" onclick="location.href='/system/privilege/edit/{{$l->id}}'" type="button">编辑</button>
                                            <span id="but_{{$l->id}}">
                                                 <button class="btn @if($l->status==1) btn-danger @else btn-primary @endif btn-xs" onclick="chageStatus('{{$l->id}}','{{$l->status}}')" type="button">@if($l->status==1)禁用@else启用@endif</button>
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                    @else
                                    <tbody>
                                    <tr>
                                        <td colspan="6" align="center">暂无信息!</td>
                                    </tr>
                                    </tbody>
                                 @endif
                            </table>
                            </div>
                            @if(count($list)>0)
                                {!!
                                $list->appends(['menu_id'=>$menu_id])->render()
                                !!}
                            @endif
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
@section('jscontent')
        <!-- start: CORE JAVASCRIPTS  -->
    <script src="{{ asset('/js/main.js') }}"></script>
    <script src="{{ asset('/js/common.js') }}"></script>
    <!-- Toastr style -->
    <link href="/css/toastr/toastr.min.css" rel="stylesheet">
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
                    url:'/system/privilege/chageStatus',
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
    </script>
@endsection