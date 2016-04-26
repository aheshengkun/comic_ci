<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="<?php echo (base_url()."assets/resources")?>/css/style.css" type="text/css">
	<link rel="stylesheet" href="<?php echo (base_url()."assets/resources")?>/css/admin.css" type="text/css">
	<link rel="stylesheet" href="<?php echo (base_url()."assets/resources")?>/css/main.css" type="text/css">
	<script src="<?php echo (base_url()."assets/resources")?>/js/jquery-1.3.2.js" type="text/javascript"></script>
	<script src="<?php echo (base_url()."assets/resources")?>/js/ajaxfileupload.js" type="text/javascript"></script>
	<script src="<?php echo (base_url()."assets/resources")?>/js/common.js" type="text/javascript"></script>
	<title></title>
</head>
<body>
<ul class="row" id="admin_header" style="background: #000000; line-height: 36px;">
	<li style="width: 100px;">
		<a href="#"><img style="margin-top: 4px;" height="26" align="top"></a>
	</li>
	<li id="admin_link">
		<a href="index" style="color:red;">后台</a>
		<a href="#" target="_blank">前台</a>
	</li>
	<li style="width: 200px;" class="right">
		欢迎您，<?php echo $_COOKIE["TokenBackLogin"] ?>, <a href="loginout">退出</a> &nbsp;
	</li>
</ul>
<ul class="row vtop">
	<li style="width: 200px;">
		<div id="admin_menu" class="left_menu margin">
			<div>
				<h3>设置</h3>
					<a href="<?php echo (base_url()."index.php/admin/") ?>index">基本信息</a>
					<a href="<?php echo (base_url()."index.php/admin/") ?>comicdir">漫画路径</a>
			</div>
			<div>
				<h3>后台用户</h3>
				<a href="<?php echo (base_url()."index.php/admin/") ?>userlist">用户管理</a>
				<a href="<?php echo (base_url()."index.php/admin/") ?>usercreate">添加用户</a>
			</div>
			<div>
				<h3>漫画类型</h3>
					<a href="<?php echo (base_url()."index.php/admin/") ?>comictypelist">漫画类型管理</a>
					<a href="<?php echo (base_url()."index.php/admin/") ?>comictypecreate">添加类型</a>
			</div>
			<div>
				<h3>漫画</h3>
				<a href="<?php echo (base_url()."index.php/admin/") ?>comiclist">漫画管理</a>
				<a href="<?php echo (base_url()."index.php/admin/") ?>createcomic">添加漫画</a>
			</div>
		</div>
	</li>
<li style="vertical-align: top; padding: 0px 8px; ">