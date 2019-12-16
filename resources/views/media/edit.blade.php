@extends('base')
@section('content')

    <link href="/css/common.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/js/selectator-master/fm.selectator.jquery.css') }}">
    <div class="main-content">
        <!-- end: SPANEL CONFIGURATION MODAL FORM -->
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
                        <li><a href="{{ url('/media') }}">新闻媒体列表</a></li>
                        <li class="active">编辑 新闻媒体</li>
                    </ol>
                </div>
            </div>
            <!-- end: BREADCRUMB -->
            <!-- start: PAGE CONTENT -->
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-white">
                            <div class="panel-body">
                                <div class="ibox-title">
                                    <h5>
                                        <strong>编辑</strong>
                                    </h5>
                                </div>
                                <div class="ibox-content">
                                    <form id="form" method="post" class="form-horizontal" action="/media/editSave/{{$info->id}}">
                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                        {{--<div class="hr-line-dashed"></div>--}}
                                        {{--<div class="form-group">--}}
                                            {{--<label class="col-sm-2 control-label">--}}
                                                {{--<span style="color:#c00">*</span>--}}
                                                {{--媒体类型--}}
                                            {{--</label>--}}
                                            {{--<div class="col-sm-10">--}}
                                                {{--{!! Form::select('media_type',config('configure.media_type'),$info->media_type,array('id' => 'media_type','class' => 'form-control required tel ')) !!}--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">
                                                <span style="color:#c00">*</span>
                                                媒体级别
                                            </label>
                                            <div class="col-sm-10">
                                                {!! Form::select('media_level',config('configure.media_level'),$info->media_level,array('id' => 'media_level','class' => 'form-control required tel ')) !!}
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">
                                                <span style="color:#c00">*</span>
                                                媒体名称
                                            </label>
                                            <div class="col-sm-10 status">
                                                {!! Form::text('media_name',$info->media_name,array('placeholder' => '请输入媒体名称','id' => 'media_name','class' => 'form-control required media_name ',"maxlength"=>"80")) !!}
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">
                                                媒体描述
                                            </label>
                                            <div class="col-sm-10 status">
                                                {!! Form::text('media_info',$info->media_info,array('placeholder' => '请输入媒体描述','id' => 'media_info','class' => 'form-control media_info ',"maxlength"=>"80")) !!}
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>

                                        <div class="form-group">
                                            <div class="col-sm-4 col-sm-offset-2" id="submut_div">
                                                <input name="url" id="url" type="hidden" value="{{$url}}" >
                                                <button class="btn btn-primary sub_but" type="button" >保 存</button>
                                                <button class="btn btn-white" type="button" onclick="history.go(-1);">取 消</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- end: PAGE CONTENT-->
                </div>
            </div>
        </div>
        <div class="subviews">
            <div class="subviews-container"></div>
        </div>
        <!-- end: PAGE -->
    </div>
    <!-- end: MAIN CONTAINER -->
@endsection
@section('subview')
    <style>
        .col-lg-3{height:75px}
    </style>
@endsection
@section('jscontent')
    <script src="{{ asset('/js/admin/nav/system.js') }}"></script>
    <!-- start: CORE JAVASCRIPTS  -->
    <script src="{{ asset('/js/main.js') }}"></script>
    <script src="{{ asset('/js/common.js') }}"></script>
    <link href="/css/toastr/toastr.min.css" rel="stylesheet">
    <script src="{{ asset('/js/selectator-master/fm.selectator.jquery.js') }}"></script>
    <!-- end: CORE JAVASCRIPTS  -->
    <style>
        .chosen-container-single .chosen-single{
            height: 32px;
            border: 1px solid #E6E8E8;
        }
    </style>
    <script>
        var post_token = '<?php echo csrf_token(); ?>';
        jQuery(document).ready(function() {
            Main.init();
            status();
            $('.chosen-select').chosen({search_contains: true});

            var id={{$info->id}};

            $('.sub_but').click(function () {
                ajax_check_mediaName();
            });

            function ajax_check_mediaName() {
                var media_type=$('#media_type option:selected').val();
                var media_level=$('#media_level option:selected').val();
                var media_name=$('#media_name').val();
                if(media_name==''){
                    pop('提示','媒体名称不能为空',3);
                    return false;
                }
                $.ajax({
                    async:false,
                    type:'POST',
                    url:'/media/ajax_check_mediaName',
                    dataType:'json',
                    data:{id:id,media_type:media_type,media_level:media_level,media_name:media_name,_token:post_token},
                    success: function(data)
                    {
                        if(data['code'] != 0)
                        {
                            pop('提示','媒体名称已存在',3);
                            return false;
                        }
                        $('#form').submit();

                    },
                    error : function() {
                        pop('提示','网络异常',3)
                    }
                });
            }
            // $("#form").validate({
            //     onkeyup: false, //关闭输入时验证
            //     ignore: ".ignore",  //开启隐藏域验证
            //     rules: {
            //         media_name: {
            //             required: true,
            //             remote:genAjaxRemoteData({
            //                 media_type:function(){return $('#media_type option:selected').val();},
            //                 media_level:function(){return $('#media_level option:selected').val();},
            //                 _token:function(){return post_token;},
            //                 id:function(){return id}
            //                 }, "/media/ajax_check_mediaName")   //AJAX验重
            //         }
            //     },
            //     messages: {
            //         media_name: {
            //             required: " * 媒体名称不能为空",
            //             remote: "* 媒体名称已存在"
            //         }
            //     }
            // });
        });
    </script>
@endsection