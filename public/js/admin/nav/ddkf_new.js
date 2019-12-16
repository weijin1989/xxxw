/**
 * Created by weijin on 2016/6/1.
 */

//出单
$('.issue').on('click',function() {
    $('.issue').attr("disabled",true);
    var url='/ddkf/issue';
    var ms='出单中...';
    var plate_num=$("#plate_num").val();
    var frame_num=$("#frame_num").val();
    var engine_num=$("#engine_num").val();
    var certificates_num=$("#certificates_num").val();
    if(payment==2&&order_status==22){//汇款转账and 订单状态为已经上传支付支付凭证 变成待出单
        url='/ddkf/toPay'
        ms='确认中...';
    }else {
        if (plate_num == "" || frame_num == "" || engine_num == "" || certificates_num == "") {
            swal('车牌号、车架号、发动机号、身份证号码不能为空', '', "error");
            return false;
        }
    }
    
    //
    //var policy_no = "";
    //var express_no = "";
    //if($("#app_policy_no").length>0){
	 //   policy_no = $("#app_policy_no").val();
	 //   express_no = $("#app_express_no").val();
    //    $("#policy_no").val(policy_no);
    //}
    
    bootbox.confirm({
        buttons: {cancel: {label: "取消"}, confirm: {label: "确认"}},
        message: "您确定出单吗?",
        callback: function (result) {
            if (result) {
                var order_no = $('#order_no').val();
                if (!order_no) {
                    return false;
                }
                $.blockUI({
                    message: '<i class="fa fa-spinner fa-spin"></i> ' + ms
                });
                $.ajax({
                    type: "post",
                    url: url,
                    headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                    data: {
                        order_no: order_no,
                        //policy_no: policy_no,
                        //express_no: express_no,
                        plate_num: plate_num,
                        frame_num: frame_num,
                        engine_num: engine_num,
                        certificates_num: certificates_num
                    },
                    success: function (data) {
                        if (data['code'] != 0) {
                            swal(data['msg'], '', "error");
                            $.unblockUI();
                            return false;
                        }
                        swal("提交成功!", '', "success");
                        location.href = '/ddkf';

                    }
                });
            }else{
                $('.issue').removeAttr("disabled");
            }
        }
    });
});

$('.save_info').on('click',function() {//点击打回弹出框输入信息提交
    var plate_num=$("#plate_num").val();
    var frame_num=$("#frame_num").val();
    var engine_num=$("#engine_num").val();
    var certificates_num=$("#certificates_num").val();
    var order_no=$('#order_no').val();
    var brand=$('#brand').val();

    var beneficiary=$('#beneficiary').val();
    var beneficiary_tel=$('#beneficiary_tel').val();
    var certificates_type=$('#certificates_type').val();

    var express_address=$('#express_address').val();
    var express_name=$('#express_name').val();
    var express_contact=$('#express_contact').val();

    var remarks=$('#remarks').val();
    var kf_remarks=$('#kf_remarks').val();

    var app_express_no=$('#app_express_no').val();
    var app_express_company=$('#app_express_company').val();

    var policy_no=$('#policy_no').val();
    if(!order_no){
        swal('订单号不存在', '', "error");
        return false;
    }
    //if (plate_num == "" || frame_num == "" || engine_num == "" || certificates_num == "") {
    //    swal('车牌号、车架号、发动机号、身份证号码不能为空', '', "error");
    //    return false;
    //}
    //save_info();
    $.blockUI({
        message:'<i class="fa fa-spinner fa-spin"></i> 提交中...'
    });
    $.ajax({
        type: "post",
        url: '/ddkf/save_info',
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
        data: {order_no: order_no,plate_num:plate_num,frame_num:frame_num,engine_num:engine_num,certificates_num:certificates_num,brand:brand
            ,beneficiary:beneficiary,beneficiary_tel:beneficiary_tel,certificates_type:certificates_type,express_address:express_address
            ,express_name:express_name,express_contact:express_contact,kf_remarks:kf_remarks,remarks:remarks,policy_no:policy_no,
            app_express_no:app_express_no,app_express_company:app_express_company
        },
        success: function (data) {
            if(data['code']!=0){
                swal(data['msg'], '', "error");
                $.unblockUI();
                return false;
            }
            swal("提交成功!", '', "success");
            location.reload();

        }
    });
});

$('.audit').on('click',function() {//点击通过审核
    var order_no=$('#order_no').val();
    if(!order_no){
        swal('订单号不存在', '', "error");
        return false;
    }

    bootbox.confirm({
        buttons:{cancel:{label:"取消"}, confirm:{label:"确认"}},
        message:"您确定通过审核吗?",
        callback:function(result) {
            if(result){
                var order_no=$('#order_no').val();
                if(!order_no){
                    return false;
                }
                $.blockUI({
                    message:'<i class="fa fa-spinner fa-spin"></i> 提交中... '
                });
                $.ajax({
                    type: "post",
                    url: '/ddkf/audit',
                    headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                    data: {order_no: order_no},
                    success: function (data) {
                        if(data['code']!=0){
                            swal(data['msg'], '', "error");
                            $.unblockUI();
                            return false;
                        }
                        swal("提交成功!", '', "success");
                        //location.reload();

                        location.href ='/ddkf';
                    }
                });
            }
        }
    });
});

$('.order_over').on('click',function() {//点击通过审核
	var order_no=$('#order_no').val();
	if(!order_no){
		swal('订单号不存在', '', "error");
		return false;
	}
	
	bootbox.confirm({
		buttons:{cancel:{label:"取消"}, confirm:{label:"确认"}},
		message:"您确定要修改为已结单吗?",
		callback:function(result) {
			if(result){
				var order_no=$('#order_no').val();
				if(!order_no){
					return false;
				}
				$.blockUI({
					message:'<i class="fa fa-spinner fa-spin"></i> 提交中... '
				});
				$.ajax({
					type: "post",
					url: '/ddkf/order_over',
					headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
					data: {order_no: order_no},
					success: function (data) {
						if(data['code']!=0){
							swal(data['msg'], '', "error");
							$.unblockUI();
							return false;
						}
						swal("提交成功!", '', "success");
						//location.reload();
						
						location.href ='/ddkf';
					}
				});
			}
		}
	});
});

$('.app_express_no_save').on('click',function() {//点击保存保单号、快递公司、快递单号
	var order_no=$('#order_no').val();
	var express_no=$('#app_express_no').val();
	var app_express_company=$('#app_express_company').val();
	var app_policy_no=$('#app_policy_no').val();
	if(!order_no){
		swal('订单号不存在', '', "error");
		return false;
	}
	if(!express_no){
		swal('快递单号不能为空', '', "error");
		return false;
	}
	
	bootbox.confirm({
		buttons:{cancel:{label:"取消"}, confirm:{label:"确认"}},
		message:"您确定要快递单号并且给客户推送消息吗?",
		callback:function(result) {
			if(result){
				var order_no=$('#order_no').val();
				var express_no=$('#app_express_no').val();
				if(!order_no){
					return false;
				}
				$.blockUI({
					message:'<i class="fa fa-spinner fa-spin"></i> 提交中... '
				});
				$.ajax({
					type: "post",
					url: '/ddkf/express_no_save',
					headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
					data: {order_no: order_no, express_no:express_no,express_company:app_express_company,policy_no:app_policy_no},
					success: function (data) {
						if(data['code']!=0){
							swal(data['msg'], '', "error");
							$.unblockUI();
							return false;
						}
						swal("提交成功!", '', "success");
						location.reload();
						
//						location.href ='/ddkf';
					}
				});
			}
		}
	});
});
$('.download').on('click',function() {//点击下载
    var order_no=$('#order_no').val();
    if(!order_no){
        swal('订单号不存在', '', "error");
        return false;
    }
    $.blockUI({
        message:'<i class="fa fa-spinner fa-spin"></i> 下载中... '
    });
    var form = $("<form>");   //定义一个form表单
    form.attr('style', 'display:none');   //在form表单中添加查询参数
    form.attr('target', '');
    form.attr('method', 'post');
    form.attr('action', "/ddkf/compressZip");
    var input1 = $('<input>');
    var input2 = $('<input>');
    input1.attr('type', 'hidden');
    input1.attr('name', 'order_no');
    input1.attr('value', order_no);
    input2.attr('type', 'hidden');
    input2.attr('name', '_token');
    input2.attr('value', $('input[name="_token"]').val());
    $('body').append(form);  //将表单放置在web中
    form.append(input1);   //将查询参数控件提交到表单上
    form.append(input2);   //将查询参数控件提交到表单上
    form.submit();
    $.unblockUI();
});

$('.back_voucher').on('click',function(){//点击打回弹出框输入信息提交
        swal({
            title: "支付凭证打回消息",
            text: '',
            type: 'input',
            showCancelButton: true,
            closeOnConfirm: false,
            animation: "slide-from-top"
        }, function (text) {
            var order_no=$('#order_no').val();
            if(!order_no){
                return false;
            }
            if(text == false){
                return false;
            } else {
                $.ajax({
                    type:'POST',
                    url:'/ddkf/back_voucher',
                    data: {order_no:order_no,text:text},
                    dataType:'json',
                    headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')},
                success:function (data) {
                    if(data){
                        if(data['code']==0){
                            swal("提交成功!", '', "success");
                            location.reload();
                        }else{
                            swal(data['msg'], '', "error");
                        }
                    }
                }
            });
        }
    }
);
});

$('.refund').on('click',function(){//用户申请退款

    swal({
            title: "退款原因",
            text: '',
            type: 'input',
            showCancelButton: true,
            closeOnConfirm: false,
            animation: "slide-from-top"
        }, function (text) {
            var order_no=$('#order_no').val();
            if(!order_no){
                return false;
            }
            if(text == false){
                swal('请填写退款原因', '', "error");
                return false;
            } else {
                $.ajax({
                    type:'POST',
                    url:'/ddkf/refund',
                    data: {order_no:order_no,text:text},
                    dataType:'json',
                    headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')},
                    success:function (data) {
                        if(data){
                            if(data['code']==0){
                                swal("成功提交!", '', "success");
                                location.reload();
                            }else{
                                swal(data['msg'], '', "error");
                            }
                        }
                    }
                });
            }
        }
    );

    //var order_no=$('#order_no').val();
    //if(!order_no){
    //    swal('订单号不存在', '', "error");
    //    return false;
    //}
    //
    //bootbox.confirm({
    //    buttons:{cancel:{label:"取消"}, confirm:{label:"确认"}},
    //    message:"您确定吗?",
    //    callback:function(result) {
    //        if(result){
    //            var order_no=$('#order_no').val();
    //            if(!order_no){
    //                return false;
    //            }
    //            $.blockUI({
    //                message:'<i class="fa fa-spinner fa-spin"></i> 提交中... '
    //            });
    //            $.ajax({
    //                type: "post",
    //                url: '/ddkf/refund',
    //                headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
    //                data: {order_no: order_no},
    //                success: function (data) {
    //                    if(data['code']!=0){
    //                        swal(data['msg'], '', "error");
    //                        $.unblockUI();
    //                        return false;
    //                    }
    //                    swal("提交成功!", '', "success");
    //                    location.reload();
    //
    //                    //location.href ='/ddkf';
    //                }
    //            });
    //        }
    //    }
    //});
});


$('.order_remarks').off().on('click',function(){//点击打回弹出框输入信息提交
        swal({
            title: "订单备注",
            text: '',
            type: 'input',
            showCancelButton: true,
            closeOnConfirm: false,
            animation: "slide-from-top"
        }, function (text) {
            var order_no=$('#order_no').val();
            if(!order_no){
                return false;
            }
            if(text == false){
                return false;
            } else {
                $.ajax({
                    type:'POST',
                    url:'/ddkf/order_remarks',
                    data: {order_no:order_no,text:text},
                    dataType:'json',
                    headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')},
                success:function (data) {
                    if(data){
                        if(data['code']==0){
                            swal("成功提交!", '', "success");
                            location.reload();
                        }else{
                            swal(data['msg'], '', "error");
                        }
                    }
                }
            });
        }
    }
);
});

$('.kf_remarks').off().on('click',function(){//点击打回弹出框输入信息提交
    swal({
            title: "客服订单备注",
            text: '',
            type: 'input',
            showCancelButton: true,
            closeOnConfirm: false,
            animation: "slide-from-top"
        }, function (text) {
            var order_no=$('#order_no').val();
            if(!order_no){
                return false;
            }
            if(text == false){
                return false;
            } else {
                $.ajax({
                    type:'POST',
                    url:'/ddkf/kf_remarks',
                    data: {order_no:order_no,text:text},
                    dataType:'json',
                    headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')},
                    success:function (data) {
                        if(data){
                            if(data['code']==0){
                                swal("成功提交!", '', "success");
                                location.reload();
                            }else{
                                swal(data['msg'], '', "error");
                            }
                        }
                    }
                });
            }
        }
    );
});

$('.edit_jf').click(function(){
    var integral=$('#integral').val();
    var total_integral=$('#total_integral').val();
    var title="总积分为："+total_integral+"<br/>车主返利为："+integral+"<br/>确认修改吗？";
    var content="<table><tr><th>订单总积分：</th><td><input id='edit_total_integral' type='number'></td></tr><tr><th>车主返利积分：</th><td><input id='edit_integral' type='number'></td></tr></table>";
    Popup({
        conTitle:title,//标题字段
        conContent:content,//内容字段
        conStyle:'center',//内容字段样式。left —— 左  center —— 中  right —— right
        conEsc:'取消',//关闭按钮事件
        conConfirm:'提交',//确认按钮文本内容
        conEscEvent:'PopupClose()',//关闭事件
        conConfirmEvent:'eidt_integral()'//确认事件
    });
});

//修改订单积分
function eidt_integral(){
    var integral=$('#edit_integral').val();
    var total_integral=$('#edit_total_integral').val();
    var order_no=$('#order_no').val();
    if(!integral||!total_integral){
        pop('提示','积分不能为空',3);
        return false;
    }
    $.ajax({
        type:'POST',
        url:'/ddkf/eidtIntegral',
        data: {order_no:order_no,integral:integral,total_integral:total_integral},
        dataType:'json',
        headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')},
        success:function (data) {
            if(data){
                if(data['code']==0){
                    swal("成功提交!", '', "success");
                    location.reload();
                }else{
                    swal(data['msg'], '', "error");
                }
            }
        }
    });
}


//弹窗加载
function Popup(popupCon1) {
    var popupCon = {
        conTitle: '111', //标题字段
        conContent: '400-010-6767', //内容字段
        conStyle: 'left', //内容字段样式。left —— 左  center —— 中  right —— right
        conEsc: '111', //关闭按钮事件
        conConfirm: '222', //确认按钮文本内容
        conEscEvent: 'PopupClose()', //关闭事件
        conConfirmEvent: 'PopupClose()' //确认事件
    };
    popupCon = popupCon1;
    $('body').append('<div class="popup_bg"><div class="poput_box"><div class="poput_con"><h3>' + popupCon.conTitle + '</h3><div style="text-align: ' + popupCon.conStyle + ';">' + popupCon.conContent + '</div><a class="poput_esc" onclick="' + popupCon.conEscEvent + ';">' + popupCon.conEsc + '</a><a class="poput_confirm" onclick="' + popupCon.conConfirmEvent + '">' + popupCon.conConfirm + '</a></div></div></div>');


    var pop_top=parseInt($(document).scrollTop())+parseInt($('.poput_box').height());
    $('.poput_box').attr('style','top:'+pop_top+'px');
    $('.popup_bg').height($('body').height());
}
function PopupClose() {
    $('.popup_bg').remove();
}

$('.cancel_refund').click(function(){
    bootbox.confirm({
        buttons:{cancel:{label:"取消"}, confirm:{label:"确认"}},
        message:"确定要取消退款吗?",
        callback:function(result) {
            if(result){
                var order_no=$('#order_no').val();
                if(!order_no){
                    return false;
                }
                $.blockUI({
                    message:'<i class="fa fa-spinner fa-spin"></i> 提交中... '
                });
                $.ajax({
                    type: "post",
                    url: '/ddkf/cancel_refund',
                    headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                    data: {order_no: order_no},
                    success: function (data) {
                        if(data['code']!=0){
                            swal(data['msg'], '', "error");
                            $.unblockUI();
                            return false;
                        }
                        swal("提交成功!", '', "success");
                        location.reload();
                    }
                });
            }
        }
    });
});


$('.order_offer').click(function(){
    bootbox.confirm({
        buttons:{cancel:{label:"取消"}, confirm:{label:"确认"}},
        message:"确定报价吗?",
        callback:function(result) {
            if(result){
                var order_no=$('#order_no').val();
                if(!order_no){
                    return false;
                }
                var plate_num=$('#plate_num').val();
                var frame_num=$('#frame_num').val();
                var engine_num=$('#engine_num').val();
                var brand=$('#brand').val();
                var certificates_num=$('#certificates_num').val();
                if(plate_num==""){
                    alert('车牌号不能为空！');
                    $.unblockUI();
                    return false;
                }
                if(frame_num==""){
                    alert('车架号不能为空！');
                    $.unblockUI();
                    return false;
                }
                if(engine_num==""){
                    alert('发动机号不能为空！');
                    $.unblockUI();
                    return false;
                }
                if(brand==""){
                    alert('车辆品牌不能为空！');
                    $.unblockUI();
                    return false;
                }
                if(certificates_num==""){
                    $.unblockUI();
                    alert('身份证格式不正确！');
                    return false;
                }
                $.blockUI({
                    message:'<i class="fa fa-spinner fa-spin"></i> 提交中... '
                });
                $.ajax({
                    type: "post",
                    url: '/ddkf/order_offer',
                    headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                    data: {order_no: order_no},
                    success: function (data) {
                        if(data['code']!=0){
                            swal(data['msg'], '', "error");
                            $.unblockUI();
                            return false;
                        }
                        $.unblockUI();
                        swal("报价成功!", '', "success");
                        location.reload();
                    }
                });
            }
        }
    });
});