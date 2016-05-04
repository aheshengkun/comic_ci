<?php
class ComicNum_Model extends CI_Model {
		
		public $tableName = "comicnum";
		public $numname;
		public $dirname;
		public $comicname;
		public $sort_id;
		public $created_at;
		public $updated_at;
		public $cmp;
		
        public function __construct()
        {
			parent::__construct();
			$this->load->database();
			$currentTime = date('Y-m-d H:i:s');
			$this->created_at = $currentTime;
			$this->updated_at = $currentTime;
			$this->sort_id = 0;
        }
		
		public function delete($array)
		{
			$this->db->where($array)->delete($this->tableName);
		}
		
		private function getArray()
		{
			$data = array(
				'numname' => $this->numname,
				'dirname' => $this->dirname,
				'comicname' => $this->comicname,
				'sort_id' => $this->sort_id,
				'cmp' => $this->cmp,
				'created_at' => $this->created_at,
				'updated_at' => $this->updated_at
			);
			return $data;
		}
		
		private function getUpdateArray()
		{
			$data = array(
				'numname' => $this->numname,
				'sort_id' => $this->sort_id,
				'updated_at' => $this->updated_at
			);
			return $data;
		}
		
		public function updateEx($arrWhere, $arrSet)
		{
			$this->db->where($arrWhere);
			$this->db->set($arrSet);
			$this->db->update($this->tableName);
		}
		
		public function updateSort()
		{
			$dataWhere = array(
				'id' => $this->id
			);
			var_dump($this->db->where($dataWhere));
			$data = array(
				'sort_id' => $this->sort_id
			);
			var_dump($this->db->set($data));
			return $this->db->update($this->tableName);
		}
		
		public function update($array)
		{
			$this->db->where($array);
			$data = $this->getUpdateArray();
			$this->db->set($data);
			$this->db->update($this->tableName);
		}
		
		public function insert()
		{
			$data = $this->getArray();
			$data['created_at'] = $this->created_at;
			$data['updated_at'] = $this->updated_at;
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
		
		public function query_where_limit_orderby($sqldata, $num, $index, $strsql)
		{
			$this->db->where($sqldata);
			$this->db->limit($num, $index);
			$this->db->order_by($strsql);
			$query = $this->db->get($this->tableName);
			$row = $query->result();
			return $row;
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