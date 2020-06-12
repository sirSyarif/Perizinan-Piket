<?php

class NotFound extends Controller {
    
    public function index() {
        $data['title'] = 'Not Found';        
        $this->view('templates/notFound', $data);
    }
}