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
                        <h2>记者上稿管理<small></small></h2>
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
                        <li class="active">线索管理列表</li>
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
                                                <label for="wxnameID">状态：</label>
                                                <select name="status" id="status">
                                                    {{--<option value="" >全部</option>--}}
                                                    @foreach(config('configure.status2') as $k=>$v)
                                                    {{--@if($k!=1)--}}
                                                    <option value="{{$k}}" @if($status==$k) selected @endif>{{$v}}</option>
                                                    {{--@endif--}}
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                &nbsp;<label for="wxnameID">线索时间：</label>
                                                <input id="starttime" class="form-control starttime" value="{{$starttime}}" type="text"  placeholder="请选择时间" name="starttime" /> -
                                                <input id="endtime" class="form-control endtime" value="{{$endtime}}" type="text"  placeholder="请选择时间" name="endtime" />
                                                <input type="hidden" id="export" value="0" name="export">
                                            </div>
                                            &nbsp;<button type='button' class="btn btn-blue search"> 搜索 </button>
                                            <button type="button" class="btn btn-info refresh pull-right export"> 导出 </button>
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
                                                <th>线索日期</th>
                                                <th>区域</th>
                                                <th>提供者</th>
                                                <th>提供者单位</th>
                                                <th>内容</th>
                                                <th>线索状态</th>
                                                <th>处置情况</th>
                                                <th>操作</th>
                                            </tr>
                                            </thead>
                                            @if(count($list)>0)
                                                @foreach($list as $k=>$l)
                                                    <tr>
                                                        <td>{{$l->addtime}}</td>
                                                        <td>{{$l->region}}</td>
                                                        <td>{{$l->provider}}</td>
                                                        <td>{{$l->provider_company}}</td>
                                                        <td>{{str_limit($l->content,30,'...')}}</td>
                                                        <td>{{config('configure.status2')[$l->status]}}</td>
                                                        <td>{{str_limit($l->confirmation,40,'...')}}</td>
                                                        <td>
                                                            <button class="btn btn-info  btn-xs edit_but" data-status="{{$l['status']}}"
                                                                    data-id="{{$l['id']}}"
                                                                    data-addtime="{{$l['addtime']}}"
                                                                    data-region="{{$l['region']}}"
                                                                    data-provider="{{$l['provider']}}"
                                                                    data-provider_company="{{$l['provider_company']}}"
                                                                    data-content="{{$l['content']}}"
                                                                    data-confirmation="{{$l['confirmation']}}"
                                                                    type="button">处置</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tbody>
                                                <tr>
                                                    <td colspan="8" align="center">暂无信息!</td>
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
                        <h4 class="modal-title">新闻线索</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped modal_table">
                            <tr>
                                <th>线索日期</th>
                                <td><input type="text" class="form-control"  value="{{date('Y-m-d')}}" id='addtime' readonly="readonly"></td>
                            </tr>
                            <tr>
                                <th>区域</th>
                                <td><input type="text" class="form-control"  id="region" maxlength="80"></td>
                            </tr>
                            <tr>
                                <th>提供者</th>
                                <td><input type="text" class="form-control"  id="provider" maxlength="80"></td>
                            </tr>
                            <tr>
                                <th>提供者单位</th>
                                <td><input type="text" class="form-control"  id="provider_company" maxlength="80"></td>
                            </tr>
                            <tr>
                                <th>内容</th>
                                <td>
                                    <textarea id="content" class="form-control" ></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th>处置方式</th>
                                <td id="cz_nr" style="text-align: left">
                                    <label><input type="radio" value="3" name="status"> 已处理</label>
                                    <label><input type="radio" value="4" name="status"> 未处理</label>
                                </td>
                            </tr>
                            <tr>
                                <th>处置情况</th>
                                <td>
                                    <textarea id="confirmation" class="form-control" maxlength="130"></textarea>
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
//        $('#status').change(function () {
//            var status=$('#status option:selected').val();
//            window.location.href="/news/draft?status="+status+'&export=';
//        });
        var id=0;
        //修改弹窗
        $(".edit_but").click(function () {
            id=$(this).data('id');
            $('#is_edit').val(1);
            $('#addtime').val($(this).data('addtime'));
            $('#region').val($(this).data('region'));
            $('#provider').val($(this).data('provider'));
            $('#provider_company').val($(this).data('provider_company'));
            $('#content').val($(this).data('content'));
            $('#confirmation').val($(this).data('confirmation'));
            var status =$(this).data('status');
            if(status==1){
                status=4;
            }
            var s1='<label><input type="radio" value="3" name="status"';
            var s2='<label><input type="radio" value="4" name="status"';
            if(status==3){
                s1=s1+' checked ';
            }
            if(status==4){
                s2=s2+' checked ';
            }
            s1=s1+'> 已处理</label>&nbsp;&nbsp;&nbsp;';
            s2=s2+'> 未处理</label>';
            $('#cz_nr').html(s1+s2);
            $('.modal').modal('show');
        });

        var is_sub=0;
        //提交 线索
        $(".sub_but").click(function () {
            var addtime=$('#addtime').val();
            var region=$('#region').val();
            var provider=$('#provider').val();
            var provider_company=$('#provider_company').val();
            var content=$('#content').val();
            var is_edit=$('#is_edit').val();
            var status=$('input:radio[name="status"]:checked').val();
            var confirmation=$('#confirmation').val();
            if(is_sub==1){
                return false;
            }
            is_sub=1;
            if(region==''){
                alert('区域不能为空');
                return false;
            }
            if(provider==''){
                alert('提供者不能为空');
                return false;
            }
            if(provider_company==''){
                alert('提供者单位不能为空');
                return false;
            }
            if(content==''){
                alert('内容不能为空');
                return false;
            }
            url='/clue/draft/editSave/'+id;
            $.ajax({
                async:false,
                type:'POST',
                url:url,
                dataType:'json',
                data:{addtime:addtime,region:region,provider:provider,provider_company:provider_company,content:content,status:status,confirmation:confirmation,_token:post_token},
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
    </script>

@endsection