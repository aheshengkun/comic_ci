<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<dl class="row margin">
	<dt>
		<button id="create" class="blue" onclick="back()">返回</button>
	</dt>
	<dd class="right">	
	</dd>
</dl>
 <div class="panel">
	<div class="header">编辑漫画集数</div>
	<div class="body">
		<form method="POST" id="form" action="#">
			<input type="hidden" name="numid" id="numid" value="<?php echo $comicnum->id ?>" />
			<table class="form">
				<tr>
					<th>漫画名</th>
					<td><input type="text" disabled="disabled" name="comicname" id="comicname" value="<?php echo $comicnum->comicname ?>" style="width: 200px" /></td>
				</tr>
				<tr>
					<th>漫画集数名</th>
					<td><input type="text" name="numname" id="numname" value="<?php echo $comicnum->numname ?>" style="width: 200px" />&nbsp&nbsp长度1到45位</td>
				</tr>
				<tr>
					<th>集数文件夹名</th>
					<td><input type="text" name="dirname" id="dirname" value="<?php echo $comicnum->dirname ?>" style="width: 200px" />&nbsp&nbsp只能是数字，最大长度4位</td>
				</tr>
				<tr>
					<th>排序ID</th>
					<td><input type="text" name="sort_id" id="sort_id" value="<?php echo $comicnum->sort_id ?>" style="width: 200px" />&nbsp&nbsp只能是数字，最大长度4位</td>
				</tr>
				<tr>
					<th>&nbsp;</th>
					<td colspan="2"><p class="font_02" id="errMsg"></p></td>
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
	var numname = mytrim(document.getElementById('numname').value);
	if(numname == "")
	{
		alert("漫画集数名不能为空");
		return ;
	}
	var dirname = mytrim(document.getElementById('dirname').value);
	var msg = VerifyNum(dirname, 4);
	if(msg != 1)
	{
		alert("集数文件夹名" + msg);
		return ;
	}
	var sort_id = mytrim(document.getElementById('sort_id').value);
	msg = VerifyNum(sort_id, 4);
	if(msg != 1)
	{
		alert("排序ID" + msg);
		return ;
	}
	var numid = document.getElementById('numid').value;
	var comicname = document.getElementById('comicname').value;
	var context = {'comicname':comicname, 'numid':numid, 'numname':numname, 'dirname':dirname, 'sort_id':sort_id};
	$.ajax( {
		type: 'POST',
		dataType:'json',
		url:'updatecomicnum',
		data:context,
		success:function(data) { 
			var msg = data.errMsg;
			if(msg === "success"){
				$('#errMsg').html("更新漫画集数成功");
				window.location.href="comicnumlist?comicname=<?php echo $comicnum->comicname ?>";
			}else{
				$('#errMsg').html(msg);
			}
		}
	});
}
</script>
</body>
</html>