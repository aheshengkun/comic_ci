<!doctype html>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="jquery-1.3.2.js"></script>
<script type="text/javascript" src="kkpager.min.js"></script>
<link rel="stylesheet" type="text/css" href="kkpager_orange.css" />
</head>
<style>
.showimg{
	width:700px;
	margin:0 auto;
}
.showimg img{
	width:700px;
}
.ui_button_page{
	background: none repeat scroll 0 0 #32b5f2; 
	width:100px;  
	height:30px;  
	border-width: 0; 
	font-size: 17px; 
	color: #FFFFFF; 
	font-weight: 500;  
	border-radius: 6px; 
	cursor:pointer;
	line-height:30px;
	text-align:center; 
	border:1px solid #BDCFE4;
	opacity:1; 
	filter: alpha(opacity=100);
}
.ui_button_page:hover{
	opacity:0.90; 
	filter: alpha(opacity=90);
}
.comicpage_001{
	width:310px;
	margin:0 auto;
}
.comicpage_001 ul{
	margin:0px;
	padding:0px;
}
.comicpage_001 ul li{
	list-style:none;
	float: left;
}
.divselect{
	margin: 0px 10px;
}
.select_01{
	font-size:24px;
	width:80px;
}
.body_001{
	background-color: #023D58;
	width:100%;
}
body{
	margin:0px;
	padding:0px;
}
.kkpager{
	width:800px;
	margin:0 auto;
	padding:5px 0px;
}
.header_001{
	font-size: 16px;
	color: #FFFFFF;
	background-color: #000000;
	height: 35px;
	line-height: 35px;
}
.header_001 a{
	color: #FFFFFF;
	text-decoration: none;
}
.header_001_1{
	padding-left:10px;
}
.chapter{
	width:800px;
	margin:0 auto;
	padding:10px 0px;
}
.chapter_01{
	float:right;
}
</style>
<body>
<div class="body_001">
<!-- 头部菜单 start -->
<div class="header_001">
<div class="header_001_1"><a href="#">首页</a>><a href="#">火影忍者</a>>第一话</div>
</div>
<!-- 头部菜单 end -->
<div class="chapter">
<div class="ui_button_page chapter_01">下一章</div>
<div class="ui_button_page">上一章</div>
</div>
<!-- 章节 start -->
<div >
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
var dir = "../../hhhhh/(C86) [MTSP (Jin)] 橘さん家ノ男性事情 まとめ版 [天月NTR]/";
initSelect();
function initSelect()
{
	for(var i=1; i<=totalPage; i++)
	{
		$('select').append("<option value=\"" + i + "\">" + i + "</option>");
	}
}

function changeSelect(n)
{
	var str = n + "";
	$("select").val(str);
}

function getParameter(name) { 
	var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)"); 
	var r = window.location.search.substr(1).match(reg); 
	if (r!=null) return unescape(r[2]); return null;
}

//init
$(function(){
	var pageNo = getParameter('pno');
	if(!pageNo){
		pageNo = 1;
	}
	//生成分页
	//有些参数是可选的，比如lang，若不传有默认值
	kkpager.generPageHtml({
		pno : pageNo,
		//总页码
		total : totalPage,
		//总数据条数
		totalRecords : totalRecords,
		mode : 'click',//默认值是link，可选link或者click
		click : function(n){
			// do something
			//手动选中按钮
			this.selectPage(n);
			changeImg(n);
			changeSelect(n);
			return false;
		}
		/*
		,lang				: {
			firstPageText			: '首页',
			firstPageTipText		: '首页',
			lastPageText			: '尾页',
			lastPageTipText			: '尾页',
			prePageText				: '上一页',
			prePageTipText			: '上一页',
			nextPageText			: '下一页',
			nextPageTipText			: '下一页',
			totalPageBeforeText		: '共',
			totalPageAfterText		: '页',
			currPageBeforeText		: '当前第',
			currPageAfterText		: '页',
			totalInfoSplitStr		: '/',
			totalRecordsBeforeText	: '共',
			totalRecordsAfterText	: '条数据',
			gopageBeforeText		: '&nbsp;转到',
			gopageButtonOkText		: '确定',
			gopageAfterText			: '页',
			buttonTipBeforeText		: '第',
			buttonTipAfterText		: '页'
		}*/
	});
});

function makeUpZero(str, num)
{
	str = str + "";
	var len = str.length;
	var count = num - len;
	for(var i=0; i<count; i++){
		str = "0" + str;
	}
	return str;
}

function changeImg(n)
{
	var imgName = makeUpZero(n, 3) + ".jpg";
	document.getElementById("img_id").src = dir + imgName;
}

function selectChangeImg()
{
	var n = $("select").val();
	kkpager.selectPage(n);
	changeImg(n);
}

function nextPage()
{
	var curPage = kkpager.pno;
	if(curPage >= totalPage)
	{
		return ;
	}
	var nextPage = curPage + 1;
	kkpager.selectPage(nextPage);
	changeImg(nextPage);
	changeSelect(nextPage);
}

function prePage()
{
	var curPage = kkpager.pno;
	if(curPage <= 1)
	{
		return;
	}
	var prePage = curPage - 1;
	kkpager.selectPage(prePage);
	changeImg(prePage);
	changeSelect(prePage);
}

function clickImg(event)
{
	var width = screen.availWidth/2;
	var x = event.x;
	if(x > width)
	{
		nextPage();
	}
	else
	{
		prePage();
	}
	
}
</script>
</body>
</html>