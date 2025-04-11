<?php 

// Require file Common
require_once '../commons/env.php'; // Khai báo biến môi trường
require_once '../commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once 'controllers/DashboardController.php';
require_once './controllers/NguoidungController.php';

// Require toàn bộ file Models
require_once './models/Nguoidung.php';

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

};