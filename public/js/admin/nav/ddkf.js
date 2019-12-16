var Ddkf = function (){
    "use strict";
    var subViewElement, subViewContent,status,order_no,openId,pid;
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
            url: '/ddkf/myOrder',
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
            $('#myToolbar .download').prop('disabled', !$('#myOrderTable').bootstrapTable('getSelections').length);
        });
    };

    var queryParams = function (params) {
        var handle_type=$('#handle_type').val();
        params.order_no    = $('#order_noID').val();
        params.wxname    = $('.wxname').val();
        params.beneficiary    = $('.beneficiary').val();
        params.status_name    = $('.status_name').val();
        params.delay    	= $('.delay').val();
        params.starttime    = $('.starttime').val();
        params.endtime    	= $('.endtime').val();
        params.province    	= $('.province').val();
        params.mobile    	= $('#mobileID').val();
        params.car_num    = $('#car_numID').val();
        if(handle_type!=""){
            params.status_name=handle_type;
        }
        //alert(params.status_name);
        //return false;
        return params;
    };
    var refresh = function(){
        $('.searchMember').on('click',function(){
            $('#myOrderTable').bootstrapTable('refresh');
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
    setInterval(function(){
        $('#orderTable').bootstrapTable('refresh');
        if($('#orderTable').bootstrapTable('getData').length > 0){
            $('#chatAudio')[0].play();
        }
        //$('#myOrderTable').bootstrapTable('refresh');
    },27000);
    var orderPromising = function(){//接单
        $('#toolbar .orderPromising').on('click',function(){
            $.blockUI({
                message:'<i class="fa fa-spinner fa-spin"></i> 接单中...'
            });
            arr = $('#orderTable').bootstrapTable('getSelections');
            $.ajax({
                url: '/ddkf/orderPromising',
                type: 'POST',
                dataType: 'json',
                headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')},
                data: {order_no:arr['0']['order_no'],bool:true},
            }) .done(function(msg) {
                order_no     = msg['data']['order_no'];
                status  = msg['data']['status'];
                openId  = msg['data']['uid'];
                //pid     = msg['data']['pid'];
                if(msg['code'] != 0){
                    swal(msg['msg'],'','warning');
                    $('#orderTable').bootstrapTable('refresh');
                    return false;
                }
                else{
                    location.href = '/ddkf/processing/'+msg['data']['order_no'];
                }
                //if(msg['code'] == -2){
                //    swal('该单已被人接了','','warning');
                //    $('#orderTable').bootstrapTable('refresh');
                //    return false;
                //}

                //orderPromisingSubView(msg);
                //$('#myOrderTable').bootstrapTable('refresh');
                //$('#orderTable').bootstrapTable('refresh');
            });
        });
        $(".close-subview-button").off().on("click", function(e) {
            $(".close-subviews").trigger("click");
            e.preventDefault();
        });
    };
    //移除
    var orderdelete = function(){
        $('#myToolbar .orderdelete').off().on("click", function () {
            arr = $('#myOrderTable').bootstrapTable('getSelections');
            //location.href = '/ddkf/orderdelete/'+arr['0']['order_no'];
            // 删除用户
            swal({
                title: "确认移除该订单吗",
                text: '',
                showCancelButton: true,
                closeOnConfirm: true,
                animation: "slide-from-top"
            },function(){
                //alert(111111);exit;
                $.ajax({
                    async:false,
                    type:'POST',
                    url:'/ddkf/order_delete',
                    dataType:'json',
                    data:{id:arr['0']['order_no'],_token:post_token},
                    success: function(data)
                    {
                        if(data['code'] != 0)
                        {
                            pop('提示',data['msg'],3);
                            return false;
                        }
                        window.location.reload();
                        pop('提示','删除成功',1);
                    },
                    error : function() {
                        pop('提示','删除失败1',3)
                    }
                });
                return false;
            });
        });

    };
    var processing = function(){
        $('#myToolbar .orderPromising').off().on("click", function () {
            arr = $('#myOrderTable').bootstrapTable('getSelections');
            location.href = '/ddkf/processing/'+arr['0']['order_no'];
        });
        $(".close-subview-button").off().on("click", function(e) {
            $(".close-subviews").trigger("click");
            e.preventDefault();
        });
    };
    var addGXH = function(){
        $('.addGXH').off().on('click',function(){
            var xianzhong = $(this).parent().parent().find('input:eq(0)').val();
            var jiaqian = parseFloat($(this).parent().parent().find('input:eq(1)').val()).toFixed(2);
            if(xianzhong && jiaqian){
                $.ajax({
                    type:'POST',
                    url:'/ddkf/addgxh',
                    data:{order_no:order_no,name:xianzhong,price:jiaqian},
                    dataType:'json',
                    headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')},
                    success: function(msg) {
                        if(msg){
                            var bh = $('.individuation tr').length;
                            var str = '<tr><td>'+ bh +'</td><td>'+xianzhong+'</td><td>'+jiaqian+'</td><td><button class="delGXH">删除</button></td> </tr>';
                            $('.individuation').append(str);
                            $('.addGXH').parent().parent().find('input').val('');
                        }
                    }
                });
            } else {
                swal('请填写完全','','warning');
            }
        });
    };
    var delGXH = function() {
        $('.individuation').on('click','.delGXH',function(e){
            e.preventDefault();
            var name = $(this).parent().parent().find('td:eq(1)').text();
            $.ajax({
                type:'POST',
                url:'/ddkf/delgxh',
                data:{order_no:order_no,name:name},
                dataType:'json',
                headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')},
                success: function(msg) {
                    if(msg){
                        $('.individuation tr').remove();
                        $('.individuation').append('<tr> <td>编号</td> <td>险种</td> <td>价钱</td> <td>操作</td> </tr>');
                        for(var i = 0;i < msg.length;i++){
                            var bh = i + 1;
                            var tr = '<tr><td>'+ bh +'</td><td>'+msg[i].name+'</td><td>'+msg[i].price+'</td><td><button class="delGXH">删除</button></td> </tr>';
                            $('.individuation').append(tr);
                        }
                    }
                }
            });
        });
    };
    var processingSubView = function (arr){
        $.subview({
            content: '#buy',
            startFrom: "right",
            onShow: function () {
                $.ajax({
                    type:'POST',
                    url:'/ddkf/detailsData',
                    data: {order_no:arr['0']['order_no']},
                    dataType:'json',
                    headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')},
                }).done(function(msg) {
                    order_no     = msg['order_no'];
                    status  = msg['status'];
                    openId  = msg['uid'];
                    pid     = msg['pid'];
                    $('#buyContent').load('/ddkf/buy',function() {
                        var field = $('#buyContent').find('table').find('td');
                        $(field[5]).text(msg['tel']);
                        $(field[3]).text(msg['bxgs']);
                        $(field[4]).text(msg['szd']);
                        $(field[0]).text(msg['order_no']);
                        $(field[1]).text(msg['wxname']);
                        var parameter = ['旧车','新车'];
                        $(field[6]).text(parameter[msg['isnew']]);
                        var arr = new Array();
                         if(msg['jqx']) {
                            arr.push('交强险');
                            $('#jqxstart').val(msg['jqxstart']);
                            $('#jqxend').val(msg['jqxend']);
                            $('#JQXJG').val(msg['jqxprice']);
                            $('.individuation').remove();
                        } else {
                            $('#jqxstart').parent().parent().parent().remove();
                            $('#jqxend').parent().parent().parent().remove();
                            $('#JQXJG').parent().parent().parent().remove();
                        }
                        if(msg['sysz']) {
                            var array = ['商业:30W','商业:50W','商业:100W'];
                            arr.push(array[msg['sysz']-1]);
                            $('#syszstart').val(msg['systart']);
                            $('#syszend').val(msg['syend']);
                            $('#SYSZJG').val(msg['syszprice']);
                            $('.individuation').remove();
                        } else {
                            $('#syszstart').parent().parent().parent().remove();
                            $('#syszend').parent().parent().parent().remove();
                            $('#SYSZJG').parent().parent().parent().remove();
                        }
                        if(msg['quanxian']) {
                            arr.push('优选套餐');
                            $('#qxstart').val(msg['qxstart']);
                            $('#qxend').val(msg['qxend']);
                            $('#QXJG').val(msg['qxprice']);
                            for(var i = 0; i<msg['infoData'].length;i++){
                                var bh = i + 1;
                                var str = '<tr><td>'+ bh +'</td><td>'+msg['infoData'][i]['name']+'</td><td>'+msg['infoData'][i]['price']+'</td> </tr>';
                                $('.individuation').append(str);
                            }
                        } else {
                            $('#qxstart').parent().parent().parent().remove();
                            $('#qxend').parent().parent().parent().remove();
                            $('#QXJG').parent().parent().parent().remove();
                        }
                        if(msg['gxh']){
                            arr.push('个性化投保');
                            $('#GXHJG').val(msg['gxhprice']);
                            $('#gxhstart').val(msg['gxhstart']);
                            $('#gxhend').val(msg['gxhend']);
                            $('.individuation').remove();
                            for(var i in msg['gxh_info']) {
                                if(i == 'syszsel' || i == 'csryxsel' || i == 'ssxsssxsel' || i == 'csryxcksel' ||  i == 'blddpsxsel'){
                                    $('.'+i).val(msg['gxh_info'][i]);
                                }else if(msg['gxh_info'][i] != '0'){
                                    $('.'+i).attr('checked',1);
                                }
                            };
                        } else {
                            $('.gxhDetails').remove();
                            $('#gxhstart').parent().parent().parent().remove();
                            $('#gxhend').parent().parent().parent().remove();
                            $('#GXHJG').parent().parent().parent().remove();
                        }
                        $('#DSCCS').val(msg['dsccs']);
                        $(field[2]).text(arr.join(','));
                        $('.processing').css('display','');

                        //图片插件
                    $('.image-carpic1').cropit({
                        imageState: {src: '/img/'+msg['carpic1'], }
                    });
                    $('.image-carpic1 .rotate-cw').on('click',function(){
                         $('.image-carpic1').cropit('rotateCW');
                    });
                    var div2 = '<div class="image-carpic2"><div style="clear:both"><h3>行驶本副本</h3></div>'+
                        '<div class="cropit-preview"></div>'+
                        '<div class="image-size-label">  <table style="width:100%"><tr>'+
                    '<td style="width:60px;" align="center">放缩</td>'+
                    '<td><input type="range" class="cropit-image-zoom-input"></td>'+
                    '<td style="width:100px;" align="center"> <button class="rotate-cw " type="button">旋转</button></td></tr> </table>'+
                    '</div>';
                    $('.fourimage').append(div2);
                    $('.image-carpic2').cropit({
                        imageState: {src: '/img/'+msg['carpic2'], }
                    });
                    $('.image-carpic2 .rotate-cw').on('click',function(){
                         $('.image-carpic2').cropit('rotateCW');
                    });
                    var div3 = '<div class="image-idpic1"><div style="clear:both"><h3>身份证正面</h3></div><div class="cropit-preview"></div>'+
                        '<div class="image-size-label">  <table style="width:100%"> <tr> <td style="width:60px;" align="center">放缩</td> <td><input type="range" class="cropit-image-zoom-input"></td> <td style="width:100px;" align="center"> <button class="rotate-cw " type="button">旋转</button></td> </tr> </table> </div>';
                    $('.fourimage').append(div3);
                    $('.image-idpic1').cropit({
                        imageState: {src: '/img/'+msg['idpic1'], }
                    });
                    $('.image-idpic1 .rotate-cw').on('click',function(){
                         $('.image-idpic1').cropit('rotateCW');
                    });
                    var div4 = '<div class="image-idpic2"><div style="clear:both"><h3>身份证反面</h3></div>'+
                        '<div class="cropit-preview"></div>'+
                        '<div class="image-size-label"> <table style="width:100%"> <tr> <td style="width:60px;" align="center">放缩</td>'+
                    '<td><input type="range" class="cropit-image-zoom-input"></td>'+
                    '<td style="width:100px;" align="center"> <button class="rotate-cw " type="button">旋转</button></td></tr></table></div>';
                    $('.fourimage').append(div4);
                    $('.image-idpic2').cropit({
                        imageState: {src: '/img/'+msg['idpic2'], }
                    });
                    $('.image-idpic2 .rotate-cw').on('click',function(){
                         $('.image-idpic2').cropit('rotateCW');
                    });

                        $('#CZName').val(msg['czname']);
                        $('#postalAddress').val(msg['yjdz']);
                        var arr = [];
                        $('#CJH').val(msg['cjh']);
                        $('#CPH').val(msg['cph']);
                        $('#FDJH').val(msg['fdjh']);
                        $('#Coverage').text(arr.join(','));
                        $('#tel').text(msg['tel']);
                        $('#areaCode').text(msg['quhao']);
                        $('.buy').css('display','');
                    });
                });
            },
            onClose: function () {
                bootbox.confirm({
                    buttons:{cancel:{label:"取消"}, confirm:{label:"确认"}},
                    message:"您还没有完成此次服务，确定关闭吗？",
                    callback:function(result) {
                        if (result) {
                            $.hideSubview();
                            $('#buy').css('display','none');
                            $('#buyContent div').remove();
                            $('.buy').css('display','none');
                            $('#Processing .submit').parent().css('display','');
                            $('#Processing .payment').parent().css('display','');
                        }
                    }
                });
            },
            onHide: function () {}
        });
    };
    // 接单
    var orderPromisingSubView = function(msg){
        $.subview({
            content: '#Processing',
            startFrom: "right",
            onShow: function () {
                $('#processingContent').load('/ddkf/processing',function() {
                    //addGXH();
                    //delGXH();
                    $('#processingContent .date-picker').datepicker();
                    if(msg['quanxian']){
                        for(var i = 0; i<msg['infoData'].length;i++){
                            var bh = i + 1;
                            var str = '<tr><td>'+ bh +'</td><td>'+msg['infoData'][i]['name']+'</td><td>'+msg['infoData'][i]['price']+'</td><td><button class="delGXH">删除</button></td> </tr>';
                            $('.individuation').append(str);
                        }
                    }
                    var field = $('#processingContent').find('table').find('td');
                    $(field[0]).text(msg['wxname']);
                    $(field[5]).text(msg['tel']);
                    $(field[3]).text(msg['bxgs']);
                    $(field[4]).text(msg['szd']);
                    $(field[1]).text(msg['oid']);
                    var parameter = ['旧车','新车'];
                    $(field[6]).text(parameter[msg['isnew']]);
                    var array = new Array();
                    if (msg['jqx']) {
                        array.push('交强险');
                        $('#jqxstart').on('change',function(){
                            runTime($(this).val(),'#jqxend');
                        });
                        $('.individuation').remove();
                        $('.addtable').remove();
                    } else {
                        $('#jqxPrice').parent().parent().parent().remove();
                        $('#jqxstart').parent().parent().parent().remove();
                        $('#jqxend').parent().parent().parent().remove();
                    }
                    if (msg['sysz']) {
                        var syszArr = ['商业三者:30W', '商业三者:50W', '商业三者:100W'];
                        array.push(syszArr[msg['sysz'] - 1]);
                        $('#syszstart').on('change',function(){
                            runTime($(this).val(),'#syszend');
                        });
                        $('.individuation').remove();
                        $('.addtable').remove();
                    } else {
                        $('#syszPrice').parent().parent().parent().remove();
                        $('#syszstart').parent().parent().parent().remove();
                        $('#syszend').parent().parent().parent().remove();
                    }
                    if (msg['quanxian']) {
                        array.push('优选套餐');
                        $('#qxstart').on('change',function(){
                            runTime($(this).val(),'#qxend');
                        });
                    } else {
                        $('#quanxianPrice').parent().parent().parent().remove();
                        $('#qxstart').parent().parent().parent().remove();
                        $('#qxend').parent().parent().parent().remove();
                    }
                    if(msg['gxh']){
                        array.push('个性化投保');
                        $('#gxhstart').on('change',function(){
                            runTime($(this).val(),'#gxhend');
                        });
                        for(var i in msg['gxh_info']) {
                            if(i == 'syszsel' || i == 'csryxsel' || i == 'ssxsssxsel' || i == 'csryxcksel' || i == 'blddpsxsel'){
                                $('.'+i).val(msg['gxh_info'][i]);
                            }else if(msg['gxh_info'][i] != '0'){
                                $('.'+i).attr('checked',1);
                            }
                        };
                        $('.individuation').remove();
                        $('.addtable').remove();
                    } else {
                        $('#gxhPrice').parent().parent().parent().remove();
                        $('#gxhstart').parent().parent().parent().remove();
                        $('#gxhend').parent().parent().parent().remove();
                        $('.gxhDetails').remove();
                    }
                    $(field[2]).text(array.join(','));
                    $('.processing').css('display','');
                    $('.image-carpic1').cropit({
                        imageState: {src: '/img/'+msg['carpic1'], }
                    });
                    $('.image-carpic1 .rotate-cw').on('click',function(){
                         $('.image-carpic1').cropit('rotateCW');
                    });
                    var div2 = '<div class="image-carpic2"><div style="clear:both"><h3>行驶本副本</h3></div>'+
                        '<div class="cropit-preview"></div>'+
                        '<div class="image-size-label">  <table style="width:100%"><tr>'+
                    '<td style="width:60px;" align="center">放缩</td>'+
                    '<td><input type="range" class="cropit-image-zoom-input"></td>'+
                    '<td style="width:100px;" align="center"> <button class="rotate-cw " type="button">旋转</button></td></tr> </table>'+
                    '</div> ';
                    $('.fourimage').append(div2);
                    $('.image-carpic2').cropit({
                        imageState: {src: '/img/'+msg['carpic2'], }
                    });
                    $('.image-carpic2 .rotate-cw').on('click',function(){
                         $('.image-carpic2').cropit('rotateCW');
                    });
                    var div3 = '<div class="image-idpic1"><div style="clear:both"><h3>身份证正面</h3></div><div class="cropit-preview"></div>'+
                        '<div class="image-size-label">  <table style="width:100%"> <tr> <td style="width:60px;" align="center">放缩</td> <td><input type="range" class="cropit-image-zoom-input"></td> <td style="width:100px;" align="center"> <button class="rotate-cw " type="button">旋转</button></td> </tr> </table> </div>';
                    $('.fourimage').append(div3);
                    $('.image-idpic1').cropit({
                        imageState: {src: '/img/'+msg['idpic1'], }
                    });
                    $('.image-idpic1 .rotate-cw').on('click',function(){
                         $('.image-idpic1').cropit('rotateCW');
                    });
                    var div4 = '<div class="image-idpic2"><div style="clear:both"><h3>身份证反面</h3></div>'+
                        '<div class="cropit-preview"></div>'+
                        '<div class="image-size-label"> <table style="width:100%"> <tr> <td style="width:60px;" align="center">放缩</td>'+
                    '<td><input type="range" class="cropit-image-zoom-input"></td>'+
                    '<td style="width:100px;" align="center"> <button class="rotate-cw " type="button">旋转</button></td></tr></table></div>';
                    $('.fourimage').append(div4);
                    $('.image-idpic2').cropit({
                        imageState: {src: '/img/'+msg['idpic2'], }
                    });
                    $('.image-idpic2 .rotate-cw').on('click',function(){
                         $('.image-idpic2').cropit('rotateCW');
                    });


                });            
            },
            onClose: function () {
                bootbox.confirm({
                    buttons:{cancel:{label:"取消"}, confirm:{label:"确认"}},
                    message:"您还没有完成此次服务，确定关闭吗？",
                    callback:function(result) {
                        if(result){
                            $.hideSubview();
                            $('#processing').css('display','none');
                            $('#processingContent div').remove();
                            $('.image').remove();
                            $('.processing').css('display','none');
                            $('#Processing .submit').parent().css('display','');
                            $('#orderTable').bootstrapTable('refresh');
                            $('#myOrderTable').bootstrapTable('refresh');
                        }
                    }
                });
            },
            onHide: function () {}
        });
    };
    var imgRotate = function(url,element){
       $(element).cropit({
            imageState: {src: url, }
        });
        $(element+' .rotate-cw').on('click',function(){
          $(element).cropit('rotateCW');
        });
    };
    var back = function (){
        $('.back').off().on('click',function(){//点击打回弹出框输入信息提交
            swal({
                title: "打回消息",
                text: '',
                type: 'input',
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top"
            }, function (text) {
                    if(text == false){
                        return false;
                    } else {
                        $.ajax({
                            type:'POST',
                            url:'/ddkf/back',
                            data: {oid:oid,status:status,openId:openId,text:text},
                            dataType:'json',
                            headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')},
                            success:function (msg) {
                                if(msg){
                                    swal("成功提交!", '', "success");
                                    $('#processing').css('display','none');
                                    $('#orderTable').bootstrapTable('refresh');
                                    $('#myOrderTable').bootstrapTable('refresh');
                                    $('#buy').css('display','none');
                                    $('#buyContent div').remove();
                                    $('#processingContent div').remove();
                                    $('#Processing .submit').parent().css('display','');
                                    $('#Processing .payment').parent().css('display','');
                                    $.hideSubview();
                                }
                            }
                        });                    
                    }
                }
            );
        });
    };
    var paymentSubView = function (arr,bool){
        $.subview({
            content: '#insureDetails',
            startFrom: "right",
            onShow: function () {
                $('#insureDetailsContent').load("/insure/details", function () {
                    oid = arr['0']['oid'];
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
                            $.each(msg[1],function(index,value){
                                $('#insureDetailsContent .'+value).remove();
                            });
                            var idpic = '<img style="height:300px; width:400px; padding:1px;" src="img/'+msg['0']['idpic1']+'" alt="" /><img style="height:300px;   width: 400px; padding:1px;" src="img/'+msg['0']['idpic2']+'" alt="" />';
                            var carpic = '<img style="height:300px; width:400px; padding:1px;" src="img/'+msg['0']['carpic1']+'" alt="" /><img style="height:300px; width: 400px;  padding:1px;" src="img/'+msg['0']['carpic2']+'" alt="" />';
                            if(typeof msg['0']['idpic1'] != 'undefined'){
                                $('#idpic').html(idpic);
                            }
                            if(typeof msg['0']['carpic1'] != 'undefined'){
                                $('#carpic').html(carpic);
                            }
                            if(bool){
                                if(arr['0']['status'] == '等待支付'){
                                    $('.insure div:eq(0)').css('display','');
                                } else {
                                    $('.insure div:eq(1)').css('display',''); 
                                }
                            }
                        }
                    });
                });
            },
            onClose: function () {$.hideSubview(); },
            onHide: function () {}
        });
    };
    var payment = function (){
        $('.payment').on('click',function() {
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
                                $('#myOrderTable').bootstrapTable('refresh');
                                $('#orderTable').bootstrapTable('refresh');
                                $.hideSubview();
                            }
                        });
                    }
                }
            );
        });    
    };

    var download = function (){
        $('.download').on('click',function() {//点击下载
            arr = $('#myOrderTable').bootstrapTable('getSelections');
            var order_no=arr['0']['order_no'];
            if(!order_no){
                swal('订单号不存在', '', "error");
                return false;
            }
            $.blockUI({
                message:'<i class="fa fa-spinner fa-spin"></i> 下载中... '
            });
            var form = $("<form>");   //定义一个form表单
            form.attr('style', 'display:none');   //在form表单中添加查询参数
            form.attr('target', '');
            form.attr('method', 'post');
            form.attr('action', "/ddkf/compressZip");
            var input1 = $('<input>');
            var input2 = $('<input>');
            input1.attr('type', 'hidden');
            input1.attr('name', 'order_no');
            input1.attr('value', order_no);
            input2.attr('type', 'hidden');
            input2.attr('name', '_token');
            input2.attr('value', $('input[name="_token"]').val());
            $('body').append(form);  //将表单放置在web中
            form.append(input1);   //将查询参数控件提交到表单上
            form.append(input2);   //将查询参数控件提交到表单上
            form.submit();
            $.unblockUI();
        });
    };
    var submitEnquiryValidation = function () {
        var formAddUser = $('.form-processing');
        var errorHandler1 = $('.errorHandler',formAddUser);
        var successHandler1 = $('.successHandler', formAddUser);
        formAddUser.validate({
            errorElement: "span",
            errorClass: 'help-block',
            errorPlacement: function(error, element) {
                element.parent().parent().find('label').append(error);
            },
            ignore: "",
            rules: {
                jqxPrice : {
                    required:true,
                    number:true,
                },
                syszPrice : {
                    required:true,
                    number:true,
                },
                quanxianPrice : {
                    required:true,
                    number:true,
                },
                dsccs : {
                    required:true,
                },
                gxhPrice:{
                    required:true
                },
                jqxstart:{
                    required:true
                },
                jqxend:{
                    required:true
                },
                syszstart:{
                    required:true
                },
                syszend:{
                    required:true
                },
                qxstart:{
                    required:true
                },
                qxend:{
                    required:true
                },
                gxhstart:{
                    required:true
                },
                gxhend:{
                    required:true
                }
            },
            messages: {
                jqxPrice : {
                    required : '价格不能为空',
                    number: '必须是有效的数字',
                },
                syszPrice : {
                    required : '价格不能为空',
                    number:'必须是有效的数字',
                },
                quanxianPrice : {
                    required : '价格不能为空',
                    number:'必须是有效的数字',
                },
                gxhPrice:{
                    required:'个性化价格不能为空'
                },
                dsccs:{
                    required : '代收车船税不能为空'
                },
                jqxstart:{
                    required:'请填写时间'
                },
                jqxend:{
                    required:'请填写时间'
                },
                syszstart:{
                    required:'请填写时间'
                },
                syszend:{
                    required:'请填写时间'
                },
                qxstart:{
                    required:'请填写时间'
                },
                qxend:{
                    required:'请填写时间'
                },
                gxhstart:{
                    required:'请填写时间'
                },
                gxhend:{
                    required:'请填写时间'
                }
            },
            submitHandler : function(form) {
                errorHandler1.hide();
                $.blockUI({
                    message:'<i class="fa fa-spinner fa-spin"></i> 正在提交数据...'
                });
                var price = new Object();
                    price.jqx = $('.form-processing .jqxPrice').val();
                    price.jqxstart = $('.form-processing .jqxstart').val();
                    price.jqxend = $('.form-processing .jqxend').val();
                    price.quanxian = $('.form-processing .quanxianPrice').val();
                    price.qxstart = $('.form-processing .qxstart').val();
                    price.qxend = $('.form-processing .qxend').val();
                    price.sysz = $('.form-processing .syszPrice').val();
                    price.syszstart = $('.form-processing .syszstart').val();
                    price.syszend = $('.form-processing .syszend').val();
                    price.gxh = $('.form-processing .gxhPrice').val();
                    price.gxhstart = $('.form-processing .gxhstart').val();
                    price.gxhend = $('.form-processing .gxhend').val();
                    price.dsccs = $('.form-processing .dsccs').val();
                $.ajax({
                    type:'POST',
                    url:'/ddkf/submitPrice',
                    data:{oid:oid,price:price,openId:openId,pid:pid},
                    dataType:'json',
                    headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')},
                    success: function(msg) {
                        if(msg){
                            $.unblockUI();
                            $.hideSubview();
                            $('#myOrderTable').bootstrapTable('refresh');
                            $('#orderTable').bootstrapTable('refresh');
                            $('#processingContent div').remove();
                            $('#Processing .submit').parent().css('display','');
                            $('#Processing .payment').parent().css('display','');
                        }
                    }
                });
            },
            invalidHandler : function(event, validator) {//display error alert on form submit
                errorHandler1.show();
            }
        });
    };
    var submitBuyValidation = function () {
        var Ddkf = $('#buy .form-buy');
        var errorHandler1 = $('.errorHandler',Ddkf);
        var successHandler1 = $('.successHandler', Ddkf);
        Ddkf.validate({
            errorElement: "span",
            errorClass: 'help-block',
            errorPlacement: function(error, element) {
                element.parent().parent().find('label').append(error);
            },
            ignore: "",
            rules: {
                CJH : {
                    required:true,
                },
                CPH : {
                    required:true,
                },
                FDJH : {
                    required:true,
                },
                ZJH : {
                    required:true,
                },
                payurl: {
                    url:true,
                    required:true
                },
            },
            messages: {
                CJH : {
                    required : '（不能为空）',
                },
                CPH : {
                    required : '（不能为空）',
                },
                FDJH : {
                    required : '（不能为空）',
                },
                ZJH : {
                    required : '（不能为空）',
                },
                payurl:{
                    url : '请填写正确的url地址',
                    required: '请输入url'
                }
            },
            submitHandler : function(form) {
                errorHandler1.hide();
                $.blockUI({
                    message:'<i class="fa fa-spinner fa-spin"></i> 正在提交数据...'
                });
                var arr = new Object();
                arr.cjh = $('#CJH').val();
                arr.cph = $('#CPH').val();
                arr.fdjh = $('#FDJH').val();
                arr.zjh = $('#ZJH').val();
                arr.payurl = $('#payurl').val();
                arr.payment  = $('#payWay').val();
                $.ajax({
                    type:'POST',
                    url:'/ddkf/buying',
                    data:{oid:oid,details:arr,openId:openId,pid:pid},
                    dataType:'json',
                    headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')},
                    success: function(msg) {
                        if(msg){
                            $.hideSubview();
                            $.unblockUI();
                            $('#myOrderTable').bootstrapTable('refresh');
                            $('#orderTable').bootstrapTable('refresh');
                            $('#buyContent div').remove();
                            $('#Processing .submit').parent().css('display','');
                            $('#Processing .payment').parent().css('display','');
                        }
                    }
                });

            },
            invalidHandler : function(event, validator) {//display error alert on form submit
                errorHandler1.show();
            }
        });
    };
    var changePayWay = function(){
        $('#buyContent').on('change','#payWay',function(){
            if($(this).val() == 1){
                $('.payurl').val('');
                $('.payurl').removeAttr('disabled');
            } else {
                $('.payurl').val('http://wyx.bzb100.com');
                $('.payurl').attr('disabled',true);
                $('.payurl').parent().prev().find('span').remove();
            }
        });
    };
    var issuing = function(){
        $('.chudan').on('click',function() {
            bootbox.confirm({
                buttons:{cancel:{label:"取消"}, confirm:{label:"确认"}},
                message:"您确定出单吗?",
                callback:function(result) {
                    if(result){
                        $.ajax({
                            type: "post",
                            url: "/insure/chudan",
                            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                            data: {oid: arr['0']['oid']},
                            success: function (msg) {
                                $('#myOrderTable').bootstrapTable('refresh');
                                $('#orderTable').bootstrapTable('refresh');
                                $.hideSubview();
                            }
                        });
                    }
                }
            });
        });
    };
    var runTime = function (mytime,str) {
        $.ajax({
            type: 'POST',
            url: '/ddkf/time',
            data: {mytime:mytime},
            dataType: 'json',
            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
            success: function (msg) {
                $(str).val(msg);
            }
        });
    };
    return {
        init: function (){
            orderTable();
            myOrderTable();
            refreshTable();
            orderPromising();
            back();
            orderdelete();
            processing();
            submitEnquiryValidation();
            submitBuyValidation();
            payment();
            issuing();
            changePayWay();
            refresh();
            download();//下载订单
            // imgRotate();
       }
    }
}();