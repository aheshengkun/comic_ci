<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comic extends CI_Controller {

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
	 
	public function __construct()
    {
          parent::__construct();
          {
            //this is where the magic happens

            //inlcude a better hashing library
			$this->load->helper('url');
			$this->load->library('PaginationExClass');
			$this->load->library('WordCodeClass');
			$this->load->library('form_validation');
			$this->load->model('admin/Comic_Model', 'Comic_Model');
			$this->load->model('admin/ComicType_Model', 'ComicType_Model');
			$this->load->model('admin/ComicTypes_Model', 'ComicTypes_Model');
			$this->load->model('admin/ComicDir_Model', 'ComicDir_Model');
          }
    }
	public function showComicList()
	{
		$total = $this->Comic_Model->total();
		$num = 20;
		$pageurl = $this->config->item('base_url').'/index.php/admin/comiclist/';
		$info['page'] = $this->paginationexclass->page($pageurl,$total,$num);
		if($total <= $num)
		{
			$totalPage = 1;
		}
		else
		{
			$totalPage = intval($total/$num) + 1;
		}
		$page = 1;
		if($this->input->get('per_page'))
		{
			$page = trim($this->input->get('per_page'));
			if($page > $totalPage){
				$page = $totalPage;
			}
			if($page <= 0)
			{
				$page = 1;
			}
		}
		$query = $this->Comic_Model->query_limit($num, $num*($page-1));
		$info['comiclist'] = $query;
		$info['curPage'] = $page;
		$info['totalPage'] = $totalPage;
		$this->load->view('admin/header');
		$this->load->view('admin/comic_list', $info);
	}
	
	private function dirUrl($name, $covername, &$coverurl, &$coverdir)
	{
		$comic_base_dir =  $this->config->item('comic_base_dir');
		$endcod_name = $this->wordcodeclass->unicode_encode($name);	//生成将名字加密为MD5
		$dir = $comic_base_dir.$endcod_name."/";	//生成保存漫画文件路径
		if(!file_exists($dir))
		{
			mkdir($dir);
		}
		$srcFile = $coverdir.$covername;
		$desFile = $dir.$covername;
		if(file_exists($srcFile))
		{
			copy($srcFile, $desFile);	//将上传成功的图片 复制到 漫画文件路径下
			unlink($srcFile);
		}
		$coverurl = $endcod_name."/".$covername;
		$coverdir = $endcod_name."/";
	}
	
	private function updateCoverPic($srcFile, $desFile, $delFile)
	{
		if(file_exists($delFile)) //删除之前的文件
		{
			unlink($delFile);
		}
		if(file_exists($srcFile))
		{
			copy($srcFile, $desFile);	//将上传成功的图片 复制到 漫画文件路径下
			unlink($srcFile);
		}
	}
	
	public function createComic()
	{
		if(isset($_POST['name']) && isset($_POST['comictype']))
		{
			//add comic
			$msg = "";
			$this->form_validation->set_rules('name','name','trim|required|min_length[1]|max_length[45]');
			$this->form_validation->set_rules('showdate','showdate','trim|required|min_length[1]|max_length[45]');
			$this->form_validation->set_rules('author','author','trim|required|min_length[1]|max_length[45]');
			$this->form_validation->set_rules('searchword','searchword','trim|required|min_length[1]|max_length[500]');
			$this->form_validation->set_rules('description','description','trim|required|min_length[1]|max_length[2000]');
			$this->form_validation->set_rules('covername','covername','trim|required|min_length[1]|max_length[45]');
			$this->form_validation->set_rules('status','status','trim|required|min_length[1]|max_length[45]');
			$this->form_validation->set_rules('coverdir','coverdir','trim|required|min_length[1]|max_length[200]');
			if ($this->form_validation->run() == FALSE)
			{
				$msg = "输入信息有误";
			}
			else
			{
				$name = $this->input->post('name');
				if(strpos($name, '_') != "")
				{
					$msg = "漫画名不能包含下划线";
				}
				$author = $this->input->post('author');
				$description = $this->input->post('description');
				$showdate = $this->input->post('showdate');
				$searchword = $this->input->post('searchword');
				$covername = $this->input->post('covername');
				$coverdir = $this->input->post('coverdir');
				$coverurl = "";
				$array = array(
					'name'  => $name
					);
				$row = $this->Comic_Model->query($array);	
				if(!$row)
				{
					$this->dirUrl($name, $covername, $coverurl, $coverdir);
					$this->Comic_Model->name = $name;
					$this->Comic_Model->description = $description;
					$this->Comic_Model->showdate = $showdate;
					$this->Comic_Model->searchword = $searchword;
					$this->Comic_Model->covername = $covername;
					$this->Comic_Model->coverurl = $coverurl;
					$this->Comic_Model->coverdir = $coverdir;
					$this->Comic_Model->author = $author;
					$this->Comic_Model->types = trim($this->input->post('comictype'));
					$this->Comic_Model->status = $this->input->post('status');
					//$this->db->trans_begin();
					if($this->Comic_Model->insert())
					{
						$msg = "success";
					}
					else{
						$msg = "输入数据有误创建失败";
					}
				}
				else
				{
					$msg = "漫画名已存在";
				}
			}
			$data = array('errMsg'=>$msg);
			echo json_encode($data);
			return;
		}
		
		$dataSql = array(
							'1'  => 1
						);
		$rows = $this->ComicType_Model->query($dataSql);
		$info['typelist'] =  $rows;
		$this->load->view('admin/header');
		$this->load->view('admin/comic_create', $info);
	}
	
	public function updateComic()
	{
		if(isset($_POST['name']) && isset($_POST['comictype']))
		{
			//update comic
			$msg = "";
			$this->form_validation->set_rules('name','name','trim|required|min_length[1]|max_length[45]');
			$this->form_validation->set_rules('showdate','showdate','trim|required|min_length[1]|max_length[45]');
			$this->form_validation->set_rules('author','author','trim|required|min_length[1]|max_length[45]');
			$this->form_validation->set_rules('searchword','searchword','trim|required|min_length[1]|max_length[500]');
			$this->form_validation->set_rules('description','description','trim|required|min_length[1]|max_length[2000]');
			$this->form_validation->set_rules('covername','covername','trim|required|min_length[1]|max_length[45]');
			$this->form_validation->set_rules('status','status','trim|required|min_length[1]|max_length[45]');
			$this->form_validation->set_rules('coverdir','coverdir','trim|required|min_length[1]|max_length[200]');
			if ($this->form_validation->run() == FALSE)
			{
				$msg = "输入信息有误";
			}
			else
			{
				$name = $this->input->post('name');
				$author = $this->input->post('author');
				$description = $this->input->post('description');
				$showdate = $this->input->post('showdate');
				$searchword = $this->input->post('searchword');
				$covername = $this->input->post('covername');
				$coverdir = $this->input->post('coverdir');
				
				$array = array(
					'name'  => $name
					);
				$row = $this->Comic_Model->query($array);	
				if($row)
				{
					$coverdirTmp = $coverdir;
					$coverdir = $row[0]->coverdir;
					$covernameTmp = $row[0]->covername;
					$coverurl = $row[0]->coverurl;
					//如果上传过图片就更新漫画封面
					if($covernameTmp != $covername)
					{
						$endcod_name = $this->wordcodeclass->unicode_encode($name);	//生成将名字加密为MD5
						$coverdir = $endcod_name."/";
						$scrFile = $coverdirTmp.$covername;
						$desFile = $this->config->item('comic_base_dir').$coverdir.$covername;
						$delFile = $this->config->item('comic_base_dir').$coverdir.$covernameTmp;
						$this->updateCoverPic($scrFile, $desFile, $delFile);
						
						$coverurl = $endcod_name."/".$covername;
					}
					$this->load->model('admin/ComicTypes_Model', 'ComicTypes_Model');
					$this->Comic_Model->description = $description;
					$this->Comic_Model->showdate = $showdate;
					$this->Comic_Model->searchword = $searchword;
					$this->Comic_Model->covername = $covername;
					$this->Comic_Model->coverurl = $coverurl;
					$this->Comic_Model->coverdir = $coverdir;
					$this->Comic_Model->author = $author;
					$this->Comic_Model->types = trim($this->input->post('comictype'));
					$this->Comic_Model->status = $this->input->post('status');
					$this->Comic_Model->update($array);
					$msg = "success";
				}
				else
				{
					$msg = "漫画不存在更新失败";
				}
			}
			$data = array('errMsg'=>$msg);
			echo json_encode($data);
			return;
		}
	}
	
	public function editComic()
	{
		if(isset($_GET['comicname']))
		{
			$comicname = $this->input->get('comicname');
			$dataSql = array(
						'1'  => 1
					);
					
			$rows = $this->ComicType_Model->query($dataSql);
			$info['typelist'] =  $rows;
			$dataSql = array(
						'comicname'  => $comicname
					);
			
			$dataSql = array(
						'name'  => $comicname
					);
			$rows = $this->Comic_Model->query($dataSql);
			$rows[0]->coverurl = $this->config->item('comic_base_url').$rows[0]->coverurl;
			$info['comic'] =  $rows[0];
			$info['types'] =  explode("|", $rows[0]->types);
			$this->load->view('admin/header');
			$this->load->view('admin/comic_edit', $info);		
		}
	}
}
