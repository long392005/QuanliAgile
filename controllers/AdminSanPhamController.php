<?php
class AdminSanPhamController
{
    public $modelSanpham;
    public $modelDanhMuc;
    public $modelDanhGia;
    public function __construct()
    {
        $this->modelSanpham = new AdminSanPham();
        $this->modelDanhMuc = new AdminDanhMuc();
        $this->modelDanhGia = new AdminDanhGia();

    }

    public function detailSanpham()
    {
        
        $id_san_pham = $_GET['id_san_pham'];
        $sanpham = $this->modelSanpham->getOnetSanPham($id_san_pham);
        $listAnhSanPham = $this->modelSanpham->getListAnhSanPham($id_san_pham);

        $listBinhLuan=$this->modelSanpham->getBinhLuanFromSanPham($id_san_pham);
        $listDanhGia = $this->modelDanhGia->getDanhGiaBySanPham($id_san_pham);
        if ($sanpham) {
            require_once './views/sanpham/detailSanpham.php';
        } else {
            header('Location: ' . BASE_URL_ADMIN . '?act=san-pham');
            exit();
        }
    }



}
?>