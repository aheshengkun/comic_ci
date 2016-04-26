<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
 <div class="panel">
	<div class="header">编辑漫画路径 </div>
	<div class="body">
		<form method="POST" id="form" action="#">
			<table class="form">
				<tr>
					<th>漫画路径：</th>
					<td><input type="text" name="comicdir" id="comicdir" value="<?php echo $comicdir->comicdir ?>" style="width: 390px" /></td>
				</tr>
				<tr>
					<th>&nbsp;</th>
					<td colspan="2"><p>例如：D:/www/mywebsite/</p></td>
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
	var comicdir = mytrim(document.getElementById('comicdir').value);
	if(comicdir == "")
	{
		alert("漫画路径不能为空");
		return ;
	}
	var context = {'comicdir':comicdir};
	$.ajax( {
		type: 'POST',
		dataType:'json',
		url:'updatecomicdir',
		data:context,
		success:function(data) { 
			var msg = data.errMsg;
			if(msg === "success"){
				$('#errMsg').html("更新漫画路径成功");
				window.location.href="comicdir";
			}else{
				$('#errMsg').html(msg);
			}
		}
	});
}
</script>
</body>
</html>