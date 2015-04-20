var Login = function(){
	var openForgotPassword = function() {
		$("#loginFrm").hide();
		$("#forgotFrm").show();
	}
	var openLogin = function(){	
		$("#loginFrm").show();
		$("#forgotFrm").hide();
	}
	var validateLogin = function(){
		var username = $("#username").val();
		var password = $("#password").val();
		
		if(username == "")
		{
			$("#username_error").html("Please provide a username.");
			return false;
		}
		if(password == "")
		{
			$("#password_error").html("Please provide a password.");
			return false;
		}
	}
	var validateForgotPassword = function(){
		var email = $("#forgot_email").val();	
		var pattern=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;	
		if(pattern.test(email) == false || email == "")
		{
			$("#forgot_email_error").html("Please provide correct email Id.");
			return false;
		}
	}
	return {
		openLogin : openLogin,
		openForgotPassword : openForgotPassword,
		validateLogin : validateLogin,
		validateForgotPassword : validateForgotPassword
	};
}();


