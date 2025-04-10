<?php
session_start();
class LoginController {
    public $modelLogin;
    
    public function __construct() {
        $this->modelLogin = new Login();
    }
 public function logout(){
    if (isset($_SESSION['user_admin'])) {
    unset($_SESSION['user_admin']);
    header('Location: '. BASE_URL_ADMIN.'?act=login-admin');
    exit();
    }
}
}
 ?>