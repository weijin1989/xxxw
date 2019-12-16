var mCount = function () {
	var memberCountTable = function () {
        $('#memberCountTable').bootstrapTable({
            method: 'get',
            url: '/mCount/data',
            toolbar: '#toolbar',
            cache: false,
            striped: true,
            selectItemName: 'radioName',
            pagination: true,
            pageList: [10, 20, 50, 100],
            pageSize: 10,
            pageNumber: 1,
            search: false,
            sidePagination: 'server',
            queryParams: queryParams,
            showColumns: false,
            clickToSelect: true
        });
        $('#memberCountTable').on('check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table', function () {
            $('.details').prop('disabled', !$('#memberCountTable').bootstrapTable('getSelections').length);
        });
    };
    var queryParams = function (params) {
        return params;
    };
    var refresh = function(){
    	$('.searchMember').on('click',function(){
    		$('#memberCountTable').bootstrapTable('refresh');
    	});
    };

    return {
        init:function () {
        	memberCountTable();
        	refresh();
        }
    }
}();