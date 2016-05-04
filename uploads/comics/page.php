<!doctype html>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="jquery-1.3.2.js"></script>
<script type="text/javascript" src="kkpager.min.js"></script>
<link rel="stylesheet" type="text/css" href="kkpager_orange.css" />
<link rel="stylesheet" type="text/css" href="page.css" />
</head>
<body>
<div class="body_001">
<!-- 头部菜单 start -->
<div class="header_001">
<div class="header_001_1"><a href="#">首页</a>><a href="#">火影忍者</a>>第一话</div>
</div>
<!-- 头部菜单 end -->
<!-- 章节 start -->
<div class="chapter">
<div class="ui_button_page chapter_01">下一章</div>
<div class="ui_button_page">上一章</div>
</div>
<!-- 章节 end -->
<!-- 分页 start -->
<div class="kkpager">
<div id="kkpager"></div>
</div>
<!-- 分页 end -->
<!-- 显示漫画 start -->
<div class="showimg">
	<img id="img_id" onClick="clickImg(event)" src="../../hhhhh/(C86) [MTSP (Jin)] 橘さん家ノ男性事情 まとめ版 [天月NTR]/001.jpg" />
</div>
<!-- 显示漫画 end -->
<!-- select分页 start -->
<div class="comicpage_001">
	<ul>
		<li><div class="ui_button_page" onClick="prePage()">上一页</div></li>
		<li><div class="divselect"><select class="select_01" onChange="selectChangeImg()"></select></div></li>
		<li><div class="ui_button_page" onClick="nextPage()">下一页</div></li>
	</ul>
</div>
<!-- select分页 end -->
<br/><br/>
</div>
<script type="text/javascript">
var totalPage = 100;
var totalRecords = totalPage;
var page_urls = "";
var contents = "";
initSelect();
initPage();
</script>
<script type="text/javascript" src="kkpager.min.js"></script>
</body>
</html>