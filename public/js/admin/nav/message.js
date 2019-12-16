var Ddkf = function (){
    "use strict";

    var arr;
    var orderTable = function () {
        $('#orderTable').bootstrapTable({
            method: 'get',
            url: '/system/messagePhone',
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
    	 params.address    = $('.address').val();
         params.phone    = $('.phone').val();
         params.interMax   = $('.interMax').val();
         params.interMin   = $('.interMin').val();
    	 params.ringMin    = $('.ringMin').val();
         params.ringMax    = $('.ringMax').val();
         params.forceMin   = $('.forceMin').val();
         params.forceMax   = $('.forceMax').val();
         params.pro   = $('.pro').val();
         params.city   = $('.city').val();
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