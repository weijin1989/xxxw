var orderStatistics = function (){
    "use strict";
    var echartsConfig = function () {
        require.config({
            paths:{
                echarts:'/plugins/echarts/build/dist'
            }
        });
    };
    var statisticsTable = function () {
        $('#statisticsTable').bootstrapTable({
            toolbar:"#toolbar",
            cache: false,
            striped: true,
            selectItemName:"radioName",
            pageList: [10,20,50,100],
            pageSize:10,
            pageNumber:1
        });
    };
    var searchMember=function(){
        $('.searchMember').on('click',function(){
            var starttime=$('#starttime').val();
            if(starttime) {
                data();
            }
        });
    };
    var data = function () {
        var provinceID=$('#provinceID').val();
        var starttime=$('#starttime').val();
        $.ajax({
            type: 'POST',
            url: '/statistics/orderSales/data',
            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
            data: {starttime: starttime,province: provinceID},
            success: function (msg) {
                $('#statisticsTable').bootstrapTable('removeAll');
                $('#statisticsTable').bootstrapTable('append',msg['rows']);
                require(
                    [
                        'echarts',
                        'echarts/chart/bar'
                    ],
                    function (ec) {
                        var myChart = ec.init(document.getElementById('bar_charts'));
                        var option = {
                            title:{
                                text:msg.date+'车险销量',
                                x:'center'
                            },
                            tooltip: {
                                trigger:'item',
                                formatter:"{a}<br/>{b}日:{c}单"
                            },
                            legend: {
                                show: false,
                                data: ['每天增加数量']
                            },
                            toolbox: {
                                show : false,
                                feature : {
                                    saveAsImage : {show: true}
                                }
                            },
                            calculable : false,
                            xAxis : [
                                {
                                    name :'日',
                                    type : 'category',
                                    data : msg.daySubMember.x
                                }
                            ],
                            yAxis : [
                                {
                                    name :'订单数',
                                    type : 'value'
                                }
                            ],
                            series : [
                                {
                                    name:'新增订单',
                                    type:'bar',
                                    itemStyle : {
                                        normal : {
                                            label : {
                                                show : true,
                                                position : 'top',
                                                formatter : function(val){
                                                    return val.y;
                                                }
                                            }
                                        }
                                    },
                                    data: msg.daySubMember.y
                                }
                            ],
                            noDataLoadingOption:{
                                text:'暂无数据',
                                effect:'bubble',
                                effectOption : {
                                    effect: {
                                        n: 0
                                    }
                                },
                                textStyle: {
                                    fontSize: 32,
                                    fontWeight: 'bold'
                                }
                            }
                        };
                        myChart.setOption(option);
                    }
                );
            }
        });
    };
    var refresh = function () {
        $('.refresh').on('click',function(){
            data();
        });
    };
    var resize = function() {
        window.onresize = function () {
            data();
        };
    };
    return {
        init : function () {
            statisticsTable();
            echartsConfig();
            data();
            resize();
            refresh();
            searchMember();
        }
    }
}();