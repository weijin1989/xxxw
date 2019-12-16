var Coefficient = function (){
    var num = $('#factor input[name=num]');
    var factorFunction = function () {
        $('#addFactor').on('click',function(){
            var str = $('#factor div:eq(0)').clone();
            $('#factor').append(str);
            var numOld = num.val();
            var numNew = num.val(parseInt(numOld)+1);
            $('#factor .row').last().find('label').text('第'+(parseInt(numOld)+1)+'级');
            $('#factor .row').last().find('input').attr('name','factor'+(parseInt(numOld)+1));
            $('#factor .row').last().find('input').val(0);
        });
        $('#delFactor').on('click',function(){
            var numOld = num.val();
            if (numOld > 1){
                var numNew = num.val(parseInt(numOld)-1);
                $('#factor .row').last().remove();
            } else {
                swal('不能删除所有','','warning');
            }
        });
    };
    var submitValidation = function () {
        var formCoefficient = $('.form-coefficient');
        var errorHandler1 = $('.errorHandler',formCoefficient);
        var successHandler1 = $('.successHandler', formCoefficient);
        formCoefficient.validate({
            debug : true,
            errorElement: "span",
            errorClass: 'help-block',
            errorPlacement: function(error, element) {
                element.parent().parent().find('label').append(error);
            },
            ignore: "",
            rules: {
                factor1 : {
                    required : true,
                    number: true,
                    min : 0,
                    max : 100,
                },
                factor2 : {
                    required : true,
                    number: true,
                    min : 0,
                    max : 100,
                },
                factor3 : {
                    required : true,
                    number: true,
                    min : 0,
                    max : 100,
                },
                factor4 : {
                    required : true,
                    number: true,
                    min : 0,
                    max : 100,
                },
                factor5 : {
                    required : true,
                    number: true,
                    min : 0,
                    max : 100,
                },
                factor6 : {
                    required : true,
                    number: true,
                    min : 0,
                    max : 100,
                },
                factor7 : {
                    required : true,
                    number: true,
                    min : 0,
                    max : 100,
                },
                factor8 : {
                    required : true,
                    number: true,
                    min : 0,
                    max : 100,
                },
                factor9 : {
                    required : true,
                    number: true,
                    min : 0,
                    max : 100,
                },
                factor10 : {
                    required : true,
                    number: true,
                    min : 0,
                    max : 100,
                },
                giveBase :{
                    required : true,
                    number  : true,
                    min : 0,
                } ,
                eachGive : {
                    required : true,
                    number :true,
                    min  : 0,
                },
                cash     : {
                    required : true,
                    number : true,
                    min : 0,
                    max : 100,
                },
                profit : {
                    required : true,
                    number : true,
                    max    : 100,
                    min    : 0,
                },
                costomer: {
                    required : true,
                    number : true,
                    max : 100,
                    min : 0,
                },
                subint : {
                    'required' :true,
                    'number' : true,
                    'digits' : true,
                    'min' : 0
                }
            },
            messages: {
                factor1 : {
                    required : '(不能为空)',
                    number : '(必须是数字)',
                    min    : '(不能是负数)',
                    max : '(最大百分比不能超过100)',
                },
                factor2 : {
                    required : '(不能为空)',
                    number : '(必须是数字)',
                    min    : '(不能是负数)',
                    max : '(最大百分比不能超过100)',
                },
                factor3: {
                    required : '(不能为空)',
                    number : '(必须是数字)',
                    min    : '(不能是负数)',
                    max : '(最大百分比不能超过100)',
                },
                factor4: {
                    required : '(不能为空)',
                    number : '(必须是数字)',
                    min    : '(不能是负数)',
                    max : '(最大百分比不能超过100)',
                },
                factor5: {
                    required : '(不能为空)',
                    number : '(必须是数字)',
                    min    : '(不能是负数)',
                    max : '(最大百分比不能超过100)',
                },
                factor6: {
                    required : '(不能为空)',
                    number : '(必须是数字)',
                    min    : '(不能是负数)',
                    max : '(最大百分比不能超过100)',
                },
                factor7: {
                    required : '(不能为空)',
                    number : '(必须是数字)',
                    min    : '(不能是负数)',
                    max : '(最大百分比不能超过100)',
                },
                factor8: {
                    required : '(不能为空)',
                    number : '(必须是数字)',
                    min    : '(不能是负数)',
                    max : '(最大百分比不能超过100)',
                },
                factor9: {
                    required : '(不能为空)',
                    number : '(必须是数字)',
                    min    : '(不能是负数)',
                    max : '(最大百分比不能超过100)',
                },
                factor10: {
                    required : '(不能为空)',
                    number : '(必须是数字)',
                    min    : '(不能是负数)',
                    max : '(最大百分比不能超过100)',
                },
                giveBase : {
                    required : '(不能为空)',
                    number : '(必须是数字)',
                    min : '(值不能为负数)',
                },
                eachGive : {
                    required : '(不能为空)',
                    number : '(只能是数字)',
                    min : '(值不能为负数)',
                },
                cash     : {
                    required : '不能为空',
                    number : '只能是数字',
                    min : '值不能为负数',
                    max : '系数比例不能超过100%',
                },
                profit : {
                    required : '不能为空',
                    number : '只能是数字',
                    max    : '系数比例不能超过100%',
                    min    : '系数比例不能是负数',
                },
                costomer: {
                    required : '不能为空',
                    number : '只能是数字',
                    max    : '系数比例不能超过100%',
                    min    : '系数比例不能是负数',
                },
                subint : {
                    'required' : '不能为空',
                    'number' : '只能是数字',
                    digits:'必须是整数',
                    min : '不能小于0',
                }
            },
            submitHandler : function(form) {
                errorHandler1.hide();
                var m = 0;
                var ele = $('.form-coefficient .factor');
                for(var i=0; i < ele.length; i++) {
                    m += parseFloat($('.form-coefficient .factor:eq('+ i +')').val()) * 10000;
                }
                m = m/10000;
                //if(m > 1) {
                //    swal('系数转换的总和不能大于1');
                //} else
                if(m < 1 ) {
                    swal('系数转换的总和不能小于1');
                } else {
                    bootbox.confirm({
                        buttons: {cancel: {label: "取消"}, confirm: {label: "确认"}},
                        message: "您确定提交这些系数吗?",
                        callback: function (result) {
                            if (result) {
                                $.hideSubview();
                                submitCheck('','');
                                //send();
                            }
                        }
                    });
                }
            },
            invalidHandler : function(event, validator) { //display error alert on form submit
                errorHandler1.show();
            },
        });
    };
    var send = function(){
        $.ajax({
            type: 'GET',
            url: '/coefficient/send',
            dataType: 'json',
            success: function (msg) {
                if(msg['trueOrFalse']){
                    swal({
                        title: "请填写验证码",
                        text: '',
                        type: 'input',
                        showCancelButton: true,
                        closeOnConfirm: false,
                        animation: "slide-from-top"
                    }, function (text) {
                            if(text == false){
                                return false;
                            } else {
                                $.blockUI({
                                    message: '<i class="fa fa-spinner fa-spin"></i> 正在提交数据...'
                                });
                                submitCheck(msg['code'],text);
                            }
                        }
                    );
                 } else{
                     swal("验证码发送失败", '', "warning");
                }
            }
        });
    }
    var submitCheck  = function  (code1,code2){
        var arr      = new Object();
        arr.factor   = [];
        var id       = $('.form-coefficient input[name=id]').val();
        arr.num      = $('.form-coefficient input[name=num]').val();
        arr.cash     = $('.form-coefficient input[name=cash]').val();
        arr.giveBase = $('.form-coefficient input[name=giveBase]').val();
        arr.eachGive = $('.form-coefficient input[name=eachGive]').val();
        arr.costomer = $('.form-coefficient input[name=costomer]').val();
        //arr.profit   = $('.form-coefficient input[name=profit]').val();
        arr.subint   = $('.form-coefficient input[name=subint]').val();
        arr.agent   = $('.form-coefficient input[name=agent]').val();
        arr.share   = $('.form-coefficient input[name=share]').val();
        for(var i=0; i < arr.num; i++) {
            arr.factor.push(parseFloat($('.form-coefficient .factor:eq('+ i +')').val()));
        }
        $.ajax({
            type: 'POST',
            url: '/coefficient/submit',
            data: {data: arr, id: id, code1: code1,code2:code2},
            dataType: 'json',
            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
            success: function (msg) {
                if (msg != 'codeNo') {
                    swal("修改成功", '', "success");
                    $.unblockUI();
                } else {
                    swal('验证码错误','','warning');
                    $.unblockUI();
                }
            }
        });
    };
    return {
        init: function (){
            factorFunction();
            submitValidation();
        }
    }
}();