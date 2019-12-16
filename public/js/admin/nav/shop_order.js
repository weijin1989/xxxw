/**
 * Created by weijin on 2016/7/12.
 */

//确认订单
$('.confirm').on('click',function() {
    var url='/shop/shop_list/confirm';
    var ms='确认中...';
    var order_no=$("#order_no").val();
    bootbox.confirm({
        buttons:{cancel:{label:"取消"}, confirm:{label:"确认"}},
        message:"您确认吗?",
        callback:function(result) {
            if(result){
                if(!order_no){
                    return false;
                }
                $.blockUI({
                    message:'<i class="fa fa-spinner fa-spin"></i> '+ms
                });
                $.ajax({
                    type: "post",
                    url: url,
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

//发货并填写物流信息
$('.delivery').on('click',function() {
    var url='/shop/shop_list/delivery';
    var order_no=$("#order_no").val();
    swal({
        title: "填写快递公司+运单号",
        text: '',
        type: 'input',
        showCancelButton: true,
        closeOnConfirm: false,
        animation: "slide-from-top"
    }, function (text) {
        if(!order_no){
            swal('订单号不存在', '', "error");
            return false;
        }
        if(text == false){
            pop('提示','竟然要发货写个订单号呗',3);
            return false;
        }else {
            $.ajax({
                type: "post",
                url: url,
                headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                data: {order_no: order_no, logistics_info: text},
                success: function (data) {
                    if (data['code'] != 0) {
                        swal(data['msg'], '', "error");
                        return false;
                    }
                    swal("提交成功!", '', "success");
                    location.href = '/shop/order_list';

                }
            });
        }
    });
});