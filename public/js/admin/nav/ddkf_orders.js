var Ddkf_all = function (){
    "use strict";
    var subViewElement, subViewContent,status,order_no,openId,pid;
    var arr;

    var all_OrderTable = function () {
        $('#myOrderTable').bootstrapTable({
            method: 'get',
            url: '/ddkf/orders_all',
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
            $('#myToolbar .orderDetails').prop('disabled', !$('#myOrderTable').bootstrapTable('getSelections').length);
            $('#myToolbar .ordermove').prop('disabled', !$('#myOrderTable').bootstrapTable('getSelections').length);

        });
    };
    var queryParams = function (params) {
        var handle_type=$('#handle_type').val();
        params.order_no    = $('#order_noID').val();
        params.province    = $('#provinceID').val();
        params.wxname    = $('.wxname').val();
        params.beneficiary    = $('.beneficiary').val();
        params.car_num    = $('#car_numID').val();
        params.status_name    = $('.status_name').val();
        params.delay    	= $('.delay').val();
        params.starttime    = $('.starttime').val();
        params.endtime    = $('.endtime').val();
        params.salesman    = $('.salesman').val();
        params.auto_uid    = $('.auto_uid').val();
        if(handle_type!=""){
            params.status_name=handle_type;
        }
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
            $('#toolbar .orderDetails').prop('disabled',true);
        });
        $('#myToolbar .refresh').on('click',function(){
            $('#myOrderTable').bootstrapTable('refresh');
            $('#myToolbar .orderDetails').prop('disabled',true);
        });
    };
    //setInterval(function(){
    //    $('#orderTable').bootstrapTable('refresh');
    //    if($('#orderTable').bootstrapTable('getData').length > 0){
    //        $('#chatAudio')[0].play();
    //    }
    //    $('#myOrderTable').bootstrapTable('refresh');
    //},60000);

    var orderView = function(){
        $('#myToolbar .orderDetails').off().on("click", function () {
            arr = $('#myOrderTable').bootstrapTable('getSelections');
//            location.href = '/ddkf/order_view/'+arr['0']['order_no'];
//            window.open('/ddkf/order_view/'+arr['0']['order_no']);
            $("#form_detail").attr("action",'/ddkf/order_view/'+arr['0']['order_no']);
            $("#form_detail").submit();
           
        });
        $(".close-subview-button").off().on("click", function(e) {
            $(".close-subviews").trigger("click");
            e.preventDefault();
        });
    };


    return {
        init: function (){
            all_OrderTable();
            refreshTable();
            orderView();
            refresh();
       }
    }
}();