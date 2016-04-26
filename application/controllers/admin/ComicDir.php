<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ComicDir extends CI_Controller {

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
			$this->load->model('admin/ComicDir_Model', 'ComicDir_Model');
			$this->load->helper('url');
			$this->load->helper('form');
			$this->load->library('form_validation');
			$this->load->library('PaginationExClass');
          }
    }

	public function showComicDir()
	{
		$array = array('1' => 1);
		$row = $this->ComicDir_Model->query($array);
		$info['comicdir'] = $row[0];
		$this->load->view('admin/header');
		$this->load->view('admin/comicdir', $info);
	}
	
	public function eidtComicDir()
	{
		$array = array('1' => 1);
		$row = $this->ComicDir_Model->query($array);
		$info['comicdir'] = $row[0];
		$info['errMsg'] = "";
		$this->load->view('admin/header');
		$this->load->view('admin/comicdir_edit', $info);
	}
	
	public function updateComicDir()
	{
		if(isset($_POST['comicdir']))
		{
			$msg = "";
			$this->form_validation->set_rules('comicdir','comicdir','trim|required');
			if ($this->form_validation->run() == FALSE)
			{
				$msg = "输入信息有误";
			}
			else
			{
				$comicdir = $this->input->post('comicdir');
				$this->ComicDir_Model->comicdir = $comicdir;
				$array = array('1'=>1);
				$this->ComicDir_Model->update($array);
				$msg = "success";
			}
			$data = array('errMsg'=>$msg);
			echo json_encode($data);
			return;
		}
	}
}
