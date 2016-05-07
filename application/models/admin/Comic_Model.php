<?php
class Comic_Model extends CI_Model {
		
		public $tableName = "comic";
		public $name;
		public $description;
		public $showdate;
		public $searchword;
		public $author;
		public $covername;
		public $coverdir;
		public $coverurl;
		public $created_at;
		public $updated_at;
		public $types;
		public $status;
		
        public function __construct()
        {
                parent::__construct();
				$this->load->database();
				$currentTime = date('Y-m-d H:i:s');
				$this->created_at = $currentTime;
				$this->updated_at = $currentTime;
        }
		
		public function delete($array)
		{
			$this->db->where($array)->delete($this->tableName);
		}
		
		private function getArray()
		{
			$data = array(
				'name' => $this->name,
				'description' => $this->description,
				'showdate' => $this->showdate,
				'searchword' => $this->searchword,
				'covername' => $this->covername,
				'coverurl' => $this->coverurl,
				'coverdir' => $this->coverdir,
				'author' => $this->author,
				'types' => $this->types,
				'status' => $this->status,
				'created_at' => $this->created_at,
				'updated_at' => $this->updated_at
			);
			return $data;
		}
		
		private function getUpdateArray()
		{
			$data = array(
				'description' => $this->description,
				'showdate' => $this->showdate,
				'searchword' => $this->searchword,
				'covername' => $this->covername,
				'coverurl' => $this->coverurl,
				'coverdir' => $this->coverdir,
				'author' => $this->author,
				'types' => $this->types,
				'status' => $this->status,
				'updated_at' => $this->updated_at
			);
			return $data;
		}
		
		public function getUpdateData()
		{
			$data = array();
			if(isset($description))
			{
				$data['description'] = $this->description;
			}
			if(isset($showdate))
			{
				$data['showdate'] = $this->showdate;
			}
			if(isset($searchword))
			{
				$data['searchword'] = $this->searchword;
			}
			if(isset($covername))
			{
				$data['covername'] = $this->covername;
			}
			if(isset($coverurl))
			{
				$data['coverurl'] = $this->coverurl;
			}
			if(isset($coverdir))
			{
				$data['coverdir'] = $this->coverdir;
			}
			if(isset($types))
			{
				$data['types'] = $this->types;
			}
			if(isset($updated_at))
			{
				$data['updated_at'] = $this->updated_at;
			}
			if(isset($status))
			{
				$data['status'] = $this->status;
			}
			return $data;
		}
		
		public function updateEx($arrWhere, $arrSet)
		{
			$this->db->where($arrWhere);
			$this->db->set($arrSet);
			$this->db->update($this->tableName);
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
		
		public function query_limit($num, $index)
		{
			$this->db->limit($num, $index);
			$query = $this->db->get($this->tableName);
			$row = $query->result();
			return $row;
		}
}
?>