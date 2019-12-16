var memberCount = function () {
	var memberCountTable = function () {
        $('#memberCountTable').bootstrapTable({
            method: 'get',
            url: '/memberCount/data',
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
        params.wxname    = $('.wxname').val();
        params.tel    = $('.tel').val();
        params.city    = $('.city').val();
        return params;
    };
    var refresh = function(){
    	$('.searchMember').on('click',function(){
    		$('#memberCountTable').bootstrapTable('refresh');
    	});
    };
    var exportExcel = function(){
        console.log(123);
    };
    return {
        init:function () {
        	memberCountTable();
        	refresh();
            // exportExcel();
        }
    }
}();