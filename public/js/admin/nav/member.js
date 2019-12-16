/**
 * Created by user on 2016/3/11.
 */
var member = function () {
    var arr;
    "use strict";
    // delete start
    //树结构加载
    //var memberztree = function () {
    //    var setting = {
    //        async: {
    //            enable: true,
    //            url:"/member/tree",
    //            autoParam:["id=id", "wxname=wxname", "tel=telephone"],
    //            otherParam:{"_token":$('meta[name="_token"]').attr('content')},
    //            dataFilter: filter
    //        },
    //        data: {
    //            simpleData: {
    //                enable: true
    //            }
    //        }
    //
    //    };
    //
    //    function filter(treeId, parentNode, childNodes) {
    //        if (!childNodes) return null;
    //        for (var i=0, l=childNodes.length; i<l; i++) {
    //            childNodes[i].name = childNodes[i].name.replace(/\.n/g, '.');
    //        }
    //        return childNodes;
    //    }
    //    $(document).ready(function(){
    //        $.fn.zTree.init($("#treeDemo"), setting);
    //    });
    //};


    var doReadPeople = function (id) {
        $.ajax({
            type:'POST',
            url:'/member/list',
            data: {id:id},
            dataType:'json',
            headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')},
            success:function (msg) {
                $('#memberTable').bootstrapTable('removeAll');
                $('#memberTable').bootstrapTable('append',msg['row']);
                $('.details').prop('disabled', 1);
                $('.details_up').prop('disabled', 1);
                $('.see').prop('disabled',1);
                $('.member-list a,i').remove();
            }
        });
    };
    // deleteend
    var memberTable = function () {
        $('#memberTable').bootstrapTable({
            toolbar:"#toolbar",
            cache: false,
            striped: true,
            selectItemName:"radioName",
            pagination: true,
            pageList: [10,20,50,100],
            pageSize:10,
            pageNumber:1,
            clickToSelect: true
        });
        $('#memberTable').on('check.bs.table uncheck.bs.table ' + 'check-all.bs.table uncheck-all.bs.table', function () {
            $('.details').prop('disabled', !$('#memberTable').bootstrapTable('getSelections').length);
            $('.details_up').prop('disabled', !$('#memberTable').bootstrapTable('getSelections').length);
            $('.see').prop('disabled',!$('#memberTable').bootstrapTable('getSelections').length);
            $('.recharge').prop('disabled',!$('#memberTable').bootstrapTable('getSelections').length);
            $('.moveMember').prop('disabled',!$('#memberTable').bootstrapTable('getSelections').length);
        });
    };
    var queryParams = function (params) {
        $('.details').prop('disabled', true);
        return params;
    };
    var memberDetails = function () {
        $('.details').off().on("click", function () {
            var arr = $('#memberTable').bootstrapTable('getSelections');
            memberAjax(arr[0]['id'],arr[0]['wxname'],true);
        });
        $('.member-list').on('click','.breakpoints',function(e){
            e.preventDefault();
            var id = $(this).attr('name');
            var name = $(this).text();
            $(this).nextAll().remove();
            $(this).parent().append(' <i class="fa fa-angle-double-right"></i> ');
            memberAjax(id,name,false);
        });
    };
    function memberAjax(id,name,bool) {
        $.ajax({
            type:'POST',
            url:'/member/detailsData',
            data: {id:id},
            dataType:'json',
            headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')},
            success:function (msg) {
                if(msg != 'empty') {
                    if (bool) {
                        $('.member-list').html($('.member-list').html() + '<a name="' + id + '" class="breakpoints" href="javascript:void(0);">' + name + '</a> <i class="fa fa-angle-double-right"></i> ');
                    }
                    $('#memberTable').bootstrapTable('removeAll');
                    $('#memberTable').bootstrapTable('append', msg);
                    $('.details').attr('disabled', 'disabled');
                    $('.details_up').attr('disabled', 'disabled');
                    $('.see').attr('disabled',1);
                }
            }
        });
    }
    //var memberInit = function () {
    //    memberAjax('0','null',false);
    //    memberUPAjax('0','null',false);
    //};

    //上级会员
    var memberDetailsUp = function () {
        $('.details_up').off().on("click", function () {
            var arr = $('#memberTable').bootstrapTable('getSelections');
            memberUpAjax(arr[0]['id'],arr[0]['wxname'],true);
        });
        $('.member-list').on('click','.breakpoints',function(e){
            e.preventDefault();
            var id = $(this).attr('name');
            var name = $(this).text();
            $(this).nextAll().remove();
            $(this).parent().append(' <i class="fa fa-angle-double-right"></i> ');
            memberUpAjax(id,name,false);
        });
    };
    function memberUpAjax(id,name,bool) {
        $.ajax({
            type:'POST',
            url:'/member/detailsDataUp',
            data: {id:id},
            dataType:'json',
            headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')},
            success:function (msg) {
                if(msg != 'empty') {
                    if (bool) {
                        $('.member-list').html($('.member-list').html() + '<a name="' + id + '" class="breakpoints" href="javascript:void(0);">' + name + '</a> <i class="fa fa-angle-double-right"></i> ');
                    }
                    $('#memberTable').bootstrapTable('removeAll');
                    $('#memberTable').bootstrapTable('append', msg);
                    $('.details').attr('disabled', 'disabled');
                    $('.details_up').attr('disabled', 'disabled');
                    $('.see').attr('disabled',1);
                }
            }
        });
    }
    var memberInit = function () {
        memberAjax('0','null',false);
        memberUpAjax('0','null',false);

    };


    var searchMember = function () {
        $('.searchMember').on('click',function(){
            var wxname = $('.wxname').val().trim();
            var tel = $('.tel').val().trim();
            $.ajax({
                type:'POST',
                url:'/member/detailsData',
                data: {wxname:wxname,tel:tel},
                dataType:'json',
                headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')},
                success:function (msg) {
                    if(msg != 'empty') {
                        $('#memberTable').bootstrapTable('removeAll');
                        $('#memberTable').bootstrapTable('append', msg);
                        $('.details').attr('disabled', 'disabled');
                        $('.see').attr('disabled',1);
                        $('.member-list a,i').remove();
                    }
                }
            });
        });
    };
    var runSubview = function () {
        arr = $('#memberTable').bootstrapTable('getSelections');
        $('.see').off().on("click", function () {
            $.subview({
                content: '#erweima',
                startFrom: "right",
                onShow: function () {
                    $('#erweimaContent').load('/member/details',function() {
                        arr = $('#memberTable').bootstrapTable('getSelections');
                        $.ajax({
                            type:'POST',
                            url:'/member/see',
                            data: {id:arr['0']['id']},
                            dataType:'json',
                            headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')},
                            success:function (msg) {
                                for(var i in msg){
                                    $('.'+i).html(msg[i]);
                                }
                            }
                        });
                    });
                },
                onClose: function () {
                    $.hideSubview();
                    $('#erweimaContent img').remove();
                },
                onHide: function () {}
            });
        });
        $('.moveMember').off().on("click", function () {
            $.subview({
                content: '#moveMember',
                startFrom: "right",
                onShow: function () {
                    arr = $('#memberTable').bootstrapTable('getSelections');
                    $('.hiddenid').val(arr[0].id);
                },
                onClose: function () {
                    $.hideSubview();
                    $('#moveMember').css('display','none');
                    $('.moveMemberInput').val('');
                },
                onHide: function () {}
            });
        });
        $('.recharge').off().on('click',function(){
            $.subview({
                content: '#recharge',
                startFrom: "right",
                onShow: function () {
                    arr = $('#memberTable').bootstrapTable('getSelections');
                    // $('.rechargeWxname').text('微信名：'+arr['0']['wxname']);
                },
                onClose: function () {
                    $.hideSubview();
                    $('#recharge').css('display','none');
                    $('.rechargeInput').val('');
                    $('.rechargeWxname').text('');
                },
                onHide: function () {}
            });
        })
        $(".close-subview-button").off().on("click", function(e) {
            $(".close-subviews").trigger("click");
            e.preventDefault();
        });
    };
    var rechargeValidation = function () {
        var formRecharge = $('.form-recharge');
        var errorHandler1 = $('.errorHandler',formRecharge);
        var successHandler1 = $('.successHandler', formRecharge);
        formRecharge.validate({
            errorElement: "span",
            errorClass: 'help-block',
            errorPlacement: function(error, element) {
                element.parent().parent().find('label').append(error);
            },
            ignore: "",
            rules: {
                recharge : {
                    required: true
                }
            },
            messages: {
                recharge :{
                    required : '不能为空'
                } 
            },
            submitHandler : function(form) {
                errorHandler1.hide();
                $.blockUI({
                    message:'<i class="fa fa-spinner fa-spin"></i> 正在提交数据...'
                });
                var number = $('.rechargeInput').val();
                var info   = $('.rechargeInfoInput').val();
                $.ajax({
                    type:'POST',
                    url:'/member/recharge',
                    data:{uid:arr['0']['id'],number : number,info:info },
                    dataType:'json',
                    headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')},
                    success: function(msg) {
                        if(msg){
                            $.unblockUI();
                            $.hideSubview();
                            $('#recharge').css('display','none');
                            $('.rechargeInput').val('');
                            $('.rechargeWxname').text('');
                        }
                    }
                });
            },
            invalidHandler : function(event, validator) {//display error alert on form submit
                errorHandler1.show();
            }
        });
    };
    var moveMemberValidation = function(){
        var fromMoveMember = $('.form-moveMember');
        var errorHandler1 = $('.errorHandler',fromMoveMember);
        var successHandler1 = $('.successHandler', fromMoveMember);
        fromMoveMember.validate({
            errorElement: "span",
            errorClass: 'help-block',
            errorPlacement: function(error, element) {
                element.parent().parent().find('label').append(error);
            },
            ignore: "",
            rules: {
                moveMember : {
                    required: true
                }
            },
            messages: {
                moveMember :{
                    required : '不能为空'
                } 
            },
            submitHandler : function(form) {
                errorHandler1.hide();
                $.blockUI({
                    message:'<i class="fa fa-spinner fa-spin"></i> 正在提交数据...'
                });
                var id = $('.moveMemberInput').val();
                var mvId = $('.hiddenid').val();
                $.ajax({
                    type:'POST',
                    url:'/member/moveMember',
                    data:{id:id,mvId:mvId},
                    dataType:'json',
                    headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')},
                    success: function(msg) {
                        $.unblockUI();
                        $.hideSubview();
                        $('#moveMember').css('display','none');
                    }
                });
            },
            invalidHandler : function(event, validator) {//display error alert on form submit
                errorHandler1.show();
            }
        });

    };

    return {
        init: function () {
            memberTable();
            memberDetails();
            memberDetailsUp();
            moveMemberValidation();
            runSubview();
            memberInit();
            searchMember();
            rechargeValidation();
            //memberztree();
        }
    };
}();