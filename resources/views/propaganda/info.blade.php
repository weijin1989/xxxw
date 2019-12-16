@extends('base')
@section('content')
    <!-- start: PAGE -->
    <style>
        .toolbar{
            height:auto;
        }
        .toolbar h2.h2{
            font-size: 24px;
            text-align: center;
        }
        .nr{
            margin-top:20px
        }
        .news .title {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            color:#000
        }
        .news .descript {
            font-size: 14px;
            text-align: center;
        }
        hr {
             border: 1px dotted #808080;
         }
        .news .content {
              font-size: 14px;
              line-height: 25px;
              text-align: left;
              color: #333333;
          }
        .news{
            padding:0 20px;
        }
    </style>
    <div class="main-content">
        <div class="container">
            <!-- start: PAGE HEADER -->
            <!-- start: TOOLBAR -->
            <div class="toolbar row">
                <div class="col-sm-12 hidden-xs">
                    <div class="page-header">
                        <h2 class="h2">典型宣传报告预览<small></small></h2>
                    </div>
                </div>
            </div>
            <div class="row nr">
                <div class="col-md-12">
                    <div class="panel panel-white">
                        <div class="panel-body">
                            <div id="myTabContent" class="tab-content news">
                                <h1  class="title">{{$info->name}}</h1>
                                <div class="descript">
                                    <b>报道类型:</b>{{config('configure.pro_types')[$info->types]}} | <b>典型类型:</b>{{config('configure.pro_category')[$info->category]}} |
                                    <b>类型:</b>{{config('configure.pro_cur_type')[$info->cur_type]}} | <b>所属县区:</b>{{$area[$info->p_id]}}-{{$area[$info->area_id]}}
                                    <br/><b>创建时间:</b>{{$info->created_at}}
                                </div>
                                <hr/>
                                <h1>基本资料</h1>
                                <div class="content">
                                    {!! $info->situation !!}
                                </div>
                                <hr/>
                                <h1>典型宣传报道</h1>
                                <div class="content">
                                    {!! $info->report !!}
                                </div>
                                <hr/>
                                <h1>典型原始资料</h1>
                                <div class="content">
                                    {!! $info->datas !!}
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
    <script src="/js/context/context.js"></script>
    <script src="/js/context/demo.js"></script>
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
            window.location.href="/news/draft?status="+status;
        });

        $('.look_but').click(function () {
            var id=$(this).data('id');
            window.open("/news/draft/look/"+id);
        });

        //提交 变更成待审
        $(".sub_but").click(function () {
            var id=$(this).data('id');
            chageStatus(id,2)
        });

        //删除 变更成待审
        $(".del_but").click(function () {
            var id=$(this).data('id');
            chageStatus(id,0)
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
                    url:'/news/draft/chageStatus',
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