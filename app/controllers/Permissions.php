<?php

class Permissions extends Controller {

    public function __construct() {
        $this->teacher = $this->model('TeacherModel');
        $this->permission = $this->model('PermissionModel');
    }

    public function index($page = 1){
        if (isset($_SESSION['user_id'])) {
            $page = $page;
            $limit = 5;
            $space = 2;

            if (isset($_SESSION['admin_mode'])) {
                $this->permission->getPermissions();
            } else {
                $this->permission->getPermissionsById(intval($_SESSION['user_id']));
            }

            $totalRows = $this->permission->getRowCount();
            $totalPages = ceil($totalRows / $limit);
            $offset = $limit * ($page - 1);

            if ($totalPages <= (1 + ($space * 2))) {
                $start = 1;
                $end   = $totalPages;
            } else {
                if (($page - $space) > 1) {
                    if (($page + $space) < $totalPages) {
                        $start = ($page - $space);
                        $end   = ($page + $space);
                    } else {
                        $start = ($totalPages - (1 + ($space * 2)));
                        $end   = $totalPages;
                    }
                } else {
                    $start = 1;
                    $end   = (1 + ($space * 2));
                }
            }

            if (isset($_SESSION['admin_mode'])) {
                $permissions = $this->permission->getPermissionsByPagination($offset, $limit);
            } else {
                $permissions = $this->permission->getPermissionsByIdPagination($offset, $limit, $_SESSION['user_id']);
            }
            
            $data = [
                'permissions' => $permissions,
                'page' => $page,
                'start' => $start,
                'end' => $end,
                'totalPages' => $totalPages,
                'title' => 'Permissions'
            ];

            $this->view('permissions/index', $data);
        } else {
            Redirect::to();
        }
	}

	public function show($id){
		if(isset($_SESSION['user_id'])){
			$permission = $this->permission->getPermissionById($id);

			if(!isset($_SESSION['admin_mode'])){
				$customerId = $this->permission->getCustomerId($_SESSION['user_id']);
			}
			
			if(isset($_SESSION['admin_mode']) || $customerId == $permission->customer_id){
				$permissionDetails = $this->permission->getPermissionDetailsById($id);
				foreach ($permissionDetails as $teacher) {
		            $teacherTypes = $this->teacher->getTeacherTypesById($teacher->id);
		            $teacher->category = [];
		            foreach ($teacherTypes as $teacherType) {
		                $teacher->category[$teacherType->type_id] = $teacherType->type;
		            }
				}

				$data = [
					'started' => $permission->started,
					'ended' => $permission->ended,
                    'teachers' => $permissionDetails,
                    'title' => 'permissions'
				];
				$this->view('permissions/show', $data);
			} else {
				Redirect::to('permissions');
			}
		} else {
            Redirect::to();
		}
	}
}
