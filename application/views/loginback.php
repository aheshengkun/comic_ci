<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="<?php echo (base_url()."assets/resources")?>/css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="<?php echo (base_url()."assets/resources")?>/css/main.css" type="text/css">
<script src="<?php echo (base_url()."assets/resources")?>/js/jquery-1.3.2.js" type="text/javascript"></script>
<script></script>
<title></title>
</head>
<script>
function newCaptcha()
{
	$.ajax( {
		type: 'GET',
		dataType:'json',
		url:'get/captcha',
		data:{
		},
		success:function(data) { 
			var imgUrl = data.imgUrl;
			$("#captchaImg").attr("src",imgUrl);
		}
	});
}	
function submitForm()
{
	//$("#form").submit();
	var username = $("#username").val();
	var password = $("#password").val();
	var captcha = $("#captcha").val();
	var context = {'username':username, 'password':password, 'captcha':captcha};
	$.ajax( {
		type: 'POST',
		dataType:'json',
		url:'check/loginback',
		data:context,
		success:function(data) { 
			var msg = data.errMsg;
			if(msg === "success"){
				$('#errMsg').html("登陆成功");
				window.location.href="admin/index";
			}else{
				$('#errMsg').html(msg);
			}
		}
	});
}
function Enter()
{
	var e=window.event||arguments.callee.caller.arguments[0];
      if(e.keyCode==13 || arguments[0]){
          submitForm();
      }
}
</script>
<body onkeydown="Enter()">
<div class="container">
	<div class="container_03">
		<img src="<?php echo (base_url()."assets/resources")?>/imgs/login.png" />
	</div>
	<form id="form">
	<div class="container_01">
		<p class="font_01">用户名</p>
		<input class="form-control" type="text" name="username" id="username"  /><br/>
		<p class="font_01">密码</p>
		<input class="form-control" type="password" name="password" id="password" /><br/>
		<p class="font_01">验证码</p>
		<p><img src="<?php echo $imgUrl ?>" id="captchaImg" />&nbsp;<input class="btn btn-default" type="button" value="换一张" onclick="newCaptcha()" /></p>
		<input class="form-control" type="text" name="captcha" id="captcha" /><br/>
		<p class="font_02" id="errMsg"><?php echo $errMsg ?></p>
	</div>
	</form>
	<div class="container_02">
		<input class="btn btn-primary btn-block" type="button" onclick="submitForm()" value="登  陆">
	</div>
</div>
</body>
</html>
