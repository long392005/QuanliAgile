<?php 

// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/HomeController.php';
require_once './controllers/DashboardController.php';
require_once './controllers/AdminSanPhamController.php';
// Require toàn bộ file Model
require_once './models/AdminSanPham.php';
require_once './models/SanPham.php';
require_once './models/SlideModel.php';


// Route
$act = $_GET['act'] ?? '/';

// Để bảo bảo tính chất chỉ gọi 1 hàm Controller để xử lý request thì mình sử dụng match

match ($act) {
    // Trang chủ

    '/'                 => (new HomeController())->index(),
    'chi-tiet-san-pham' => (new AdminSanPhamController())->detailSanpham(), 
    'cap-nhat-san-pham' => (new AdminSanPhamController())->formEditSanpham(),       
}
   '/' => (new ListController())->home(),
    'list-san-pham' => (new ListController())->listProduct(),
'chi-tiet-san-pham' => (new ListController())->detailProduct(),
    'them-binh-luan' => (new ListController())->addComment(),

};

