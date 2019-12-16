var Ddkf_rec = function (){
    "use strict";
    var subViewElement, subViewContent,status,order_no,openId,pid;
    var arr;

    var my_order_recycle = function () {
        $('#myOrderTable').bootstrapTable({
            method: 'get',
            url: '/ddkf/my_order_recycle',
            toolbar: '#myToolbar',
            cache: false,
            striped: true,
            selectItemName: 'radioName',
            pagination: true,
            pageList: [10],
            pageSize: 10,
            pageNumber: 1,
            search: false,
            sidePagination: 'server',
            queryParams: queryParams,
            showColumns: false,
            clickToSelect: true
        });
        $('#myOrderTable').on('check.bs.table uncheck.bs.table ' +
            'check-all.bs.table uncheck-all.bs.table', function () {
            //alert($('#myOrderTable').bootstrapTable('getSelections').length);
            if($('#myOrderTable').bootstrapTable('getSelections')[0].status==40)//用户取消
            {
                return false;
            }
            $('#myToolbar .orderPromising').prop('disabled', !$('#myOrderTable').bootstrapTable('getSelections').length);
            $('#myToolbar .orderrecycle').prop('disabled', !$('#myOrderTable').bootstrapTable('getSelections').length);
        });
    };
    var queryParams = function (params) {
        params.order_no    = $('#order_noID').val();
        params.wxname    = $('.wxname').val();
        params.beneficiary    = $('.beneficiary').val();
        params.status_name    = $('.status_name').val();
        params.starttime    = $('.starttime').val();
        params.endtime    = $('.endtime').val();
        return params;
    };
    var refresh = function(){
        $('.searchMember').on('click',function(){
            $('#myOrderTable').bootstrapTable('refresh');
        });
    };
    var refreshTable = function(){
        $('#toolbar .refresh').on('click',function(){
             $('#orderTable').bootstrapTable('refresh');
             $('#toolbar .orderrecycle').prop('disabled',true);
        });
        $('#myToolbar .refresh').on('click',function(){
             $('#myOrderTable').bootstrapTable('refresh');
             $('#myToolbar .orderrecycle').prop('disabled',true);
             $('#myToolbar .orderdelete').prop('disabled',true);
        });
    };
    //setInterval(function(){
    //    $('#orderTable').bootstrapTable('refresh');
    //    if($('#orderTable').bootstrapTable('getData').length > 0){
    //        $('#chatAudio')[0].play();
    //    }
    //    $('#myOrderTable').bootstrapTable('refresh');
    //},60000);

    //还原
    var orderrecycle = function(){
        $('#myToolbar .orderrecycle').off().on("click", function () {
            arr = $('#myOrderTable').bootstrapTable('getSelections');
            // 删除用户
            swal({
                title: "确认还原该订单吗",
                text: '',
                showCancelButton: true,
                closeOnConfirm: true,
                animation: "slide-from-top"
            },function(){
                //alert(111111);exit;
                $.ajax({
                    async:false,
                    type:'POST',
                    url:'/ddkf/order_recycle',
                    dataType:'json',
                    data:{id:arr['0']['order_no'],_token:post_token},
                    success: function(data)
                    {
                        if(data['code'] != 0)
                        {
                            pop('提示',data['msg'],3);
                            return false;
                        }
                        window.location.reload();
                        pop('提示','还原成功',1);
                    },
                    error : function() {
                        pop('提示','还原失败',3)
                    }
                });
                return false;
            });
        });

    };



    return {
        init: function (){
            my_order_recycle();
            refreshTable();
            orderrecycle();
            refresh();
       }
    }
}();