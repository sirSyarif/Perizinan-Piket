<?php

class Users extends Controller {

    public function __construct(){
        $this->userModel = $this->model('UserModel');
        $this->teacherModel = $this->model('TeacherModel');
        $this->permission = $this->model('PermissionModel');
    }    

    public function register(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {                
            $data = [
                'name'                 => $_POST['name'],
                'email'                => $_POST['email'],
                'password'             => $_POST['password'],
                'confirm_password'     => $_POST['confirm_password'],
                'title'                => 'Register'
            ];
            
            if (!empty($data)){
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                if ($this->userModel->register($data)) {
                    Flash::setFlash('Register', 'success', 'success');
                    Redirect::to('users/login');
                } else {
                    Flash::setFlash('Register', 'failed', 'danger');
                    Redirect::to('users/register');
                }
            } else {
                $this->view('users/register', $data);
            }
        } else {
            $data = [
                'name'                 => '',
                'email'                => '',
                'password'             => '',
                'confirm_password'     => '',                
                'title'                => 'Register'
            ];
            $this->view('users/register', $data);
        }
    }

    public function login(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'email'        => $_POST['email'],
                'password'     => $_POST['password'],
                'title'        => 'Login'
            ];

            $user = $this->userModel->login($data['email'], $data['password']);
            if ($user) {
                Flash::setFlash('Login', 'Success', 'success');
                $this->createUserSession($user);
            } else {
                Flash::setFlash('Login', 'Failed', 'danger');
                Redirect::to('users/login');
            }
        } else {
            $data = [
                'email'        => '',
                'password'     => '',
                'title'        => 'Login'
            ];            
            $this->view('users/login', $data);
        }
    }

    public function permission() {
        if (!isset($_SESSION['admin_mode'])) {            
            if (isset($_SESSION['permission'])) {
                $teacherRowId = [];

                foreach ($_SESSION['permission'] as $key => $value) {
                    array_push($teacherRowId, $key);
                }
                $teachers = $this->teacherModel->getMultipleTeachersById($teacherRowId);
                $teachers = $this->initializePermission($teachers);                
                
                $data = [                    
                    'teachers'      => $teachers,
                    'title'         => 'Permission'
                ];
                $this->view('users/permission', $data);
            } else {
                $data = [
                    'title' => 'Permission'
                ];
                $this->view('users/permission', $data);
            }
        } else {
            Redirect::to('teachers');
        }
    }
    
    public function addPermission(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $index = $_POST['index'];
            if (isset($_SESSION['permission'][$index])) {
                $_SESSION['permission'][$index] += 1;
            } else {
                $_SESSION['permission'][$index] = 1;
            }
            echo array_sum($_SESSION['permission']);
        } else {
            Redirect::to();
        }
    }

    public function updatePermission(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $teacherIdArray = [];

            foreach ($_POST as $key => $value) {
                if (strpos($key, 'teacherQuantityId_') !== false) {
                    $id = str_replace('teacherQuantityId_', '', $key);
                    $_SESSION['permission'][$id] = $value;
                    array_push($teacherIdArray, intval($id));
                }
            }

            $teachers = $this->teacherModel->getMultipleTeachersById($teacherIdArray);  
            $teachers = $this->initializePermission($teachers);

            $data = [
                'teachers'      => $teachers,
                'totalItems' => array_sum($_SESSION['permission']),
                'title'         => 'Permission'
            ];

            echo json_encode($data);
        } else {
            Redirect::to();
        }
    }

    public function deletePermission(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $teacherIdArray = [];
            foreach ($_POST as $key => $value) {
                if (strpos($key, 'teacherQuantityId_') !== false) {
                    $id = str_replace('teacherQuantityId_', '', $key);
                    array_push($teacherIdArray, intval($id));
                }
            }

            unset($_SESSION['permission'][$_POST['teacherRowId']]);
            $index = array_search($_POST['teacherRowId'], $teacherIdArray);
            if ($index !== false) {
                unset($teacherIdArray[$index]);
                $teacherIdArray = array_values($teacherIdArray);
            }

            if (empty($teacherIdArray)) {
                unset($_SESSION['permission']);
                $data = [
                    'permissionEmpty' => true
                ];

            } else {
                $teachers = $this->teacherModel->getMultipleTeachersById($teacherIdArray);  
                $teachers = $this->initializePermission($teachers);

                $data = [
                    'permissionEmpty' => false,
                    'totalItems' => array_sum($_SESSION['permission']),
                    'title'      => 'Permission'
                ];
            }
            echo json_encode($data);
        } else {
            Redirect::to();
        }
    }    

    public function sendPermission() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $teacherIdArray = [];
            foreach ($_SESSION['permission'] as $key => $value) {
                array_push($teacherIdArray, $key);
            }

            $teachers = $this->teacherModel->getMultipleTeachersById($teacherIdArray);
            $teachers = $this->initializePermission($teachers);

            $data = [
                'userId'        => $_SESSION['user_id'],
                'teachers'      => $teachers,
                'title'         => 'Send Permission'
            ];

            if ($this->permission->addPermission($data)) {
                unset($_SESSION['permission']);
                Flash::setFlash('Send Permission', 'success', 'success');
                Redirect::to('users/permission');
            } else {
                Flash::setFlash('Send Permission', 'Failed', 'danger');
            }
        } else {
            Redirect::to();
        }
    }

    private function initializePermission($teachers) {
        foreach ($teachers as $teacher) {        
            $teacherTypes = $this->teacherModel->getTeacherTypesById($teacher->id);
            $teacher->category = [];
            foreach ($teacherTypes as $teacherType) {
                $teacher->category[$teacherType->matpel_id] = $teacherType->matpel;
            }
        }
        return $teachers;
    }

    public function createUserSession($user){
        $_SESSION['user_id']    = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name']  = $user->name;
        if ($user->is_admin) {
            $_SESSION['admin_mode'] = true;
        }
        Redirect::to();
    }

    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        unset($_SESSION['admin_mode']);
        session_destroy();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        Flash::setFlash('Logout', 'Success', 'warning');
        Redirect::to();
    }
}
