<?php 
class User extends Controller {
    public function __construct() {
        $this->userModel = $this->model('User');
    }
   
    public function login() {
        $data = [
            'title' => 'Login Page'
        ];

        $this->view('users/login', $data);
    }
}