@extends('base')
@section('content')

    <style>
        /*弹窗样式*/
        .popup_bg{position: absolute;top: 0px;left: 0px;width: 100%;height: 100%;background: rgba(0,0,0,0.8);z-index: 9999;}
        .poput_con{position: relative;width: 540px;height: 308px;}
        .poput_box{width: 540px;height: 308px;position: absolute;z-index: 9999;top: 50%;left: 50%;margin: -154px 0 0 -270px;background: #fafafa;border-radius: 10px}
        .poput_con h3{text-align: left;line-height:25px;font-size: 14px;color:#000;margin:0;padding:5px 10px;}
        h3 i{color:#4ca520}
        .poput_con div{width: 480px;font-size: 28px;color: #585858;padding: 5px 30px;position: absolute;top: 55px;}
        .poput_con div input{width:320px;height:30px;font-size: 15px;}
        .poput_con div th{ text-align: right;font-weight: normal;font-size:14px;}
        .poput_con th{}
        .poput_con td.up{ text-align: left;}
        .poput_esc{text-align: center;line-height:88px; position: absolute;left: 0px;bottom: 0px;border-bottom-left-radius: 10px;width: 269px;height: 88px;border: none;display: block;background: #fafafa;border-right: 1px solid #dddddd;border-top: 1px solid #dddddd;font-size: 36px;font-family: '微软雅黑'; ;cursor: pointer}
        .poput_esc:active{background: #dddddd;}
        .poput_confirm{text-align: center;line-height:88px;position: absolute;right: 0px;bottom: 0px;border-bottom-right-radius: .1rem;width: 271px;height: 88px;border: none;display: block;background: #fafafa;border-top: 1px solid #dddddd;color: #00c682;font-size: 36px;font-family: '微软雅黑';cursor: pointer}
        .poput_confirm:active{background: #dddddd;}
        .ibox-title h3{
            font-size: 20px;
            font-weight: bold;
            padding:0;
            color:#000
        }
    </style>
    <!-- start: PAGE -->
    <div class="main-content">
        <div class="container">
            <!-- start: PAGE HEADER -->
            <!-- start: TOOLBAR -->
            <div class="toolbar row">
                <div class="col-sm-6 hidden-xs">
                    <div class="page-header">
                        <h2>新闻媒体管理<small></small></h2>
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
                        <li class="active">新闻媒体列表</li>
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
                                        <form class="form-inline" method="get" action="/media">
                                            <div class="form-group">
                                                <label for="wxnameID">媒体级别：</label>
                                                <select name="media_type" id="media_type">
                                                    <option value="" >全部</option>
                                                    @foreach(config('configure.media_level') as $k=>$v)
                                                    <option value="{{$k}}" @if($media_type==$k) selected @endif>{{$v}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            {{--<button type='submit' class="btn btn-blue"> 搜索 </button>--}}
                                            {{--<button type="button" onclick="add()" class="btn btn-blue refresh pull-right"> 增加媒体 </button>--}}
                                            <button type="button" onclick="location='/media/add?url={{base64_encode($url)}}';" class="btn btn-blue refresh pull-right"> 增加媒体 </button>
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
                                                <th>id</th>
                                                <th>媒体名称</th>
                                                <th>媒体级别</th>
                                                {{--<th>媒体类型</th>--}}
                                                <th>媒体描述</th>
                                                <th>旧媒体</th>
                                                <th>操作</th>
                                            </tr>
                                            </thead>
                                            @if(count($list)>0)
                                                @foreach($list as $k=>$l)
                                                    <tr>
                                                        <td>{{$l->id}}</td>
                                                        <td>{{$l->media_name}}</td>
                                                        <td>
                                                            {{config('configure.media_level')[$l->media_level]}}
                                                        </td>
                                                        {{--<td>--}}
                                                            {{--{{config('configure.media_type')[$l->media_type]}}--}}
                                                        {{--</td>--}}
                                                        <td>
                                                            {{$l->media_info}}
                                                        </td>
                                                        <td>
                                                            @if($l['is_past']==0)
                                                                新媒体
                                                                @else
                                                                旧媒体
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-primary btn-xs" onclick="location.href='/media/edit/{{$l['id']}}?url={{base64_encode($url)}}'" type="button">编辑</button>
                                                            @if($l['status']==1)
                                                                <button class="btn btn-warning btn-xs del_but" data-id="{{$l['id']}}" type="button">禁用</button>
                                                            @else
                                                                <button class="btn btn-info btn-xs start_but" data-id="{{$l['id']}}" type="button">启用</button>
                                                            @endif
                                                            @if($l['is_past']==0)
                                                            <button class="btn btn-danger btn-xs dels_but" data-id="{{$l['id']}}" type="button">删除</button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tbody>
                                                <tr>
                                                    <td colspan="4" align="center" id="ssss">暂无信息!</td>
                                                </tr>
                                                </tbody>
                                            @endif
                                        </table>
                                        <div style="display: none" id="mt_html"></div>
                                    </div>
                                    @if(count($list)>0)
                                        {!!
                                        $list->appends(['media_type' => $media_type])->render()
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
        function get_type(id){
            var m_t='<select name="" id="media_type_form">';
            $.ajax({
                async:false,
                type:'post',
                url:'/media/get_media_types',
                dataType:'json',
                data: {_token:post_token},
                success: function(data)
                {
                    for(var i=0;i<data.length; i++){
                        var s='';
                        if(data[i]['id']==id){
                            s='selected';
                        }
                        m_t=m_t+'<option value="'+data[i]['id']+'" '+s+'>'+data[i]['name']+'</option>';
                    }
                    m_t=m_t+'</select>';
                    $('#mt_html').html(m_t);
                }
            });
        }
//        alert(get_type());
        var is_pop = @if (session('is_pop')){{session('is_pop')}}@else 0 @endif ;
        jQuery(document).ready(function() {
            Main.init();
            FormElements.init();
            if (is_pop > 0) {
                pop_template(is_pop);
            }

        });
        $('#media_type').change(function () {
            var media_type=$('#media_type option:selected').val();
            window.location.href="/media?media_type="+media_type;
        });

        //新增
        function add(){
            var title = "新增新闻媒体";
            get_type();
            var media_type=$('#mt_html').html();
            var content='<form id="form" class="img_form"' +
                '<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">' +
                '<table><tr><th>媒体类型：</th><td class="up">'+media_type+'</td></tr>' +
                '</table>';
            Popup1({
                conTitle:title,//标题字段
                conContent:content,//内容字段
                conStyle:'center',//内容字段样式。left —— 左  center —— 中  right —— right
                conEsc:'取消',//关闭按钮事件
                conConfirm:'提交反馈',//确认按钮文本内容
                conEscEvent:'PopupClose()',//关闭事件
                conConfirmEvent:'saveReply()'//确认事件
            });
        }

        //弹窗加载
        function Popup1(popupCon1) {
            popupCon = popupCon1;
            $('body').append('<div class="popup_bg"><div class="poput_box"><div class="poput_con"><h3><i class="glyphicon glyphicon-plus"></i> ' + popupCon.conTitle + '</h3><div style="text-align: ' + popupCon.conStyle + ';">' + popupCon.conContent + '</div><a class="poput_esc" onclick="' + popupCon.conEscEvent + ';">' + popupCon.conEsc + '</a><a class="poput_confirm" onclick="' + popupCon.conConfirmEvent + '">' + popupCon.conConfirm + '</a></div></div></div>');
            var pop_top=parseInt($(document).scrollTop())+parseInt($('.poput_box').height());
            $('.poput_box').attr('style','top:'+pop_top+'px');
            $('.popup_bg').height($('body').height());
        }



        //禁用
        $(".del_but").click(function () {
            var id=$(this).data('id');
            chageStatus(id,2)
        });

        //启用
        $(".start_but").click(function () {
            var id=$(this).data('id');
            chageStatus(id,1)
        });
        //删除
        $(".dels_but").click(function () {
            var id=$(this).data('id');
            chageStatus(id,9)
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
                    url:'/media/chageStatus',
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
                        window.location.reload();


                    },
                    error : function() {
                        pop('提示','网络异常',3)
                    }
                });
            });
        }

    </script>

@endsection