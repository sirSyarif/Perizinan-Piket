<?php 

class Teachers extends Controller {	

	public function __construct(){
		$this->teacher = $this->model('TeacherModel');
	}

	public function index(){
		$this->page();
	}

	public function page($page = 1){
		if (isset($_GET['teacher-search']) && isset($_GET['matpel'])) {
			if(!empty(trim($_GET['teacher-search'])) || $_GET['matpel'] != '0'){
				$this->paginate($page, $_GET['teacher-search'], $_GET['matpel']);
			} else {					
				$this->paginate($page);
			}
		} else {
			$this->paginate($page);				
		}
	}

	private function paginate($page, $search = "", $type = ""){
		$page = $page;
		$limit = 12;
		$space = 2;	

		if($search == "" && $type == ""){
			$this->teacher->getTeachers();
			$totalRows = $this->teacher->getRowCount();
			$totalPages = ceil($totalRows / $limit);
			$offset = $limit * ($page-1);

			if($totalPages <= (1+($space * 2))) {
				$start = 1;
				$end   = $totalPages;
			} else {
				if(($page - $space) > 1) { 
					if(($page + $space) < $totalPages) { 
						$start = ($page - $space);            
						$end   = ($page + $space);         
					} else {             
						$start = ($totalPages - (1+($space*2)));  
						$end   = $totalPages;               
					}
				} else {               
					$start = 1;                                
					$end   = (1+($space * 2));             
				}
			}
			
			$teachers = $this->teacher->getTeachersByPagination($offset, $limit);
			foreach ($teachers as $teacher) {
				$teacherTypes = $this->teacher->getTeacherTypesById($teacher->id);
				$teacher->category = [];
				foreach ($teacherTypes as $teacherType) {
					$teacher->category[$teacherType->matpel_id] = $teacherType->matpel;
				}
			}		
		} else {				
			$this->teacher->getTeachersBySearch($search, $type);
			$totalRows = $this->teacher->getRowCount();
			$totalPages = ceil($totalRows / $limit);
			$offset = $limit * ($page-1);

			if($totalPages <= (1+($space * 2))) {
				$start = 1;
				$end   = $totalPages;
			} else {
				if(($page - $space) > 1) { 
					if(($page + $space) < $totalPages) { 
						$start = ($page - $space);            
						$end   = ($page + $space);         
					} else {             
						$start = ($totalPages - (1+($space*2)));  
						$end   = $totalPages;               
					}
				} else {               
					$start = 1;                                
					$end   = (1+($space * 2));             
				}
			}		      	
			$teachers = $this->teacher->getTeachersByPaginationSearch($search, $type, $offset, $limit);
			foreach ($teachers as $teacher) {
				$teacherTypes = $this->teacher->getTeacherTypesById($teacher->id);
				$teacher->category = [];
				foreach ($teacherTypes as $teacherType) {
					$teacher->category[$teacherType->matpel_id] = $teacherType->matpel;
				}
			}
		}

		$typesList = $this->teacher->getTypesList();

		$data = [
			'teachers' => $teachers,
			'typesList' => $typesList,
			'page' => $page,
			'start' => $start,
			'end' => $end,
			'totalPages' => $totalPages,
			'title' => 'Teachers'
		];

		$this->view('teachers/index', $data);
	}

	public function add(){
		if(isset($_SESSION['admin_mode'])){
			$typesList = $this->teacher->getTypesList();
			if($_SERVER['REQUEST_METHOD'] == 'POST'){				

				$typesChecked = [];
				foreach ($typesList as $type) {
					if(isset($_POST[$type->id])){
						$typesChecked[$type->id] = "checked";
					} else {
						$typesChecked[$type->id] = "";
					}
				}		
			
				$data = [
					'image' => $_FILES['image']['name'],
					'image_dir' => $_FILES['image']['tmp_name'],
					'image_size' => $_FILES['image']['size'],
					'nip' => trim($_POST['nip']),
					'name' => trim($_POST['name']),
					'kelas' => trim($_POST['kelas']),					
					'types' => $typesList,
					'typesChecked' => $typesChecked,
					'title' => 'Add Teachers'
				];

				$imgExt = strtolower(pathinfo($data['image'], PATHINFO_EXTENSION));
				$valid_extensions = array('jpeg', 'jpg', 'png', 'gif');

				if (empty($data['image'])) {
					$data['image_err'] = "Please upload image";
				} else if (!in_array($imgExt, $valid_extensions)) {
					$data['image_err'] = "Please upload valid image (jpeg, jpg, png, gif)";
				} else if ($_FILES['image']['error'] == 2) {
					$data['image_err'] = "Image file too large";
				} else if ($data['image_size'] > 300000) {
					$data['image_err'] = "Image file too large";
				}

				$upload_dir = PUB_ROOT . "/images/uploads/";		


				if($data){						
					if($this->teacher->addTeacher($data)){
						if(move_uploaded_file($data['image_dir'], $upload_dir . $data['image'])){							
							Flash::setFlash('Success', 'Add Teachers', 'success');
							Redirect::to('teachers');
						}
					} else {
						Flash::setFlash('Failed', 'Add Teachers', 'danger');
						Redirect::to('teachers/add');
					}
				} 
			} else {
				$typesChecked = [];
				foreach ($typesList as $type) {
					$typesChecked[$type->id] = "";
				}
				$data = [
					'name' => '',
					'nip' => '',
					'kelas' => '' ,
					'types' => $typesList,
					'typesChecked' => $typesChecked,
					'title' => 'Add Teachers'
				];
				$this->view('teachers/add', $data);	
			}
		} else {
			Redirect::to();
		}
	}

	public function edit($id){
		if(isset($_SESSION['admin_mode'])){
			$teacher = $this->teacher->getTeacherById($id);
			$teacherTypes = $this->teacher->getTeacherTypesById($teacher->id);
			$typesList = $this->teacher->getTypesList();
			if($_SERVER['REQUEST_METHOD'] == 'POST'){				

				$typesChecked = [];
				foreach ($typesList as $type) {
					if(isset($_POST[$type->id])){
						$typesChecked[$type->id] = "checked";
					} else {
						$typesChecked[$type->id] = "";
					}
				}

				$data = [];
				$upload_dir = PUB_ROOT . "/images/uploads/";

				$uploadImage = false;
				if(is_uploaded_file($_FILES['image']['tmp_name'])){
					$uploadImage = true;
				} else {
					$uploadImage = false;
				}
				if($uploadImage){
					$data = [
						'id' => $id,
						'image' => $_FILES['image']['name'],
						'image_dir' => $_FILES['image']['tmp_name'],
						'image_size' => $_FILES['image']['size'],						
						'name' => trim($_POST['name']),
						'nip' => trim($_POST['nip']),
						'kelas' => $_POST['kelas'],						
						'types' => $typesList,
						'typesChecked' => $typesChecked
					];
					
					$imgExt = strtolower(pathinfo($data['image'],PATHINFO_EXTENSION));					
					$valid_extensions = array('jpeg', 'jpg', 'png', 'gif');

					if (!in_array($imgExt, $valid_extensions)) {
						$data['image_err'] = "Please upload valid image (jpeg, jpg, png, gif)";
					} else if($_FILES['image']['error'] == 2){						
						$data['image_err'] = "Image file too large";
					} else if ($data['image_size'] > 300000){
						$data['image_err'] = "Image file too large";
					}
				} else {
					$data = [
						'id' => $id,
						'image' => $teacher->image,					
						'name' => trim($_POST['name']),
						'nip' => trim($_POST['nip']),
						'kelas' => $_POST['kelas'],
						'types' => $typesList,
						'typesChecked' => $typesChecked,
					];
				}	

				if(!empty($data)){
					if($this->teacher->updateTeacher($data)){
						if($uploadImage){
							unlink($upload_dir . $teacher->image);
							move_uploaded_file($data['image_dir'], $upload_dir . $data['image']);
						}
						Flash::setFlash('teachers', 'Updated', 'success');
						Redirect::to('teachers');
					} else {
						Flash::setFlash('Update Teachers', 'Failed', 'danger');
						Redirect::to('teachers/add');
					}
				} else {
					$this->view('teachers/edit', $data);
				}
			} else {
				$typesChecked = [];
				foreach($teacherTypes as $type){
					$typesChecked[$type->matpel_id] = "checked";
				}
				foreach ($typesList as $type) {
					if(!isset($typesChecked[$type->id])){
						$typesChecked[$type->id] = "";
					}
				}

				$data = [
					'id' => $id,
					'nip' => $teacher->nip,
					'image' => $teacher->image,
					'name' => $teacher->name,
					'kelas' => $teacher->kelas,
					'types' => $typesList,
					'typesChecked' => $typesChecked,
					'title' => 'Edit Teachers'
				];
				$this->view('teachers/edit', $data);	
			}
		} else {
			Redirect::to();
		}
	}

	public function show($id){
		$teacher = $this->teacher->getTeacherById($id);
		$typesList = $this->teacher->getTypesList();
		$teacherTypes = $this->teacher->getTeacherTypesById($teacher->id);
		$teacher->category = [];
		foreach ($teacherTypes as $teacherType) {
			$teacher->category[$teacherType->matpel_id] = $teacherType->matpel;
		}
		$data = [
			'teacher' => $teacher,
			'title' => 'Teacher'				
		];
		$this->view('teachers/show', $data);
	}

	public function delete($id){
		if(isset($_SESSION['admin_mode'])){
			if($_SERVER["REQUEST_METHOD"] == 'POST'){
				$teacher = $this->teacher->getTeacherById($id);
				if($this->teacher->checkTeacherIfUsed($id)){
					Flash::setFlash('Cannot Delete Item', 'because its used', 'warning');
					Redirect::to('teachers');
				} else {
					if($this->teacher->deleteTeacher($id)){
						unlink(PUB_ROOT . '/images/uploads/' . $teacher->image);
						Flash::setFlash('Teachers', 'deleted', 'danger');
						Redirect::to('teachers');
					} else {
						Flash::setFlash('Cannot Deleted', 'Teachers', 'danger');						
					}
				}
			} else {
				Redirect::to('teachers');
			}
		} else {
			Redirect::to('teachers');
		}
	}

}

?>