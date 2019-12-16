/**
 * Created by dev on 15/9/14.
 */
var Login = function() {
    "use strict";
    var runBoxToShow = function() {
        var el = $('.box-login');
        if (getParameterByName('box').length) {
            switch(getParameterByName('box')) {
                case "register" :
                    el = $('.box-register');
                    break;
                case "forgot" :
                    el = $('.box-forgot');
                    break;
                default :
                    el = $('.box-login');
                    break;
            }
        }
        el.show().addClass("animated flipInY").on('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
            $(this).removeClass("animated flipInY");
        });
    };
    var runLoginButtons = function() {
        //点击登录页面的忘记密码
        $('.forgot').on('click', function() {
            $('.box-login').removeClass("animated flipInY").addClass("animated bounceOutRight").on('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                $(this).hide().removeClass("animated bounceOutRight");
            });
            $('.box-forgot').show().addClass("animated bounceInLeft").on('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                $(this).show().removeClass("animated bounceInLeft");
            });
        });
        //点击注册
        $('.register').on('click', function() {
            $('.box-login').removeClass("animated flipInY").addClass("animated bounceOutRight").on('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                $(this).hide().removeClass("animated bounceOutRight");
            });
            $('.box-register').show().addClass("animated bounceInLeft").on('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                $(this).show().removeClass("animated bounceInLeft");
            });
        });
        $('.go-back').click(function() {
            var boxToShow;
            if ($('.box-register').is(":visible")) {
                boxToShow = $('.box-register');
            } else {
                boxToShow = $('.box-forgot');
            }
            boxToShow.addClass("animated bounceOutLeft").on('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                boxToShow.hide().removeClass("animated bounceOutLeft");

            });
            $('.box-login').show().addClass("animated bounceInRight").on('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                $(this).show().removeClass("animated bounceInRight");

            });
        });
    };
    //function to return the querystring parameter with a given name.
    var getParameterByName = function(name) {
        name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"), results = regex.exec(location.search);
        return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    };
    var runSetDefaultValidation = function() {
        $.validator.setDefaults({
            errorElement : "span", // contain the error msg in a small tag
            errorClass : 'help-block',
            errorPlacement : function(error, element) {// render error placement for each input type
                if (element.attr("type") == "radio" || element.attr("type") == "checkbox") {// for chosen elements, need to insert the error after the chosen container
                    error.insertAfter($(element).closest('.form-group').children('div').children().last());
                } else if (element.attr("name") == "card_expiry_mm" || element.attr("name") == "card_expiry_yyyy") {
                    error.appendTo($(element).closest('.form-group').children('div'));
                } else {
                    error.insertAfter(element);
                    // for other inputs, just perform default behavior
                }
            },
            ignore : ':hidden',
            success : function(label, element) {
                label.addClass('help-block valid');
                // mark the current input as valid and display OK icon
                $(element).closest('.form-group').removeClass('has-error');
            },
            highlight : function(element) {
                $(element).closest('.help-block').removeClass('valid');
                // display OK icon
                $(element).closest('.form-group').addClass('has-error');
                // add the Bootstrap error class to the control group
            },
            unhighlight : function(element) {// revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error');
                // set error class to the control group
            }
        });
    };
    var runLoginValidator = function() {
        var form = $('.form-login');
        var errorHandler = $('.errorHandler', form);
        form.validate({
            rules : {
                email : {
                    minlength : 2,
                    required : true
                },
                password : {
                    minlength : 6,
                    required : true
                }
            },
            messages: {
                email : {
                    minlength : '请至少输入两位字符',
                    required : '用户名不能为空'
                },
                password : {
                    minlength : '请至少输入六位密码',
                    required : '密码不能为空'
                }
            },
            invalidHandler : function(event, validator) {//display error alert on form submit
                errorHandler.show();
            },
            submitHandler : function(form) {
                errorHandler.hide();
                form.submit();
            }
        });
    };
    var runForgotValidator = function() {
        var form2 = $('.form-forgot');
        var errorHandler2 = $('.errorHandler', form2);
        form2.validate({
            rules : {
                email : {
                    required : true
                }
            },
            submitHandler : function(form) {
                errorHandler2.hide();
                form2.submit();
            },
            invalidHandler : function(event, validator) {//display error alert on form submit
                errorHandler2.show();
            }
        });
    };
    var runRegisterValidator = function() {
        var form3 = $('.form-register');
        var errorHandler3 = $('.errorHandler', form3);
        form3.validate({
            rules : {
                name : {
                    required : true
                },
                email : {
                    // email : true,
                    required : true
                },
                password : {
                    minlength : 6,
                    required : true
                },
                password_again : {
                    minlength : 5,
                    equalTo : "#password"
                },
                agree : {
                    minlength : 1,
                    required : true
                }
            },
            messages : {
                name :{
                    required : '姓名不能为空'
                },
                email :{
                    required : '用户名不能为空'
                },
                password :{
                    minlength : '至少输入六个字符',
                    required : '密码不能为空'
                },
                password_confirmation :{
                    minlength : '至少输入六个字符',
                    equalTo:'两次密码不一致'
                },
                agree :{
                    minlength : '至少输入一个字符',
                    required : '.'
                }
            },
            submitHandler : function(form) {
                errorHandler3.hide();
                form3.submit();
            },
            invalidHandler : function(event, validator) {//display error alert on form submit
                errorHandler3.show();
            }
        });
    };
    return {
        //main function to initiate template pages
        init : function() {
            runBoxToShow();
            runLoginButtons();
            runSetDefaultValidation();
            runLoginValidator();
            runForgotValidator();
            runRegisterValidator();
        }
    };
}();

