<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {

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
          }
    }
	public function doUpload()
	{
		$config['upload_path']          = './uploads/tmps';
		$config['allowed_types']        = 'gif|jpg|png';
		$config['max_size']             = 2048;

		$this->load->library('upload', $config);
		$fileurl = "";
		$file_name = "";
		$file_path = "";
		if ( ! $this->upload->do_upload('userfile'))
		{
			$msg = "文件格式不对或文件长度太大";
		}
		else
		{
			$msg = "success";
			$data = $this->upload->data();
			$file_name = $data['file_name'];
			$fileurl = base_url().'uploads/tmps/'.$file_name;
			$file_path = $data['file_path'];
		}
		$data = array('errMsg'=>$msg, 'fileurl'=>$fileurl, 'file_name'=>$file_name, 'file_path'=>$file_path);
		echo json_encode($data);
	}
}
