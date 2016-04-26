<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

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
	private $infoUser; 
	public function __construct()
    {
          parent::__construct();
          {
            //this is where the magic happens

            //inlcude a better hashing library
            $this->load->database();
			$this->load->helper('url');
			$this->load->helper('cookie');
			$this->infoUser = get_cookie("TokenBackLogin");
          }
    }
	public function showIndex()
	{
		$info['server_software'] = $_SERVER["SERVER_SOFTWARE"];
		$info['system'] = 	PHP_OS;
		$info['php_sapi_name'] = php_sapi_name();
		$info['version'] = "Mysql ".$this->db->version();
		$info['upload_max_filesize'] = ini_get('upload_max_filesize');
		$info['post_max_size'] = ini_get('post_max_size');
		$infoUser['user'] = $this->infoUser;
		$this->load->view('admin/header');
		$this->load->view('admin/index', $info);
	}
}
