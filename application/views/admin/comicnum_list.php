<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<dl class="row margin">
	<dt>
		<input type="text" id="keyword" placeholder="关键词" value="" style="width: 200px;" />
		<button id="search" class="blue">搜索</button>
	</dt>
	<dd class="right">
		<button id="create" class="blue" onclick="back()">返回</button>
		<button id="search" class="blue" onclick="location.reload()">刷新</button>
		<button id="create" class="blue" onclick="createComicNum()">创建漫画集数</button>
	</dd>
</dl>

<div class="panel">
	<div class="header">漫画集数列表</div>
	<div class="body">
		
		<table class="tlist" width="100%" id="userlist">
			<tr>
				<th width="100">排序ID</th>
				<th width="100">ID</th>
				<th>漫画名</th>
				<th>漫画集数名</th>
				<th>文件夹名</th>
				<th>操作</th>
			</tr>
			<?php foreach($comicnumlist as $_comicnum){ ?>
			<tr>
				<td><input type="text" name="sortid" id="sortid" sortid="<?php echo $_comicnum->id ?>" value="<?php echo $_comicnum->sort_id ?>" style="width:50px" /></td>
				<td><?php echo $_comicnum->id; ?></td>
				<td><?php echo $_comicnum->comicname; ?></td>
				<td><?php echo $_comicnum->numname; ?></td>
				<td><?php echo $_comicnum->dirname; ?></td>
				<td>
				<a href="<?php echo base_url()."index.php/admin/editcomicnum?numid=".$_comicnum->id ?>">编辑</a>
				|<a href="<?php echo base_url()."index.php/admin/comicpagelist?numid=".$_comicnum->id ?>">页数管理</a>
				</td>
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
	sendSort('sortcomicnum');
}
function createComicNum()
{
	window.location.href="<?php echo base_url()."index.php/admin/createcomicnum?comicname=".$comicname ?>";
}
function deleteType(param)
{
	window.location.href="<?php echo base_url()."index.php/admin/"?>comictypecreate";
}
</script>
</body>
</html>