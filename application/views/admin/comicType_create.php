<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
 <div class="panel">
	<div class="header">创建漫画类型</div>
	<div class="body">
		<form method="POST" id="form" action="#">
			<table class="form">
				<tr>
					<th>漫画类型名：</th>
					<td><input type="text" name="typename" id="typename" style="width: 200px" />1.长度1到45位</td>
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
	var typename = mytrim(document.getElementById('typename').value);
	var msg = VerifyLen(typename, 1, 45);
	if(msg != 1)
	{
		alert("漫画类型" + msg);
		return ;
	}
	var context = {'typename':typename};
	$.ajax( {
		type: 'POST',
		dataType:'json',
		url:'comictypecreate',
		data:context,
		success:function(data) { 
			var msg = data.errMsg;
			if(msg === "success"){
				$('#errMsg').html("创建漫画类型成功");
				window.location.href="comictypelist";
			}else{
				$('#errMsg').html(msg);
			}
		}
	});
}
</script>
</body>
</html>