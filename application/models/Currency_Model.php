<?php
class Currency_Model extends CI_Model {
		
		public $tableName = "";
        
		public function __construct()
        {
                parent::__construct();
        }
		
		public function test()
		{
			var_dump($this->tableName);
		}
		
		public function insert($data)
		{
			$query = $this->db->insert_string($this->tableName, $data);
			$this->db->query($query);
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
			$query = $this->db->get('admin');
			$row = $query->result();
			return $row;
		}
}
?>