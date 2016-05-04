<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ComicNum extends CI_Controller {

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
			$this->load->library('form_validation');
			$this->load->library('WordCodeClass');
			$this->load->model('admin/ComicNum_Model', 'ComicNum_Model');
          }
    }
	public function showComicNumList()
	{
		if(isset($_GET['comicname']))
		{
			$comicname = $this->input->get('comicname');
			$total = $this->ComicNum_Model->total();
			$num = 20;
			$pageurl = $this->config->item('base_url').'/index.php/admin/comicnumlist/';
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
			$sqldata = array(
				'comicname' => $comicname
			);
			$strOrderBy = "sort_id ASC";
			$query = $this->ComicNum_Model->query_where_limit_orderby($sqldata, $num, $num*($page-1), $strOrderBy);
			$info['comicnumlist'] = $query;
			$info['comicname'] = $comicname;
			$info['curPage'] = $page;
			$info['totalPage'] = $totalPage;
			$this->load->view('admin/header');
			$this->load->view('admin/comicnum_list', $info);
		}
	}
	
	public function editComicNum()
	{
		if(isset($_GET['numid']))
		{
			$numid = $this->input->get('numid');
			$dataSql = array(
						'id'  => $numid
					);
					
			$rows = $this->ComicNum_Model->query($dataSql);
			$info['comicnum'] =  $rows[0];
			$this->load->view('admin/header');
			$this->load->view('admin/comicnum_edit', $info);		
		}
	}
	
	public function sortComicNum()
	{
		$msg = "";
		if(isset($_POST['sortstr']))
		{
			$sortstr = trim($this->input->post('sortstr'));
			if($sortstr != "")
			{
				$array = explode(",", $sortstr);
				for($i=0; $i<count($array); $i++)
				{
					$array2 = explode("|", $array[$i]);
					if(count($array2) == 2)
					{
						$this->ComicNum_Model->id = $array2[0];
						$this->ComicNum_Model->sort_id = $array2[1];
						$this->ComicNum_Model->updateSort();
					}
					else
					{
						$msg = "error";
						break;
					}
				}
				if($msg == "")
				{
					$msg = "success";
				}
			}
		}
		$data = array('errMsg'=>$msg);
		echo json_encode($data);
		return;
	}
	
	public function createComicNum()
	{
		if(isset($_POST['comicname']) && isset($_POST['numname']))
		{
			//add comicnum
			$msg = "";
			$this->form_validation->set_rules('comicname','comicname','trim|required|min_length[1]|max_length[45]');
			$this->form_validation->set_rules('numname','numname','trim|required|min_length[1]|max_length[45]');
			$this->form_validation->set_rules('dirname','dirname','trim|required|min_length[1]|max_length[45]|regex_match[/^[0-9]+$/]');
			$this->form_validation->set_rules('sort_id','sort_id','trim|required|min_length[1]|max_length[10]|regex_match[/^[0-9]+$/]');
			if ($this->form_validation->run() == FALSE)
			{
				$msg = "输入信息有误";
			}
			else
			{
				$comicname = $this->input->post('comicname');
				$numname = $this->input->post('numname');
				$dirname = $this->input->post('dirname');
				$sort_id = $this->input->post('sort_id');
				$coverurl = "";
				$array = array(
					'numname'  => $numname,
					'comicname' => $comicname
					);
				$row = $this->ComicNum_Model->query($array);	
				if(!$row)
				{
					$this->ComicNum_Model->comicname = $comicname;
					$this->ComicNum_Model->numname = $numname;
					$this->ComicNum_Model->dirname = $dirname;
					$this->ComicNum_Model->sort_id = $sort_id;
					$this->ComicNum_Model->cmp = $comicname."_".$dirname;
					$this->ComicNum_Model->insert();
					$endcod_name = $this->wordcodeclass->unicode_encode($comicname);	//生成将名字加密为MD5	
					$path = $this->config->item('comic_base_dir').$endcod_name."/".$dirname."/";
					if(!file_exists($path))
					{
						mkdir($path,0777,true);
					}
					$msg = "success";
				}
				else
				{
					$msg = "漫画集数名已存在";
				}			
			}
			$data = array('errMsg'=>$msg);
			echo json_encode($data);
			return;
		}
		
		if(isset($_GET['comicname']))
		{
			$comicname = $this->input->get('comicname');
			$info['comicname'] = $comicname;
			$this->load->view('admin/header');
			$this->load->view('admin/comicnum_create', $info);
		}
	}
	
	public function updateComicNum()
	{
		if(isset($_POST['comicname']) && isset($_POST['numname']))
		{
			//update comicnum
			$msg = "";
			$this->form_validation->set_rules('numid','numid','trim|required|regex_match[/^[0-9]+$/]');
			$this->form_validation->set_rules('comicname','comicname','trim|required|min_length[1]|max_length[45]');
			$this->form_validation->set_rules('numname','numname','trim|required|min_length[1]|max_length[45]');
			$this->form_validation->set_rules('dirname','dirname','trim|required|min_length[1]|max_length[45]|regex_match[/^[0-9]+$/]');
			$this->form_validation->set_rules('sort_id','sort_id','trim|required|min_length[1]|max_length[10]|regex_match[/^[0-9]+$/]');
			if ($this->form_validation->run() == FALSE)
			{
				$msg = "输入信息有误";
			}
			else
			{
				$comicname = $this->input->post('comicname');
				$numid = $this->input->post('numid');
				$numname = $this->input->post('numname');
				$dirname = $this->input->post('dirname');
				$sort_id = $this->input->post('sort_id');
				
				$this->ComicNum_Model->numname = $numname;
				$this->ComicNum_Model->dirname = $dirname;
				$this->ComicNum_Model->sort_id = $sort_id;
				$array = array(
					'id'  => $numid,
					);
				$this->ComicNum_Model->update($array);
				$msg = "success";
			}
			$data = array('errMsg'=>$msg);
			echo json_encode($data);
			return;
		}
	}
}
