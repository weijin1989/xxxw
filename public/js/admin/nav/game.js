var Game = function (){
	var subViewContent,subViewElement;
	"use strict";
	$('#gameTable').bootstrapTable({
		toolbar:"#toolbar",
		cache: false,
		striped: true,
		selectItemName:"radioName",
		pagination: true,
		pageList: [10,20,50,100],
		pageSize:10,
		pageNumber:1,
		clickToSelect: true,
		showRefresh:true,
		search:true,
	});
	var data = function () {
		$.ajax({
			type: 'GET',
			url: '/game/data',
			dataType: 'json',
			headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
			success: function (msg) {
				$('#gameTable').bootstrapTable('removeAll');
				$('#gameTable').bootstrapTable('append',msg['row']);
			}
		});
	};
	var refresh = function () {
		$('.refresh').on('click',function(){
			data();
		});
	};
	var clear = function () {
	  $('.clear').on('click',function() {
		  $.ajax({
			  type: 'GET',
			  url: '/game/clear',
			  dataType: 'json',
			  headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
			  success: function (msg) {
				  $('#gameTable').bootstrapTable('removeAll');
				  console.log(msg);
			  }
		  });
	  });
	};
	var subView = function(){
	  $('.qrcode').off().on("click", function () {
			subViewElement = $(this);
			subViewContent = '#qrcodeSubview';
			$.subview({
				content: subViewContent,
				startFrom: "right",
				onShow: function () {
				  $.ajax({
                            type:'GET',
                            url:'/game/img',
                            success:function (msg) {
                               	var img = '<img src='+msg.msg+'>';
                               	$('#qrcodeSubview').append(img);
                            }
                        });
				},
				onClose: function () {
					$('#qrcodeSubview img').remove();
					$.hideSubview();
				},
				onHide: function () {}
			});
		});
	};
	return {
	   init : function () {
		   data();
		   clear();
		   refresh();
		   subView();
		}
	}
}();