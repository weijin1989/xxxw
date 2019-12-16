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
                    <h2>区域管理<small></small></h2>
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
                    <li class="active">区域管理</li>
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
                                <button type="button" onclick="location='/system/area/add';" class="btn btn-blue refresh pull-right" > 增加 </button>
                            </div>
                            <div class="fixed-table-container" style="margin-top:10px">
                                <table class="table table-striped ">
                                    <thead>
                                    <tr>
                                        <th><div class="th-inner center">区域名称</div></th>
                                        <th><div class="th-inner center">状态</div></th>
                                        <th><div class="th-inner center">操作</div></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($p_arr as $l)
                                        <tr>
                                            <td class="">{{$l['area']}}</td>
                                            <td id="status_{{$l['id']}}" class="center">
                                                @if($l['status']==1)
                                                    <span class="badge badge-success">启用</span>
                                                @else
                                                    <span class="badge badge-danger">禁用</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-primary btn-xs" onclick="location.href='/system/area/edit/{{$l['id']}}'" type="button">编辑</button>
                                            </td>
                                        </tr>
                                        @if(count($l['two'])>0)
                                            @foreach($l['two'] as $v)
                                            <tr>
                                                <td class="">———{{$v['area']}}</td>
                                                <td id="status_{{$v['id']}}" class="center">
                                                    @if($v['status']==1)
                                                        <span class="badge badge-success">启用</span>
                                                    @else
                                                        <span class="badge badge-danger">禁用</span>
                                                    @endif
                                                </td>
                                                <td width="">
                                                    <button class="btn btn-primary btn-xs" onclick="location.href='/system/area/edit/{{$v['id']}}'" type="button">编辑</button>
                                                    <span id="but_{{$v['id']}}">
                                                    <button class="btn @if($v['status']==1) btn-danger @else btn-success @endif btn-xs" onclick="chageStatus('{{$v['id']}}','{{$v['status']}}')" type="button">@if($v['status']==1)禁用@else启用@endif</button>
                                                    </span>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>

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
@section('jscontent')
        <!-- start: CORE JAVASCRIPTS  -->
<script src="{{ asset('/js/main.js') }}"></script>
<script src="{{ asset('/js/common.js') }}"></script>
<!-- Toastr style -->
<link href="/css/toastr/toastr.min.css" rel="stylesheet">

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
                url:'/system/area/chageStatus',
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
    // 删除用户
    function deleteMenus(id){
        swal({
            title: "确认删除该栏目吗",
            text: '',
            showCancelButton: true,
            closeOnConfirm: true,
            animation: "slide-from-top"
        },function(){
            $.ajax({
                async:false,
                type:'POST',
                url:'/system/area/del',
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

    jQuery(document).ready(function() {
        Main.init();
    });
</script>
@endsection