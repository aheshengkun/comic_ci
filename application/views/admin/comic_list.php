<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<dl class="row margin">
	<dt>
		<select id="srchtype" value="">
			<option value="uid">漫画类型</option>
			<option value="username">漫画名</option>
		</select>
	
		<input type="text" id="keyword" placeholder="关键词" value="" style="width: 200px;" />
		<button id="search" class="blue">搜索</button>
	</dt>
	<dd class="right">
		<button id="search" class="blue" onclick="location.reload()">刷新</button>
		<button id="create" class="blue" onclick="createComic()">创建漫画</button>
	</dd>
</dl>

<div class="panel">
	<div class="header">漫画列表</div>
	<div class="body">
		
		<table class="tlist" width="100%" id="userlist">
			<tr>
				<th width="100">ID</th>
				<th>漫画名</th>
				<th>漫画作者</th>
				<th>上映时间</th>
				<th>操作</th>
			</tr>
			<?php foreach($comiclist as $_comic){ ?>
			<tr>
				<td width="100"><?php echo $_comic->id; ?></td>
				<td><?php echo $_comic->name; ?></td>
				<td><?php echo $_comic->author; ?></td>
				<td><?php echo $_comic->showdate; ?></td>
				<td><a href="<?php echo base_url()."index.php/admin/editcomic?comicname=".$_comic->name ?>">编辑</a>
				|<a href="<?php echo base_url()."index.php/admin/comicnumlist?comicname=".$_comic->name ?>">集数管理</a>
				|<a href="<?php echo base_url()."index.php/admin/createcomicnum?comicname=".$_comic->name ?>">创建集数</a>
				</td>
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
function createComic()
{
	window.location.href="<?php echo base_url()."index.php/admin/"?>createcomic";
}
</script>
</body>
</html>