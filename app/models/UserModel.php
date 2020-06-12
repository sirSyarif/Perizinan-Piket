<?php 

class UserModel {
	private $db;

	public function __construct(){
		$this->db = new Database();
	}

	public function register($data){
		$this->db->query("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
		$this->db->bind(":name", $data['name']);
		$this->db->bind(":email", $data['email']);
		$this->db->bind(":password", $data['password']);

		if($this->db->execute()){
			$id = $this->db->getLastInsertId();
			$this->db->query("INSERT INTO siswa (user_id) VALUES (:id)");
			$this->db->bind(":id", $id);
			$this->db->execute();
			return true;
		} else {
			return false;
		}
	}

	public function login($email, $password){
		$this->db->query("SELECT * FROM users WHERE email = :email");
		$this->db->bind(":email", $email);
		$data = $this->db->single();

		$hashed = $data->password;
		
		if(password_verify($password, $hashed)){
			return $data;
		} else {
			return false;
		}
	}

	public function findUserByEmail($email){
		$this->db->query('SELECT * FROM users WHERE email = :email');
		$this->db->bind(":email", $email);
		$row = $this->db->single();

		if($this->db->rowCount() > 0){
			return true;
		} else {
			return false;
		}
	}

	public function getUserById($id){
		$this->db->query('SELECT * FROM users WHERE id = :id');
		$this->db->bind(":id", $id);
		$row = $this->db->single();
		return $row;
	}
}
