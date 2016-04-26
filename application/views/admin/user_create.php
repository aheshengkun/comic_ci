<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
 <div class="panel">
	<div class="header">创建用户</div>
	<div class="body">
		<form method="POST" id="form" action="#">
			<table class="form">
				<tr>
					<th>用户名：</th>
					<td><input type="text" name="username" id="username" style="width: 200px" />1.长度5到12位。2.首字符不能为-或者_。3.只允许英文和数字以及-和_</td>
				</tr>
				<tr>
					<th>密码：</th>
					<td><input type="password" name="password" id="password" style="width: 200px" />1.长度5到12位。2.首字符不能为-或者_。3.只允许英文和数字以及-和_</td>
				</tr>
				<tr>
					<th>&nbsp;</th>
					<td colspan="2"><p class="font_02" id="errMsg"><?php echo $errMsg ?></p></td>
				</tr>
				<tr>
					<th>&nbsp;</th>
					<td colspan="2"><button type="button" id="submit" loading-text="正在提交..." onclick="submitForm()" class="blue big">确定</button></td>
				</tr>
			</table>
		</form>
	</div>
</div>
</li>
</ul>
<script>
function submitForm()
{
	var username = mytrim(document.getElementById('username').value);
	var msg = VerifyLenAndName(username, 5, 12);
	if(msg != 1)
	{
		alert("用户名" + msg);
		return ;
	}
	var password = mytrim(document.getElementById('password').value);
	msg = VerifyLenAndName(password, 5, 12);
	if(msg != 1)
	{
		alert("密码" + msg);
		return ;
	}
	var context = {'username':username, 'password':password};
	$.ajax( {
		type: 'POST',
		dataType:'json',
		url:'usercreate',
		data:context,
		success:function(data) { 
			var msg = data.errMsg;
			if(msg === "success"){
				$('#errMsg').html("创建用户成功");
				window.location.href="userlist";
			}else{
				$('#errMsg').html(msg);
			}
		}
	});
}
</script>
</body>
</html>