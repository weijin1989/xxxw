var Ddkf = function (){
    "use strict";

    var arr;
    var orderTable = function () {
        $('#orderTable').bootstrapTable({
            method: 'get',
            url: '/statement/statementList',
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

    };
    
    var queryParams = function (params) {
    	 params.starttime    = $('.starttime').val();
         params.endtime    = $('.endtime').val();
         params.wxname    = $('.wxname').val();
         params.tel    = $('.tel').val();
        return params;
    };


    var refresh = function(){
        $('.search').on('click',function(){
        	
            $('#orderTable').bootstrapTable('refresh');
        });
    };






    return {
        init: function (){
            orderTable();
            refresh();
            // imgRotate();
       }
    }
}();