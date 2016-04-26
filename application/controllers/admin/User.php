<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

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
			$this->load->model('admin/User_Model', 'User_Model');
			$this->load->helper('url');
			$this->load->helper('form');
			$this->load->helper('cookie');
			$this->load->library('form_validation');
			$this->load->database();
			$this->load->library('PaginationExClass');
          }
    }

	private function IsDigit($cCheck) 
	{ 
		return (('0'<=$cCheck) && ($cCheck<='9')); 
	} 
	
	private function IsAlpha($cCheck) 
	{ 
		return ((('a'<=$cCheck) && ($cCheck<='z')) || (('A'<=$cCheck) && ($cCheck<='Z'))); 
	} 
	
	private function VerifyName($param) 
	{ 
		for ($nIndex=0; $nIndex<strlen($param); $nIndex++) 
		{ 
			$cCheck = $param[$nIndex]; 
			if ( $nIndex==0 && ( $cCheck =='-' || $cCheck =='_') ) 
			{ 
				return '首字符不能为-或者_'; 
			} 
			if (!($this->IsDigit($cCheck) || $this->IsAlpha($cCheck) || $cCheck=='-' || $cCheck=='_' )) 
			{ 
				return '只允许英文和数字以及-和_'; 
			} 
		} 
		return '1'; 
	}
	
	private function createCaptcha()
	{
		$this->load->helper('captcha');
		$imgUrl = base_url()."/captcha/";
		$vals = array(
			'img_path'  => './captcha/',
			'img_url' => $imgUrl, //图片访问的路径
			'img_width'     => '150',
			'expiration'=>10,                    //存放时间,
			'word_length'=>4                     //显示几位验证数字
		);
		$cap = create_captcha($vals);
		$data = array(
			'captcha_time'  => $cap['time'],
			'ip_address'    => $this->input->ip_address(),
			'word'      => $cap['word']
		);
		$query = $this->db->insert_string('captcha', $data);
		$this->db->query($query);
		return $imgUrl.$cap['filename'];
	}
	
	private function checkCaptcha($captcha)
	{
		$expiration = time() - 300; // 5 分钟
		$this->db->where('captcha_time < ', $expiration)
				->delete('captcha');
		// Then see if a captcha exists:
		$sql = 'SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?';
		$binds = array($captcha, $this->input->ip_address(), $expiration);
		$query = $this->db->query($sql, $binds);
		$row = $query->row();
		
		if ($row->count == 0)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	private function getErrMsg($flag)
	{
		$errMsg = "";
		if($flag == 1)
		{
			$errMsg = "验证错误";
		}
		if($flag == 2)
		{
			$errMsg = "用户名或密码错误";
		}
		if($flag == 3)
		{
			$errMsg = "输入信息有误";
		}
		return $errMsg;
	}
	
	public function loginOut()
	{
		delete_cookie("TokenBackLogin");
		redirect('loginback');
	}
	
	public function checkLogin()
	{
		$this->form_validation->set_rules('username','Username','trim|required|min_length[5]|max_length[12]');//username要5个到12个字符之间
		$this->form_validation->set_rules('password','password','trim|required|min_length[5]|max_length[12]');//password要5个到12个字符之间
		$this->form_validation->set_rules('captcha','captcha','trim|required');
		$msg = "";
		if ($this->form_validation->run() == FALSE)
        {
			$msg = $this->getErrMsg(3);
			
        }
        else
        {
			$captcha = $this->input->post('captcha');
			if($this->checkCaptcha($captcha))
			{
				$username = $this->input->post('username');
				$password = md5($this->input->post('password'));
				$array = array('username' => $username, 'password' => $password);
				$row = $this->User_Model->query($array);
				if(!$row)
				{
					$msg = $this->getErrMsg(2);
				}
				else
				{
					$value = $username;
					set_cookie("TokenBackLogin", $value, 7200);
					$msg = "success";
				}
			}
			else
			{
				$msg = $this->getErrMsg(1);
			}
        }
		$data = array('errMsg'=>$msg);
		echo json_encode($data);
		return;
	}
	
	public function jsonCreateCaptcha()
	{
		$imgUrl = $this->createCaptcha();
		$data = array('imgUrl'=>$imgUrl);
		echo json_encode($data);
	}
	
	public function showLogin($flag = 0)
	{
		$imgUrl = $this->createCaptcha();
		$msg = $this->getErrMsg($flag);
		$data = array('imgUrl'=>$imgUrl, 'errMsg'=>$msg);
		$this->load->view('loginback', $data);
	}
	public function showUserList()
	{
		
		$total = $this->User_Model->total();
		$num = 2;
		
		$pageurl = $this->config->item('base_url').'/index.php/admin/userlist/';
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
		$query = $this->User_Model->query_limit($num, $num*($page-1));
		$info['userlist'] = $query;
		$info['curPage'] = $page;
		$info['totalPage'] = $totalPage;
		$this->load->view('admin/header');
		$this->load->view('admin/user_list', $info);
	}
	
	public function createUser()
	{
		if(isset($_POST['username']))
		{
			//add user
			$msg = "";
			$this->form_validation->set_rules('username','Username','trim|required|min_length[5]|max_length[12]');//username要5个到12个字符之间
			$this->form_validation->set_rules('password','password','trim|required|min_length[5]|max_length[12]');//password要5个到12个字符之间
			if ($this->form_validation->run() == FALSE)
			{
				$msg = "输入信息有误";
			}
			else
			{
				$username = $this->input->post('username');
				$password = md5($this->input->post('password'));
				$this->VerifyName($username);
				if( $this->VerifyName($username) == '1' && $this->VerifyName($password) == '1' )
				{
					$array = array(
						'username'  => $username
						);
					$row = $this->User_Model->query($array);
					if(!$row)
					{
						$this->User_Model->username = $username;
						$this->User_Model->password = $password;
						$this->User_Model->insert();
						$msg = "success";
					}
					else
					{
						$msg = "用户已存在";
					}
				}
				else
				{
					$msg = "输入信息有误";
				}
			}
			$data = array('errMsg'=>$msg);
			echo json_encode($data);
			return;
		}
		else
		{
			$info['errMsg'] = "";
			$this->load->view('admin/header');
			$this->load->view('admin/user_create', $info);
		}
	}
	
	public function updateUser()
	{
		$this->load->view('admin/header');
		$this->load->view('admin/user_update');
	}
}
