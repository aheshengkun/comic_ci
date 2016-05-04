<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ComicPage extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	private $comic_txt = "file.txt"; 
	private $pageHTML = "page.html";
	public function __construct()
    {
          parent::__construct();
          {
            //this is where the magic happens

            //inlcude a better hashing library
			$this->load->helper('url');
			$this->load->library('CommentFunction');
			$this->load->library('WordCodeClass');
			$this->load->model('admin/ComicNum_Model', 'ComicNum_Model');
          }
    }
	
	public function showComicPage()
	{
		if(isset($_GET['numid']))
		{
			$numid = $this->input->get('numid');
			$result = $this->getPath($numid);
			if($result['msg'] == "success")
			{
				$url_path =  $result['url_path'];
				$path = $result['path'];
				$filename = $path.$this->comic_txt;
				$array_page = array();
				if(file_exists($filename))
				{
					$fp = fopen($filename, "r");
					$contents = fread($fp, filesize ($filename));
					fclose($fp); 
					$array_page = explode("|", $contents);
					for ($i=0;$i<count($array_page);$i++)
					{
						$array_page[$i] = $url_path.$array_page[$i];
					}
				}
				$info['array_page'] = $array_page;
				$info['numid'] = $numid;
				$info['url_page'] = $url_path.$this->pageHTML;
				
				$this->load->view('admin/header');
				$this->load->view('admin/comicpage', $info);
			}		
		}
	}
	
	private function getPath($numid)
	{
		$result = array("msg"=>"success","path"=>"","url_path"=>"","comicname"=>"","numname"=>"");
		$dataSql = array(
						'id'  => $numid
					);
		$rows = $this->ComicNum_Model->query($dataSql);
		if($rows)
		{
			$result['comicname'] = $rows[0]->comicname;
			$result['numname'] = $rows[0]->numname;
			$dirname =  $rows[0]->dirname;
			$endcod_name = $this->wordcodeclass->unicode_encode($rows[0]->comicname);	//生成将名字加密为MD5		
			$result['path'] = $this->config->item('comic_base_dir').$endcod_name."/".$dirname."/";
			$result['url_path'] = $this->config->item('comic_base_url').$endcod_name."/".$dirname."/";
		}
		else
		{
			$result['msg'] = "error";
		}
		return $result;
	}
	
	private function createTxt($array)
	{
		$path = $array['path'];
		$url_path = $array['url_path'];
		$files=scandir($path);
		$content = "";
		$content_url = "";
		$frist_url = "";
		$total = 0;
		foreach ($files as $value)
		{
			if ($value != "." && $value != ".." && $value != $this->pageHTML)
			{
				$extension = $this->commentfunction->get_extension($value);
				if($extension == "jpg" || $extension == "png")
				{
					$total = $total + 1;
					if($content == "")
					{
						$content = $value;
						$frist_url = $url_path.$value;
						$content_url = $frist_url;
					}
					else
					{
						$content = $content."|".$value;
						$content_url = $content_url."|".$url_path.$value;
					}
				}
				else
				{
					$filename = $path.$value;
					if(!is_dir($filename))
					{
						unlink($filename);
					}
					else
					{
						$this->commentfunction->deldir($filename);
					}
				}
			}
		}
		$fp = fopen($path.$this->comic_txt, "w");
		fwrite($fp, $content);
		fclose($fp);
		if($total > 0)
		{
			$array_html = array(
				"total"=>$total,
				"frist_url"=>$frist_url,
				"content_url"=>$content_url,
				"comicname"=>$array['comicname'],
				"numname"=>$array['numname']
			);
			$filename = $path.$this->pageHTML;
			$this->createPageHTML($filename, $array_html);
		}
	}
	
	public function doUpload()
	{
		if(isset($_POST['numid']))
		{
			$numid = $this->input->post('numid');
			$result = $this->getPath($numid);
			if($result['msg'] == "success")
			{
				$config['upload_path']          = $result['path'];
				$config['allowed_types']        = 'zip';
				$uploadsize = ini_get('upload_max_filesize');
				$config['max_size']             = $uploadsize*1024;

				$this->load->library('upload', $config);
				$file_name = "";
				if ( ! $this->upload->do_upload('userfile'))
				{
					$msg = "文件格式不对或文件长度太大";
				}
				else
				{
					$msg = "success";
					$data = $this->upload->data();
					$file_name = $data['file_name'];
				}
				$data = array('errMsg'=>$msg, 'file_name'=>$file_name);
				echo json_encode($data);
			}
		}
	}
	
	public function createComicPage()
	{		
		$msg = "信息有误！";
		if(isset($_POST['numid']) && isset($_POST['zipname']) && isset($_POST['operate']))
		{
			$numid = $this->input->post('numid');
			$zipname = $this->input->post('zipname');
			$operate = $this->input->post('operate');
			$result = $this->getPath($numid);
			if($result['msg'] == "success")
			{
				$path = $result['path'];
				$url_path = $result['url_path'];
				if($operate == "create")
				{
					$filezip = $path.$zipname;
					if(!file_exists($filezip))
					{
						$msg = "找不到zip压缩文件";
						
					}
					else
					{
						//1.解压zip文件到指定文件目录下
						$this->commentfunction->get_zip_originalsize($filezip, $path);
						//2.遍历文件夹的所有文件，如是图$片文件名就保存到txt，否则删除文件。
						$this->createTxt($result);
						$msg = "success";
					}
				}
				if($operate == "renew")
				{
					$this->createTxt($result);
					$msg = "success";
				}
			}
		}
		$data = array('errMsg'=>$msg);
		echo json_encode($data);
	} 
	
	private function createPageHTML($filename, $array)
	{
		$base_url = $this->config->item('base_url');

		$content = "";
		$data = '<!doctype html>'."\x0d\x0a";
		$content = $content.$data;
		$data = '<html>'."\x0d\x0a";
		$content = $content.$data;
		$data = '<head>'."\x0d\x0a";
		$content = $content.$data;
		$data = '<title></title>'."\x0d\x0a";
		$content = $content.$data;
		$data = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'."\x0d\x0a";
		$content = $content.$data;
		$js = $base_url."assets/resources/js/jquery-1.3.2.js";
		$data = '<script type="text/javascript" src="'.$js.'"></script>'."\x0d\x0a";
		$content = $content.$data;
		$js = $base_url."assets/resources/js/kkpager.min.js";
		$data = '<script type="text/javascript" src="'.$js.'"></script>'."\x0d\x0a";
		$content = $content.$data;
		$js = $base_url."assets/resources/js/page.js";
		$data = '<script type="text/javascript" src="'.$js.'"></script>'."\x0d\x0a";
		$content = $content.$data;
		$css = $base_url."assets/resources/css/kkpager_orange.css";
		$data = '<link rel="stylesheet" type="text/css" href="'.$css.'" />'."\x0d\x0a";
		$content = $content.$data;
		$css = $base_url."assets/resources/css/page.css";
		$data = '<link rel="stylesheet" type="text/css" href="'.$css.'" />'."\x0d\x0a";
		$content = $content.$data;
		$data = '</head>'."\x0d\x0a";
		$content = $content.$data;
		$data = '<body>'."\x0d\x0a";
		$content = $content.$data;
		$data = '<div class="body_001">'."\x0d\x0a";
		$content = $content.$data;
		$data = '<div class="header_001">'."\x0d\x0a";
		$content = $content.$data;
		$data = '<div class="header_001_1"><a href="'.$base_url.'index.php">首页</a>><a href="#">'.$array['comicname'].'</a>>'.$array['numname'].'</div>'."\x0d\x0a";
		$content = $content.$data;
		$data = '</div>'."\x0d\x0a";
		$content = $content.$data;
		$data = '<div class="chapter">'."\x0d\x0a";
		$content = $content.$data;
		$data = '<div class="ui_button_page chapter_01">下一章</div>'."\x0d\x0a";
		$content = $content.$data;
		$data = '<div class="ui_button_page">上一章</div>'."\x0d\x0a";
		$content = $content.$data;
		$data = '</div>'."\x0d\x0a";
		$content = $content.$data;
		$data = '<div class="kkpager">'."\x0d\x0a";
		$content = $content.$data;
		$data = '<div id="kkpager"></div>'."\x0d\x0a";
		$content = $content.$data;
		$data = '</div>'."\x0d\x0a";
		$content = $content.$data;
		$data = '<div class="showimg">'."\x0d\x0a";
		$content = $content.$data;
		$data = '<img id="img_id" onClick="clickImg(event)" src="'.$array['frist_url'].'" />'."\x0d\x0a";
		$content = $content.$data;
		$data = '<div class="comicpage_001">'."\x0d\x0a";
		$content = $content.$data;
		$data = '<ul>'."\x0d\x0a";
		$content = $content.$data;
		$data = '<li><div class="ui_button_page" onClick="prePage()">上一页</div></li>'."\x0d\x0a";
		$content = $content.$data;
		$data = '<li><div class="divselect"><select class="select_01" onChange="selectChangeImg()"></select></div></li>'."\x0d\x0a";
		$content = $content.$data;
		$data = '<li><div class="ui_button_page" onClick="nextPage()">下一页</div></li>'."\x0d\x0a";
		$content = $content.$data;
		$data = '</ul>'."\x0d\x0a";
		$content = $content.$data;
		$data = '</div>'."\x0d\x0a";
		$content = $content.$data;
		$data = '<br/><br/>'."\x0d\x0a";
		$content = $content.$data;
		$data = '</div>'."\x0d\x0a";
		$content = $content.$data;
		$data = '<script type="text/javascript">'."\x0d\x0a";
		$content = $content.$data;
		$data = 'var totalPage = '.$array['total'].';'."\x0d\x0a";
		$content = $content.$data;
		$data = 'var totalRecords = totalPage;'."\x0d\x0a";
		$content = $content.$data;
		$data = 'var page_urls = "";'."\x0d\x0a";
		$content = $content.$data;
		$data = 'var contents = "'.$array['content_url'].'";'."\x0d\x0a";
		$content = $content.$data;
		$data = 'initSelect();'."\x0d\x0a";
		$content = $content.$data;
		$data = 'initPage();'."\x0d\x0a";
		$content = $content.$data;
		$data = '</script>'."\x0d\x0a";
		$content = $content.$data;
		$data = '</body>'."\x0d\x0a";
		$content = $content.$data;
		$data = '</html>'."\x0d\x0a";
		$content = $content.$data;
		
		$f=fopen($filename, "w");
		//$content=utf8_encode($content); 
		//$content="\xEF\xBB\xBF".$content;
		fputs($f, $content);
		fclose($f);
	}
	
}
?>