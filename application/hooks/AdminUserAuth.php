<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminUserAuth extends CI_Controller {

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
          }
    }
	
	public function CheckLoginStatus()
	{	
		$this->load->helper('cookie');
		$this->load->helper('url');
		if(preg_match("/admin.*/i", uri_string()))
		{
			
			$mixed = get_cookie("TokenBackLogin");
			if($mixed)
			{
				//继续go
			}
			else
			{
				redirect('loginback');
			}
		}
	}
}
