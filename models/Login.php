<?php
class Login {
    public $conn;

    public function __construct(){
        $this->conn = connectDB();
    }
}

 ?>