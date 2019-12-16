var userChanges = function (){
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
        var starttime=$('#starttime').val();
        $.ajax({
            type: 'POST',
            url: '/statistics/userChanges/data',
            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
            data: {starttime: starttime},
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
                                text:'用户'+msg.date+'注册统计',
                                x:'left'
                            },
                            tooltip: {
                                trigger:'item',
                                formatter:"{a}<br/>本月{b}日:{c}人"
                            },
                            legend: {
                                //show: false,
                                //data: ['当日数量'],
                                data:['当日注册数量','当日新增总数']
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
                                    name :'天',
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
                                    name:'当日注册数量',
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
                                },
                                {
                                    name:'当日新增总数',
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
                                    data: msg.daySubMember.z
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