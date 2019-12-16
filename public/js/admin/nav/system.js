var system = function () {
    "use strict";
    var subViewElement, subViewContent;
    var username = $('.username').text();
    var usertable = function (){
        $('#usertable').bootstrapTable({
            method:'get',
            url: '/system/data',
            toolbar:"#toolbar",
            cache: false,
            striped: true,
            selectItemName:"radioName",
            pagination: true,
            pageList: [10,20,50,100],
            pageSize:10,
            pageNumber:1,
            search: true,
            sidePagination:'server',
            queryParams: queryParams,
            showColumns: true,
            clickToSelect: true
        });
        $('#large-columns-table').next().click(function () {
            $(this).hide();
            buildTable($('#usertable'), 50, 50);
        });
        $('#usertable').on('check.bs.table uncheck.bs.table ' +
            'check-all.bs.table uncheck-all.bs.table', function () {
            $('.edit-user').prop('disabled', !$('#usertable').bootstrapTable('getSelections').length);
            $('.reset-user').prop('disabled', !$('#usertable').bootstrapTable('getSelections').length);
        });
    };
    var queryParams = function(params) {
        $('.edit-user').prop('disabled',true);
        $('.reset-user').prop('disabled',true);
        return params
    };
    var checkAddUser = function() {
        bootbox.confirm({
            buttons:{cancel:{label:"取消"}, confirm:{label:"确认"}},
            message:"您没有保存该记录，确定关闭吗?",
            callback:function(result) {
                if (result) {
                    $('#formAdduserDiv div').remove();
                    $('.form-adduser .pull-right').css('display','none');
                    $.hideSubview();
                }
            }
        });
    };
    var checkEditUser = function () {
        bootbox.confirm({
            buttons:{cancel:{label:"取消"}, confirm:{label:"确认"}},
            message:"您没有保存该记录，确定关闭吗?",
            callback:function(result) {
                if (result) {
                    $('#formEdituserDiv div').remove();
                    $('.form-edituser .pull-right').css('display','none');
                    $.hideSubview();
                }
            }
        });
    };
    var checkResetUser = function () {
        bootbox.confirm({
            buttons:{cancel:{label:"取消"}, confirm:{label:"确认"}},
            message:"您没有保存该记录，确定关闭吗?",
            callback:function(result) {
                if (result) {
                    $('#formResetuserDiv div').remove();
                    $('.form-resetuser .pull-right').css('display','none');
                    $.hideSubview();
                }
            }
        });
    };
    var runSubviews = function () {
        $('.new-user').off().on("click",function() {
            subViewElement = $(this);
            subViewContent = subViewElement.attr('href');
            $.subview({
                content: subViewContent,
                startFrom: "right",
                onShow: function() {
                    $('#formAdduserDiv').load("/system/add",function(){
                        doAddUserSth();
                        ajaxInterlock(3,$('.province'));
                    });
                },
                onClose: function() {
                    checkAddUser();
                },
                onHide: function() {

                }
            });
        });
        $('.edit-user').off().on("click",function() {
            subViewElement = $(this);
            subViewContent = '#editUser';
            $.subview({
                content: subViewContent,
                startFrom: "right",
                onShow: function() {
                    $.blockUI({
                        message:'<i class="fa fa-spinner fa-spin"></i> 加载数据中...'
                    });
                    $("#formEdituserDiv").load("/system/edit",function(){
                        doEditUserSth();
                    });
                },
                onClose: function() {
                    checkEditUser();
                },
                onHide: function() {

                }
            });
        });
        $('.reset-user').off().on("click",function() {
            subViewElement = $(this);
            subViewContent = '#resetUser';
            $.subview({
                content: subViewContent,
                startFrom: "right",
                onShow: function() {
                    $('#formResetuserDiv').load("/system/reset",function(){
                        doResetUserSth();
                    });
                },
                onClose: function() {
                    checkResetUser();
                },
                onHide: function() {

                }
            });
        });
        $(".close-subview-button").off().on("click", function(e) {
            $(".close-subviews").trigger("click");
            e.preventDefault();
        });
    };
    var doAddUserSth = function () {
        $('.form-adduser .pull-right').css('display','');
    };
    var doEditUserSth = function () {
        var arr = $('#usertable').bootstrapTable('getSelections');
        var role,auth;
        switch(arr[0].role){
            case '超级管理员': role = '0'; break;
            case '业务总监': role = '1'; break;
            case '业务经理': role = '2'; break;
            case '业务员': role = '3'; break;
        }
        switch(arr[0].auth){
            case '最高权限': auth = '0'; break;
            case '客服权限': auth = '1'; break;
            case '审核权限': auth = '2'; break;
        }
        $('.form-edituser .email').val(arr[0].email);
        $('.form-edituser .name').val(arr[0].name);
        $('.form-edituser .role').val(role);
        $('.form-edituser .auth').val(auth);
        $('.form-edituser .pull-right').css('display','');
        $.ajax({
            url: '/system/editAddress',
            type: 'POST',
            dataType: 'json',
            headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content') },
            data: {email: arr['0']['email']},
            success : function (msg){
                ajaxInterlock(3,$('.province'),msg['0']);
                ajaxInterlock(msg['0'],$('.city'),msg['1']);
                ajaxInterlock(msg['1'],$('.county'),msg['2']);
            }
        });   
        $.unblockUI();
    };

    var doResetUserSth = function () {
        var arr = $('#usertable').bootstrapTable('getSelections');
        $('.form-resetuser .email').val(arr[0].email);
        $('.form-resetuser .pull-right').css('display','');
    };

    var runAddUserFormValidation = function () {
        var formAddUser = $('.form-adduser');
        var errorHandler1 = $('.errorHandler',formAddUser);
        var successHandler1 = $('.successHandler', formAddUser);
        formAddUser.validate({
            errorElement: "span",
            errorClass: 'help-block',
            errorPlacement: function(error, element) {
                element.parent().parent().find('label').append(error);
            },
            ignore: "",
            rules: {
                role : {
                    required : true
                },
                name : {
                    required : true
                },
                email : {
                    email :true,
                    required :true
                },
                password : {
                    minlength : 6,
                    required :true
                },
                repass : {
                    minlength : 5,
                    equalTo:"#password"
                }
            },
            messages: {
                role : {
                    required : '*角色不能为空'
                },
                name : {
                    required : ' *不能为空'
                },
                email : {
                    email :'请输入正确的email',
                    required :' *不能为空'
                },
                password : {
                    minlength : '至少输入六个字符',
                    required :' *不能为空'
                },
                repass : {
                    minlength : '至少输入六个字符',
                    equalTo:"两次密码不一致"
                }
            },
            submitHandler : function(form) {
                errorHandler1.hide();
                $.blockUI({
                    message:'<i class="fa fa-spinner fa-spin"></i> 正在提交管理员数据...'
                });
                var userToAdd = new Object;
                    userToAdd.email = $('.form-adduser .email').val(),
                    userToAdd.password = $('.form-adduser .password').val(),
                    userToAdd.name = $('.form-adduser .name').val(),
                    userToAdd.role = $('.form-adduser .role').val(),
                    userToAdd.auth = $('.form-adduser .auth').val();
                    //userToAdd.address = $('.form-adduser .province').val() + ',' + $('.form-adduser .city').val()+','+$('.form-adduser .county').val();
                $.ajax({
                    type:'POST',
                    url:'/system/doadd',
                    data:{postdata:userToAdd},
                    dataType:'json',
                    headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content') },
                    success: function(json) {
                        if(json.say == 'ok'){
                            $('#formAdduserDiv div').remove();
                            $('.form-adduser .pull-right').css('display','none');
                            $.hideSubview();
                            toastr.success( username + '添加一个管理员！');
                            $('#usertable').bootstrapTable('refresh');
                        }
                        if(json.say == 'no'){
                            swal('用户名已存在','','warning');
                        }
                        $.unblockUI();
                    }
                });
            },
            invalidHandler : function(event, validator) {//display error alert on form submit
                errorHandler1.show();
            }
        });
    };

    var runEditUserFormValidation = function () {
        var formEditUser = $('.form-edituser');
        var errorHandler2 = $('.errorHandler',formEditUser);
        var successHandler2 = $('.successHandler', formEditUser);
        formEditUser.validate({
            errorElement: "span",
            errorClass: 'help-block',
            errorPlacement: function(error, element) {
                element.parent().parent().find('label').append(error);
            },
            ignore: "",
            rules: {
                role : {
                    required : true
                },
                name : {
                    required : true
                }
            },
            messages:{
                role : {
                    required : '*角色不能为空'
                },
                name : {
                    required : ' *不能为空'
                }
            },
            invalidHandler: function(event, validator) {
                successHandler2.hide();
                errorHandler2.show();
            },
            submitHandler:function(form) {
                successHandler2.show();
                errorHandler2.hide();
                $.blockUI({
                    message: '<i class="fa fa-spinner fa-spin"></i> 正在提交管理员数据...'
                });
                var userToEdit = new Object;
                    userToEdit.email = $('.form-edituser .email').val(),
                    userToEdit.name = $('.form-edituser .name').val(),
                    userToEdit.role = $('.form-edituser .role').val(),
                    userToEdit.auth = $('.form-edituser .auth').val();
                    //userToEdit.address = $('.form-edituser .province').val()+','+$('.form-edituser .city').val()+','+$('.form-edituser .county').val();
                $.ajax({
                    type:'POST',
                    url:'/system/doedit',
                    data:{postdata:userToEdit},
                    dataType:'json',
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                    },
                    success: function(json){
                        if(json.say == 'ok'){
                            $.hideSubview();
                            toastr.success( username + '修改一条管理员信息');
                            $('#formEdituserDiv div').remove();
                            $('.form-edituser .pull-right').css('display','none');
                            $('#usertable').bootstrapTable('refresh');
                        }
                        $.unblockUI();
                    }
                });
            }
        });
    };
    var runResetUserFormValidation = function () {
        var formResetUser = $('.form-resetuser');
        var errorHandler3 = $('.errorHandler',formResetUser);
        var successHandler3 = $('.successHandler', formResetUser);
        formResetUser.validate({
            errorElement: "span",
            errorClass: 'help-block',
            errorPlacement: function(error, element) {
                element.parent().parent().find('label').append(error);
            },
            ignore: "",
            rules: {
                password : {
                    minlength : 6,
                    required :true
                },
                repass : {
                    minlength : 5,
                    equalTo:"#password"
                }
            },
            messages: {
                password : {
                    minlength : '至少输入六个字符',
                    required :' *不能为空'
                },
                repass : {
                    minlength : '至少输入六个字符',
                    equalTo:"两次密码不一致"
                }
            },
            invalidHandler: function(event, validator) {
                successHandler3.hide();
                errorHandler3.show();
            },
            submitHandler:function(form) {
                successHandler3.show();
                errorHandler3.hide();
                $.blockUI({
                    message: '<i class="fa fa-spinner fa-spin"></i> 正在重置管理员密码...'
                });
                var userToReset = new Object;
                userToReset.email = $('.form-resetuser .email').val(),
                    userToReset.password = $('.form-resetuser .password').val();
                $.ajax({
                    type:'POST',
                    url:'/system/doreset',
                    data:{postdata:userToReset},
                    dataType:'json',
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                    },
                    success: function(json){
                        if(json.say == 'ok'){
                            $.hideSubview();
                            toastr.success( username + '重置一个管理员密码');
                            $('#formResetuserDiv div').remove();
                            $('.form-resetuser .pull-right').css('display','none');
                        }
                        $.unblockUI();
                    }
                });
            }
        });
    };
    var interlock = function(){
        $('#formAdduserDiv,#formEdituserDiv').on('change','.province',function(){
            if($(this).val() != 0){
                ajaxInterlock($(this).val(),$('.city'),0);
            } else {
                $('.city').html('<option value="0">未选择</option>');
                $('.county').html('<option value="0">未选择</option>');
            }
        });
        $('#formAdduserDiv,#formEdituserDiv').on('change','.city',function(){
            if($(this).val() != 0){
                ajaxInterlock($(this).val(),$('.county'),0);
            } else {
                $('.county').html('<option value="0">未选择</option>');
            }
        });
    };
    var ajaxInterlock = function(pid,area,id){
        $.ajax({
          url: '/system/interlock',
          type: 'POST',
          dataType: 'json',
          headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content') },
          data: {pid: pid},
          success: function(msg) {
            var str = '<option value="0">未选择</option>';
            for(var i in msg){
                if(id == msg[i]['id']){
                    str += '<option value="'+msg[i]['id']+'" selected>'+msg[i]['name']+'</option>';                    
                }else {
                    str += '<option value="'+msg[i]['id']+'">'+msg[i]['name']+'</option>';
                }
            }
            area.html(str);
          }
        });
    };  
    return {
        init: function () {
            usertable();
            runSubviews();
            runAddUserFormValidation();
            runEditUserFormValidation();
            runResetUserFormValidation();
            interlock();
        }
    };
}();
