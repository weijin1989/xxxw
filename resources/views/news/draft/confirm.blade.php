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
                        <li class="active">上稿确认列表</li>
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
                .hides{
                    display: none;
                }
                .sort{
                    cursor: pointer;
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
                                        <form id="from1" class="form-inline" method="get" action="">
                                            <div class="form-group">
                                                <label for="wxnameID">上稿状态：</label>
                                                <select name="status" id="status">
                                                    {{--<option value="" >全部</option>--}}
                                                    @foreach(config('configure.status1') as $k=>$v)
                                                    @if($k!=1)
                                                    <option value="{{$k}}" @if($status==$k) selected @endif>{{$v}}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                &nbsp;<label for="wxnameID">刊播时间：</label>
                                                <input id="starttime" autocomplete="off" class="form-control starttime" value="{{$starttime}}" type="text"  placeholder="请选择时间" name="starttime" /> -
                                                <input id="endtime" autocomplete="off" class="form-control endtime" value="{{$endtime}}" type="text"  placeholder="请选择时间" name="endtime" />
                                            </div>
                                            <div class="form-group">
                                                &nbsp;<label for="wxnameID">标题：</label>
                                                <input type="text" name="search" id="search" value="{{$search}}" placeholder="支持模糊搜索">
                                            </div>
                                            <input type="hidden" name="order_by" id="order_by" value="{{$order_by}}">
                                            <input type="hidden" name="order_by_select" id="order_by_select" value="{{$order_by_select}}">
                                            &nbsp;<button type='submit' class="btn btn-blue search"> 搜索 </button>
                                            <button type="button" id="export" class="btn btn-info refresh pull-right"> 导出 </button>
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
                                                <th>新闻标题</th>
                                                <th>媒体名称</th>
                                                <th>栏目版面</th>
                                                <th class="sort" data-order_by="addtime" data-order_by_select="{{$order_by_select?$order_by_select:'desc'}}">
                                                    刊播时间
                                                    @if($order_by=='addtime')
                                                        @if($order_by_select=='')
                                                            <i class="glyphicon glyphicon-sort"></i>
                                                        @else
                                                            @if($order_by_select=='desc')
                                                                <i class="glyphicon glyphicon glyphicon-chevron-down"></i>
                                                            @else
                                                                <i class="glyphicon glyphicon-chevron-up"></i>
                                                            @endif
                                                        @endif
                                                    @else
                                                        <i class="glyphicon glyphicon-sort"></i>
                                                    @endif
                                                </th>
                                                <th>字数</th>
                                                <th>获奖情况</th>
                                                <th>稿件状态</th>
                                                <th class="sort" id="s2" data-order_by="created_at" data-order_by_select="{{$order_by_select?$order_by_select:'desc'}}">
                                                    上稿时间
                                                    @if($order_by=='created_at')
                                                        @if($order_by_select=='')
                                                        <i class="glyphicon glyphicon-sort jt1"></i>
                                                        @else
                                                            @if($order_by_select=='desc'&& $order_by=='created_at')
                                                                <i class="glyphicon glyphicon glyphicon-chevron-down"></i>
                                                            @else
                                                                <i class="glyphicon glyphicon-chevron-up"></i>
                                                            @endif
                                                        @endif
                                                    @else
                                                        <i class="glyphicon glyphicon-sort"></i>
                                                    @endif
                                                </th>
                                                <th>确认意见</th>
                                                <th>操作</th>
                                            </tr>
                                            </thead>
                                            @if(count($list)>0)
                                                @foreach($list as $k=>$l)
                                                    <tr>
                                                        <td>{{$l->title}}</td>
                                                        {{--<td>{{$l->addtime}}</td>--}}
                                                        <td>{{$medias[$l->media_id]??""}}</td>
                                                        <td>{{$l->cat_page}}</td>
                                                        <td>{{$l->addtime}}</td>
                                                        <td>{{$l->text_size}}</td>
                                                        <td>{{$l->prize_money}}</td>
                                                        <td>{{config('configure.status1')[$l->status]}}</td>
                                                        <td>{{$l->created_at}}</td>
                                                        <td>{{$l->confirmation}}</td>
                                                        <td>
                                                            <button class="btn btn-primary btn-xs" onclick="location.href='/news/draft/confirm/edit/{{$l['id']}}?url={{base64_encode($url)}}'" type="button">确认</button>
                                                            @if(in_array($l['status'],[2,3]))
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
                                        $list->appends(['status' => $status,'starttime' => $starttime,'endtime' => $endtime,'search' => $search,'order_by' => $order_by,'order_by_select' => $order_by_select,])->render()
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

        $('.sort').click(function () {
            $('#order_by').val($(this).data('order_by'));
            var ss=$(this).data('order_by_select');
            if(ss=='desc'){
                ss='asc';
            }else{
                ss='desc';
            }
            $('#order_by_select').val(ss);
            $('#from1').submit();
        })

        $('.look_but').click(function () {
            var id=$(this).data('id');
            window.open("/news/draft/look/"+id);
        });
        $("#export").click(function () {
            var status=$('#status option:selected').val();
            var starttime=$('#starttime').val();
            var endtime=$('#endtime').val();
            var search=$('#search').val();
            window.location.href="/news/draft/confirm?status="+status+'&export=1&search='+search+'&starttime='+'&endtime='+endtime;

        });
    </script>

@endsection