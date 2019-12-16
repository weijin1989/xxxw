/**
 * Created by user on 2016/3/11.
 */
var recharge = function () {
    var arr;
    "use strict";
    var memberTable = function () {
        $('#memberTable').bootstrapTable({
            toolbar:"#toolbar1",
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
            //$('.details').prop('disabled', !$('#memberTable').bootstrapTable('getSelections').length);
            $('.recharge').prop('disabled',!$('#memberTable').bootstrapTable('getSelections').length);
        });
    };

    //var rechargeTable = function () {
    //    $('#rechargeTable').bootstrapTable({
    //        toolbar:"#toolbar2",
    //        cache: false,
    //        striped: true,
    //        pagination: true,
    //        pageList: [10,20,50,100],
    //        pageSize:10,
    //        pageNumber:1,
    //        clickToSelect: true
    //    });
    //    //$('#rechargeTable').on('check.bs.table uncheck.bs.table ' + 'check-all.bs.table uncheck-all.bs.table', function () {
    //    //    //$('.recharge').prop('disabled',!$('#rechargeTable').bootstrapTable('getSelections').length);
    //    //});
    //};


    var queryParams = function (params) {
        $('.details').prop('disabled', true);
        return params;
    };

    var memberDetails = function () {
        $('.details').off().on("click", function () {
            var arr = $('#memberTable').bootstrapTable('getSelections');
            memberAjax(arr[0]['id'],arr[0]['wxname'],true);
        });
        //$('.member-list').on('click','.breakpoints',function(e){
        //    e.preventDefault();
        //    var id = $(this).attr('name');
        //    var name = $(this).text();
        //    $(this).nextAll().remove();
        //    $(this).parent().append(' <i class="fa fa-angle-double-right"></i> ');
        //    memberAjax(id,name,false);
        //});
    };

    function memberAjax(id,name,bool) {
        $.ajax({
            type:'POST',
            url:'/integralManage/detailsData',
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
                    $('.seeImage').attr('disabled',1);
                }
            }
        });
    }

    function rechargeAjax(wxname,tel,status) {
        $.ajax({
            type:'POST',
            url:'/integralManage/detailsData',
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
                    $('.seeImage').attr('disabled',1);
                }
            }
        });
    }

    var memberInit = function () {

    };

    var searchMember = function () {
        $('.searchMember').on('click',function(){
            var wxname = $('.wxname').val().trim();
            var tel = $('.tel').val().trim();
            if(wxname=="" && tel==""){
                pop('提示','请输入查询条件',3)
            }else{
                $.ajax({
                    type:'POST',
                    url:'/integralManage/detailsData',
                    data: {wxname:wxname,tel:tel},
                    dataType:'json',
                    headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')},
                    success:function (msg) {
                        if(msg != 'empty') {
                            $('#memberTable').bootstrapTable('removeAll');
                            $('#memberTable').bootstrapTable('append', msg);
                            $('.details').attr('disabled', 'disabled');
                            $('.seeImage').attr('disabled',1);
                            $('.member-list a,i').remove();
                        }
                    }
                });

            }
        });
    };

    var runSubview = function () {
        arr = $('#memberTable').bootstrapTable('getSelections');
        $('.seeImage').off().on("click", function () {
            $.subview({
                content: '#erweima',
                startFrom: "right",
                onShow: function () {
                    $('#erweimaContent').load('/member/details',function() {
                        arr = $('#memberTable').bootstrapTable('getSelections');
                        $.ajax({
                            type:'POST',
                            url:'/integralManage/seeImage',
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
                    url:'/integralManage/recharge',
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
    return {
        init: function () {
            memberTable();
            //memberDetails();
            //runSubview();
            //memberInit();
            //searchMember();
            //rechargeValidation();
            //rechargeTable();
        }
    };
}();