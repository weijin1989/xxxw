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
                        <h2>工作台帐管理<small></small></h2>
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
                        <li class="active">工作台帐列表</li>
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
                                        <form class="form-inline" id="from1" method="get" action="">
                                            <div class="form-group">
                                                &nbsp;<label for="wxnameID">时间：</label>
                                                <input id="starttime" autocomplete="off" class="form-control starttime" value="{{$starttime}}" type="text"  placeholder="请选择时间" name="starttime" /> -
                                                <input id="endtime" autocomplete="off" class="form-control endtime" value="{{$endtime}}" type="text"  placeholder="请选择时间" name="endtime" />
                                                <input type="hidden" id="export" value="0" name="export">
                                            </div>
                                            <div class="form-group">
                                                &nbsp;<label for="wxnameID">标题：</label>
                                                <input type="text" name="search" id="search" value="{{$search}}" placeholder="支持模糊搜索">
                                            </div>
                                            &nbsp;<button type='button' class="btn btn-blue search"> 搜索 </button>
                                            <button type="button" class="btn btn-blue refresh pull-right add_but"> 增加 </button>
                                            <button type="button" class="btn btn-info refresh pull-right export" style="margin-right:10px"> 导出 </button>
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
                                                <th>时间</th>
                                                <th>标题</th>
                                                <th>内容</th>
                                                <th>操作</th>
                                            </tr>
                                            </thead>
                                            @if(count($list)>0)
                                                @foreach($list as $k=>$l)
                                                    <tr>
                                                        <td width="11%">{{$l->created_at}}</td>
                                                        <td width="10%">{{$l->title}}</td>
                                                        <td style="text-align: left">{{$l->content}}</td>
                                                        <td width="7%">
                                                            <button class="btn btn-info  btn-xs edit_but"
                                                                    data-id="{{$l['id']}}"
                                                                    data-created_at="{{$l['created_at']}}"
                                                                    data-title="{{$l['title']}}"
                                                                    data-content="{{$l['content']}}"
                                                                    type="button">修改</button>
                                                            <button class="btn btn-danger btn-xs del_but" data-id="{{$l['id']}}" type="button">删除</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tbody>
                                                <tr>
                                                    <td colspan="4" align="center">暂无信息!</td>
                                                </tr>
                                                </tbody>
                                            @endif
                                        </table>
                                    </div>
                                    @if(count($list)>0)
                                        {!!
                                        $list->appends(['status' => $status,'starttime' => $starttime,'endtime' => $endtime])->render()
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

        <div class="modal fade" tabindex="1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">工作台帐</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped modal_table">
                            <tr>
                                <th>时间</th>
                                <td><input type="text" class="form-control"  value="{{date('Y-m-d H:i:s')}}" id='created_at' readonly="readonly"></td>
                            </tr>
                            <tr>
                                <th>标题</th>
                                <td><input type="text" class="form-control"  id="title" maxlength="80"></td>
                            </tr>
                            <tr>
                                <th>内容</th>
                                <td>
                                    <textarea id="content" class="form-control" maxlength="250" style="height:120px"></textarea>
                                    <input type="hidden" value="0" id="is_edit">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-primary sub_but">确认</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

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
    <script src="{{ asset('/plugins/laydate/laydate.js')  }}"></script>
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
        var addtime = {
            elem: '#created_at',
            format: 'YYYY-MM-DD hh:mm:ss',
//            max: laydate.now(), //设定最小日期为当前日期
//            max: '2099-06-16 23:59:59', //最大日期
            value: laydate.now(),
            istime: true,
            istoday: false
        };
        var start = {
            elem: '#starttime',
            format: 'YYYY-MM-DD',
//            max: laydate.now(), //设定最小日期为当前日期
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
            format: 'YYYY-MM-DD',
//            max: laydate.now(),
            //max: '2099-06-16 23:59:59',
            istime: true,
            istoday: false,
            choose: function(datas){
                start.max = datas; //结束日选好后，重置开始日的最大日期
            }
        };
        laydate(start);
        laydate(end);
        laydate(addtime);

        $('.add_but').click(function () {
            $('#content').val('');
            $('#title').val('');
            $('#is_edit').val(0);
            $('.modal').modal('show');
        });

        var id=0;
        //修改弹窗
        $(".edit_but").click(function () {
            id=$(this).data('id');
            $('#is_edit').val(1);
            $('#created_at').val($(this).data('created_at'));
            $('#content').val($(this).data('content'));
            $('#title').val($(this).data('title'));
            $('.modal').modal('show');
        });

        var is_sub=0;
        //提交 线索
        $(".sub_but").click(function () {
            var created_at=$('#created_at').val();
            var content=$('#content').val();
            var title=$('#title').val();
            var is_edit=$('#is_edit').val();
            if(is_sub==1){
                return false;
            }
            is_sub=1;
            if(title==''){
                alert('标题不能为空');
                return false;
            }
            if(content==''){
                alert('内容不能为空');
                return false;
            }
            var url='/work/addSave';
            if(is_edit==1) {
                url = '/work/editSave/' + id;
            }
            $.ajax({
                async:false,
                type:'POST',
                url:url,
                dataType:'json',
                data:{title:title,content:content,created_at:created_at,_token:post_token},
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

        $(".search").click(function () {
            $('#export').val(0);
            $('#from1').submit();
        });

        $(".export").click(function () {
            $('#export').val(1);
            $('#from1').submit();
        });

        //删除
        $(".del_but").click(function () {
            var id=$(this).data('id');
            chageStatus(id,-1)
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
                    url:'/work/chageStatus',
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