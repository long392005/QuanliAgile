<?php

class AdminSanPhamController
{
    public $modelSanpham;
    public $modelDanhMuc;
    public $modelDanhGia;
    public function __construct()
    {
        $this->modelSanpham = new AdminSanPham();
       

    }

     
  public function formEditSanpham()
    {

        $id = $_GET['id_san_pham'];
        $sanpham = $this->modelSanpham->getOnetSanPham($id);
        $listdanhmuc = $this->modelDanhMuc->getAllDanhMuc();
        //lấy ra thông tin của danh mục cần sửa

        if ($sanpham) {
            require_once './views/sanpham/editSanpham.php';
            deleteSessionError();
        } else {

            header('Location: ' . BASE_URL_ADMIN . '?act=san-pham');
            exit();
        }
    }

public function postEditSanpham() {
    // kiểm tra xem người dùng có gửi dữ liệu từ form không
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Lấy dữ liệu
        $san_pham_id = $_POST['san_pham_id'] ?? '';
        // Truy vấn sản phẩm cũ
        $sanPhamOld = $this->modelSanpham->getOnetSanPham($san_pham_id);
        $old_file = $sanPhamOld['hinh_anh'];

        $ma_san_pham = $_POST['ma_san_pham'] ?? '';
        $ten_san_pham = $_POST['ten_san_pham'] ?? '';
        $gia_nhap = $_POST['gia_nhap'] ?? '';
        $gia_san_pham = $_POST['gia_san_pham'] ?? '';
        $so_luong = $_POST['so_luong'] ?? '';
        $luot_xem = $_POST['luot_xem'] ?? '';
        $ngay_nhap = $_POST['ngay_nhap'] ?? '';
        $danh_muc_id = $_POST['danh_muc_id'] ?? '';
        $trang_thai = $_POST['trang_thai'] ?? '';
        $mo_ta = $_POST['mo_ta'] ?? '';
        $hinh_anh = $_FILES['hinh_anh'] ?? null;

        // Tạo một mảng trống để chứa lỗi
        $errors = [];
        if (empty($ma_san_pham)) {
            $errors['ma_san_pham'] = 'Mã sản phẩm không được để trống';
        }
        if (empty($ten_san_pham)) {
            $errors['ten_san_pham'] = 'Tên sản phẩm không được để trống';
        }
        if (empty($gia_nhap)) {
            $errors['gia_nhap'] = 'Giá nhập không được để trống';
        }
        if (empty($gia_san_pham)) {
            $errors['gia_san_pham'] = 'Giá sản phẩm không được để trống';
        }
    
        if (empty($so_luong)) {
            $errors['so_luong'] = 'Số lượng không được để trống';
        }
        if (empty($luot_xem)) {
            $errors['luot_xem'] = 'Lượt xem không được để trống';
        }
        if (empty($ngay_nhap)) {
            $errors['ngay_nhap'] = 'Ngày nhập không được để trống';
        }
        if (empty($danh_muc_id)) {
            $errors['danh_muc_id'] = 'Danh mục phải chọn';
        }
        if (empty($trang_thai)) {
            $errors['trang_thai'] = 'Trạng thái phải chọn';
        }

        $_SESSION['error'] = $errors;

        // Nếu không có lỗi thì tiến hành thêm sản phẩm
        if (isset($hinh_anh) && $hinh_anh['error'] == UPLOAD_ERR_OK) {
            $new_file = uploadFile($hinh_anh, './uploads/');
            if (!empty($old_file)) {
                deleteFile($old_file);
            }
        } else {
            $new_file = $old_file;
        }

        if (empty($errors)) {
            $this->modelSanpham->UpdateSanPham(
                $san_pham_id,
                $ma_san_pham,
                $ten_san_pham,
                $gia_nhap,
                $gia_san_pham,
                $so_luong,
                $luot_xem,
                $ngay_nhap,
                $danh_muc_id,
                $trang_thai,
                $mo_ta,
                $new_file
            );

            header('Location: ' . BASE_URL_ADMIN . '?act=san-pham');
            exit();
        } else {
            
            $_SESSION['flash'] = true;
            header('Location: ' . BASE_URL_ADMIN . '?act=form-sua-san-pham&id_san_pham=' . $san_pham_id);
            exit();
        }
    }
}



   
 
    public function detailSanpham()
    {
        
        $id_san_pham = $_GET['id_san_pham'];
        $sanpham = $this->modelSanpham->getOnetSanPham($id_san_pham);
      

       
        if ($sanpham) {
            require_once './views/sanpham/detailSanpham.php';
        } else {
            header('Location: ' . BASE_URL_ADMIN . '?act=san-pham');
            exit();
        }
    }
  
    
   
   
 
    
}