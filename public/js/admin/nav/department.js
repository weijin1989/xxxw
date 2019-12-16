department = function () {
    "use strict";
    var subViewElement, subViewContent,newnum;
    var username = $('.username').text();
    var agentztree = function () {
        var setting = {
            async: {
                enable: true,
                url:"/department/tree",
                autoParam:["id=id", "name=name", "level=level"],
                otherParam:{"_token":$('meta[name="_token"]').attr('content')},
                dataFilter: filter
            },
            data: {
                simpleData: {
                    enable: true
                }
            },
            callback: {
                beforeClick: zTreeBeforeClick
            }
        };
        function zTreeBeforeClick(treeId, treeNode, clickFlag){
            doReadAgentSth('open',treeNode.id);
        }
        //function zTreeBeforeExpand(treeId, treeNode){
        //    doReadAgentSth('open',treeNode.id);
        //}
        //function zTreeBeforeCollapse(treeId, treeNode){
        //    doReadAgentSth('close',treeNode.id);
        //}
        function filter(treeId, parentNode, childNodes) {
            if (!childNodes) return null;
            for (var i=0, l=childNodes.length; i<l; i++) {
                childNodes[i].name = childNodes[i].name.replace(/\.n/g, '.');
            }
            return childNodes;
        }
        $(document).ready(function(){
            $.fn.zTree.init($("#treeDemo"), setting);
        });
    };
    var agentable = function () {
        $('#agentable').bootstrapTable({
            toolbar:"#toolbar",
            cache: false,
            striped: true,
            selectItemName:"radioName",
            pagination: true,
            pageList: [10,20,50,100],
            pageSize:10,
            pageNumber:1,
            clickToSelect: true
        });
        $('#large-columns-table').next().click(function () {
            $(this).hide();
            buildTable($('#agentable'), 50, 50);
        });
        $('#agentable').on('check.bs.table uncheck.bs.table ' +
            'check-all.bs.table uncheck-all.bs.table', function () {
            $('.delete-agent').prop('disabled', !$('#agentable').bootstrapTable('getSelections').length);
            $('.edit-agent').prop('disabled', !$('#agentable').bootstrapTable('getSelections').length);
            $('.qrcode-agent').prop('disabled', !$('#agentable').bootstrapTable('getSelections').length);
        });
    };
    var checkAddAgent = function() {
        bootbox.confirm({
            buttons:{cancel:{label:"取消"}, confirm:{label:"确认"}},
            message:"您没有保存该记录，确定关闭吗?",
            callback:function(result) {
                if (result) {
                    $('.form-addagent')[0].reset();
                    $.hideSubview();
                }
            }
        });
    };
    var checkEditAgent = function() {
        bootbox.confirm({
            buttons:{cancel:{label:"取消"}, confirm:{label:"确认"}},
            message:"您没有保存该记录，确定关闭吗?",
            callback:function(result) {
                if (result) {
                    $('.form-editagent')[0].reset();
                    $.hideSubview();
                }
            }
        });
    };
    var runSubviews = function () {
        $('.add-agent').off().on("click",function() {
            subViewElement = $(this);
            subViewContent = subViewElement.attr('href');
            $.subview({
                content: subViewContent,
                startFrom: "right",
                onShow: function() {
                },
                onClose: function() {
                    checkAddAgent();
                },
                onHide: function() {

                }
            });
        });
        $('.edit-agent').off().on('click',function() {
            subViewElement = $(this);
            subViewContent = '#editAgent';
            $.subview({
                content: subViewContent,
                startFrom: "right",
                onShow: function() {
                    doEditAgentSth();
                },
                onClose: function() {
                    checkEditAgent();
                },
                onHide: function() {

                }
            });
        });
        $('.qrcode-agent').off().on('click',function () {
            subViewElement = $(this);
            subViewContent = '#qrcodeAgent';
            $.subview({
                content: subViewContent,
                startFrom: "right",
                onShow: function() {
                    doQrcodeAgentSth();
                },
                onClose: function() {
                    $('.qrcodepic img').remove();
                    $.hideSubview();
                },
                onHide: function() {

                }
            });
        });
        $(".close-subview-button").off().on("click", function(e) {
            $(".close-subviews").trigger("click");
            e.preventDefault();
        });
    };
    var findNextAgent = function () {
        $('.choose-agent').on('click',function() {
            var arr = $('#agentable').bootstrapTable('getSelections');
            $.ajax({
                type:'POST',
                url:'/department/choose',
                data:{postdata:arr[0].id},
                dataType:'json',
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                },
                success: function(json) {
                    if(json.say == 'ok'){
                        //var treeObj = $.fn.zTree.getZTreeObj("treeDemo");
                        //var node = treeObj.getNodeByParam("id", json.pid, null);
                        //treeObj.expandNode(node, true, true, true);
                        $('.agent-head').attr('name',json.pid);
                        $('.agent-head').html(($('.agent-head').html()) + '<a name="'+ json.pid +'" class="read-agent" href="javascript:void(0);">'+ arr[0].name +'</a> <i class="fa fa-angle-double-right"></i> ');
                        $('#agentable').bootstrapTable('removeAll');
                        $('#agentable').bootstrapTable('append',json.rows);
                        $('.delete-agent').prop('disabled',true);
                        $('.edit-agent').prop('disabled',true);
                        $('.qrcode-agent').prop('disabled',true);
                    }else{
                        swal('已经是最小区域','','warning');
                    }
                }
            });
        });
    };
    var ReadOneAgent = function () {
        $('.agent-head').on('click','.read-agent',function(e){
            e.preventDefault();
            var id = $(this).attr('name');
            $(this).nextAll().remove();
            $(this).parent().append(' <i class="fa fa-angle-double-right"></i> ');
            $.ajax({
                type:'POST',
                url:'/department/read',
                data:{postdata:id},
                dataType:'json',
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                },
                success: function(json){
                    if(json.say == 'ok'){
                        //var treeObj = $.fn.zTree.getZTreeObj("treeDemo");
                        //for(var i = 0,len = json.rows.length;i < len;i++){
                        //    var node = treeObj.getNodeByParam("id", json.rows[i].id, null);
                        //    treeObj.expandNode(node, false, true, true);
                        //}
                        $('.agent-head').attr('name',id);
                        $('#agentable').bootstrapTable('removeAll');
                        $('#agentable').bootstrapTable('append',json.rows);
                        $('.delete-agent').prop('disabled',true);
                        $('.edit-agent').prop('disabled',true);
                        $('.qrcode-agent').prop('disabled',true);
                    }
                }
            });
        });
    };
    var doReadAgentSth = function (active,id) {
        var treeReadObj = new Object;
        treeReadObj.active = active,treeReadObj.id = id;
        $.ajax({
            type:'POST',
            url:'/department/treeread',
            data:{postdata:treeReadObj},
            dataType:'json',
            headers:{
                'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
            },
            success: function(json){
                if(json.say == 'ok'){
                    var ai;
                    $('.agent-head a').remove();
                    $('.agent-head i').remove();
                    for(var i = 0,len = json.tree.length;i < len;i++){
                        ai = '<a name="'+ json.tree[i].id +'" class="read-agent" href="javascript:void(0);">'+ json.tree[i].name +'</a> <i class="fa fa-angle-double-right"></i>';
                        $('.agent-head').append(ai);
                    }
                    $('.agent-head').attr('name',json.pid);
                    $('#agentable').bootstrapTable('removeAll');
                    $('#agentable').bootstrapTable('append',json.rows);
                    $('.delete-agent').prop('disabled',true);
                    $('.edit-agent').prop('disabled',true);
                    $('.qrcode-agent').prop('disabled',true);
                }
            }
        });
    };
    var doEditAgentSth = function () {
        var arr = $('#agentable').bootstrapTable('getSelections');
        var id = arr[0].id;
        var name = arr[0].name;
        $('.form-editagent .id').val(id);
        $('.form-editagent .name').val(name);
    };
    var doQrcodeAgentSth = function () {
        $.blockUI({
            message:'<i class="fa fa-spinner fa-spin"></i> 正在生成二维码图片...'
        });
        var arr = $('#agentable').bootstrapTable('getSelections');
        var id = arr[0].id;
        $.ajax({
            type:'POST',
            url:'/department/qrcode',
            data:{postdata:id},
            dataType:'json',
            headers:{
                'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
            },
            success: function(json) {
                if(json.say == 'ok'){
                    var img = '<img src="'+ json.src +'">';
                    $('.qrcodepic').append(img);
                }
                $.unblockUI();
            }
        });
    };
    var runAddAgentFormValidation = function () {
        var formAddAgent = $('.form-addagent');
        var errorHandler1 = $('.errorHandler',formAddAgent);
        var successHandler1 = $('.successHandler', formAddAgent);
        formAddAgent.validate({
            errorElement: "span",
            errorClass: 'help-block',
            errorPlacement: function(error, element) {
                element.parent().parent().find('label').append(error);
            },
            ignore: "",
            rules: {
                name : {
                    required : true
                }
            },
            messages: {
                name : {
                    required : ' *不能为空'
                }
            },
            submitHandler : function(form) {
                errorHandler1.hide();
                $.blockUI({
                    message:'<i class="fa fa-spinner fa-spin"></i> 正在添加新区域...'
                });
                var agentToAdd = new Object;
                    agentToAdd.name = $('.form-addagent .name').val();
                    agentToAdd.pid = $('.agent-head').attr('name');
                $.ajax({
                    type:'POST',
                    url:'/department/doadd',
                    data:{postdata:agentToAdd},
                    dataType:'json',
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                    },
                    success: function(json) {
                        if(json.say == 'ok'){
                            $('.form-addagent')[0].reset();
                            var rows = [];
                            rows.push({
                                name:agentToAdd.name,
                                id:json.id,
                            });
                            $('#agentable').bootstrapTable('append', rows);
                            var zTree = $.fn.zTree.getZTreeObj("treeDemo");
                            var pNode = zTree.getNodeByParam("id", agentToAdd.pid , null);
                            if(agentToAdd.pid == 1){
                                var newNodes = {id:json.id, pId:agentToAdd.pid, name:agentToAdd.name};
                                zTree.addNodes(pNode, -1 , newNodes, false);
                            }
                            $.hideSubview();
                            toastr.success( username + '添加一个部门！');
                        }
                        $.unblockUI();
                    }
                });
            },
            invalidHandler : function(event, validator) {//display error alert on form submit
                errorHandler1.show();
            }
        });
    };
    var runEditAgentFormValidation = function () {
        var formEditAgent = $('.form-editagent');
        var errorHandler2 = $('.errorHandler',formEditAgent);
        var successHandler2 = $('.successHandler', formEditAgent);
        formEditAgent.validate({
            errorElement: "span",
            errorClass: 'help-block',
            errorPlacement: function(error, element) {
                element.parent().parent().find('label').append(error);
            },
            ignore: "",
            rules: {
                name :{required:true}
            },
            messages:{
                name:{required:' * 不能为空'}
            },
            invalidHandler: function(event, validator) {
                successHandler2.hide();
                errorHandler2.show();
            },
            submitHandler:function(form) {
                successHandler2.show();
                errorHandler2.hide();
                $.blockUI({
                    message: '<i class="fa fa-spinner fa-spin"></i> 正在修改区域信息...'
                });
                var agentToEdit = new Object;
                    agentToEdit.id = $('.form-editagent .id').val(),
                    agentToEdit.name = $('.form-editagent .name').val();

                $.ajax({
                    type:'POST',
                    url:'/department/edit',
                    data:{postdata:agentToEdit},
                    dataType:'json',
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
                    },
                    success: function(json){
                        if(json.say == 'ok'){
                            $.hideSubview();
                            $('input[name="radioName"]:checked').each(function () {newnum = $(this).data('index');});
                            $('#agentable').bootstrapTable('updateRow', {
                                index: newnum,
                                row: {
                                    name:agentToEdit.name
                                }
                            });
                            var zTree = $.fn.zTree.getZTreeObj("treeDemo");
                            var editNode = zTree.getNodeByParam("id", json.id , null);
                            zTree.editName(editNode);
                            zTree.cancelEditName(agentToEdit.name);
                            toastr.success( username + '修改一个部门信息');
                        }
                        $.unblockUI();
                    }
                });
            }
        });
    };

    var dodeleteAgent = function () {
        $('.delete-agent').on('click',function(){
        $.blockUI({
            message:'<i class="fa fa-spinner fa-spin"></i> 正在删除...'
        });
        var arr = $('#agentable').bootstrapTable('getSelections');
        var id = arr[0].id;
        $.ajax({
            type:'POST',
            url:'/department/dodelete',
            data:{postdata:id},
            dataType:'json',
            headers:{
                'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')
            },
            success: function(json) {
                if(json.say == 'ok'){
                    toastr.success( username + '删除一个部门信息');
                    location.reload();
                }
                $.unblockUI();
            }
        });
        });
    };

    return {
        init: function () {
            agentztree();
            agentable();
            runSubviews();
            findNextAgent();
            ReadOneAgent();
            dodeleteAgent();
            runAddAgentFormValidation();
            runEditAgentFormValidation();

        }
    };
}();
