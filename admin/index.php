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
    '/'                 => (new DashboardController())->index(),
    'nguoi-dung'           => (new NguoiDungtController() )->index(),
'detail-tai-khoan' =>(new NguoiDungtController)->formDetail(),
    'update-tai-khoan' =>(new NguoiDungtController)->updateAcc(),
    'form-password' =>(new NguoiDungtController)->formPassword(),
    'update-password' =>(new NguoiDungtController)->updatePassword(),
    
    'dang-ki'=>(new NguoiDungtController)->formDangki(),
    'check-dang-ki'=>(new NguoiDungtController)->DangKi(),
    'dang-ki-thanh-cong'=>(new NguoiDungtController)->formDangkiThanhCong(),


    'san-pham' => (new AdminSanPhamController())->index(),
'form-sua-san-pham' => (new AdminSanPhamController())->formEditSanpham(),
    'sua-san-pham' => (new AdminSanPhamController())->postEditSanpham(),
    'xoa-san-pham' => (new AdminSanPhamController())->deleteSanpham(),
    'chi-tiet-san-pham' => (new AdminSanPhamController)->detailSanpham(),

};