<?php

class Home extends Controller {

    public function __construct() {
        $this->teachers = $this->model('TeacherModel');
    }

    public function index() {        
        $typesList = $this->teachers->getTypesList();
        $data = [
            'typesList' => $typesList,
            'title' => 'Home'
        ];
        $this->view('pages/home', $data);
    }
}