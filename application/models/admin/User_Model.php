<?php
class User_Model extends CI_Model {
		
		public $tableName = "admin";
		public $username;
		public $password;
		public $created_at;
		public $updated_at;
		
        public function __construct()
        {
            parent::__construct();
			$this->load->database();
			$currentTime = date('Y-m-d H:i:s');
			$this->created_at = $currentTime;
			$this->updated_at = $currentTime;
        }
		
		public function insert()
		{
			$data = array(
				'username' => $this->username,
				'password' => $this->password,
				'created_at' => $this->created_at,
				'updated_at' => $this->updated_at
			);
			$query = $this->db->insert_string($this->tableName, $data);
			return $this->db->query($query);
		}
		
		public function query($array)
		{
			$this->db->where($array);
			$query = $this->db->get($this->tableName);
			$row = $query->result();
			return $row;
		}
		
		public function total()
		{
			$sql = 'SELECT COUNT(*) AS count FROM '.$this->tableName.' WHERE 1=1';
			$query = $this->db->query($sql);
			$row = $query->row();
			return $row->count;
		}
		
		public function query_limit($num, $index)
		{
			$this->db->limit($num, $index);
			$query = $this->db->get($this->tableName);
			$row = $query->result();
			return $row;
		}
}
?>