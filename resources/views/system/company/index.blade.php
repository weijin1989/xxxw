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
                        <h2>单位管理<small></small></h2>
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
                        <li class="active">单位管理</li>
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
                                    <button type="button" onclick="location='/system/company/add';" class="btn btn-blue refresh pull-right" > 增加 </button>
                                </div>
                                <div class="fixed-table-container" style="margin-top:10px">
                                    <table class="table table-striped ">
                                        <thead>
                                        <tr>
                                            <th><div class="th-inner center">单位编号</div></th>
                                            <th><div class="th-inner center">单位名称</div></th>
                                            <th><div class="th-inner center">单位类型</div></th>
                                            <th><div class="th-inner center">状态</div></th>
                                            <th><div class="th-inner center">操作</div></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($p_list as $l)
                                            <tr>
                                                <td>{{$l['company_no']}}</td>
                                                <td class="center">{{$l['company_name']}}</td>
                                                <td class="center">{{config('configure.company_type')[$l['company_type']]}}</td>
                                                <td id="status_{{$l['id']}}" class="center">
                                                    @if($l['status']==1)
                                                        <span class="badge badge-success">启用</span>
                                                    @else
                                                        <span class="badge badge-danger">禁用</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button class="btn btn-primary btn-xs" onclick="location.href='/system/company/edit/{{$l['id']}}'" type="button">修改</button>
                                                    <button class="btn btn-info btn-xs" onclick="location.href='/system?com_id={{$l['id']}}'" type="button">查看账户</button>
                                                </td>
                                            </tr>
                                            @if(count($l['sub'])>0)
                                                @foreach($l['sub'] as $v)
                                                    <tr>
                                                        <td class="">———{{$v['company_no']}}</td>
                                                        <td class="center">{{$v['company_name']}}</td>
                                                        <td class="center">
                                                            {{config('configure.company_type')[$v['company_type']]}}
                                                        </td>
                                                        <td id="status_{{$v['id']}}" class="center">
                                                            @if($v['status']==1)
                                                                <span class="badge badge-success">启用</span>
                                                            @else
                                                                <span class="badge badge-danger">禁用</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-primary btn-xs" onclick="location.href='/system/company/edit/{{$v['id']}}'" type="button">修改</button>
                                                            <button class="btn btn-info btn-xs" onclick="location.href='/system?com_id={{$v['id']}}'" type="button">查看账户</button>
                                                            <button class="btn btn-danger btn-xs dels_but" data-id="{{$v['id']}}" type="button">删除</button>
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

        //删除
        $(".dels_but").click(function () {
            var id=$(this).data('id');

            swal({
                title: "确认操作吗-(该单位下面的账户都会一并删除)",
                text: '',
                showCancelButton: true,
                closeOnConfirm: true,
                animation: "slide-from-top"
            },function(){
                $.ajax({
                    async:false,
                    type:'POST',
                    url:'/system/company/del',
                    dataType:'json',
                    data:{id:id,_token:post_token},
                    success: function(data)
                    {
                        if(data['code'] != 0)
                        {
                            pop('提示',data['msg'],3);
                            return false;
                        }
                        pop('提示','操作成功',1);
                        window.location.reload();


                    },
                    error : function() {
                        pop('提示','网络异常',3)
                    }
                });
            });
        });
        jQuery(document).ready(function() {
            Main.init();
        });
    </script>
@endsection