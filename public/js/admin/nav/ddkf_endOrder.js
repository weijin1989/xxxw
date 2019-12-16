var Ddkf_endOrder = function (){
    "use strict";
    var arr;
    var orderTable = function () {
        $('#orderTable').bootstrapTable({
            method: 'get',
            url: '/ddkf/order',
            toolbar: '#toolbar',
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
        $('#orderTable').on('check.bs.table uncheck.bs.table ' +
            'check-all.bs.table uncheck-all.bs.table', function () {
            $('#toolbar .orderPromising').prop('disabled', !$('#orderTable').bootstrapTable('getSelections').length);
        });
    };
    var myOrderTable = function () {
        $('#myOrderTable').bootstrapTable({
            method: 'get',
            url: '/ddkf/myEndOrder',
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
            $('#myToolbar .orderdelete').prop('disabled', !$('#myOrderTable').bootstrapTable('getSelections').length);
            $('#myToolbar .ordermove').prop('disabled', !$('#myOrderTable').bootstrapTable('getSelections').length);
        });
    };

    var queryParams = function (params) {
        params.order_no    = $('#order_noID').val();
        params.wxname    = $('.wxname').val();
        params.beneficiary    = $('.beneficiary').val();
        params.status_name    = $('.status_name').val();
        params.delay    	= $('.delay').val();
        params.starttime    = $('.starttime').val();
        params.endtime    	= $('.endtime').val();
        params.province    	= $('.province').val();
        return params;
    };
    var refresh = function(){
        $('.searchMember').on('click',function(){
            $('#myOrderTable').bootstrapTable('refresh');
        });
    };

    var processing = function(){
        $('#myToolbar .orderPromising').off().on("click", function () {
            arr = $('#myOrderTable').bootstrapTable('getSelections');
            location.href = '/ddkf/order_view/'+arr['0']['order_no'];
        });
        $(".close-subview-button").off().on("click", function(e) {
            $(".close-subviews").trigger("click");
            e.preventDefault();
        });
    };
    var refreshTable = function(){
        $('#toolbar .refresh').on('click',function(){
             $('#orderTable').bootstrapTable('refresh');
             $('#toolbar .orderPromising').prop('disabled',true);
        });
        $('#myToolbar .refresh').on('click',function(){
             $('#myOrderTable').bootstrapTable('refresh');
             $('#myToolbar .orderPromising').prop('disabled',true);
             $('#myToolbar .orderdelete').prop('disabled',true);
             $('#myToolbar .ordermove').prop('disabled',true);
        });
    };
    return {
        init: function (){
            processing();
            myOrderTable();
            refreshTable();
            refresh();
       }
    }
}();