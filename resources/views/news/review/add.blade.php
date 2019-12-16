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
                        <h2>新闻评阅管理<small></small></h2>
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
                        <li><a href="{{ base64_decode($url) }}">新闻评阅列表</a></li>
                        <li class="active">新增</li>
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
                                        <strong>新增</strong>
                                    </h5>
                                </div>
                                <div class="ibox-content">
                                        {!! Form::open(array('class'=>'form-horizontal','route' => 'review.draft.addSave','method'=>'POST','id'=>'form')) !!}
                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">
                                                <span style="color:#c00">*</span>
                                                标题
                                            </label>
                                            <div class="col-sm-10">
                                                {!! Form::text('title','',array('id' => 'title','class' => 'form-control required title ')) !!}
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">
                                                <span style="color:#c00">*</span>
                                                被评阅媒体名称
                                            </label>
                                            <div class="col-sm-5">
                                                <select id="media_type" class="form-control media_type"  name="media_type" >
                                                    <option value="">- - -请选择级别- - -</option>
                                                    @foreach(config('configure.media_level') as $k=>$v)
                                                        <option class="option" value="{{$k}}">{{$v}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-5">
                                                <span style="color:#c00;position: absolute;left:1px;">*</span>
                                                <select id="media_id" class="form-control media_id chosen-select required"  name="media_id" tabindex="2">
                                                    <option value="">请先选择媒体级别</option>
                                                    {{--@foreach($medias as $k=>$v)--}}
                                                    {{--<option class="option" value="{{$v->id}}">{{$v->media_name}}--{{config('configure.media_level')[$v->media_level]}}</option>--}}
                                                    {{--@endforeach--}}
                                                </select>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">
                                                栏目版面
                                            </label>
                                            <div class="col-sm-10 status">
                                                {!! Form::text('cat_page',null,array('placeholder' => '请输入栏目版面','id' => 'cat_page','class' => 'form-control ')) !!}
                                            </div>
                                        </div>
                                        {{--<div class="hr-line-dashed"></div>--}}
                                        {{--<div class="form-group">--}}
                                            {{--<label class="col-sm-2 control-label">--}}
                                                {{--刊播时间--}}
                                            {{--</label>--}}
                                            {{--<div class="col-sm-10 status">--}}
                                                {{--{!! Form::text('addtime',null,array('placeholder' => '发布时间','id' => 'addtime','class' => 'form-control  start_time ',"maxlength"=>"20",'readonly'=>'readonly')) !!}--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">
                                                字数
                                            </label>
                                            <div class="col-sm-10 status">
                                                {!! Form::text('text_size',null,array('placeholder' => '字数','class' => 'form-control  ','id'=>'text_size')) !!}
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">
                                                刊播内容
                                            </label>
                                            <div class="col-sm-10 status">
                                                {!! Form::textarea('content',null,array('placeholder' => '请输入活动内容','id' => 'content','class' => '','style' => 'min-height:200px')) !!}
                                            </div>
                                        </div>

                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <div class="col-sm-4 col-sm-offset-2" id="submut_div">
                                                <input name="url" id="url" type="hidden" value="{{$url}}" >
                                                <button class="btn btn-primary" type="submit" >保 存</button>
                                                <button class="btn btn-white" type="button" onclick="history.go(-1);">取 消</button>
                                            </div>
                                        </div>
                                    {!! Form::close() !!}
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
    <script src="{{ asset('/plugins/laydate/laydate.js')  }}"></script>
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
//            status();
//            $('.chosen-select').chosen({search_contains: true});
//            var start = {
//                elem: '#addtime',
//                format: 'YYYY-MM-DD',
////                max: laydate.now(), //设定最小日期为当前日期
////            max: '2099-06-16 23:59:59', //最大日期
//                istime: true,
//                istoday: false
//            };
//
//            laydate(start);

            $('#media_type').change(function () {
                var media_type=$('#media_type option:selected').val();
                if(media_type!=''){
                    getByMedia(media_type);
                }
            });
            function getByMedia(media_type) {
                $('#media_id').html('');
                $.ajax({
                    async:false,
                    type:'POST',
                    url:'/news/draft/getTypeByMedia',
                    dataType:'json',
                    data:{media_type:media_type,_token:post_token},
                    success: function(data)
                    {
                        if(data['code'] != 0)
                        {
                            pop('提示',data['msg'],3);
                            return false;
                        }
                        var html="<option value=''>请选择媒体名称</option>";
                        for (var i = 0; i < data.data.length; i++) {
                            var selected='';
                            html+="<option value='"+data.data[i].id+"'>";
                            if(data.data[i].is_past==1){
                                html+="===旧媒体===";
                            }
                            html+=data.data[i].media_level_name+"---"+data.data[i].media_name+"</option>";
//                            html+="<option value='"+data.data[i].id+"' "+selected+">"+data.data[i].media_level_name+"---"+data.data[i].media_name+"</option>";
                        }
                        $('#media_id').html(html);
//                        $('.chosen-select').chosen({search_contains: true});
                    },
                    error : function() {
                        pop('提示','网络异常',3)
                    }
                });
            }

            <!-- 实例化编辑器 -->
            var ue = UE.getEditor('content',{
//                toolbars: [
//                    ['fullscreen', 'source', 'undo', 'redo', 'bold','italic', 'underline', 'fontborder'
//                        , 'fontfamily', 'fontsize','date', 'time', '|'
//                        , 'simpleupload'
//                        , 'insertimage','insertvideo', 'mergeright', 'mergedown', 'edittable','insertframe'
//                        , 'edittd'
//                        , 'inserttable' //插入表格'
//                        , 'link', //超链接
//                        'attachment',
//
//                    ]
////                    [
////                        'fullscreen', 'source', '|', 'undo', 'redo', '|',
//////                        'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat',s'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
////                        'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
////                        'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
////                        'directionalityltr', 'directionalityrtl', 'indent', '|',
////                        'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
////                        'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
////                        'simpleupload', 'insertimage', 'emotion', 'scrawl', 'insertvideo', 'music', 'attachment', 'map', 'gmap', 'insertframe', 'insertcode', 'webapp', 'pagebreak', 'template', 'background', '|',
////                        'horizontal', 'date', 'time', 'spechars', 'snapscreen', 'wordimage', '|',
////                        'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts', '|',
////                        'print', 'preview', 'searchreplace', 'drafts'
////                        , 'help'
////                    ]
//                ],
                catchRemoteImageEnable: true
            });
            ue.ready(function(){
                ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
            });
            ue.addListener("blur",function(){
                var editor=UE.getEditor('content');
                var arr =(editor.getContentTxt().length);
                $('#text_size').val(arr)
            })

            $("#form").validate({
                onkeyup: false, //关闭输入时验证
                ignore: ".ignore",  //开启隐藏域验证
                rules: {
                    title: {
                        required: true,
                        remote: genAjaxRemote("", "/news/draft/ajax_check_title", post_token)   //AJAX验重
                    },
                    media_id: {
                        required: true
                    }
                },
                messages: {
                    title: {
                        required: " * 标题不能为空",
                        remote: "* 标题已存在"
                    },
                    media_id: {
                        required: " *请选择媒体类型"
                    }
                }
            });
        });
    </script>
@endsection