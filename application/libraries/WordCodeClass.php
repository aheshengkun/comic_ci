<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WordCodeClass {

	public function __construct()
    {
	
    }
	
	function unicode_encode($name)
	{
		$name = iconv('UTF-8', 'UCS-2', $name);
		$len = strlen($name);
		$str = '';
		for ($i = 0; $i < $len - 1; $i = $i + 2)
		{
			$c = $name[$i];
			$c2 = $name[$i + 1];
			if (ord($c) > 0)
			{    // 两个字节的文字
				$str .= '_'.base_convert(ord($c), 10, 16).base_convert(ord($c2), 10, 16);
			}
			else
			{
				$str .= $c2;
			}
		}
		return $str;
	}

	function unicode_decode($name)
	{
		// 转换编码，将Unicode编码转换成可以浏览的utf-8编码
		$name = str_replace('_','\u',$name);
		$pattern = '/([\w]+)|(\\\u([\w]{4}))/i';
		preg_match_all($pattern, $name, $matches);
		var_dump($matches);
		if (!empty($matches))
		{
			$name = '';
			for ($j = 0; $j < count($matches[0]); $j++)
			{
				$str = $matches[0][$j];
				if (strpos($str, '\\u') === 0)
				{
					$code = base_convert(substr($str, 2, 2), 16, 10);
					$code2 = base_convert(substr($str, 4), 16, 10);
					$c = chr($code).chr($code2);
					$c = iconv('UCS-2', 'UTF-8', $c);
					$name .= $c;
				}
				else
				{
					$name .= $str;
				}
			}
		}
		return $name;
	}
}