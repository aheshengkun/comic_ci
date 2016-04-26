<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<dl class="row margin">
	<dt>
		<button id="create" class="blue" onclick="createType()">创建漫画类型</button>
	</dt>
	<dd class="right">
	</dd>
</dl>

<div class="panel">
	<div class="header">漫画类型列表</div>
	<div class="body">
		
		<table class="tlist" width="100%" id="userlist">
			<tr>
				<th width="100">排序ID</th>
				<th>ID</th>
				<th>类型名</th>
				<th>操作</th>
			</tr>
			<?php foreach($typelist as $_type){ ?>
			<tr>
				<td><input type="text" name="sortid" id="sortid" sortid="<?php echo $_type->id ?>" value="<?php echo $_type->sort_id ?>" style="width:50px" /></td>
				<td><?php echo $_type->id; ?></td>
				<td><?php echo $_type->type; ?></td>
				<td><a href="<?php echo base_url()."index.php/admin/"?>comictypedelete?per_page=<?php echo $curPage ?>&typeid=<?php echo $_type->id;?>">删除</a></td>
			</tr>
		<?php } ?>
		</table>
		<p class="hr"></p> 
	</div>
</div>
		<br/>
		<button id="sort" class="blue" onclick="saveSort()">保存排序</button>
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
function saveSort()
{
	sendSort('sortcomictype');
}
function createType()
{
	window.location.href="<?php echo base_url()."index.php/admin/"?>comictypecreate";
}
function deleteType(param)
{
	window.location.href="<?php echo base_url()."index.php/admin/"?>comictypecreate";
}
</script>
</body>
</html>