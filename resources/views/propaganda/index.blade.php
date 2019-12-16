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
                        <h2>典型宣传报告管理<small></small></h2>
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
                        <li class="active">列表</li>
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
                .form-group{
                    padding-bottom:10px;
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
                                                <label for="wxnameID">姓名：</label>
                                                <input type="text" name="search" class="form-control" id="search" value="{{$search}}" placeholder="支持模糊搜索">
                                            </div>
                                            <div class="form-group">
                                                <label for="wxnameID">报道类型：</label>
                                                <select name="types" class="form-control">
                                                    <option value="">请选择</option>
                                                    @foreach(config('configure.pro_types') as $k=>$v)
                                                    <option value="{{$k}}" @if($types==$k) selected @endif>{{$v}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="wxnameID">所属类别：</label>
                                                <select name="category" class="form-control">
                                                    <option value="">请选择</option>
                                                    @foreach(config('configure.pro_category') as $k=>$v)
                                                    <option value="{{$k}}" @if($category==$k) selected @endif>{{$v}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="wxnameID">类型：</label>
                                                <select name="cur_type" class="form-control">
                                                    <option value="">请选择</option>
                                                    @foreach(config('configure.pro_cur_type') as $k=>$v)
                                                    <option value="{{$k}}" @if($cur_type==$k) selected @endif>{{$v}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="wxnameID">所属县市区：</label>
                                                {{--<select id="p_id" class="form-control p_id"  name="p_id" >--}}
                                                <select  class="form-control area_id"  name="area_id" >
                                                    <option value="">请选择</option>
                                                    @foreach($p_area as $k=>$v)
                                                        <option class="option" value="{{$k}}" @if($area_id==$k) selected @endif>{{$v}}</option>
                                                    @endforeach
                                                </select>

                                                {{--<select id="area_id" class="form-control area_id chosen-select required"  name="area_id" tabindex="2">--}}
                                                    {{--<option value="">请选择父区域</option>--}}
                                                {{--</select>--}}
                                            </div>
                                            <div class="form-group">
                                            <button type='submit' class="btn btn-blue"> 搜索 </button>
                                            <button type="button" onclick="location='/propaganda';" class="btn btn-info"> 清空 </button>
                                            </div>
                                            {{--<button type="button" onclick="add()" class="btn btn-blue refresh pull-right"> 增加媒体 </button>--}}
                                            <input type="hidden" name="order_by" id="order_by" value="{{$order_by}}">
                                            <input type="hidden" name="order_by_select" id="order_by_select" value="{{$order_by_select}}">
                                            <button type="button" onclick="location='/propaganda/add?url={{base64_encode($url)}}';" class="btn btn-blue refresh pull-right"> 增加 </button>


                                            {{--<button type="button" id="export" class="btn btn-info refresh pull-right" style="margin-right:20px"> 导出 </button>--}}
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
                                                <th>报道类型</th>
                                                <th>所属类别</th>
                                                <th>姓名</th>
                                                <th>类型</th>
                                                <th>所属县市区</th>
                                                {{--<th id="s1" data-order_by="created_at" data-order_by_select="{{$order_by_select}}">所属县市区</th>--}}
                                                <th>状态</th>
                                                <th class="sort" data-order_by="created_at" data-order_by_select="{{$order_by_select?$order_by_select:'desc'}}">
                                                    添加时间
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
                                                {{--<th id="s2" data-order_by="created_at" data-order_by_select="{{$order_by_select}}">添加时间</th>--}}
                                                <th>操作</th>
                                            </tr>
                                            </thead>
                                            @if(count($list)>0)
                                                @foreach($list as $k=>$l)
                                                    <tr>
                                                        <td>{{config('configure.pro_types')[$l->types]}}</td>
                                                        <td>{{config('configure.pro_category')[$l->category]}}</td>
                                                        <td>{{$l->name}}</td>
                                                        <td>{{config('configure.pro_cur_type')[$l->cur_type]}}</td>
                                                        <td>{{$area[$l->area_id]}}</td>
                                                        <td>{{$l->status==1?'启用':'禁用'}}</td>
                                                        <td>{{$l->created_at}}</td>
                                                        <td>
                                                            <button class="btn btn-primary btn-xs" onclick="location.href='/propaganda/edit/{{$l['id']}}?url={{base64_encode($url)}}'" type="button">编辑</button>
                                                            @if($l->status==1)
                                                                <button class="btn btn-warning btn-xs jy_but" data-id="{{$l['id']}}" type="button">禁用</button>
                                                                <button class="btn btn-danger btn-xs del_but" data-id="{{$l['id']}}" type="button">删除</button>
                                                            @elseif($l->status==2)
                                                                <button class="btn btn-success btn-xs qy_but" data-id="{{$l['id']}}" type="button">启用</button>
                                                            @endif
                                                            <button class="btn btn-info  btn-xs look_but" data-id="{{$l['id']}}" type="button">预览</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tbody>
                                                <tr>
                                                    <td colspan="7" align="center" id="ssss">暂无信息!</td>
                                                </tr>
                                                </tbody>
                                            @endif
                                        </table>
                                    </div>
                                    @if(count($list)>0)
                                        {!!
                                        $list->appends(['search' => $search,'types' => $types,'category' => $category,'cur_type' => $cur_type,'p_id' => $p_id,
                                        'area_id' => $area_id,
                                        'order_by' => $order_by,
                                        'order_by_select' => $order_by_select,
                                        ])->render()
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
        var p_id='{{$p_id}}';
        var area_id='{{$area_id}}';
        jQuery(document).ready(function() {
            Main.init();
            FormElements.init();
            if (is_pop > 0) {
                pop_template(is_pop);
            }

        });
        if(p_id!=''){
            getByArea(p_id);
        }

        $('.look_but').click(function () {
            var id=$(this).data('id');
            window.open("/propaganda/look/"+id);
        });

        //删除 变更成待审
        $(".qy_but").click(function () {
            var id=$(this).data('id');
            chageStatus(id,1)
        })
        //启用变成禁用
        $(".jy_but").click(function () {
            var id=$(this).data('id');
            chageStatus(id,2)
        });//启用变成 删除
        $(".del_but").click(function () {
            var id=$(this).data('id');
            chageStatus(id,9)
        });
        $('#p_id').change(function () {
            var pid=$('#p_id option:selected').val();
            if(pid!=''){
                getByArea(pid);
            }
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

        function getByArea(p_id) {
            $.ajax({
                async:false,
                type:'POST',
                url:'/propaganda/getIdByList',
                dataType:'json',
                data:{p_id:p_id,_token:post_token},
                success: function(data)
                {
                    if(data['code'] != 0)
                    {
                        pop('提示',data['msg'],3);
                        return false;
                    }
                    var html="<option value=''>请选择</option>";
                    for (var i = 0; i < data.data.length; i++) {
                        var selected='';
                        if(area_id==data.data[i].id){
                            selected='selected';
                        }
                        html+="<option value='"+data.data[i].id+"' "+selected+">"+data.data[i].area+"</option>";
                    }
                    $('#area_id').html(html);
//                        $('.chosen-select').chosen({search_contains: true});
                },
                error : function() {
                    pop('提示','网络异常',3)
                }
            });
        }

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
                    url:'/propaganda/chageStatus',
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
                        // setInterval(function () {
                            window.location.reload();
                        // },1000);

                    },
                    error : function() {
                        pop('提示','网络异常',3)
                    }
                });
            });
        }
    </script>

@endsection