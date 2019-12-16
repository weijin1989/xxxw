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
                        <h2>典型宣传报告管理<small></small></h2>
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
                        <li><a href="{{ url('/propaganda') }}">典型宣传报告列表</a></li>
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
                                        {!! Form::open(array('class'=>'form-horizontal','route' => 'propaganda.addSave','method'=>'POST','id'=>'form')) !!}
                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">
                                                <span style="color:#c00">*</span>
                                                报道类型
                                            </label>
                                            <div class="col-sm-5 status">
                                                <select id="types" class="form-control types"  name="types" >
                                                    {{--<option value="">- - -请选择- - -</option>--}}
                                                    @foreach(config('configure.pro_types') as $k=>$v)
                                                        <option class="option" value="{{$k}}">{{$v}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">
                                                <span style="color:#c00">*</span>
                                                所属类型
                                            </label>
                                            <div class="col-sm-5 status">
                                                <select id="category" class="form-control category"  name="category" >
                                                    {{--<option value="">- - -请选择- - -</option>--}}
                                                    @foreach(config('configure.pro_category') as $k=>$v)
                                                        <option class="option" value="{{$k}}">{{$v}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">
                                                <span style="color:#c00">*</span>
                                                姓名
                                            </label>
                                            <div class="col-sm-5">
{{--                                                {!! Form::text('title','',array('id' => 'title','class' => 'form-control required title ','autocomplete'=>"off")) !!}--}}
                                                {!! Form::text('name','',array('id' => 'name','class' => 'form-control required name ' ,'data-toggle'=>'dropdown','autocomplete'=>"off")) !!}
                                                {{--<ul class="dropdown-menu" id="dropdown_nr" style="margin-left:15px">--}}
                                                {{--</ul>--}}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">
                                                <span style="color:#c00">*</span>
                                                类型
                                            </label>
                                            <div class="col-sm-5 status">
                                                <select id="cur_type" class="form-control cur_type"  name="cur_type" >
                                                    {{--<option value="">- - -请选择- - -</option>--}}
                                                    @foreach(config('configure.pro_cur_type') as $k=>$v)
                                                        <option class="option" value="{{$k}}">{{$v}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">
                                                <span style="color:#c00">*</span>
                                                所属县市区
                                            </label>
                                            <div class="col-sm-5 status">
                                                <select id="p_id" class="form-control p_id"  name="p_id" >
                                                    <option value="">- - -请选择- - -</option>
                                                    @foreach($p_area as $k=>$v)
                                                        <option class="option" value="{{$k}}">{{$v}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-5 status">
                                                <select id="area_id" class="form-control area_id chosen-select required"  name="area_id" tabindex="2">
                                                    <option value="">请选择父区域</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">
                                                基本情况
                                            </label>
                                            <div class="col-sm-10 status">
                                                {!! Form::textarea('situation',null,array('placeholder' => '请输入活动内容','id' => 'situation','class' => '','style' => 'min-height:200px')) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">
                                                典型宣传报道
                                            </label>
                                            <div class="col-sm-10 status">
                                                {!! Form::textarea('report',null,array('placeholder' => '请输入活动内容','id' => 'report','class' => '','style' => 'min-height:200px')) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">
                                                典型原始资料
                                            </label>
                                            <div class="col-sm-10 status">
                                                {!! Form::textarea('datas',null,array('placeholder' => '请输入活动内容','id' => 'datas','class' => '','style' => 'min-height:200px')) !!}
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

//             var start = {
//                 elem: '#addtime',
//                 format: 'YYYY-MM-DD',
// //                max: laydate.now(), //设定最小日期为当前日期
// //            max: '2099-06-16 23:59:59', //最大日期
//                 istime: true,
//                 istoday: false
//             };
//
//             laydate(start);
            $('#p_id').change(function () {
                var media_type=$('#p_id option:selected').val();
                if(media_type!=''){
                    getByMedia(media_type);
                }
            });
            // $('#title').focus(function () {
            //     var title = $(this).val();
            //     if(title=='') {
            //         $('#dropdown_nr').css({"height": "0px", 'padding': '0', 'border': '0'});
            //     }
            // });
            // $('#title').focusout(function () {
            //     var title = $(this).val();
            //     if (title) {
            //         $.ajax({
            //             async: false,
            //             type: 'POST',
            //             url: '/news/draft/getTypeByTitle',
            //             dataType: 'json',
            //             data: {title: title, _token: post_token},
            //             success: function (data) {
            //                 if (data['code'] != 0) {
            //                     pop('提示', data['msg'], 3);
            //                     return false;
            //                 }
            //                 var html = "";
            //                 console.log(data.data);
            //                 for (var i = 0; i < data.data.length; i++) {
            //                     html += "<li><a>"+data.data[i].title+"</a></li>";
            //                 }
            //                 $('#dropdown_nr').html(html);
            //
            //                 $('#dropdown_nr').css({"height":"auto",'padding':'5px 0','border':'1px solid #ccc'});
            //             },
            //             error: function () {
            //                 pop('提示', '网络异常', 3)
            //             }
            //         });
            //     }
            // });
            function getByMedia(p_id) {
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
                        console.log(data.data);
                        for (var i = 0; i < data.data.length; i++) {
                            var selected='';
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

            <!-- 实例化编辑器 -->
            var ue = UE.getEditor('situation',{
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

            <!-- 实例化编辑器 -->
            var ue1 = UE.getEditor('report',{
//                toolbars: [
////                    ['fullscreen', 'source', 'undo', 'redo', 'bold','italic', 'underline', 'fontborder'
////                        , 'fontfamily', 'fontsize','date', 'time', '|'
////                        , 'simpleupload'
////                        , 'insertimage','insertvideo', 'mergeright', 'mergedown', 'edittable','insertframe'
////                        , 'edittd'
////                        , 'inserttable' //插入表格'
////                        , 'link', //超链接
////                        'attachment',
////
////                    ]
//                    [
//                        'fullscreen', 'source', '|', 'undo', 'redo', '|',
////                        'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat',s'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
//                        'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
//                        'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
//                        'directionalityltr', 'directionalityrtl', 'indent', '|',
//                        'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
//                        'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
//                        'simpleupload', 'insertimage', 'emotion', 'scrawl', 'insertvideo', 'music', 'attachment', 'map', 'gmap', 'insertframe', 'insertcode', 'webapp', 'pagebreak', 'template', 'background', '|',
//                        'horizontal', 'date', 'time', 'spechars', 'snapscreen', 'wordimage', '|',
//                        'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts', '|',
//                        'print', 'preview', 'searchreplace', 'drafts'
//                        , 'help'
//                    ]
//                ],
                catchRemoteImageEnable: true
            });
            ue1.ready(function(){
                ue1.execCommand('serverparam', '_token', '{{ csrf_token() }}');
            });

            <!-- 实例化编辑器 -->
            var ue2 = UE.getEditor('datas',{
//                toolbars: [
////                    ['fullscreen', 'source', 'undo', 'redo', 'bold', 'simpleupload'
////                        , 'insertimage','insertvideo', 'mergeright', 'mergedown', 'edittable','insertframe'
////                        , 'edittd'
////                        , 'inserttable' //插入表格'
////                        , 'link', //超链接
////                    ]
//                    [
//                        'fullscreen', 'source', '|', 'undo', 'redo', '|',
//                        'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
//                        'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
//                        'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
//                        'directionalityltr', 'directionalityrtl', 'indent', '|',
//                        'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
//                        'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
//                        'simpleupload', 'insertimage', 'emotion', 'scrawl', 'insertvideo', 'music', 'attachment', 'map', 'gmap', 'insertframe', 'insertcode', 'webapp', 'pagebreak', 'template', 'background', '|',
//                        'horizontal', 'date', 'time', 'spechars', 'snapscreen', 'wordimage', '|',
//                        'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts', '|',
//                        'print', 'preview', 'searchreplace', 'drafts'
//                        , 'help'
//                    ]
//                ],
            });
            ue2.ready(function(){
                ue2.execCommand('serverparam', '_token', '{{ csrf_token() }}');
            });
            // ue.addListener("blur",function(){
            //     var editor=UE.getEditor('content');
            //     var arr =(editor.getContentTxt().length);
            //     $('#text_size').val(arr)
            // })

            $("#form").validate({
                onkeyup: false, //关闭输入时验证
                ignore: ".ignore",  //开启隐藏域验证
                rules: {
                    name: {
                        required: true,
                        // remote: genAjaxRemote("", "/news/draft/ajax_check_title", post_token)   //AJAX验重
                    },
                    area_id: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: " * 不能为空",
                        // remote: "* 新闻标题已存在"
                    },
                    area_id: {
                        required: " * 请选择区域",
                    }
                }
            });
        });
    </script>
@endsection