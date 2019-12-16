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
                        <h2>新闻评阅管理<small></small></h2>
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
                        <li class="active">新闻评阅列表</li>
                    </ol>
                </div>
            </div>
            <style>
                .table th,.table td{
                    text-align: center;
                }
                .table{
                    margin-bottom:0px
                }
            </style>
            <!-- end: BREADCRUMB -->
            <!-- start: PAGE CONTENT -->
            <div class="row">

                <div class="col-md-12">
                    <div class="panel panel-white">

                        <div class="panel-body">
                            <div id="myTabContent" class="tab-content">
                                <!--会员表格结构-->
                                <div class="tab-pane fade in active" id="home">
                                    <!--搜索-->
                                    <div id="toolbar">
                                        <form class="form-inline" method="get" action="/">
                                            <div class="form-group">
                                                <label for="wxnameID">评阅状态：</label>
                                                <select name="status" id="status">
                                                    {{--<option value="" >全部</option>--}}
                                                    @foreach(config('configure.status1') as $k=>$v)
                                                    <option value="{{$k}}" @if($status==$k) selected @endif>{{$v}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            {{--<button type='submit' class="btn btn-blue"> 搜索 </button>--}}
                                            {{--<button type="button" onclick="add()" class="btn btn-blue refresh pull-right"> 增加媒体 </button>--}}
                                            <button type="button" onclick="location='/review/draft/add?url={{base64_encode($url)}}';" class="btn btn-blue refresh pull-right"> 增加 </button>

                                            <button type="button" id="export" class="btn btn-info refresh pull-right" style="margin-right:20px"> 导出 </button>
                                        </form>
                                    </div>
                                    {{--<div class="ibox-tools clearfix">--}}
                                    <div style="padding:10px 0">
                                        总条数：{{$list->total()}}
                                    </div>
                                    {{--</div>--}}
                                    <div class="fixed-table-container" style="margin-top:10px">
                                        <table class="table table-striped ">
                                            <thead>
                                            <tr>
                                                <th>评阅标题</th>
                                                <th>被评阅媒体</th>
                                                <th>栏目版面</th>
                                                <th>评阅员</th>
                                                <th>撰写时间</th>
                                                <th>稿件字数</th>
                                                <th>刊发情况</th>
                                                <th>阅评状态</th>
                                                <th>确认意见</th>
                                                <th>操作</th>
                                            </tr>
                                            </thead>
                                            @if(count($list)>0)
                                                @foreach($list as $k=>$l)
                                                    <tr>
                                                        <td>{{$l->title}}</td>
                                                        <td>{{$medias[$l->media_id]??""}}</td>
                                                        <td>{{$l->cat_page}}</td>
                                                        <td>{{$users[$l->at_id]}}</td>
                                                        <td>{{$l->created_at}}</td>
                                                        <td>{{$l->text_size}}</td>
                                                        <td>{{$l->publication}}</td>
                                                        <td>{{config('configure.status1')[$l->status]}}</td>
                                                        <td>{{$l->confirmation}}</td>
                                                        <td>
                                                                @if(in_array($l['status'],[1,4]))
                                                                    @if($l['status']==1||Auth::user()->role==0)
                                                                        <button class="btn btn-primary btn-xs" onclick="location.href='/review/draft/edit/{{$l['id']}}?url={{base64_encode($url)}}'" type="button">编辑</button>

                                                                        @if($l['status']==1)
                                                                            <button class="btn btn-success btn-xs sub_but" data-id="{{$l['id']}}" type="button">提交</button>
                                                                        @endif
                                                                    <?php
                                                                        $del_class='del_but';
                                                                        if($l['status']==4){
                                                                            $del_class='del_but1';
                                                                        }
                                                                    ?>
                                                                    <button class="btn btn-danger btn-xs {{$del_class}}" data-id="{{$l['id']}}" type="button">删除</button>
                                                                    @endif
                                                                @endif
                                                                @if(in_array($l['status'],[1,2,3]))
                                                                    <button class="btn btn-info  btn-xs look_but" data-id="{{$l['id']}}" type="button">预览</button>
                                                                @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tbody>
                                                <tr>
                                                    <td colspan="10" align="center">暂无信息!</td>
                                                </tr>
                                                </tbody>
                                            @endif
                                        </table>
                                    </div>
                                    @if(count($list)>0)
                                        {!!
                                        $list->appends(['status' => $status])->render()
                                        !!}
                                    @endif
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
@endsection
@section('jscontent')
    <script type="text/javascript" src="{{ asset('/plugins/ztree/jquery.ztree.all.min.js') }}"></script>
    <script src="{{ asset('/js/admin/nav/member.js') }}"></script>
    <!-- start: CORE JAVASCRIPTS  -->
    <script src="{{ asset('/js/main.js') }}"></script>
    <!-- end: CORE JAVASCRIPTS  -->
    <script>
        var post_token='<?php echo csrf_token(); ?>';

        var is_pop = @if (session('is_pop')){{session('is_pop')}}@else 0 @endif ;
        jQuery(document).ready(function() {
            Main.init();
            FormElements.init();
            if (is_pop > 0) {
                pop_template(is_pop);
            }

        });
        $('#status').change(function () {
            var status=$('#status option:selected').val();
            window.location.href="/review/draft?status="+status+'&export=';
        });

        $('.look_but').click(function () {
            var id=$(this).data('id');
            window.open("/review/draft/look/"+id);
        });
        $("#export").click(function () {
            var status=$('#status option:selected').val();
            window.location.href="/review/draft?status="+status+'&export=1';

        })
        //提交 变更成待审
        $(".sub_but").click(function () {
            var id=$(this).data('id');
            chageStatus(id,2)
        });

        //删除
        $(".del_but").click(function () {
            var id=$(this).data('id');
            chageStatus(id,-1)
        });

        //删除 变更成待审
        $(".del_but1").click(function () {
            var id=$(this).data('id');
            chageStatus(id,1)
        });

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
                    url:'/review/draft/chageStatus',
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
                        setInterval(function () {
                            window.location.reload();
                        },1000);

                    },
                    error : function() {
                        pop('提示','网络异常',3)
                    }
                });
            });
        }
    </script>

@endsection