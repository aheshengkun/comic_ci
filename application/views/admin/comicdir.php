<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<dl class="row margin">
	<dt>
		<button id="create" class="blue" onclick="back()">返回</button>
	</dt>
</dl>

<div class="panel">
	<div class="header">漫画类型列表</div>
	<div class="body">
		
		<table class="tlist" width="100%" id="userlist">
			<tr>
				<th width="100">ID</th>
				<th>漫画路径</th>
				<th>操作</th>
			</tr>
			<tr>
				<td width="100"><?php echo $comicdir->id; ?></td>
				<td><?php echo $comicdir->comicdir; ?></td>
				<td><a href="<?php echo base_url()."index.php/admin/"?>editcomicdir?id=<?php echo $comicdir->id; ?>">编辑</a></td>
			</tr>
		</table>
		<p class="hr"></p> 
	</div>
</div>
	
</li>
</ul>
<script>
function back()
{
	history.go(-1);
}
</script>
</body>
</html>