@extends('base')
@section('content')
    <style>
        .main-content{
            background:url('/images/login.jpg') no-repeat;
            background-attachment: fixed;
            background-size: cover;
            -moz-background-size: cover;
            -webkit-background-size: cover;
        }
    </style>
    <!-- start: PAGE -->
    <div class="main-content" xmlns:padding-left="http://www.w3.org/1999/xhtml">
        <!-- start: PANEL CONFIGURATION MODAL FORM -->
        <div class="modal fade" id="panel-config" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                        <h4 class="modal-title">Panel Configuration</h4>
                    </div>
                    <div class="modal-body">
                        Here will be a configuration form
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Close
                        </button>
                        <button type="button" class="btn btn-primary">
                            Save changes
                        </button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <!-- end: SPANEL CONFIGURATION MODAL FORM -->
        <div class="container">
            <!-- start: PAGE HEADER -->
            <!-- start: TOOLBAR -->
        {{--<div class="toolbar row">--}}
        {{--<div class="col-sm-6 hidden-xs">--}}
        {{--<div class="page-header">--}}
        {{--<h2>欢迎登陆<small></small></h2>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<div class="col-sm-6 col-xs-12">--}}
        {{--<a href="#" class="back-subviews">--}}
        {{--<i class="fa fa-chevron-left"></i> 返回--}}
        {{--</a>--}}
        {{--<a href="#" class="close-subviews">--}}
        {{--<i class="fa fa-times"></i> 关闭--}}
        {{--</a>--}}
        {{--</div>--}}
        {{--</div>--}}
        <!-- end: TOOLBAR -->
            <!-- end: PAGE HEADER -->
            <!-- start: PAGE CONTENT -->
            <div style="position: absolute;left: 35%;top: 40%;vertical-align: middle;text-align: center;color: rgb(202, 28, 29);background-position: 0px 0px;">
                <div style="font-size:20px;font-family: 微软雅黑;font-weight:bold;line-height:50px;">欢迎使用湘西土家族苗族自治州新闻管理平台</div>
                <br/>高举旗帜、引领导向，围绕中心、服务大局，团结人民、鼓舞士气，<br/>
                成风化人、凝心聚力，澄清谬误、明辨是非，联接中外、沟通世界。
            </div>
    </div>
    <!-- end: MAIN CONTAINER -->
@endsection
@section('subview')
@endsection
@section('jscontent')
    <script src="{{ asset('/js/admin/nav/system.js') }}"></script>
    <!-- start: CORE JAVASCRIPTS  -->
    <script src="{{ asset('/js/main.js') }}"></script>
    <script src="{{ asset('/js/common.js') }}"></script>
    {{--<script src="{{ asset('/js/vconsole.min.js') }}"></script>--}}
    <link href="/css/toastr/toastr.min.css" rel="stylesheet">
    <script>
        jQuery(document).ready(function() {
            Main.init();
            FormElements.init();
        });
    </script>
@endsection