<?php 

class TeacherModel {
	private $db;

	public function __construct(){
		$this->db = new Database();
	}

	public function getRandomTeachers(){
		$this->db->query("SELECT * FROM guru ORDER BY RAND() LIMIT 4");
		$results = $this->db->result();
		return $results;
	}

	public function checkTeacherIfUsed($teacherId){
		$this->db->query("SELECT * FROM izin_details WHERE guru_id = :guru_id");
		$this->db->bind(":guru_id", $teacherId);
		$this->db->execute();
		if($this->getRowCount() > 0){
			return true;
		} else {
			return false;
		}
	}

	public function getTeachersBySearch($name, $type){
		$search = "%$name%";
		if($type == "0"){
			$this->db->query("SELECT * FROM guru JOIN guru_matpel ON 
							guru.id = guru_matpel.guru_id JOIN matpel ON 
							guru_matpel.matpel_id = matpel.id 
							WHERE name LIKE :search GROUP BY name ORDER BY created_at DESC");
		} else {
			$this->db->query("SELECT * FROM guru JOIN guru_matpel ON guru.id = guru_matpel.guru_id JOIN matpel ON guru_matpel.matpel_id = matpel.id WHERE name LIKE :search AND matpel.nama = :type GROUP BY name ORDER BY created_at DESC");
			$this->db->bind(":type", $type);
		}	
		$this->db->bind(":search", $search);		
		$results = $this->db->result();
		return $results;
	}

	public function getTeachersByPaginationSearch($name, $type, $offset, $limiter){
		$search = "%$name%";
		if($type == "0"){
			$this->db->query("SELECT guru.id, name, nip, kelas, image, created_at FROM guru JOIN guru_matpel ON guru.id = guru_matpel.guru_id JOIN matpel ON guru_matpel.matpel_id = matpel.id WHERE name LIKE :search GROUP BY name ORDER BY created_at DESC LIMIT :offset, :limiter");
		} else {
			$this->db->query("SELECT guru.id, name, nip, kelas, image, created_at FROM guru JOIN guru_matpel ON guru.id = guru_matpel.guru_id JOIN matpel ON guru_matpel.matpel_id = matpel.id WHERE name LIKE :search AND matpel.nama = :type GROUP BY name ORDER BY created_at DESC LIMIT :offset, :limiter");
			$this->db->bind(":type", $type);
		}			
		$this->db->bind(":search", $search);
		$this->db->bind(":offset", $offset);
		$this->db->bind(":limiter", $limiter);
		$results = $this->db->result();
		return $results;
	}

	public function getRowCount(){
		return $this->db->rowCount();
	}

	public function getTeachers(){
		$this->db->query("SELECT * FROM guru ORDER BY created_at DESC");
		$results = $this->db->result();
		return $results;
	}

	public function getTeachersByPagination($offset, $limiter){
		$this->db->query("SELECT * FROM guru ORDER BY created_at DESC LIMIT :offset, :limiter");
		$this->db->bind(":offset", $offset);
		$this->db->bind(":limiter", $limiter);
		$results = $this->db->result();
		return $results;
	}

	public function getMultipleTeachersById($ids){
		$in = str_repeat('?,', count($ids) - 1) . '?';
		$this->db->query("SELECT * FROM guru WHERE id IN ($in)");
		$results = $this->db->result($ids);
		return $results;
	}

	public function getTeacherTypesById($id){
		$this->db->query("SELECT guru.name, matpel_id, matpel.nama as matpel FROM guru JOIN guru_matpel ON guru.id = guru_matpel.guru_id JOIN matpel ON guru_matpel.matpel_id = matpel.id WHERE guru.id = :id");
		$this->db->bind(':id', $id);
		$results = $this->db->result();
		return $results;
	}

	public function getTypesList(){
		$this->db->query("SELECT * FROM matpel");
		$results = $this->db->result();
		return $results;
	}

	public function addTeacher($data){
		$this->db->query("INSERT INTO guru (nip, name, kelas, image) VALUES (:nip, :name, :kelas, :image)");
		$this->db->bind(":nip", $data['nip']);
		$this->db->bind(":name", $data['name']);
		$this->db->bind(":kelas", $data['kelas']);
		$this->db->bind(":image", $data['image']);
		if($this->db->execute()){
			$id = $this->db->getLastInsertId();
			$this->db->query("INSERT INTO guru_matpel (guru_id, matpel_id) VALUES (:guru_id, :matpel_id)");
			$this->db->bind(":guru_id", $id);
			foreach ($data['typesChecked'] as $typeKey => $type) {
				if(!empty($type)){
					$this->db->bind(":matpel_id" , $typeKey);
					$this->db->execute();
				}
			}
			return true;
		} else {
			return false;
		}
	}

	public function updateTeacher($data){
		$this->db->query("UPDATE guru SET nip = :nip, name = :name, kelas = :kelas, image = :image WHERE id = :id");
		$this->db->bind(":nip", $data['nip']);
		$this->db->bind(":name", $data['name']);
		$this->db->bind(":kelas", $data['kelas']);
		$this->db->bind(":image", $data['image']);
		$this->db->bind(":id", $data['id']);
		if($this->db->execute()){			
			if($this->deleteTeachertypesById($data['id'])){
				foreach ($data['typesChecked'] as $matpelKey => $type) {
					if(!empty($type)){
						$this->db->query("INSERT INTO guru_matpel (guru_id, matpel_id) VALUES (:guru_id, :matpel_id)");
						$this->db->bind(":guru_id", $data['id']);
						$this->db->bind(":matpel_id" , $matpelKey);
						$this->db->execute();
					}
				}
			} else {
				return false;
			}				
			return true;
		} else {
			return false;
		}
	}

	public function deleteTeacherTypesById($id){
		$this->db->query("DELETE FROM guru_matpel WHERE guru_id = :id");
		$this->db->bind(":id", $id);
		if($this->db->execute()){
			return true;
		} else {
			return false;
		}
	}

	public function getTeacherById($id){
		$this->db->query("SELECT * FROM guru WHERE id = :id");
		$this->db->bind(":id", $id);
		$row = $this->db->single();
		return $row;
	}

	public function deleteTeacher($id){
		$this->db->query("DELETE FROM guru WHERE id = :id");
		$this->db->bind(":id", $id);
		if($this->db->execute()){
			return true;
		} else {
			return false;
		}	
	}

	public function addCategory($data) {
		$this->db->query("INSERT INTO matpel (nama) VALUES (:name)");
		$this->db->bind(":name", $data['name']);
		$this->db->execute();
	}
}
