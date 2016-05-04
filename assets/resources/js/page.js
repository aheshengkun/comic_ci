function initPage()
{
	page_urls = contents.split("|");
}
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
	document.getElementById("img_id").src = page_urls[n-1];
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

function clickImg(ev)
{
	var width = $(window).width()/2;
	ev = ev || window.event;
	var x;
	if (ev.pageX)
	{
		x = ev.pageX;
	}
	else
	{
		x = ev.clientX + document.body.scrollLeft - document.body.clientLeft; 
	}
	if(x > width)
	{
		nextPage();
	}
	else
	{
		prePage();
	}
	
}