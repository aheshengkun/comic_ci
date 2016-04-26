<?php
class ComicTypes_Model extends CI_Model {
		
		public $tableName = "comictypes";
		public $comicname;
		public $typename;
		public $cmp;
		
        public function __construct()
        {
                parent::__construct();
				$this->load->database();
        }
		
		public function delete($array)
		{
			$this->db->where($array)->delete($this->tableName);
		}
		
		public function insert()
		{
			$data = array(
				'comicname' => $this->comicname,
				'typename' => $this->typename,
				'cmp' => $this->cmp
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