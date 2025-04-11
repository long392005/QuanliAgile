<?php 
session_start();
// Require file Common
require_once '../commons/env.php'; // Khai báo biến môi trường
require_once '../commons/function.php'; // Hàm hỗ trợ

require_once './controllers/DonHangController.php';
require_once './controllers/LoginController.php';

// Require toàn bộ file Controllers
require_once 'controllers/DashboardController.php';
require_once './models/DonHang.php';
require_once './models/Login.php';

require_once  './controllers/AdminDanhMucController.php';
require_once  './controllers/AdminSanphamController.php';
// Require toàn bộ file Controllers
require_once 'controllers/DashboardController.php';
require_once './controllers/DashboardController.php';
// Require toàn bộ file Models

require_once './models/DonHang.php';
require_once './models/Login.php';
require_once './models/AdminDanhMuc.php';
require_once './models/AdminSanpham.php';
require_once './models/Dashboard.php';
// Route
$act = $_GET['act'] ?? '/';

// Để bảo bảo tính chất chỉ gọi 1 hàm Controller để xử lý request thì mình sử dụng match

match ($act) {
    // Dashboards
     // Dashboards
     '/'                 => (new DashboardController())->index(),
     'danh-muc'         => (new AdminDanhMucController())->danhSachDanhMuc(),
     'form-them-danh-muc'=> (new AdminDanhMucController())->formAddDanhMuc(),
     'them-danh-muc'     => (new AdminDanhMucController())->addDanhMuc(),
     'form-sua-danh-muc' => (new AdminDanhMucController())->formEditDanhmuc(),
     'xoa-danh-muc'      => (new AdminDanhMucController())->deleteDanhMuc(),
     'sua-danh-muc'      => (new AdminDanhMucController())-> postEditDanhmuc(),

     'login-admin'       => (new LoginController())->formLogin(),
     'check-login-admin' => (new LoginController())->Login(),
     
 

};