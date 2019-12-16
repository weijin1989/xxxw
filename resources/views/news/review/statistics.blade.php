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
                        <h2>评阅统计管理<small></small></h2>
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
                        <li class="active">评阅统计列表</li>
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
                                                &nbsp;<label for="wxnameID">日期：</label>
                                                <input id="starttime" autocomplete="off" class="form-control starttime" value="{{$starttime}}" type="text"  placeholder="请选择开始日期" name="starttime" /> -
                                                <input id="endtime" autocomplete="off" class="form-control endtime" value="{{$endtime}}" type="text"  placeholder="请选择结束日期" name="endtime" />
                                            </div>
                                            <div class="form-group">
                                                &nbsp;<label for="wxnameID">标题：</label>
                                                <input type="text" name="search" id="search" value="{{$search}}" placeholder="支持模糊搜索">
                                            </div>
                                            <div class="form-group">
                                                &nbsp;<label for="wxnameID">被阅评媒体：</label>
                                                <select name="media_id" id="media_id" class="form-control" >
                                                    <option value="" >全部</option>
                                                    @foreach($medias1 as $k=>$v)
                                                        @if($v->is_past==0)
                                                            <option value="{{$v->id}}"
                                                                    @if($media_id==$v->id) selected @endif>
                                                                【{{config('configure.media_level')[$v->media_level]}}】
                                                                {{$v->media_name}}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                    @foreach($medias1 as $k=>$v)
                                                        @if($v->is_past==1&&in_array($v->media_level,[1,2]))
                                                            <option value="{{$v->id}}"
                                                                    @if($media_id==$v->id) selected @endif>
                                                                @if($v->is_past==1)
                                                                    ===旧媒体===
                                                                @endif
                                                                【{{config('configure.media_level')[$v->media_level]}}】
                                                                {{$v->media_name}}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                &nbsp;<label for="wxnameID">栏目版面：</label>
                                                <input type="text" name="cat_page" id="cat_page" value="{{$cat_page}}" placeholder="支持模糊搜索">
                                            </div>
                                            <input type="hidden" name="order_by" id="order_by" value="{{$order_by}}">
                                            <input type="hidden" name="order_by_select" id="order_by_select" value="{{$order_by_select}}">
                                            &nbsp;<button type='submit' class="btn btn-blue search" style="margin-top:5px"> 搜索 </button>
                                            <button type="button" id="export" class="btn btn-info refresh pull-right" style="margin-top:5px;margin-right:20px"> 导出 </button>
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
                                                <th class="sort" data-order_by="media_id" data-order_by_select="{{$order_by_select?$order_by_select:'desc'}}">
                                                    被阅评媒体
                                                    @if($order_by=='media_id')
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
                                                <th>栏目版面</th>
                                                <th>阅评标题</th>
                                                <th>字数</th>
                                                <th>刊发情况</th>
                                                <th>阅评员</th>
                                                <th class="sort" data-order_by="created_at" data-order_by_select="{{$order_by_select?$order_by_select:'desc'}}">
                                                    撰写时间
                                                    @if($order_by=='created_at')
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
                                                <th>操作</th>
                                            </tr>
                                            </thead>
                                            @if(count($list)>0)
                                                @foreach($data as $k=>$l)
                                                    <?php $row='';
                                                    if(count($l)>1){
                                                        $row='rowspan='.count($l);
                                                    }
                                                    ?>
                                                    @foreach($l as $kk=> $ll)
                                                        <tr>
                                                            @if($kk==0)
                                                                <td {{$row}}>{{$medias[$k]??""}}</td>
                                                            @endif
                                                            <td>{{$ll['cat_page']}}</td>
                                                            <td>{{$ll['title']}}</td>
                                                            <td>{{$ll['text_size']}}</td>
                                                            <td>{{$ll['publication']}}</td>
                                                            <td>
                                                                {{$users[$ll['at_id']]}}
                                                            </td>
                                                            <td>{{$ll['created_at']}}</td>
                                                            <td>
                                                                <button class="btn btn-primary  btn-xs myModal" data-id="{{$ll['id']}}" type="button">刊发情况</button>
                                                                <button class="btn btn-info  btn-xs look_but" data-id="{{$ll['id']}}" type="button">预览</button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            @else
                                                <tbody>
                                                <tr>
                                                    <td colspan="8" align="center" id="ssss">暂无信息!</td>
                                                </tr>
                                                </tbody>
                                            @endif
                                        </table>
                                    </div>
                                    @if(count($list)>0)
                                        {!!
                                        $list->appends(['starttime' => $starttime,'cat_page' => $cat_page,'endtime' => $endtime,'search' => $search,'media_id' => $media_id,'order_by' => $order_by,'order_by_select' => $order_by_select])->render()
                                        !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end: PAGE CONTENT-->

                <div class="modal fade bottom" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">刊发情况</h4>
                            </div>
                            <div class="modal-body">
                                <p>
                                    请输入此新闻评阅的刊发情况：
                                </p>
                                   <input type="text" id="publication" class="form-control">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                <button type="button" class="btn btn-primary sub_prize">确认</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->


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
    <script src="{{ asset('/plugins/laydate/laydate.js')  }}"></script>
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
        var id=0;
        $('.myModal').click(function () {
            id=$(this).data('id');
            $('#prize_money').val('');
            $('.modal').modal('show');
        });

        $('.look_but').click(function () {
            var id=$(this).data('id');
            window.open("/review/draft/look/"+id);
        });

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

        //提交获奖情况
        var is_sub=0;
        $(".sub_prize").click(function () {
            var publication =$('#publication').val();
            if(is_sub==1){
                return false
            }
            is_sub=1;
            $.ajax({
                async:false,
                type:'POST',
                url:'/review/draft/statistics/sub_prize',
                dataType:'json',
                data:{id:id,publication:publication,_token:post_token},
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
        })

        $("#export").click(function () {
            var starttime=$('#starttime').val();
            var endtime=$('#endtime').val();
            var search=$('#search').val();
            window.location.href="/review/draft/statistics?search="+search+'&export=1&endtime='+endtime+'&starttime='+starttime;

        })

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
    </script>

@endsection