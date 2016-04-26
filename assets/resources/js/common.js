function getSortStr()
{
	var obj = $("input[name='sortid']");
	var str = "";
	for(var i=0; i<obj.length; i++)
	{
		var str_sortid = obj.eq(i).attr('value');
		var str_id = obj.eq(i).attr('sortid');
		if(i==0)
		{
			str = str + str_id + "|" + str_sortid;
			continue;
		}
		str = str + "," + str_id + "|" + str_sortid;
	}
	return str;
}
function sendSort(url)
{
	var str = getSortStr();
	var context = {'sortstr':str};
	$.ajax( {
		type: 'POST',
		dataType:'json',
		url:url,
		data:context,
		success:function(data) { 
			var msg = data.errMsg;
			if(msg === "success"){
				//location.reload();
			}else{
				//$('#errMsg').html(msg);
			}
		}
	});
}
function back()
{
	history.go(-1);
}
function IsDigit(cCheck) { return (('0'<=cCheck) && (cCheck<='9')); } 
function IsAlpha(cCheck) { return ((('a'<=cCheck) && (cCheck<='z')) || (('A'<=cCheck) && (cCheck<='Z'))) } 
function mytrim(str)
{ 
	return str.replace(/(^\s*)|(\s*$)/g, "");
}

function VerifyLenAndName(param, min, max)
{
	var msg = VerifyLen(param, min, max);
	if(msg === "1")
	{
		return VerifyName(param);
	}
	return msg;
}

function VerifyLen(param, min, max)
{
	var str = mytrim(param);
	if (str == "") 
	{ 
		return '不能为空'; 
	} 
	var len = str.length;
	if(len >=min && len <= max)
	{
		return '1';
	}
	return '长度错误';
}

function VerifyNum(param, maxlen)
{
	var str = mytrim(param);
	if (str == "") 
	{ 
		return '不能为空'; 
	} 
	var len = str.length;
	if(len > maxlen)
	{
		return '长度错误';
	}
	for (nIndex=0; nIndex<len; nIndex++) 
	{
		var cCheck = str.charAt(nIndex);
		if (!(IsDigit(cCheck)))
		{
			return '只允许数字'; 
		}
	}
	return '1'; 
}

function VerifyName(param) 
{ 
	var str = mytrim(param);
	if (str == "") 
	{ 
		return '不能为空'; 
	} 
	for (nIndex=0; nIndex<str.length; nIndex++) 
	{ 
		var cCheck = str.charAt(nIndex); 
		if ( nIndex==0 && ( cCheck =='-' || cCheck =='_') ) 
		{ 
			return '首字符不能为-或者_'; 
		} 
		if (!(IsDigit(cCheck) || IsAlpha(cCheck) || cCheck=='-' || cCheck=='_' )) 
		{ 
			return '只允许英文和数字以及-和_'; 
		} 
	} 
	return '1'; 
} 