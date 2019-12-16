var Logs = function (){
    "use strict";
    var subViewElement, subViewContent,status,order_no,openId,pid;
    var arr;

    var all_LogsTable = function () {
        $('#myLogsTable').bootstrapTable({
            method: 'get',
            url: '/system/logsList',
            toolbar: '#myToolbar',
            cache: false,
            striped: true,
            selectItemName: 'radioName',
            pagination: true,
            pageList: [15,30,60],
            pageSize: 15,
            pageNumber: 1,
            search: false,
            sidePagination: 'server',
            queryParams: queryParams,
            showColumns: false,
            clickToSelect: true
        });
        $('#myLogsTable').on('check.bs.table uncheck.bs.table ' +
            'check-all.bs.table uncheck-all.bs.table', function () {
            //alert($('#myLogsTable').bootstrapTable('getSelections').length);
            if($('#myLogsTable').bootstrapTable('getSelections')[0].status==40)//用户取消
            {
                return false;
            }
            $('#myToolbar .orderDetails').prop('disabled', !$('#myLogsTable').bootstrapTable('getSelections').length);

        });
    };
    var queryParams = function (params) {
        params.username    = $('#usernameID').val();
        params.contentID    = $('#contentID').val();
        params.starttime    = $('.starttime').val();
        params.endtime    = $('.endtime').val();
        return params;
    };
    var refresh = function(){
        $('.searchMember').on('click',function(){
            $('#myLogsTable').bootstrapTable('refresh');
        });
    };
    var refreshTable = function(){
        $('#toolbar .refresh').on('click',function(){
            $('#orderTable').bootstrapTable('refresh');
            $('#toolbar .orderDetails').prop('disabled',true);
        });
        $('#myToolbar .refresh').on('click',function(){
            $('#myLogsTable').bootstrapTable('refresh');
            $('#myToolbar .orderDetails').prop('disabled',true);
        });
    };



    return {
        init: function (){
            all_LogsTable();
            refreshTable();
            refresh();
       }
    }
}();