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
			$this->load->model('admin/ComicNum_Model', 'ComicNum_Model');
          }
    }
	public function showComicList()
	{
		if(isset($_GET['comicname']))
		{
			$this->showComic($this->input->get('comicname'));
		}
		else
		{
			$total = $this->Comic_Model->total();
			$num = 12;
			$pageurl = $this->config->item('base_url');
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
			$info['comic_base_url'] = $this->config->item('comic_base_url');
			$dataSql = array(
							'1'  => 1
						);
			$rows = $this->ComicType_Model->query($dataSql);
			$info['typelist'] =  $rows;
			$this->load->view('front/header');
			$this->load->view('front/comic_list', $info);
		}
	}
	
	private function showComic($comicname)
	{
		$sqldata = array(
			'name' => $comicname
		);
		$query = $this->Comic_Model->query($sqldata);
		$info['comic'] = $query[0];
		$strOrderBy = "sort_id ASC";
		$sqldata = array(
			'comicname' => $comicname
		);
		$this->db->where($sqldata);
		$this->db->order_by($strOrderBy);
		$query = $this->ComicNum_Model->queryEx();
		$info['comicnumlist'] = $query;
		$info['comic_base_url'] = $this->config->item('comic_base_url');
		$dataSql = array(
							'1'  => 1
						);
		$rows = $this->ComicType_Model->query($dataSql);
		$info['typelist'] =  $rows;
		$this->load->view('front/header');
		$this->load->view('front/comic', $info);
	}
}
