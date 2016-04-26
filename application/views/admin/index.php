<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style>
dl.row.form dt {width: 15%;}
dl.row.form dd {width: 85%;}
</style>
<div class="panel">
	<div class="header"> 当前环境信息 </div>
	<div class="body">
		<dl class="row form">
			<dt>操作系统: </dt><dd><?php echo $system ?></dd>
			<dt>Web Server: </dt><dd><?php echo $php_sapi_name ?></dd>
			<dt>PHP: </dt><dd><?php echo $server_software ?></dd>
			<dt>数据库: </dt><dd><?php echo $version ?></dd>
			<dt>最大文件上传大小: </dt><dd><?php echo $upload_max_filesize ?></dd>
			<dt>最大 POST 数据大小: </dt><dd><?php echo $post_max_size ?></dd>
		</dl>
	</div>
</div>
</li>
</ul>

</body>
</html>