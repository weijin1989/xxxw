var Insure = function () {
    var oid;
    "use strict";
    var insureTable = function () {
        $('#insureTable').bootstrapTable({
            method: 'get',
            url: '/insure/data',
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
        $('#insureTable').on('check.bs.table uncheck.bs.table ' +
            'check-all.bs.table uncheck-all.bs.table', function () {
            $('.details').prop('disabled', !$('#insureTable').bootstrapTable('getSelections').length);
        });
    };
    var queryParams = function (params) {
        $('.details').prop('disabled', true);
        params.oid    = $('.oid').val();
        params.czname = $('.czname').val();
        params.tel    = $('.tel').val();
        params.status = $('#orderStatus').val();
        return params;
    };
    var reset = function (){
        $('.btn-reset').on('click',function () {
            $('.oid').val('');
            $('.czname').val('');
            $('.tel').val('');
            $('#orderStatus').val('-1');
            $('#insureTable').bootstrapTable('refresh');
        });
    };
    var searchClick = function(){
        $('.searchCheck').on('click',function(){
           $('#insureTable').bootstrapTable('refresh');
        });
    }
    var runSubviews = function () {
        $('.details').off().on("click", function () {
            $.subview({
                content: '#insureDetails',
                startFrom: "right",
                onShow: function () {
                    $('#insureDetailsContent').load("/insure/details", function () {
                        var arr = $('#insureTable').bootstrapTable('getSelections');
                        oid = arr['0']['oid'];
                        // $('#insureTable').css('display','');
                        $.ajax({
                            type: "POST",
                            url: "/insure/detailsData",
                            headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')},
                            data: {oid:oid},
                            success: function(msg) {
                                // 1 交强险,2优选套餐,3 商业
                               $.each(msg[0],function(index,value){
                                if(index != 'jqx' &&　index != 'qx' && index != 'gxh' && index != 'sy'){
                                    $('#insureDetailsContent .'+index).text(value);
                                    if(index == "xianzhong" && value == "优选套餐"){
                                        for(var i = 0,len = msg[0]['infoData'].length;i < len;i++){
                                            $("<tr style='color:green;'><th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "+msg[0]['infoData'][i].name+"</th><td>"+ msg[0]['infoData'][i].price +"</td></tr>").insertBefore($('.empty'));
                                        }  
                                    }
                                    if(index == 'xianzhong' && value == '个性化'){
                                        var str = '<th>个性化详情</th><td>';
                                        for(var i in msg['0']['gxh_info']){
                                            if(i == 'sysz') {
                                                str += msg['0']['gxh_info'][i]+':';
                                            } else if(i == 'csryx') {
                                                str += msg['0']['gxh_info'][i]+':';
                                            }else if(i == 'csryxck'){
                                                str += msg['0']['gxh_info'][i]+':';
                                            } else if(i == 'blddpsx'){
                                                str += msg['0']['gxh_info'][i]+':';
                                            }  else if(i == 'ssxsssx'){
                                                str += msg['0']['gxh_info'][i]+':';
                                            } else {
                                                str += msg['0']['gxh_info'][i]+'<br />';
                                            }
                                        }
                                        str += '</td>';
                                        $('.empty').html(str);
                                    }
                                }
                               });
                                if(msg['0']['status'] == '等待支付') {
                                    $('.form-details').find('.Payment').css('display','');
                                }
                                if(msg['0']['status'] == '等待出单'){
                                    $('.form-details').find('.chudan').css('display','');
                                }
                                $.each(msg[1],function(index,value){
                                    $('#insureDetailsContent .'+value).remove();
                                });
                                var idpic = '<img style="height:300px;  width:400px; padding:1px;" src="img/'+msg['0']['idpic1']+'" alt="" /><img style="height:300px;  width:400px;padding:1px;" src="img/'+msg['0']['idpic2']+'" alt="" />';
                                var carpic = '<img style="height:300px; width:400px;  padding:1px;" src="img/'+msg['0']['carpic1']+'" alt="" /><img style="height:300px;width:400px;  padding:1px;" src="img/'+msg['0']['carpic2']+'" alt="" />';
                                if(typeof msg['0']['idpic1'] != 'undefined'){
                                    $('#idpic').html(idpic);
                                }
                                if(typeof msg['0']['carpic1'] != 'undefined'){
                                    $('#carpic').html(carpic);
                                }
                            }
                        });
                    });
                },
                onClose: function () {
                    $.hideSubview();
                    $('.form-details').find('.Payment').css('display','none');
                    $('.form-details').find('.chudan').css('display','none');
                },
                onHide: function () {}
            });
        });
        $(".close-subview-button").off().on("click", function(e) {
            $(".close-subviews").trigger("click");
            e.preventDefault();
        });
    };
    var payment = function () {
        $('.form-details .pay').on('click',function() {
            swal({
                title: "线下支付备注信息",
                text: '',
                type: 'input',
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top"
            },
                function (text) {
                    if(text == false){
                        return false;
                    } else {
                        $.ajax({
                            type: "post",
                            url: "/insure/payment",
                            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                            data: {oid: oid, text: text},
                            success: function (msg) {
                                swal("成功提交!", '', "success");
                                $('#insureTable').bootstrapTable('refresh');
                                $('.form-details').find('.Payment').css('display','none');
                                $.hideSubview();
                            }
                        });
                    }
                }
            );
        });
        $('.form-details .chudanbut').on('click',function() {
            bootbox.confirm({
                buttons:{cancel:{label:"取消"}, confirm:{label:"确认"}},
                message:"您确定出单吗?",
                callback:function(result) {
                    if(result){
                        $.ajax({
                            type: "post",
                            url: "/insure/chudan",
                            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                            data: {oid: oid},
                            success: function (msg) {
                                $('#insureTable').bootstrapTable('refresh');
                                $('.form-details').find('.chudan').css('display','none');
                                $.hideSubview();
                            }
                        });
                    }
                }
            });
        });
    };
    return {
        init: function () {
            insureTable();
            runSubviews();
            payment();
            searchClick();
            reset();
        }
    };
}();