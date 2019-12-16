@extends('base')
@section('content')

    <link href="/css/common.css" rel="stylesheet">

    <div class="main-content">
        <!-- end: SPANEL CONFIGURATION MODAL FORM -->
        <div class="container">
            <!-- start: PAGE HEADER -->
            <!-- start: TOOLBAR -->
            <div class="toolbar row">
                <div class="col-sm-6 hidden-xs">
                    <div class="page-header">
                        <h2>角色管理<small></small></h2>
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
                        <li><a href="{{ url('/system/') }}">角色管理</a></li>
                        <li class="active">【{{$role_info->name}}】Url权限设置</li>
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
                                <div id="myTabContent" class="tab-content">
                                    <div class="bootstrap-table">
                                        <div class="tab-pane fade in active" id="home">
                                            <div id="toolbar">
                                                <form id="form" method="post" class="form-horizontal" action="/roles/saveRolePrivilege">
                                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                    <input type="hidden" name="role_id" value="{{$role_info->id}}">
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">
                                                            选择栏目
                                                        </label>
                                                        <div class="col-sm-10">
                                                            <select class="select_input menu_id" name="menu_id" id="menu_id">
                                                                <option value="0">请选择</option>
                                                                @foreach($menus_list as $l)
                                                                    <option value="{{$l['id']}}">{{$l['catname']}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="hr-line-dashed"></div>
                                                    {{--//子栏目--}}
                                                    <div class="form-group" id="smenus">

                                                    </div>
                                                    <div class="hr-line-dashed"></div>

                                                    <div class="form-group">
                                                        <div class="col-sm-4 col-sm-offset-2" id="submut_div">
                                                            <button class="btn btn-info" type="submit" >保 存</button>
                                                            <button class="btn btn-white" type="button" onclick="history.go(-1);">取 消</button>
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{--上下区分--}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-white">
                            <div class="panel-body">
                                <div id="myTabContent" class="tab-content">
                                    <div class="bootstrap-table">
                                        <div class="tab-pane fade in active" id="home">
                                            <div id="toolbar">
                                                角色->【{{$role_info->name}}】
                                            </div>
                                            <div class="fixed-table-container" style="margin-top:10px">
                                                <table class="table table-striped ">
                                                    <thead>
                                                    <tr>
                                                        <th><div class="th-inner ">所属栏目</div></th>
                                                        <th><div class="th-inner ">url权限名称</div></th>
                                                        <th><div class="th-inner ">URL路径</div></th>
                                                        <th><div class="th-inner ">更新日期</div></th>
                                                        <th><div class="th-inner ">创建日期</div></th>
                                                        <th><div class="th-inner ">操作</div></th>
                                                    </tr>
                                                    @if(count($list)>0)
                                                        <tbody>
                                                        @foreach($list as $l)
                                                            <tr>
                                                                <td>{{$l->menus->catname}}</td>
                                                                <td>{{$l->privilege->privilege_name}}</td>
                                                                <td>{{$l->privilege->path}}</td>
                                                                <td>{{$l->created_at}}</td>
                                                                <td>{{$l->updated_at}}</td>
                                                                <td>
                                                                    <button class="btn btn-primary btn-xs" onclick="deleteRoleAuthority('{{$l->roleAuthority_id}}')" type="button">删除</button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end: PAGE CONTENT-->
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

    <!-- end: CORE JAVASCRIPTS  -->
    <script>
        var roles_id ={{$role_info->id}};
        var is_pop = @if (session('is_pop')){{session('is_pop')}}@else 0 @endif ;
        var post_token="<?php echo csrf_token(); ?>";
        $(document).ready(function () {
            if (is_pop > 0) {
                pop_template(is_pop);
            }
        });
        jQuery(document).ready(function() {
            Main.init();
            status();
        });
        //删除
        function deleteRoleAuthority(roleAuthority_id){
            swal({
                title: "确认删除吗",
                text: '',
                showCancelButton: true,
                closeOnConfirm: true,
                animation: "slide-from-top"
            },function(){
                $.ajax({
                    async:false,
                    type:'POST',
                    url:'/roles/deleteRoleAuthority',
                    dataType:'json',
                    data:{roleAuthority_id:roleAuthority_id,_token:post_token},
                    success: function(data)
                    {
                        if(data['code'] != 0)
                        {
                            pop('提示',data['msg'],3);
                            return false;
                        }
                        window.location.reload();
                        pop('提示','删除成功',1);
                    },
                    error : function() {
                        pop('提示','网络异常',3)
                    }
                });
            });
        }


        //全选/反选
        $('#select_all').click(function(){
        });

        function select_all(){
            var is=$('#select_all').is(':checked');
            if(is){
                $('#smenus').find('input').prop("checked",true);
            }else{
                $('#smenus').find('input').prop("checked",false);
            }
        }

        //栏目查询出权限节点列表
        $('.menu_id').change(function(){
            var menu_id= $(".menu_id").val();
            if(menu_id==0){
                return false;
            }
            $.blockUI({
                message:'<i class="fa fa-spinner fa-spin"></i> '
            });
            $.ajax({
                type:'POST',
                url:'/system/privilege/findPrivilegeListByMenuId',
                data:{menu_id:menu_id,roles_id:roles_id},
                dataType:'json',
                headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')},
                success: function(json) {
                    if(json['code'] == 0){
                        var list=json['data'];
                        var tab = ' <label class="col-sm-2 control-label"> 权限节点 </label><div class="col-sm-10">' +
                                '<span style="float: left;padding-right: 15px;">' +
                                '<label><input type="checkbox" id="select_all" /> 全选</label> </span>';
                        var aa = [];
                        list.forEach(function(m){
                            tab += '<span style="float: left;line-height:22px;padding-top:0;padding-right: 15px; " class="checkbox"><label><input ';
                            if(m["is_select"]==1){
                                tab += ' checked="checked" ';
                            }
                            tab += ' type="checkbox" name="privilege_id[]" id="privilege_id" value="' + m["id"] + '" />' + m["privilege_name"] + '</label></span>';
                        })
                        tab += '</div>';
                        $('#smenus').empty();
                        $('#smenus').append(tab);
                        $('#smenus').find('#select_all').on('click',select_all);
                        $.unblockUI();
                    }


                }
            });
        });
        function findMenusListByPid(menu_id) {

        }
    </script>
@endsection