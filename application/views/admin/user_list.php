<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<dl class="row margin">
	<dt>
		<select id="srchtype" value="">
			<option value="">搜索类型</option>
			<option value="uid">用户 ID</option>
			<option value="username">用户名</option>
		</select>
	
		<input type="text" id="keyword" placeholder="关键词" value="" style="width: 200px;" />
		<button id="search" class="blue">搜索</button>
	</dt>
	<dd class="right">
		<button id="create" class="blue" onclick="createUser()">创建用户</button>
	</dd>
</dl>

<div class="panel">
	<div class="header">用户列表</div>
	<div class="body">
		
		<table class="tlist" width="100%" id="userlist">
			<tr>
				<th width="100">ID</th>
				<th>用户名</th>
				<th>操作</th>
			</tr>
			<?php foreach($userlist as $_user){ ?>
			<tr>
				<td width="100"><?php echo $_user->id; ?></td>
				<td><?php echo $_user->username; ?></td>
				<td><a href="<?php echo $_user->id;?>.htm">编辑</a></td>
			</tr>
		<?php } ?>
		</table>
		<p class="hr"></p> 
	</div>
</div>
		<div id="pagelist">
		  <ul>
			<?php echo $page; ?>
			<li class="pageinfo">第<?php echo $curPage;?>页</li>
			<li class="pageinfo">共<?php echo $totalPage;?>页</li>
		  </ul>
		</div>
	
</li>
</ul>
<script>
function createUser()
{
	window.location.href="<?php echo base_url()."index.php/admin/"?>usercreate";
}
</script>
</body>
</html>