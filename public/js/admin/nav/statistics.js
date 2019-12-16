var statistics = function (){
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
    var data = function () {
        $.ajax({
            type: 'GET',
            url: '/statistics/data',
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
                                text:'新增会员',
                                x:'center'
                            },
                            tooltip: {
                                trigger:'item',
                                formatter:"{a}<br/>{b}点:{c}人"
                            },
                            legend: {
                                show: false,
                                data: ['每小时增加数量']
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
                                    name :'小时',
                                    type : 'category',
                                    data : msg.daySubMember.x
                                }
                            ],
                            yAxis : [
                                {
                                    name :'人数',
                                    type : 'value'
                                }
                            ],
                            series : [
                                {
                                    name:'新增人数',
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
        }
    }
}();