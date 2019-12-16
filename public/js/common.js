/**
 * Created by weijin on 2016/5/20.
 */
/*弹窗js简洁版*/
function pop_template(template){
    switch (template){
        case 1:
            pop('提示','保存成功',1);
            break;
        case 2:
            pop('提示','修改成功',1);
            break;
        case 3:
            pop('提示','删除成功',1);
            break;
        case 4:
            pop('提示','操作成功',1);
            break;
    }
}
/*弹窗js*/
function pop(title,content,types){
    toastr.options = {
        // "closeButton": true,
        "debug": false,
        "progressBar": true,
        "positionClass": "toast-top-center",
        "onclick": null,
        "showDuration": "400",
        "hideDuration": "1000",
        "timeOut": "4000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    if(types==1){
        toastr.success(content,title);
    }else if(types==2){
        toastr.info(content,title);
    }else if(types==3){
        toastr.warning(content,title);
    }else if(types==4){
        toastr.error(content,title);
    }
}

function genAjaxRemoteData(data, url) {
    return remote =
        {                         //自带远程验证存在的方法
            url: url,
            type: "post",
            dataType: "json",
            data: data,
            dataFilter: function (data, type) {
                data = (JSON.parse(data));
                ms = data['msg'];
                if (data['code'] == 0)
                    return true;
                else
                    return false;
            }
        }
}
function genAjaxRemote(id, url, token) {
    return remote =
    {                         //自带远程验证存在的方法
        url: url,
        type: "post",
        dataType: "json",
        data: {
            id: id,
            _token: token
        },
        dataFilter: function (data, type) {
            data = (JSON.parse(data));
            ms = data['msg'];
            if (data['code'] == 0)
                return true;
            else
                return false;
        }
    }
}


function genAjaxRemote1(id,car_type_key, url, token) {
    return remote =
    {                         //自带远程验证存在的方法
        url: url,
        type: "post",
        dataType: "json",
        data: {
            id: id,
            car_type_key: car_type_key,
            _token: token
        },
        dataFilter: function (data, type) {
            data = (JSON.parse(data));
            ms = data['msg'];
            if (data['code'] == 0)
                return true;
            else
                return false;
        }
    }
}

//封装ajax_post请求
function ajax_post(url,_data,fun){
    $.ajax({
        async:false,
        type:'POST',
        url:url,
        dataType:'json',
        data:_data,
        success: function(data)
        {
            if(data['code'] != 1)
            {
                pop('提示',data['msg'],3);
                return false;
            }
            fun(data);
        },
        error : function() {
            pop('提示','网络异常',3)
        }

    });
}

//状态开关
function status(){
    $('.status button').click(function(event) {
        $(this).addClass("btn-primary active");
        $(this).removeClass("btn-default");
        $(this).siblings('button').removeClass("btn-primary active");
        $(this).addClass('button').removeClass("btn-default");
        $("#status").val($(this).data('status'));
    });
};
//保险产品状态开关

//状态开关
function statusInsure(){
    $('.status button').click(function(event) {
    	
        $(this).addClass("btn-primary active");
        $(this).removeClass("btn-default");
        $(this).siblings('button').removeClass("btn-primary active");
        $(this).addClass('button').removeClass("btn-default");
        $(this).siblings("input").val($(this).data('status'));
    
    });
};

////省/市/县联动
//function linkage(){
////    $('.linkage button').click(function(event) {
////        $(this).addClass("btn-primary active");
////        $(this).removeClass("btn-default");
////        $(this).siblings('button').removeClass("btn-primary active");
////        $(this).addClass('button').removeClass("btn-default");
////        $("#status").val($(this).data.linkage button('status'));
////    });
////};
//    $('#formAdduserDiv,#formEdituserDiv').on('change','.province',function(){
//        if($(this).val() != 0){
//            ajaxInterlock($(this).val(),$('.city'),0);
//        } else {
//            $('.city').html('<option value="0">未选择</option>');
//            $('.county').html('<option value="0">未选择</option>');
//        }
//    });
//    $('#formAdduserDiv,#formEdituserDiv').on('change','.city',function(){
//        if($(this).val() != 0){
//            ajaxInterlock($(this).val(),$('.county'),0);
//        } else {
//            $('.county').html('<option value="0">未选择</option>');
//        }
//    });
//};







