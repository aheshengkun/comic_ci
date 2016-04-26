<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ComicType extends CI_Controller {

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
			$this->load->model('admin/ComicType_Model', 'ComicType_Model');
			$this->load->helper('url');
			$this->load->helper('form');
			$this->load->library('form_validation');
			$this->load->library('PaginationExClass');
          }
    }

	public function showTypeList()
	{
		$total = $this->ComicType_Model->total();
		$num = 10;	//每页显示的数量
		$pageurl = $this->config->item('base_url').'/index.php/admin/comictypelist/';
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
		//if ($this->uri->segment(3) != FALSE)
		if($this->input->get('per_page'))
		{
			$page = trim($this->input->get('per_page'));
			//$page = $this->uri->segment(3);
			if($page > $totalPage){
				$page = $totalPage;
			}
			if($page <= 0)
			{
				$page = 1;
			}
		}
		$query = $this->ComicType_Model->query_limit($num, $num*($page-1));
		$info['typelist'] = $query;
		$info['curPage'] = $page;
		$info['totalPage'] = $totalPage;
		$this->load->view('admin/header');
		$this->load->view('admin/comicType_list', $info);
	}
	
	public function deleteType()
	{
		if(isset($_GET['typeid']) && isset($_GET['per_page']))
		{
			$per_page = $this->input->get('per_page');
			//$this->form_validation->set_rules('typeid','typeid','trim|required');
			//if($this->form_validation->run() == true)
			//{
				$typeid = $this->input->get('typeid');
				$array = array('id' => $typeid);
				$this->ComicType_Model->delete($array);
				
			//}
			redirect(base_url()."index.php/admin/comictypelist?per_page=".$per_page);
			return;
		}
	}
	
	public function sortComicType()
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
						$this->ComicType_Model->id = $array2[0];
						$this->ComicType_Model->sort_id = $array2[1];
						$this->ComicType_Model->updateSort();
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
	
	public function createType()
	{
		if(isset($_POST['typename']))
		{
			//add user
			$msg = "";
			$this->form_validation->set_rules('typename','typename','trim|required|min_length[1]|max_length[45]');//username要1个到45个字符之间
			if ($this->form_validation->run() == FALSE)
			{
				$msg = "输入信息有误";
			}
			else
			{
				$typename = $this->input->post('typename');
				$this->ComicType_Model->type = $typename;
				$this->ComicType_Model->insert();
				$msg = "success";
			}
			$data = array('errMsg'=>$msg);
			echo json_encode($data);
			return;
		}
		else
		{
			$info['errMsg'] = "";
			$this->load->view('admin/header');
			$this->load->view('admin/comicType_create', $info);
		}
	}
}
