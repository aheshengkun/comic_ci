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
	<div class="header">编辑漫画</div>
	<div class="body">
		<form method="POST" id="form" action="#">
			<table class="form">
				<tr>
					<th><span class="red">*</span> 漫画名称</th>
					<td><input type="text" name="name" id="name" disabled="disabled" value="<?php echo $comic->name ?>" /></td>
				</tr> 
				<tr>
					<th>&nbsp</th>
					<td>注意：漫画名不能包含下划线?</td>
				</tr>
				<tr>
					<th><span class="red">*</span> 漫画作者</th>
					<td><input type="text" name="author" id="author" value="<?php echo $comic->author ?>" /></td>
				</tr>
				<tr>
					<th><span class="red">*</span> 漫画上映日期</th>
					<td><input type="text" name="showdate" id="showdate" value="<?php echo $comic->showdate ?>" /></td>
				</tr>
				<tr>
					<th><span class="red">*</span> 漫画封面图片</th>
					<td><input type="file" id="uploadfile" name="userfile" />
						<button type="button" onclick="ajaxFileUpload()"  class="blue big">上传文件</button>
					</td>
				</tr>
				<tr>
					<th></th>
					<td><label id="fileUploadProcess"></label></td>
				</tr>
				<tr>
					<th></th>
					<td><img id="uplaodImg" src="<?php echo $comic->coverurl ?>" style="max-width:200px; max-height:200px"></td>
				</tr>
				<tr>
					<th><span class="red">*</span> 漫画描述</th>
					<td><textarea name="description" id="description" rows="8" style="width: 800px; height: 200px;"><?php echo $comic->description ?></textarea></td>
				</tr>
				<tr>
					<th><span class="red">*</span>搜索关键词</th>
					<td><textarea name="searchWord" id="searchWord" rows="8" style="width: 800px; height: 100px;"><?php echo $comic->searchword ?></textarea></td>
				</tr>
				<tr>
					<th><span class="red">*</span> 漫画类型</th>
					<td>
						<?php 
						$n=1;
						foreach($typelist as $_type){ 
							if($n%7 == 0){ ?><br/>
							<?php } ?>
							<?php
							$checked = "";
							foreach($types as $v)
							{
								if($_type->type == $v)
								{
									$checked = 'checked="checked"';
									break;
								}
							}
							?>
							<?php echo $_type->type; ?><input type="checkbox"  <?php echo $checked ?> value="<?php echo $_type->type; ?>" name="typename" />&nbsp&nbsp&nbsp
						<?php 
						$n++;
						} ?>
						<br/>
					</td>
				</tr>
				<tr>
					<th>&nbsp;</th>
					<td><button type="button" id="submit" onclick="submitForm()"  class="blue big">确定</button></td>
				</tr>
				<tr>
					<th>&nbsp;</th>
					<td><span class="font_02" id="showmsg"><span></td>
				</tr>
			</table>
		</form>
	</div>
</div>
</li>
</ul>
<script>
var isRun = false;
var covername = "<?php echo $comic->covername ?>";
var coverdir = "<?php echo $comic->coverdir ?>";

function getCheckbox()
{
	var  obj = document.getElementsByName("typename");
	var str = "";
	if(obj)
	{
		for(var i = 0; i < obj.length; i++)
		{
			var a1 = obj[i].checked;
			var a2 = obj[i].value;
			if(a1 == true)
			{
				if(str=="")
				{
					str = a2;
				}
				else
				{
					str = str + "|" + a2;
				}
			}
		}
	}
	return str;
}

function submitForm()
{
	var name = mytrim(document.getElementById('name').value);
	if(name == "")
	{
		alert("漫画名不能为空");
		return ;
	}
	if(name.indexOf('_') != -1)
	{
		alert("漫画名不能包含下划线");
		return ;
	}
	var author = mytrim(document.getElementById('author').value);
	if(author == "")
	{
		alert("漫画作者不能空");
		return ;
	}
	if(covername == "")
	{
		alert("漫画封面不能为空");
		return ;
	}
	var description = mytrim(document.getElementById('description').value);
	if(description == "")
	{
		alert("漫画描述不能空");
		return ;
	}
	var showdate = mytrim(document.getElementById('showdate').value);
	if(showdate == "")
	{
		alert("漫画上映日期不能空");
		return ;
	}
	var searchWord = mytrim(document.getElementById('searchWord').value);
	if(searchWord == "")
	{
		alert("搜索关键字不能为空");
		return ;
	}
	var comicType = getCheckbox();
	var context = {
		'name':name, 
		'author':author, 
		'searchword':searchWord, 
		'description':description, 
		'showdate':showdate, 
		'covername':covername, 
		'coverdir':coverdir, 
		'comictype':comicType 
	};
	$.ajax( {
		type: 'POST',
		dataType:'json',
		url:'updatecomic',
		data:context,
		success:function(data) { 
			var msg = data.errMsg;
			if(msg === "success"){
				$('#showmsg').html("更新漫画成功");
				window.location.reload();
			}else{
				$('#showmsg').html(msg);
			}
		}
	});
}

function ajaxFileUpload()
{
	if(isRun == true)
	{
		return ;
	}
	isRun = true;
	$('#uplaodImg').attr("src","<?php echo (base_url()."assets/resources")?>/imgs/loading.gif");
	$('#fileUploadProcess').html("正在上传文件...");
	$.ajaxFileUpload
	({
		url:'<?php echo (base_url()."index.php/")?>admin/upload',
		secureuri:false,
		fileElementId:'uploadfile',
		dataType: 'json',
		data:{},
		success: function (data, status)
		{
			var msg = data.errMsg;
			if(msg=="success")
			{
				msg = "上传文件成功";
			}
			$('#fileUploadProcess').html(msg);
			var imgurl = data.fileurl;
			$('#uplaodImg').attr("src",imgurl);
			covername = data.file_name;
			coverdir = data.file_path;
			isRun = false;
		},
		error: function (data, status, e)
		{
			$('#fileUploadProcess').html("网络异常,上传失败");
			$('#uplaodImg').attr("src","");
			isRun = false;
		}
	})

	return false;
}
</script>
</body>
</html>