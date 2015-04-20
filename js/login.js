var Login = function(){
	var openForgotPassword = function() {
		$("#loginFrm").hide();
		$("#forgotFrm").show();
	}
	var openLogin = function(){	
		$("#loginFrm").show();
		$("#forgotFrm").hide();
	}
	var validateLogin = function(event){
		var username = $("#username").val();
		var password = $("#password").val();
		$("#username_error").html("");
		$("#password_error").html("");
		if(username == "")
		{
			$("#username_error").html("Please provide a username.");
			event.preventDefault();
			return false;
		}
		if(password == "")
		{
			$("#password_error").html("Please provide a password.");
			event.preventDefault();
			return false;
		}		
		
	}
	var validateForgotPassword = function(event){
		var email = $("#forgot_email").val();	
		var pattern=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;	
		if(pattern.test(email) == false || email == "")
		{
			$("#forgot_email_error").html("Please provide correct email Id.");
			event.preventDefault();
			return false;
		}
	}
	var validateEditProfile = function(event){
		var email = $("#email").val();	
		var username = $("#username").val();	
		var fname = $("#first_name").val();
		var lname = $("#last_name").val();
		$("#fname_error").html("");	
		$("#lname_error").html("");
		$("#email_error").html("");
		$("#username_error").html("");
		$("#password_error").html("");
		var pattern=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
		if(fname == "")
		{
			$("#fname_error").html("Please provide a first name.");
			event.preventDefault();
			return false;
		}
		if(lname == "")
		{
			$("#lname_error").html("Please provide a last name.");
			event.preventDefault();
			return false;
		}
		if(pattern.test(email) == false || email == "")
		{
			$("#email_error").html("Please provide correct email Id.");
			event.preventDefault();
			return false;
		}
		if(username == "")
		{
			$("#username_error").html("Please provide a username.");
			event.preventDefault();
			return false;
		}
		if($("#change_password").is(':checked') && $("#password").val() == "")
		{
			$("#password_error").html("Please provide a password.");
			event.preventDefault();
			return false;
		}
	}
	var changePassword = function(){
		if($("#change_password").is(':checked'))
		{
;			$("#password").attr("disabled",false);
		}
		else
		{
			$("#password").attr("disabled",true);
		}
	}
	return {
		openLogin : openLogin,
		openForgotPassword : openForgotPassword,
		validateLogin : validateLogin,
		validateForgotPassword : validateForgotPassword,
		validateEditProfile : validateEditProfile,
		changePassword : changePassword

	};
}();


