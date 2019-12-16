var FormElements = function() {
	"use strict";
	//function to initiate query.autosize
	var runAutosize = function() {
		$("textarea.autosize").autosize();
	};
	//function to initiate Callback on Checkbox and RadioButton
	var runCalbackIcheck = function() {
		$('input.checkbox-callback').on('ifChecked', function(event) {
			alert('Checked');
		});
		$('input.checkbox-callback').on('ifUnchecked', function(event) {
			alert('Unchecked');
		});
		$('input.radio-callback').on('ifChecked', function(event) {
			alert('checked ' + $(this).val() + ' radio button');
		});
	};
	//function to initiate bootstrap-touchspin
	var runTouchSpin = function() {
		$("input[name='demo1']").TouchSpin({
			min: 0,
			max: 100,
			step: 0.1,
			decimals: 2,
			boostat: 5,
			maxboostedstep: 10,
			postfix: '%'
		});
		$("input[name='demo2']").TouchSpin({
			min: -1000000000,
			max: 1000000000,
			stepinterval: 50,
			maxboostedstep: 10000000,
			prefix: '$'
		});
		$("input[name='demo3']").TouchSpin({
			verticalbuttons: true
		});
		$("input[name='demo4']").TouchSpin({
			verticalbuttons: true,
			verticalupclass: 'fa fa-plus',
			verticaldownclass: 'fa fa-minus'
		});
		$("input[name='demo5']").TouchSpin({
			postfix: "a button",
			postfix_extraclass: "btn btn-default"
		});
		$("input[name='demo6']").TouchSpin({
			postfix: "a button",
			postfix_extraclass: "btn btn-default"
		});
		$("input[name='demo7']").TouchSpin({
			prefix: "pre",
			postfix: "post"
		});
	};
	//function to initiate jquery.tagsinput
	var runTagsInput = function() {
		$('#tags_1').tagsInput({
			width: 'auto'
		});
	};
	return {
		//main function to initiate template pages
		init: function() {
			runAutosize();
			runTouchSpin();
			runCalbackIcheck();
			runTagsInput();
		}
	};
}();
