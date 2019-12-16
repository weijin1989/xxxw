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
                        <h2>记者上稿管理<small></small></h2>
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
                        <li><a href="{{ base64_decode($url) }}">上稿确认列表</a></li>
                        <li class="active">确认</li>
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
                                        <strong>确认</strong>
                                    </h5>
                                </div>
                                <div class="ibox-content">
                                    {!! Form::model($info,array('class'=>'form-horizontal','route' => ['news.draft.editConfirmSave',$info->id],'method'=>'POST','id'=>'form')) !!}
                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">
                                                <span style="color:#c00">*</span>
                                                标题
                                            </label>
                                            <div class="col-sm-10">
                                                {!! Form::text('title',null,array('id' => 'title','class' => 'form-control required title ')) !!}
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">
                                                <span style="color:#c00">*</span>
                                                媒体名称
                                            </label>
                                            <div class="col-sm-4 status">
                                                <select id="media_id" class="form-control chosen-select media_id required"  name="media_id" tabindex="2">
                                                    @foreach($medias as $k=>$v)
                                                        <option class="option" value="{{$v->id}}" @if($info->media_id==$v->id) selected @endif>

                                                            @if($v->is_past==1)
                                                                ===旧媒体===
                                                            @endif
                                                            {{config('configure.media_level')[$v->media_level]}}--{{$v->media_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <label class="col-sm-2 control-label">
                                                栏目版面
                                            </label>
                                            <div class="col-sm-4 status">
                                                {!! Form::text('cat_page',null,array('placeholder' => '请输入栏目版面','id' => 'cat_page','class' => 'form-control ')) !!}
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">
                                                刊播时间
                                            </label>
                                            <div class="col-sm-4">
                                                {!! Form::text('addtime',null,array('placeholder' => '发布时间','id' => 'addtime','class' => 'form-control  start_time ',"maxlength"=>"20",'readonly'=>'readonly')) !!}
                                            </div>
                                            <label class="col-sm-2 control-label">
                                                字数
                                            </label>
                                            <div class="col-sm-4">
                                                {!! Form::text('text_size',null,array('placeholder' => '字数','class' => 'form-control  ')) !!}
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">
                                                作者
                                            </label>
                                            <div class="col-sm-5 ">
                                                {!! Form::text('zuozhe',$users[$info->at_id],array('placeholder' => '','class' => 'form-control' ,'disabled'=>'disabled')) !!}
                                            </div>
                                            <div class="col-sm-5">
                                                {!! Form::text('zuozhe',$coms[$info->at_id],array('placeholder' => '','class' => 'form-control  ' ,'disabled'=>'disabled')) !!}
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">
                                                上稿日期
                                            </label>
                                            <div class="col-sm-10">
                                                {!! Form::text('created_at',null,array('placeholder' => '字数','class' => 'form-control  ','disabled'=>'disabled')) !!}
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">
                                                确认方式
                                            </label>
                                            <div class="col-sm-4 status">
                                                <select id="status" class="form-control required"  name="status">
                                                    @foreach(config('configure.confirm_status') as $k=>$v)
                                                        <option class="option" @if($info->status==$k) selected @endif value="{{$k}}">{{$v}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">
                                                确认意见
                                            </label>
                                            <div class="col-sm-10">
                                                {!! Form::text('confirmation',null,array('placeholder' => '确认意见','class' => 'form-control  ')) !!}
                                            </div>
                                        </div>
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
            $('.chosen-select').chosen({search_contains: true});
            var start = {
                elem: '#addtime',
                format: 'YYYY-MM-DD',
//                max: laydate.now(), //设定最小日期为当前日期
//            max: '2099-06-16 23:59:59', //最大日期
                istime: true,
                istoday: false
            };

            laydate(start);

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

            $("#form").validate({
                onkeyup: false, //关闭输入时验证
                ignore: ".ignore",  //开启隐藏域验证
                rules: {
                    title: {
                        required: true,
                        remote: genAjaxRemote("{{$info->id}}", "/news/draft/ajax_check_title", post_token)   //AJAX验重
                    }
                },
                messages: {
                    title: {
                        required: " * 新闻标题不能为空",
                        remote: "* 新闻标题已存在"
                    }
                }
            });
        });
    </script>
@endsection