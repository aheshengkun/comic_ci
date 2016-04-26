<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PaginationExClass {
	
	protected $CI;
	public function __construct()
    {
		$this->CI =& get_instance();
    }
	
    public function page($url, $total, $page_num)
	{
		$this->CI->load->library('pagination');
		$config['base_url'] = $url;//$this->config->item('base_url').'/index.php/admin/userlist/';
		$config['total_rows'] = $total;//总共多少条数据
		$config['per_page'] = $page_num;//每页显示几条数据
		$config['first_link'] = '首页';
		$config['first_tag_open'] = '<li>';//“第一页”链接的打开标签。
		$config['first_tag_close'] = '</li>';//“第一页”链接的关闭标签。
		$config['last_link'] = '尾页';//你希望在分页的右边显示“最后一页”链接的名字。
		$config['last_tag_open'] = '<li>';//“最后一页”链接的打开标签。
		$config['last_tag_close'] = '</li>';//“最后一页”链接的关闭标签。
		$config['next_link'] = '下一页';//你希望在分页中显示“下一页”链接的名字。
		$config['next_tag_open'] = '<li>';//“下一页”链接的打开标签。
		$config['next_tag_close'] = '</li>';//“下一页”链接的关闭标签。
		$config['prev_link'] = '上一页';//你希望在分页中显示“上一页”链接的名字。
		$config['prev_tag_open'] = '<li>';//“上一页”链接的打开标签。
		$config['prev_tag_close'] = '</li>';//“上一页”链接的关闭标签。
		$config['cur_tag_open'] = '<li class="current">';//“当前页”链接的打开标签。
		$config['cur_tag_close'] = '</li>';//“当前页”链接的关闭标签。
		$config['num_tag_open'] = '<li>';//“数字”链接的打开标签。
		$config['num_tag_close'] = '</li>';
		//$config['uri_segment'] = 3;
		$config['use_page_numbers'] = TRUE;
		$config['enable_query_strings'] = TRUE;
		$config['page_query_string'] = TRUE;
		$this->CI->pagination->initialize($config);
		return $this->CI->pagination->create_links();
	}
}