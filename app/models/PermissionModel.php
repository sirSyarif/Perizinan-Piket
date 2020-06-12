<?php 

class PermissionModel {

	private $db;

	public function __construct(){
		$this->db = new Database();	
	}

	public function getPermissions(){
		$this->db->query("SELECT * FROM izin");
		$results = $this->db->result();
		return $results;
	}

	public function getPermissionsById($userId){
		$customerId = $this->getCustomerId($userId);
		$this->db->query("SELECT * FROM izin WHERE siswa_id = :siswa_id ORDER BY started DESC");
		$this->db->bind(":siswa_id", $customerId);
		$results = $this->db->result();
		return $results;
	}

	public function getPermissionsByPagination($offset, $limiter){
		$this->db->query("SELECT * FROM izin ORDER BY started DESC LIMIT :offset, :limiter");
		$this->db->bind(":offset", $offset);
		$this->db->bind(":limiter", $limiter);
		$results = $this->db->result();
		return $results;
	}

	public function getPermissionsByIdPagination($offset, $limiter, $userId){
		$customerId = $this->getCustomerId($userId);
		$this->db->query("SELECT * FROM izin WHERE siswa_id = :siswa_id ORDER BY started DESC LIMIT :offset, :limiter");
		$this->db->bind(":offset", $offset);
		$this->db->bind(":limiter", $limiter);
		$this->db->bind(":siswa_id", $customerId);
		$results = $this->db->result();
		return $results;
	}

	public function getRowCount(){
		return $this->db->rowCount();
	}

	public function getPermissionDetailsById($izinId){
		$this->db->query("SELECT izin_details.izin_id, guru.id, guru.nip, 
				guru.name, guru.kelas, guru.image 
				FROM izin JOIN izin_details 
				ON izin.id = izin_details.izin_id JOIN guru ON izin_details.izin_id = guru.id 
				WHERE izin.id = :izin_id");
		$this->db->bind(":izin_id", $izinId);
		$results = $this->db->result();
		return $results;
	}

	public function getPermissionById($izinId){
		$this->db->query("SELECT * FROM izin WHERE id = :izin_id");
		$this->db->bind(":izin_id", $izinId);
		$result = $this->db->single();
		return $result;
	}

	public function addPermission($data){
		$customerId = $this->getCustomerId($data['userId']);			
		$this->db->query("INSERT INTO izin (siswa_id, ended) VALUES (:siswa_id, :ended)");
		$this->db->bind(":siswa_id", $customerId);
		$this->db->bind(":ended", date("Y-m-d H:i:s", strtotime("+10 minutes")));			
		if($this->db->execute()){
			$izin_id = $this->db->getLastInsertId();				
			$this->db->query("INSERT INTO izin_details (izin_id, izin_id) VALUES (:izin_id, :izin_id, :quantity)");
			$this->db->bind(":izin_id", $izin_id);
			foreach ($data['sneakers'] as $sneaker) {
				$this->db->bind(":izin_id", $sneaker->id);
				$this->db->execute();
			}
			return true;
		} else {
			return false;
		}
	}

	public function getCustomerId($userId){
		$this->db->query("SELECT * FROM siswa WHERE user_id = :user_id");
		$this->db->bind(":user_id", $userId);
		$result = $this->db->single();
		return $result->id;
	}
}

?>