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
	<input type="hidden" name="numid" id="numid" value="<?php echo $numid ?>">
	<div class="header">漫画页管理</div>
	<div class="body">
		<table class="form">
			<tr>
				<th>漫画图片</th>
				<td><input type="file" id="uploadfile" name="userfile" />
					<button type="button" onclick="ajaxFileUpload()"  class="blue big">上传文件</button>
				</td>
			</tr>
			<tr>
				<th>上传说明</th>
				<td><span class="red">1.图片文件必须在zip文件的根目录下。2.只允许上传zip文件，大小不能超过系统限定的上传文件大小。</span></td>
			</tr>
			<tr>
				<th></th>
				<td><label id="fileUploadProcess"></label></td>
			</tr>
			<tr>
				<th></th>
				<td><img id="uplaodImg" src="<?php echo (base_url()."assets/resources")?>/imgs/loading.gif" style="display:none;max-width:200px; max-height:200px"></td>
			</tr>
			<tr>
				<th></th>
				<td>
				<button type="button" onclick="createPage('create')"  class="blue big">生成漫画页</button>
				<button type="button" onclick="createPage('renew')"  class="blue big">重构漫画页</button>
				&nbsp;&nbsp;<a href="<?php echo $url_page ?>" target="_blank" class="red" >预览漫画</a>
				</td>
			</tr>
			<tr>
				<th></th>
				<td><span class="red" id="showmsg"></span></td>
			</tr>
		</table>
	</div>
	<br/>
	<div class="header">漫画页列表</div>
	<div class="body">
		
		<table class="tlist" width="100%" id="userlist">
			<tr>
				<th width="100">ID</th>
				<th>图片URL</th>
			</tr>
			<?php for($i=1; $i<=count($array_page); $i++){ ?>
			<tr>
				<td width="100"><?php echo $i; ?></td>
				<td><?php echo $array_page[$i-1]; ?></td>
				 
				</td>
			</tr>
			<?php } ?>
		</table>
		<p class="hr"></p> 
	</div>
	</div>
		<br/>
		<button id="sort" class="blue" onclick="deleteallpage()">全部删除</button>
</li>
</ul>

<script>
var isRun = false;
var zipname = "";
function deleteallpage()
{
	
}

function createPage(operate)
{
	var numid = document.getElementById('numid').value;
	var context = {
		'numid':numid,
		'zipname':zipname,
		'operate':operate
	};
	$.ajax( {
		type: 'POST',
		dataType:'json',
		url:'createcomicpage',
		data:context,
		success:function(data) { 
			var msg = data.errMsg;
			if(msg === "success"){
				if(operate == "create")
					$('#showmsg').html("创建漫画页成功");
				else
					$('#showmsg').html("重构漫画页成功");
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
	var numid = document.getElementById('numid').value;
	var context = {
		'numid':numid
	};
	$("#uplaodImg").show();
	$('#fileUploadProcess').html("正在上传文件...");
	$.ajaxFileUpload
	({
		url:'<?php echo (base_url()."index.php/")?>admin/comicpageupload',
		secureuri:false,
		fileElementId:'uploadfile',
		dataType: 'json',
		data:context,
		success: function (data, status)
		{
			var msg = data.errMsg;
			if(msg=="success")
			{
				msg = "上传文件成功";
			}
			$('#fileUploadProcess').html(msg);
			var imgurl = data.fileurl;
			$("#uplaodImg").hide();
			zipname = data.file_name;
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